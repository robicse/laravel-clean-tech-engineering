<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductService extends Model
{
    public function product(){
        return $this->belongsTo('App\Product');
    }
    public function service(){
        return $this->belongsTo('App\Service');
    }
}
