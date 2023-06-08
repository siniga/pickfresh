<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // use SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'color',
        'created_date',
        'branch_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function customers(){

        return $this->hasMany('App\Models\Customer');
    }

    public function roles(){

        return $this->belongsToMany('App\Models\Role', 'user_roles');
    }
    
    public function schedules(){
    
        return $this->belongsToMany('App\Models\Schedule');
    }

    public function attendances(){
    
        return $this->hasMany('App\Models\Attendance');
    }

    public function teams()
    {
        return $this->belongsToMany('App\Models\Team','team_users');
    }

    public function availabilities(){
    
        return $this->has('App\Availability');
    }
    
}
