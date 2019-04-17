<?php

namespace App\Policies;

use App\User;
use App\Scene;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class ScenePolicy
{
    use HandlesAuthorization;

    //php artisan make:policy ScenePolicy --model=Scene

    /**
     * Determine whether the user can view the scene.
     *
     * @param  \App\User  $user
     * @param  \App\Scene  $scene
     * @return mixed
     */
    public function view(User $user, Scene $scene)
    {
        return $scene->user_id == $user->id;
    }

    /**
     * Determine whether the user can store the scene.
     *
     * @param  \App\User  $user
     * @param  \App\Scene  $scene
     * @return mixed
     */
    public function store(User $user, Scene $scene)
    {
        return $scene->cameraOwnedByUser(request()->camera_id);
    }

    /**
     * Determine whether the user can update the scene.
     *
     * @param  \App\User  $user
     * @param  \App\Scene  $scene
     * @return mixed
     */
    public function update(User $user, Scene $scene)
    {
        return $scene->user_id == $user->id && $scene->cameraOwnedByUser(request()->camera_id);
    }
}