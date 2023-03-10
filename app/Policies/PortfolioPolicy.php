<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
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

    public function show(User $user, Portfolio $portfolio): bool
    {
        return $portfolio->user_id == $user->id;
    }

    public function edit(User $user, Portfolio $portfolio): bool
    {
        return $portfolio->user_id == $user->id;
    }

    public function delete(User $user, Portfolio $portfolio): bool
    {
        return $portfolio->user_id == $user->id;
    }
}
