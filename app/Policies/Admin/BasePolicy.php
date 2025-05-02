<?php

namespace App\Policies\Admin;

use App\Models\User;

class BasePolicy
{
    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     *
     * @return void|bool
     */
    public function authorize(User $user)
    {
        $roles = $user->roles()->get()->pluck('name')->toArray();
        // add roles to give access here
        if (!empty(array_intersect(['admin'], $roles))) {
            return true;
        }
    }
}
