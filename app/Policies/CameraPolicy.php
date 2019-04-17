<?php

namespace App\Policies;

use App\User;
use App\Camera;
use Illuminate\Auth\Access\HandlesAuthorization;

class CameraPolicy
{
    use HandlesAuthorization;

    //php artisan make:policy CameraPolicy --model=Camera

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Camera  $camera
     * @return mixed
     */
    public function view(User $user, Camera $camera)
    {
        return $camera->user_id == $user->id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Camera  $camera
     * @return mixed
     */
    public function update(User $user, Camera $camera)
    {
        return $camera->user_id == $user->id;
    }
}