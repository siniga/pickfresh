<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    public function campaigns(){
    
        return $this->hasMany('App\Models\Campaign');
    }

    public function teams(){
    
        return $this->hasMany('App\Models\Team');
    }
}
