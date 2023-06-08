<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function accounts(){

        return $this->belongsTo('App\Models\Account');
    }

    public function users(){

        return $this->belongsTo('App\Models\User');
    }

    public function orders(){

        return $this->hasMany('App\Models\Order');
    }

    public function customer_types(){

        return $this->belongsTo('App\Models\CustomerType');
    }

    public function availabilities(){
    
        return $this->has('App\Availability');
    }

    public function customer_stats(){
    
        return $this->hasMany('App\Models\CustomerStat');
    }

}
