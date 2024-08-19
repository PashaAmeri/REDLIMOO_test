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
        ]);
    }

    public function updateProfile(User $user, array $data): User|NULL
    {

        $user->name = ucwords(strtolower($data['name']));
        $user->email = strtolower($data['email']);
        $user->bio = $data['bio'] ?? NULL;

        $user->save();

        return $user;
    }

    public function generateToken(string $phone): object
    {

        // Fetch the user by phone number
        $user = User::where('phone', $phone)->first();

        // Create a token for the user
        $tokenResult = $user->createToken(CLIENT_SECRET);
        $token = $tokenResult->token;

        // Optionally set token expiration
        $token->expires_at = now()->addYear();
        $token->save();

        return (object) [
            'tokenResult' => $tokenResult,
            'token' => $token
        ];
    }
}
