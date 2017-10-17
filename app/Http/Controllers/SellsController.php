<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Expense;
use App\Http\Requests\CustomerSellsRequest;
use App\productIMEI;
use App\Products;
use App\Sells;
use App\Stock;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class SellsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sells = Sells::orderBy('id', 'desc')->get();
        $page_count = 0;

        if(count($sells) > 10){
            $sells = Sells::orderBy('id', 'desc')->paginate(10,['*'],'sells');
            $page_count = $sells->count();
        }
//return $sells;
        return view('sells.index', compact('sells', 'page_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'phone_no' => 'required|min:11'
        ]);

        $phoneNo = trim($request->phone_no, "+");
        $phoneNo = str_replace(' ','',$phoneNo);

        if(is_numeric($phoneNo)){
            if(strlen($phoneNo) == 11){
                $phone_no = Customer::wherePhoneNo($phoneNo)->first();
            }else{
                return redirect()->back()->with(['error' => 'Please enter a valid phone no.']);
            }

            $products = Products::pluck('name', 'id');

            $stocks = new Stock();
            $stocks_item = $stocks->stockIdProductName();


            return view('sells.create', compact('phone_no','products', 'stocks_item'));
        }else{
            //return redirect()->back()->with(['error' => 'Invalid Phone Or Invoice No']);
            abort(404);
        }
    }

    public function search()
    {
        return view('sells.search');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request->all();


        try{
            $input = $request->all();


            $invoice_no = str_replace('-','',\Carbon\Carbon::now());
            $invoice_no = str_replace(' ','',$invoice_no);
            $input['invoice_no'] = str_replace(':','',$invoice_no);

            $customer = Customer::wherePhoneNo($request->phone_no)->first();

            if(!$customer){
                $input['name'] = title_case($request->name);
                $input['phone_no'] = $request->phone_no;
                $input['email'] = $request->email;

                $customer = Customer::create($input);
                $input['customer_id'] = $customer->id;
            }else{
                $input['customer_id'] = $customer->id;
            }

            foreach ($request->sell_products as $sell_item) {
                if(isset($sell_item['stock_id'])) {

                    $input['stock_id']      = $sell_item['stock_id'];
                    $input['quantity']      = $sell_item['quantity'];

                    if(isset($sell_item['product_code']) && $sell_item['product_code'] != null)
                        $input['productimei_id']  = $sell_item['product_code'];
					else
						$input['productimei_id'] = null;

                    $input['selling_price'] = $sell_item['selling_price'];
                    $input['discount']      = $sell_item['discount'];
                    $input['due']           = $sell_item['due'];
                    $input['gifts']         = $sell_item['gifts'];



                    $stockById  = Stock::whereId($sell_item['stock_id'])->first();
                    $stock_left = $stockById->stock_left - $sell_item['quantity'];

                    if ($stock_left < 0) {
                        return redirect('sells/search')->with(['error' => ' Quantity Not available in ' . $stockById->stockin_id]);
                    }


                    if ($input['selling_price'])
                        $total_amount = $input['selling_price'] * $sell_item['quantity'];
                    else
                        $total_amount = $stockById->selling_price * $sell_item['quantity'];


                    $input['total_amount'] = $total_amount - $sell_item['discount'];

                    $input['user_id'] = Sentinel::getUser()->id;

                    Sells::create($input);

                    $stockById->update(['stock_left' => $stock_left]);

                    if(isset($input['productimei_id'])){
                        $imei = productIMEI::findOrFail($input['productimei_id']);
                        $imei->update(['sold' => 1]);
                    }
                }

            }



            $sells = Sells::whereInvoiceNo($input['invoice_no'])->get();
            $total_amount = Sells::whereInvoiceNo($input['invoice_no'])->sum('total_amount');
			$total_discount = Sells::whereInvoiceNo($input['invoice_no'])->sum('discount');
            $due = Sells::whereInvoiceNo($input['invoice_no'])->sum('due');

            if($customer->email != null){
                $this->sendEmail($customer, $sells, $total_amount, $total_discount, $due);
            }

            return redirect('sells')->with(['success' => 'Items Sold']);

        } catch (TokenMismatchException $e){
            return redirect('sells/search');
        }  catch (MethodNotAllowedHttpException $e){
            return redirect('sells/search');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $products = Products::pluck('name', 'id');

        $stocks = new Stock();
        $stocks_item = $stocks->stockIdProductNameAll();

        $sell = Sells::whereId($id)->first();


        return view('sells.edit', compact('products', 'stocks_item', 'sell'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'stock_id' => 'required|numeric',
            'quantity' => 'required|numeric',
            'discount' => 'numeric',
        ]);

        try{
            $input = $request->all();

            $sell = Sells::whereId($id)->first();
            $stockById = Stock::whereId($sell->stock_id)->first();
            $stock_left = $stockById->stock_left + $sell->quantity;

            if($stock_left < 0){
                return redirect('sells/search')->with(['error' => 'Quantity Not available']);
            }

            $stockById->update(['stock_left' => $stock_left]);

            $stockById = Stock::whereId($request->stock_id)->first();
            $stock_left = $stockById->stock_left - $request->quantity;
            $stockById->update(['stock_left' => $stock_left]);



            if($input['selling_price'])
                $total_amount = $input['selling_price'] * $request->quantity;
            else
                $total_amount = $stockById->selling_price * $request->quantity;


            $input['total_amount'] = $total_amount - $request->discount;
            $input['user_id'] = Sentinel::getUser()->id;

            $sell->update($input);

            return redirect()->back()->with(['success' => 'Item Update']);



        } catch (TokenMismatchException $e){
            return redirect('sells/search');
        }  catch (MethodNotAllowedHttpException $e){
            return redirect('sells/search');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $sell_item = Sells::whereId($id)->first();
        $stockById = Stock::whereId($sell_item->stock_id)->first();
        $stock_left = $stockById->stock_left + $sell_item->quantity;
        $stockById->update(['stock_left' => $stock_left]);

        $sell_item->delete();

        return redirect()->back()->with(['success' => 'Sells Item Deleted']);
    }


    public function currentMonthSell(){
        $month = date('m');
        $year = date('Y');
        $sells = Sells::whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        $sum_amount = Sells::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('total_amount');
        $expenses = Expense::whereMonth('date', $month)->whereYear('date', $year)->sum('amount');

        $customers = Customer::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        $page_count = 0;

        $profit_buying_price = 0;
        foreach ($sells as $sell){
            if($sell->stock)
                $total_buying_sum = $sell->stock->buying_price;
                $profit_buying_price = $profit_buying_price + $total_buying_sum;
        }


        if(count($sells) > 10){
            $sells = Sells::whereMonth('created_at', $month)->whereYear('created_at', $year)->paginate(10,['*'],'sells');
            $page_count = $sells->count();
        }
        return view('sells.current_month', compact('sells', 'page_count', 'customers', 'sum_amount', 'profit_buying_price', 'expenses'));
    }


    public function searchMonthRange(){
        $sells = 0;
        return view('sells.month_range', compact('sells'));
    }

    public function PostsearchMonthRange(Request $request){
        $this->validate($request, [
            'daterange' => 'required',
        ]);

        $date_range = explode(' - ', $request->daterange);

        $date_range_from = date('Y-m-d', strtotime($date_range[0]));
        $date_range_to = date('Y-m-d', strtotime($date_range[1]));

        $date_range_from = "$date_range_from 00:00:00";
        $date_range_to = "$date_range_to 23:59:59";

        $sells = Sells::whereBetween('created_at', [$date_range_from, $date_range_to])->get();
        $page_count = 0;
        //$expenses = Expense::whereBetween('date', [$date_range_from, $date_range_to])->get();

        $sum_amount = Sells::whereBetween('created_at', [$date_range_from, $date_range_to])->sum('total_amount');
        $expenses = Expense::whereBetween('date', [$date_range_from, $date_range_to])->sum('amount');

        $customers = Customer::whereBetween('created_at', [$date_range_from, $date_range_to])->count();


        $profit_buying_price = 0;
        foreach ($sells as $sell){
            if($sell->stock)
                $total_buying_sum = $sell->stock->buying_price;
                $profit_buying_price = $profit_buying_price + $total_buying_sum;
        }


        if(count($sells) > 10){
            $sells = Sells::whereBetween('created_at', [$date_range_from, $date_range_to])->paginate(10,['*'],'sells');
            $page_count = $sells->count();
        }

        return view('sells.month_range', compact('date_range', 'sells', 'page_count', 'customers', 'sum_amount', 'profit_buying_price', 'expenses'));

    }


    public function searchingSells(Request $request)
    {
        $this->validate($request, [
            'search_no' => 'required|min:11|max:14',
        ]);

        $searchNo = $request->search_no;
        $phone_No = 0;
        $sells = 0;
        $invoiceNo = 0;

        if(is_numeric($searchNo)){
            if(strlen($searchNo) == 11){
                $phone_No = Customer::wherePhoneNo($searchNo)->first();
                if(!$phone_No)
                    return redirect()->back()->with(['error' => 'No Customer Found.']);
                else
                    $sells = Sells::whereCustomerId($phone_No->id)->orderBy('id', 'desc')->get();
                    $total_spent = Sells::whereCustomerId($phone_No->id)->sum('total_amount');

            }elseif(strlen($searchNo) == 14){

                $invoiceNos = Sells::whereInvoiceNo($searchNo)->orderBy('id', 'desc')->get();
                $customerNameNo = Sells::whereInvoiceNo($searchNo)->first();
                $sells = Sells::whereCustomerId($customerNameNo->customer_id)->orderBy('id', 'desc')->count();
                $total_spent = Sells::whereCustomerId($customerNameNo->customer_id)->sum('total_amount');
                if(!$invoiceNos)
                    return redirect()->back()->with(['error' => 'No Invoice Number found']);
            }else{
                return redirect()->back()->with(['error' => 'Invalid Phone Or Invoice No']);
            }

            return view('sells.customerSearch', compact('phone_No', 'total_spent','sells', 'customerNameNo', 'invoiceNos'));

        }else{
            //return redirect()->back()->with(['error' => 'Invalid Phone Or Invoice No']);
            abort(404);
        }
    }


    public function invoice($id){
        try{

            $sells = Sells::whereInvoiceNo($id)->get();
            if(!$sells){
                return redirect('/sells')->with(['error' => 'Invalid Invoice No.']);
            }
            $created_at = $sells[0]->created_at;
            $customer = Customer::whereId($sells[0]->customer_id)->first();


            $total_amount = Sells::whereInvoiceNo($id)->sum('total_amount');
            $due = Sells::whereInvoiceNo($id)->sum('due');
            $total_discount = Sells::whereInvoiceNo($id)->sum('discount');

            return view('sells.invoice', compact('sells', 'customer', 'total_amount', 'due', 'total_discount', 'created_at'));

        }catch(ErrorException $e){
            return redirect('/sells')->with(['error' => 'Invalid Invoice No.']);
        }

    }

    /*
    |--------------------------------------------------------------------------
    | Sending Email to customer
    |--------------------------------------------------------------------------
    */

    public function sendEmail($phone_no, $sells, $total_amount, $total_discount, $due){
        $mail_data = [
            'customer' => $phone_no,
            'sells' => $sells,
            'total_amount' => $total_amount,
            'total_discount' => $total_discount,
            'due' => $due,
        ];


        $mail_send = Mail::send('email.invoice', $mail_data, function ($message) use ($phone_no){
            $message->to($phone_no->email)->subject("Invoice For Purchased Item")->from('no-reply@mobilegarden.com', 'Mobile Garden');
        });

    }

    public function invoiceEmail($id){
        $sells = Sells::whereInvoiceNo($id)->get();

        if(!$sells){
            return redirect('/sells')->with(['error' => 'Invalid Invoice No.']);
        }
        $created_at = $sells[0]->created_at;
        $customer = Customer::whereId($sells[0]->customer_id)->first();


        $total_amount = Sells::whereInvoiceNo($id)->sum('total_amount');
		$total_discount = Sells::whereInvoiceNo($id)->sum('discount');
        $due = Sells::whereInvoiceNo($id)->sum('due');

        $mail = $this->sendEmail($customer, $sells, $total_amount, $total_discount, $due);

        return redirect()->back()->with(['success' => 'Mail Send Successfully']);

    }



}
