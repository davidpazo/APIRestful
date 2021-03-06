<?php

namespace App\Policies;

use App\Traits\AdminActions;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization,AdminActions;

    /**
     * Determine whether the user can view the user.
     * sirve para que necesite un token de verificacion a la hora de poder modificar algo con respecto a los usuarios.
     * @param  \App\User $user
     * @param  \App\User $user
     * @return mixed
     */

    public function view(User $authenticatedUser, User $user)
    {
        return $authenticatedUser->id === $user->id;
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User $user
     * @return mixed
     */
    public function create(User $authenticatedUser)
    {
        //
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User $user
     * @param  \App\User $user
     * @return mixed
     */
    public function update(User $authenticatedUser, User $user)
    {
        return $authenticatedUser->id === $user->id;
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User $user
     * @param  \App\User $user
     * @return mixed
     */
    public function delete(User $authenticatedUser, User $user)
    {
        return $authenticatedUser->id === $user->id && $authenticatedUser->token()->client->personal_access_client;
    }
}
