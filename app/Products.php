<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
	protected $fillable = ['name', 'slug', 'category_id', 'brand_id', 'photo_id'];
	protected $dates = ['deleted_at'];
    public $timestamps = true;

    public function photo(){
        return $this->belongsTo('App\Photo');
    }

    public function category(){
        return $this->belongsTo('App\Category');
    }
    public function brand(){
        return $this->belongsTo('App\Brand');
    }
}
