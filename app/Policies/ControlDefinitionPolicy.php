<?php

namespace App\Policies;

use App\User;
use App\ControlDefinition;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class ControlDefinitionPolicy
{
    use HandlesAuthorization;

    //php artisan make:policy ControlDefinitionPolicy --model=ControlDefinitionPolicy

    /**
     * Determine whether the user can view the scene.
     *
     * @param  \App\User  $user
     * @param  \App\ControlDefinition  $control_definition
     * @return mixed
     */
    public function view(User $user, ControlDefinition $control_definition)
    {
        return $control_definition->user_id == $user->id;
    }

    /**
     * Determine whether the user can store the scene.
     *
     * @param  \App\User  $user
     * @param  \App\ControlDefinition  $control_definition
     * @return mixed
     */
    public function store(User $user, ControlDefinition $control_definition)
    {
        return $control_definition->ThreeDOwnedByUser(request()->three_d_id);
    }

    /**
     * Determine whether the user can update the scene.
     *
     * @param  \App\User  $user
     * @param  \App\ControlDefinition  $control_definition
     * @return mixed
     */
    public function update(User $user, ControlDefinition $control_definition)
    {
        return $control_definition->user_id == $user->id && $control_definition->ThreeDOwnedByUser(request()->three_d_id);
    }
}