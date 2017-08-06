<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sells extends Model
{
    protected $fillable = [
        'invoice_no',
        'customer_id',
        'product_code',
        'stock_id',
        'quantity',
        'discount',
        'total_amount',
        'gifts',
        'service',
        'user_id',
    ];


    public function user(){
        return $this->belongsTo('App\User');
    }

    public function stock(){
        return $this->belongsTo('App\Stock');
    }
    public function customer(){
        return $this->belongsTo('App\Customer');
    }
    public function product(){
        return $this->belongsTo('App\Products');
    }

}
