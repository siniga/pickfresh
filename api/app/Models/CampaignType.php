<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignType extends Model
{
    use HasFactory;

    public function campaigns(){
    
        return $this->has('App\Models\Campaign');
    }
}
