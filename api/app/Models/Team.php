<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany('App\Models\User','team_users');
    }

    public function campaigns()
    {
        return $this->belongsTo('App\Models\Campaign');
    }

    public function regions()
    {
        return $this->belongsTo('App\Models\Region');
    }

    public function businesses(){
    
        return $this->belongsToMany('App\Models\Business');
    }


}
