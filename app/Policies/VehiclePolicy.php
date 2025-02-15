<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vehicle;

class VehiclePolicy
{
    public function view(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id;
    }

    public function update(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id;
    }

    public function delete(User $user, Vehicle $vehicle)
    {
        return $user->id === $vehicle->user_id;
    }
}
