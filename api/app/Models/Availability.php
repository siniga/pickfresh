<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    use HasFactory;

    
    public function products(){
    
        return $this->belongsTo('App\Product');
    }

    public function customers(){
    
        return $this->belongsTo('App\Customer');
    }

    public function users(){
    
        return $this->belongsTo('App\User');
    }
}
