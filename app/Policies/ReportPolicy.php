<?php

namespace App\Policies;

use App\User;
use App\Report;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class ReportPolicy
{
    use HandlesAuthorization;

    //php artisan make:policy ControlDefinitionPolicy --model=ControlDefinitionPolicy

    /**
     * Determine whether the user can view the scene.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function view(User $user, Report $report)
    {
        return $report->control_definition->user_id == $user->id;
    }

    /**
     * Determine whether the user can store the scene.
     *
     * @param  \App\User  $user
     * @param  \App\Report  $report
     * @return mixed
     */
    public function store(User $user, Report $report)
    {
        return $report->controlDefinitionOwnedByUser(request()->control_definition_id);
    }

    /**
     * Determine whether the user can update the scene.
     *
     * @param  \App\User $user
     * @param  \App\Report $report
     * @return mixed
     */
    public function update(User $user, Report $report)
    {
        return $report->control_definition->user_id == $user->id && $report->controlDefinitionOwnedByUser(request()->control_definition_id);
    }
}