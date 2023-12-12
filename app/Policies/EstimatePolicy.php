<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Estimate;

class EstimatePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Estimate $estimate)
    {
        return $user->id === $estimate->user_id;
    }
}
