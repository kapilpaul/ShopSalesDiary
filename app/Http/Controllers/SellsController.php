<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CustomerSellsRequest;
use App\Products;
use App\Sells;
use App\Stock;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\DB;
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

        $phoneNo = $request->phone_no;

        if(is_numeric($phoneNo)){
            if(strlen($phoneNo) == 11){
                $phone_no = Customer::wherePhoneNo($phoneNo)->first();
            }else{
                abort(404);
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
    public function store(CustomerSellsRequest $request)
    {
        try{
            $input = $request->all();

            $stockById = Stock::whereId($request->stock_id)->first();
            $stock_left = $stockById->stock_left - $request->quantity;

            if($stock_left < 0){
                return redirect('sells/search')->with(['error' => 'Quantity Not available']);
            }

            $phone_no = Customer::wherePhoneNo($request->phone_no)->first();

            if(!$phone_no){
                $input['name'] = title_case($request->name);
                $input['phone_no'] = $request->phone_no;
                $input['email'] = $request->email;

                $customer = Customer::create($input);
                $input['customer_id'] = $customer->id;
            }else{
                $input['customer_id'] = $phone_no->id;
            }

            $invoice_no = str_replace('-','',\Carbon\Carbon::now());
            $invoice_no = str_replace(' ','',$invoice_no);
            $input['invoice_no'] = str_replace(':','',$invoice_no);


            $total_amount = $stockById->selling_price * $request->quantity;
            $input['total_amount'] = $total_amount - $request->discount;
            $input['user_id'] = Sentinel::getUser()->id;

            $stockById->update(['stock_left' => $stock_left]);

            Sells::create($input);

            return redirect('sells')->with(['success' => 'Item Sold']);



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
        //
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
        //
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

        $customers = Customer::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
        $page_count = 0;

        $profit_buying_price = 0;
        foreach ($sells as $sell){
            $total_buying_sum = $sell->stock->buying_price;
            $profit_buying_price = $profit_buying_price + $total_buying_sum;
        }


        if(count($sells) > 10){
            $sells = Sells::whereMonth('created_at', $month)->whereYear('created_at', $year)->paginate(10,['*'],'sells');
            $page_count = $sells->count();
        }
        return view('sells.current_month', compact('sells', 'page_count', 'customers', 'sum_amount', 'profit_buying_price'));
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

        $sum_amount = Sells::whereBetween('created_at', [$date_range_from, $date_range_to])->sum('total_amount');

        $customers = Customer::whereBetween('created_at', [$date_range_from, $date_range_to])->count();
        $page_count = 0;

        $profit_buying_price = 0;
        foreach ($sells as $sell){
            $total_buying_sum = $sell->stock->buying_price;
            $profit_buying_price = $profit_buying_price + $total_buying_sum;
        }


        if(count($sells) > 10){
            $sells = Sells::whereBetween('created_at', [$date_range_from, $date_range_to])->paginate(10,['*'],'sells');
            $page_count = $sells->count();
        }

        return view('sells.month_range', compact('date_range', 'sells', 'page_count', 'customers', 'sum_amount', 'profit_buying_price'));

    }


}
