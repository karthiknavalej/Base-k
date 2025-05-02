<?php

namespace App\Policies\Admin;

use App\Models\User;
use App\Models\Action;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActionPolicy extends BasePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     *
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($this->authorize($user)) {
            return true;
        }
    }
    
    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Action  $model
     *
     * @return mixed
     */
    public function view(User $user, Action $model)
    {
        return $user->id === $model->created_by;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Action  $model
     *
     * @return mixed
     */
    public function update(User $user, Action $model)
    {
        return $user->id === $model->created_by;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Action  $model
     *
     * @return mixed
     */
    public function delete(User $user, Action $model)
    {
        return $user->id === $model->created_by;
    }
}
