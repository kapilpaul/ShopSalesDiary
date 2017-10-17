<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class productIMEI extends Model
{
    public $table = "productimeis";
    protected $fillable = ['imei', 'stock_id', 'sold'];

    public function stock(){
        return $this->belongsTo('App\Stock');
    }
    public function brand(){
        return $this->belongsTo('App\Brand');
    }
    public function product(){
        return $this->belongsTo('App\Products');
    }
}
