<?php

namespace App\Policies;

use App\Traits\AdminActions;
use App\User;
use App\Vacation;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacationPolicy
{
    use HandlesAuthorization, AdminActions;

    /**
     * Determine whether the user can view the vacation.
     *
     * @param  \App\User  $user
     * @param  \App\Vacation  $vacation
     * @return mixed
     */
    public function view(User $user, Vacation $vacation)
    {
        return $user->id === $vacation->worker->id || $user->id ;
    }

    /**
     * Determine whether the user can create vacations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the vacation.
     *
     * @param  \App\User  $user
     * @param  \App\Vacation  $vacation
     * @return mixed
     */
    public function update(User $user, Vacation $vacation)
    {
        //
    }

    /**
     * Determine whether the user can delete the vacation.
     *
     * @param  \App\User  $user
     * @param  \App\Vacation  $vacation
     * @return mixed
     */
    public function delete(User $user, Vacation $vacation)
    {
        //
    }
}
