<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Camera;
use App\ThreeD;
use App\Scene;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type','name', 'email', 'password', 'api_key'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function cameras()
    {
        return $this->hasMany(Camera::class)->orderBy('created_at','desc');
    }

    public function three_ds()
    {
        return $this->hasMany(ThreeD::class)->orderBy('created_at','desc');
    }

    public function scenes()
    {
        return $this->hasMany(Scene::class)->orderBy('created_at','desc');
    }

    public function control_definitions()
    {
        return $this->hasMany(ControlDefinition::class)->orderBy('created_at','desc');
    }
}
