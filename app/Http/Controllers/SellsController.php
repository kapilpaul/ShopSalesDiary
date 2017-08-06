<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\CustomerSellsRequest;
use App\Products;
use App\Sells;
use App\Stock;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
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
        //
    }
}
