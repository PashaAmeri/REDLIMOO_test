<?php

namespace App\Interfaces\Services;

use App\Models\User;
use App\Models\UsersInvitations;
use Illuminate\Http\Request;

interface UsersServiceInterface
{

    public function storeUser(array $userData): User|NULL;
    public function updateProfile(User $user, array $data): User|NULL;
}
