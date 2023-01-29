<?php

namespace App\Policies;

use App\Models\Platform;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlatformPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function select(User $user, Platform $platform)
    {
        return $platform->user_id == $user->id || empty($platform->user_id);
    }

    public function edit(User $user, Platform $platform)
    {
        return $platform->user_id == $user->id;
    }

    public function delete(User $user, Platform $platform)
    {
        return $platform->user_id == $user->id;
    }
}
