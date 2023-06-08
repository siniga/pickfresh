<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    public function businesses(){
    
        return $this->belongsTo('App\Models\Business');
    }

    public function teams(){
    
        return $this->hasMany('App\Models\Team');
    }


    public function campaign_types(){
    
        return $this->belongsTo('App\Models\CampaignType');
    }
}
