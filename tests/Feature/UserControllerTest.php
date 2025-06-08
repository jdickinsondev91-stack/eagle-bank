<?php 

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\UsesJwtAuth;

class UserControllerTest extends TestCase
{
    use RefreshDatabase, UsesJwtAuth;

    public function testCanFetchUserById(): void 
    {
        $user = User::factory()->create();

        $address = Address::factory()->create([
            'user_id' => $user->id,
            'is_current' => true
        ]);

        $token = $this->authenticate();

        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->getJson("/v1/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'status' => 200,
                     'response' => [
                         'id' => $user->id,
                         'name' => $user->name,
                         'email' => $user->email,
                         'phoneNumber' => $user->phone_number,
                         'address' => [
                             'line1' => $address->line_1,
                             'line2' => $address->line_2,
                             'line3' => $address->line_3,
                             'town' => $address->town,
                             'county' => $address->county,
                             'postcode' => $address->postcode,
                         ],
                         'createdTimestamp' => $user->created_at->format('Y-m-d\TH:i:s.u'),
                         'updatedTimestamp' => $user->updated_at->format('Y-m-d\TH:i:s.u'),
                     ]
                 ]);
    }

    public function testFetchNonExistentUser(): void 
    {
        $nonExistentUserId = 'usr-nonexistent123';

        $token = $this->authenticate();

        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->getJson("/v1/users/{$nonExistentUserId}");

        $response->assertStatus(404)
                ->assertJson([
                    'status' => 404,
                    'message' => 'User not found.'
                ]);
    }

    public function testCanCreateUser(): void 
    {
        $payload = [
            "name" => "Test User",
            "address" => [
                "line1" => "123 Main St",
                "town" => "Anytown",
                "county" => "Anycounty",
                "postcode" => "A1 1AA"
            ],
            "phoneNumber" => "+441234567890",
            "email" => "user1@example.com"
        ];

        $token = $this->authenticate();

        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->postJson(route('users.store'), $payload);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'status',
            'response' => [
                'id',
                'name',
                'address' => [
                    'line1',
                    'line2',
                    'line3',
                    'town',
                    'county',
                    'postcode',
                ],
                'phoneNumber',
                'email',
                'createdTimestamp',
                'updatedTimestamp',
            ],
        ]);

        $response->assertJsonFragment([
            'name' => 'Test User',
            'phoneNumber' => '+441234567890',
            'email' => 'user1@example.com',
            'line1' => '123 Main St',
            'town' => 'Anytown',
            'county' => 'Anycounty',
            'postcode' => 'A1 1AA',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'user1@example.com',
            'name' => 'Test User',
        ]);

        $this->assertDatabaseHas('addresses', [
            'line_1' => '123 Main St',
            'town' => 'Anytown',
            'county' => 'Anycounty',
            'postcode' => 'A1 1AA',
        ]);
    }

    public function testCanNotCreateUsingFailedValidation(): void
    {
        $payload = [
            "name" => "",
            "address" => [
                "line1" => "123 Main St",
                "town" => "Anytown",
                "county" => "Anycounty",
                "postcode" => "INVALID"
            ],
            "phoneNumber" => "123456",
            "email" => "not-an-email"
        ];

        $token = $this->authenticate();

        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->postJson(route('users.store'), $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'name',
            'email',
            'phoneNumber',
            'address.postcode',
        ]);
    }

    public function testCanUpdateUser(): void 
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'email' => 'old@example.com',
        ]);

        $address = Address::factory()->create([
            'user_id' => $user->id,
            'is_current' => true,
            'line_1' => 'Old Street',
        ]);

        $payload = [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'phoneNumber' => '+441234567890',
            'address' => [
                'line1' => '123 Main St',
                'town' => 'Anytown',
                'county' => 'Anycounty',
                'postcode' => 'A1 1AA',
            ]
        ];

        $token = $this->authenticate();

        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->putJson("/v1/users/{$user->id}", $payload);

        $response->assertJsonStructure([
            'status',
            'response' => [
                'id',
                'name',
                'address' => [
                    'line1',
                    'line2',
                    'line3',
                    'town',
                    'county',
                    'postcode',
                ],
                'phoneNumber',
                'email',
                'createdTimestamp',
                'updatedTimestamp',
            ],
        ]);

        $response->assertOk();
        $response->assertJsonFragment([
            'name' => 'New Name',
            'email' => 'new@example.com',
            'line1' => '123 Main St',
            'postcode' => 'A1 1AA',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'new@example.com',
        ]);

        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'line_1' => '123 Main St',
        ]);
    }

    public function testUpdateNonExistentUser(): void 
    {
        $nonExistentId = 'usr-nonexistent123';

        $payload = [
            'name' => 'New Name',
            'email' => 'new@example.com',
            'phoneNumber' => '+441234567890',
            'address' => [
                'line1' => '123 Main St',
                'town' => 'Anytown',
                'county' => 'Anycounty',
                'postcode' => 'A1 1AA',
            ]
        ];

        $token = $this->authenticate();

        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->patchJson("/v1/users/{$nonExistentId}", $payload);

        $response->assertStatus(404)
                 ->assertJson([
                     'status' => 404,
                     'message' => 'User not found.'
                 ]);
    }

    public function testCanNotUpdateUsingFailedValidation(): void 
    {
        $user = User::factory()->create();
        Address::factory()->create(['user_id' => $user->id]);

        $payload = [
            'email' => 'not-an-email',
            'phoneNumber' => 'invalid-number',
            'address' => [
                'postcode' => 'NOT A VALID POSTCODE'
            ]
        ];

        $token = $this->authenticate();

        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->putJson("/v1/users/{$user->id}", $payload);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email', 'phoneNumber', 'address.postcode']);
    }

    public function testCanDeleteUserNoAccounts(): void 
    {
        $user = User::factory()->create();
        Address::factory()->count(2)->create(['user_id' => $user->id]);

        $token = $this->authenticate();

        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->deleteJson("/v1/users/{$user->id}");

        $response->assertStatus(200)
                 ->assertJson(['status' => 200]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
        $this->assertDatabaseMissing('addresses', ['user_id' => $user->id]);
    }

    public function testUserNotFoundDelete(): void 
    {
        $nonExistentId = 'usr-nonexistent123';

        $token = $this->authenticate();

        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->deleteJson("/v1/users/{$nonExistentId}");

        $response->assertStatus(404)
                 ->assertJson([
                     'status' => 404,
                     'message' => 'User not found.'
                 ]);
    }

    public function testCanNotDeleteUserWithAccounts(): void 
    {
        $user = User::factory()->create();
        Account::factory()->create(['user_id' => $user->id]);

        $token = $this->authenticate();

        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->deleteJson("/v1/users/{$user->id}");

        $response->assertStatus(409)
                 ->assertJson([
                     'status' => 409,
                     'message' => 'User has linked accounts.'
                 ]);

        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}