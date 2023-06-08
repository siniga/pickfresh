<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    
    public function customers(){

        return $this->belongsTo('App\Models\Customer');
    }

    public function products(){
    
        return $this->belongsToMany('App\Models\Product','order_products');
    }


}
