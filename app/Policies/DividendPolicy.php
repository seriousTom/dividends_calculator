<?php

namespace App\Policies;

use App\Models\Dividend;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DividendPolicy
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

    public function delete(User $user, Dividend $dividend): bool
    {
        return $user->id == $dividend->user_id;
    }
}
