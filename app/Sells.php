<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sells extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_no',
        'customer_id',
        'productimei_id',
        'stock_id',
        'quantity',
        'discount',
        'due',
        'total_amount',
        'gifts',
        'service',
        'user_id',
    ];

    protected $dates = ['deleted_at'];


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
    public function imei(){
        return $this->belongsTo('App\productIMEI', 'productimei_id');
    }

}
