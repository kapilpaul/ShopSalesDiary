<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{

    use SoftDeletes;

    protected $fillable = [
        "product_id",
        "stockin_id",
        "color",
        "quantity",
        "stock_left",
        "buying_price",
        "selling_price",
        "paid",
        "due",
        "date",
        "amount",
        "user_id",
        "waranty",
        "stock_left",
        "return",
        "short_list",
    ];


    protected $dates = ['deleted_at'];


    public function stockInIdGenerate(){
        $stockin_id = $this->orderBy('stockin_id', 'desc')->pluck('stockin_id')->first();

        if($stockin_id)
            return ($stockin_id + 1);
        else
            return '01';
    }

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function product(){
        return $this->belongsTo('App\Products');
    }

    public function photo(){
        return $this->belongsTo('App\Photo');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }

    public function brand(){
        return $this->belogsTo('App\Brand');
    }

    public function stockIdProductName(){
        //DB::enableQueryLog();

        return DB::table('stocks')
                   ->join('products', 'stocks.product_id', '=', 'products.id')
                   ->where('stock_left', '!=', '0')
                   ->orderBy('stock_left', 'asc')
                   ->select('stocks.*', 'products.name')
                   ->get()
                   ->mapWithKeys(function($i) {
                        return [$i->id => 'MGSE-'.$i->stockin_id.' : '.$i->name.' ('.$i->color.') / '.
                                          $i->stock_left.' in Stock'];
                   });
        
        //dd(DB::getQueryLog());


    }

    public function stockIdProductNameAll(){
        return DB::table('stocks')
                   ->join('products', 'stocks.product_id', '=', 'products.id')
                   ->orderBy('stock_left', 'asc')
                   ->select('stocks.*', 'products.name')
                   ->get()
                   ->mapWithKeys(function($i) {
                        return [$i->id => 'MGSE-'.$i->stockin_id.' : '.$i->name.' ('.$i->color.') / '.
                                          $i->stock_left.' in Stock'];
                   });

    }

    public static function availableStocks(){

        return DB::table('stocks')
                 ->join('products', 'stocks.product_id', '=', 'products.id')
                 ->join('brands', 'products.brand_id', '=', 'brands.id')
                 ->join('categories', 'products.category_id', '=', 'categories.id')
                 ->where('stock_left', '!=', '0')
                 ->orderBy('brands.name', 'asc')
                 ->select('stocks.*', 'categories.name as categoryname', 'brands.name as brandname', 'products.name as proname')
                 ->get();
    }




}
