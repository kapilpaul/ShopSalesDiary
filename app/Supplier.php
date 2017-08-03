<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['name', 'phone_no', 'address'];

    public function brands(){
        return $this->belongsToMany('App\Brand')->withTimestamps();
    }
}
