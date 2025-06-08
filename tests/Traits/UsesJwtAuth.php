<?php

namespace Tests\Traits;

use App\Models\User;

trait UsesJwtAuth
{
    protected function authenticate(array $overrides = []): string
    {
        $password = $overrides['password'] ?? 'password';

        $user = User::factory()->create(array_merge([
            'email' => 'user@example.com',
            'password' => bcrypt($password),
        ], $overrides));

        $response = $this->postJson('/v1/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertOk();

        return $response->json('access_token');
    }

    protected function withAuthHeader(string $token): array
    {
        return ['Authorization' => "Bearer $token"];
    }
}