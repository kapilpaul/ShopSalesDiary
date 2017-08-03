<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

    protected $fillable = [
        "product_id",
        "stockin_id",
        "color",
        "quantity",
        "buying_price",
        "selling_price",
        "paid",
        "due",
        "date",
        "amount",
        "user_id",
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

}
