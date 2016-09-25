<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Http\Controllers\Admin\User as UserController;
use App\Modules\User\Models\User;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Validate before proceed to next checking.
     *
     * @param  \App\Modules\User\Models\User     $user
     * @param  \App\Http\Controllers\Admin\User  $ability
     * @return bool
     */
    public function before($user, $ability)
    {
        if ($user->isSuperAdmin()) {
            return true;
        }
    }
}
