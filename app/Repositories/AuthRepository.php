<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Support\Facades\Hash;

class AuthRepository
{
    public function createUser($data)
    {
        return User::create([
            'last_name' => $data['last_name'],
            'first_name' => $data['first_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function checkEmail($data)
    {
        return User::where('email', $data['email'])->first();
    }

    public function createUserToken($data)
    {
        return UserToken::create([
            'user_id' => $data['user_id'],
            'token' => $data['token'],
            'expire_at' => $data['expire_at'],
        ]);
    }
}