<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'phone_no', 'email'];

    protected $dates = ['deleted_at'];

    public function sell(){
        return $this->hasMany('App\Sells');
    }
}
