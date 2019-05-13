<?php

namespace App\Policies;

use App\User;
use App\ThreeD;
use Illuminate\Auth\Access\HandlesAuthorization;

class ThreeDPolicy
{
    use HandlesAuthorization;

    //php artisan make:policy ThreeDPolicy --model=ThreeD

    /**
     * Determine whether the user can view the three d.
     *
     * @param  \App\User  $user
     * @param  \App\ThreeD  $three_d
     * @return mixed
     */
    public function view(User $user, ThreeD $three_d)
    {
        return $three_d->user_id == $user->id || $user->type == 'admin';
    }

    /**
     * Determine whether the user can update the three d.
     *
     * @param  \App\User  $user
     * @param  \App\ThreeD  $three_d
     * @return mixed
     */
    public function update(User $user, ThreeD $three_d)
    {
        return $three_d->user_id == $user->id || $user->type == 'admin';
    }
}