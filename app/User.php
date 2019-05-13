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
        'password', 'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function adminCameras()
    {
        $filters = filtersAllowed(['name','intrinsic']);
        sortAllowed();

        return Camera::where($filters)
            ->orderBy(request()->get('sort'),request()->get('sort_dir'))
            ->get();
    }

    public function cameras()
    {   
        $filters = filtersAllowed(['name','intrinsic']);
        sortAllowed();

        return $this->hasMany(Camera::class)
            ->where($filters)
            ->orderBy(request()->get('sort'),request()->get('sort_dir'));
    }

    public function adminThreeDs()
    {
        $filters = filtersAllowed(['name']);
        sortAllowed();

        return ThreeD::where($filters)
            ->where($filters)
            ->orderBy(request()->get('sort'),request()->get('sort_dir'))
            ->get();
    }

    public function three_ds()
    {
        $filters = filtersAllowed(['name']);
        sortAllowed();

        return $this->hasMany(ThreeD::class)
            ->where($filters)
            ->orderBy(request()->get('sort'),request()->get('sort_dir'));
    }

    public function adminScenes()
    {
        $filters = filtersAllowed(['name','intrinsic']);
        sortAllowed();

        return Scene::where($filters)
            ->orderBy(request()->get('sort'),request()->get('sort_dir'))
            ->get();
    }

    public function scenes()
    {
        $filters = filtersAllowed(['name']);
        sortAllowed();

        return $this->hasMany(Scene::class)
            ->where($filters)
            ->orderBy(request()->get('sort'),request()->get('sort_dir'));
    }

    public function adminControlDefinitions()
    {
        $filters = filtersAllowed(['name','intrinsic']);
        sortAllowed();

        return ControlDefinition::where($filters)
            ->orderBy(request()->get('sort'),request()->get('sort_dir'))
            ->get();
    }

    public function control_definitions()
    {
        $filters = filtersAllowed(['name']);
        sortAllowed();

        return $this->hasMany(ControlDefinition::class)
            ->where($filters)
            ->orderBy(request()->get('sort'),request()->get('sort_dir'));
    }
}
