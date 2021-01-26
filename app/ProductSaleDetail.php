<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSaleDetail extends Model
{
    public function product(){
        return $this->belongsTo('App\Product');
    }
    public function product_brand(){
        return $this->belongsTo('App\ProductBrand');
    }

    public function product_unit(){
        return $this->belongsTo('App\ProductUnit');
    }
    public function productsale(){
        return $this->belongsTo('App\ProductSale');
    }
    public function sale_services(){
        return $this->hasMany('App\SaleService');
    }
    public function service(){
        return $this->belongsTo('App\Service');
    }
}
