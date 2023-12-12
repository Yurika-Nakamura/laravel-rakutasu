<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class AuthService
{
    protected $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register($data)
    {
        return $this->authRepository->createUser($data);
    }

    public function checkEmail($data)
    {
        return $this->authRepository->checkEmail($data);
    }

    public function sendPasswordResetEmail($data)
    {
        $token = Password::broker()->createToken($data);
        $now = Carbon::now();
        $expire_at = $now->addHour(1)->toDateTimeString();

        $userTokenData = [
            'user_id' => $data->id,
            'token' => $token,
            'expire_at' => $expire_at,
        ];

        $this->authRepository->createUserToken($userTokenData);

        return $token;
    }

}