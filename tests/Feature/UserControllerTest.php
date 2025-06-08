<?php 

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCanFetchUserById(): void 
    {
        $user = User::factory()->create();

        $address = Address::factory()->create([
            'user_id' => $user->id,
            'is_current' => true
        ]);

        $response = $this->getJson("/v1/users/{$user->id}");

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

        $response = $this->getJson("/v1/users/{$nonExistentUserId}");

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
            "email" => "user@example.com"
        ];

        $response = $this->postJson(route('users.store'), $payload);

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
            'email' => 'user@example.com',
            'line1' => '123 Main St',
            'town' => 'Anytown',
            'county' => 'Anycounty',
            'postcode' => 'A1 1AA',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'user@example.com',
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

        $response = $this->postJson(route('users.store'), $payload);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'name',
            'email',
            'phoneNumber',
            'address.postcode',
        ]);
    }
}