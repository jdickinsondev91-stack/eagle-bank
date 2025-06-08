<?php

namespace App\Http\Controllers\V1;

use App\DTOs\AuthDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $dto = AuthDTO::fromRequest($request->validated());
            $token = $this->authService->login($dto);

            /** @var \Tymon\JWTAuth\JWTGuard $guard */
            $guard = auth();

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => $guard->factory()->getTTL() * 60
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Invalid credentials'
            ], 401);
        }
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json([
            'message' => 'Logged out'
        ]);
    }

    public function me(): JsonResponse
    {
        return response()->json($this->authService->currentUser());
    }
}
