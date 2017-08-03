<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockAddRequest;
use App\Products;
use App\Stock;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

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
        //
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
        //
    }
}
