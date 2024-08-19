<?php

namespace App\Interfaces\Services;

use App\Models\User;

interface UsersServiceInterface
{

    public function storeUser(array $userData): User|false;
    public function updateProfile(User $user, array $data): User|NULL;
    public function generateToken(string $phone): object;
}
