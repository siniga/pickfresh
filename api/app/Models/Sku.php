<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sku extends Model
{
    use HasFactory;

    public function products(){
    
        return $this->belongsToMany('App\Models\Product','product_skus');
    }

    public function order_products(){

        return $this->hasMany('App\Models\OrderProduct');
    }
}
