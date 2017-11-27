<?php

namespace App\Policies;

use App\Traits\AdminActions;
use App\User;
use App\Worker;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkerPolicy
{
    use HandlesAuthorization,AdminActions;

    /**
     * Determine whether the user can view the worker.
     *
     * @param  \App\User  $user
     * @param  \App\Worker  $worker
     * @return mixed
     */
    public function view(User $user, Worker $worker)
    {
        $user->id === $worker->id;
    }

    /**
     * Determine whether the user can create workers.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the worker.
     *
     * @param  \App\User  $user
     * @param  \App\Worker  $worker
     * @return mixed
     */
    public function update(User $user, Worker $worker)
    {
        //
    }

    /**
     * Determine whether the user can delete the worker.
     *
     * @param  \App\User  $user
     * @param  \App\Worker  $worker
     * @return mixed
     */
    public function delete(User $user, Worker $worker)
    {
        //
    }
}
