<?php

namespace App\Http\Controllers;

use App\Sells;
use App\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class homecontroller extends Controller
{
    public function index(){

        $date_range_from = \Carbon\Carbon::now()->subMonth();
        $date_range_to = \Carbon\Carbon::now();

        $brands = \App\Brand::all();
        $brand_sell_count = array();

        foreach ($brands as $brand){
            $brand_sell_count[] = DB::table('brands')
                                    ->join('products', 'products.brand_id', '=' ,'brands.id')
                                    ->join('stocks', 'stocks.product_id', '=', 'products.id')
                                    ->join('sells', 'stocks.id', '=', 'sells.stock_id')
                                    ->where('brands.id', '=', $brand->id)
                                    ->whereBetween('sells.created_at', [$date_range_from, $date_range_to])
                                    ->select('brands.name')
                                    ->get();
        }

        //latest sale

        $latest_sales = Sells::orderBy('id', 'desc')->limit(5)->get();

        $stocks = Stock::where('stock_left', '>', '0')->orderBy('id', 'desc')->limit(5)->get();

        return view('index', compact('brand_sell_count', 'latest_sales', 'stocks'));
    }
}
