<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockAddRequest;
use App\Products;
use App\Stock;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $stocks = Stock::orderBy('id', 'desc')->get();
        $page_count = 0;

        if(count($stocks) > 10){
            $stocks = Stock::orderBy('id', 'desc')->paginate(10,['*'],'stocks');
            $page_count = $stocks->count();
        }

        return view('admin.stock.index', compact('stocks','page_count'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $stock = new Stock();
        $stockin_id = $stock->stockInIdGenerate();

        $products = Products::pluck('name', 'id');

        return view('admin.stock.create', compact('stockin_id','products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StockAddRequest $request)
    {
        $stock = new Stock();
        $input = $request->all();

        $input['color'] = title_case($request->color);

        $input['amount'] = $request->buying_price * $request->quantity;

        $input['due'] = $input['amount'] - $request->paid;

        $input['stockin_id'] = $stock->stockInIdGenerate();
        $input['stock_left'] = $request->quantity;

        $input['user_id'] = Sentinel::getUser()->id;

        Stock::create($input);

        return redirect()->back()->with(['success' => 'Stock has been added']);



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
        $stock = Stock::findOrFail($id);

        $products = Products::pluck('name', 'id');

        return view('admin.stock.edit', compact('stock','products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StockAddRequest $request, $id)
    {
        $input = $request->all();
        $input['color'] = title_case($request->color);
        $input['amount'] = $request->buying_price * $request->quantity;
        $input['due'] = $input['amount'] - $request->paid;
        $input['user_id'] = Sentinel::getUser()->id;

        $stock = Stock::findOrFail($id);

        $stock->update($input);

        return redirect()->back()->with(['success' => 'Stock has been Updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Stock::whereId($id)->delete();

        return redirect()->back()->with(['success' => 'Stock has been Deleted']);
    }




    public function findSellingPrice()
    {
        $product_id = Input::get('product_id');
        $selling_price = Stock::whereId($product_id)->first();
        return $selling_price;

    }

    public function availableStocks()
    {
        $stocks = Stock::where('stock_left', '>', '0')->get();
        $page_count = 0;

        if(count($stocks) > 10){
            $stocks = Stock::where('stock_left', '>', '0')->paginate(10,['*'],'stocks');
            $page_count = $stocks->count();
        }
        return view('admin.stock.availableStock', compact('stocks', 'page_count'));

    }
}
