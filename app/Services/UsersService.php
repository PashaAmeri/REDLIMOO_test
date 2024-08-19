<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Services\UsersServiceInterface;

class UsersService implements UsersServiceInterface
{

    public function storeUser(array $data): User|false
    {

        return User::create([
            'name' => ucwords(strtolower($data['name'])),
            'email' => strtolower($data['email']),
            'phone' => $data['phone'],
            'bio' => $data['bio'] ?? NULL,
            'password' => Hash::make($data['password']),
        ]);
    }

    public function updateProfile(User $user, array $data): User|NULL
    {

        $user->name = ucwords(strtolower($data['name']));
        $user->email = strtolower($data['email']);
        $user->bio = $data['bio'];

        $user->save();

        return $user;
    }
}
