<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Stock extends Model
{

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
        "empty",
    ];


    public function stockInIdGenerate(){
        $stockin_id = $this->orderBy('stockin_id', 'DESC')->pluck('stockin_id')->first();

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
        return $this->belogsTo('App\Photo');
    }

    public function category(){
        return $this->belogsTo('App\Category');
    }

    public function brand(){
        return $this->belogsTo('App\Brand');
    }

//    public function stockIdProductName(){
//        return DB::table('stocks')
//                   ->join('products', 'stocks.product_id', '=', 'products.id')
//                   ->select('stocks.*', 'products.*')
//                   ->get();
//    }

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




}
