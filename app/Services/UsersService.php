<?php

namespace App\Services;

use App\Models\User;
use App\Traits\Users\Generators;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\Services\UsersServiceInterface;
use App\Traits\Users\ReferralCode;

class UsersService implements UsersServiceInterface
{

    public function storeUser(array $data): User|false
    {
        if (!checkClient(request()->only(['grant_type', 'client_id', 'client_secret']))) {

            return false;
        }

        return User::create([
            'name' => ucwords(strtolower($data['name'])),
            'email' => strtolower($data['email']),
            'phone' => $data['phone'],
            'bio' => $data['bio'] ?? NULL,
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
