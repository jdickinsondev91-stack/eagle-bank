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
                         'name' => $user->first_name . ' ' . $user->last_name,
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
}