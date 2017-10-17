<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = ['photo'];

    protected $uploads = '/img/';

    public function getPhotoAttribute($photo){
        return $this->uploads . $photo;
    }
}
