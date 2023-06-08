<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function skus(){
    
        return $this->belongsToMany('App\Models\Sku','product_skus');
    }

    public function units(){
    
        return $this->belongsToMany('App\Models\Unit','product_units');
    }

    public function categories(){
    
        return $this->belongsTo('App\Models\Category');
    }

    public function orders(){
    
        return $this->belongsToMany('App\Models\Order','order_products');
    }

    public function availabilities(){
    
        return $this->has('App\Availability');
    }
}
