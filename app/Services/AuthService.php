<?php 

namespace App\Services;

use App\DTOs\AuthDTO;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function login(AuthDTO $dto): string
    {
        if (! $token = JWTAuth::attempt($dto->toArray())) {
            throw new \Exception('Invalid credentials');
        }

        return $token;
    }

    public function logout(): void
    {
        /** @var JWTGuard $guard */
        $guard = auth();
        $guard->logout();
    }

    public function currentUser(): \App\Models\User
    {
        /** @var JWTGuard $guard */
        $guard = auth();
        return $guard->user();
    }
}