<?php 

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Currency;
use App\Models\TransactionType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use Tests\Traits\UsesJwtAuth;

class TransactionControllerTest extends TestCase
{
    use RefreshDatabase, UsesJwtAuth;

    public function testCanDeposit(): void 
    {
        $token = $this->authenticate([
            'email' => 'user@example.com',
            'password' => 'password'
        ]);

        $user = $this->loggedInUser;

        $transactionType = TransactionType::factory()->create([
            'slug' => 'deposit'
        ]);

        $currency = Currency::factory()->create([
            'code' => 'GBP',
            'decimal_places' => 2
        ]);

        $account = Account::factory()->create([
            'user_id' => $user->id,
            'currency_id' => $currency->id,
            'balance' => 0,
        ]);

        $payload = [
            'amount' => 100.00,
            'currency' => 'GBP',
            'type' => 'deposit',
            'reference' => 'Initial deposit'
        ];

        // Act: perform the request as the authenticated user
        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->postJson("/v1/accounts/{$account->id}/transactions", $payload);

        // Assert
        $response->assertCreated();
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('status', 201)
                 ->has('response.id')
                 ->where('response.amount', fn ($value) => $value == 100.00)
                 ->where('response.currency', 'GBP')
                 ->where('response.type', 'deposit')
                 ->where('response.reference', 'Initial deposit')
                 ->where('response.userId', $user->id)
                 ->has('response.createdTimestamp')
        );

        $this->assertDatabaseHas('transactions', [
            'account_id' => $account->id,
            'transaction_type_id' => $transactionType->id,
            'reference' => $payload['reference'],
            'amount' => 10000,
        ]);

        $this->assertDatabaseHas('accounts', [
            'balance' => 10000
        ]);
    }

    public function testCanWithdraw(): void 
    {
        $token = $this->authenticate([
            'email' => 'user@example.com',
            'password' => 'password'
        ]);

        $user = $this->loggedInUser;

        $transactionType = TransactionType::factory()->create([
            'slug' => 'withdraw'
        ]);

        $currency = Currency::factory()->create([
            'code' => 'GBP',
            'decimal_places' => 2
        ]);

        $account = Account::factory()->create([
            'user_id' => $user->id,
            'currency_id' => $currency->id,
            'balance' => 200000,
        ]);

        $payload = [
            'amount' => 100.00,
            'currency' => 'GBP',
            'type' => 'withdraw',
            'reference' => 'Withdraw reference'
        ];

        // Act: perform the request as the authenticated user
        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->postJson("/v1/accounts/{$account->id}/transactions", $payload);

        // Assert
        $response->assertCreated();
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('status', 201)
                 ->has('response.id')
                 ->where('response.amount', fn ($value) => $value == 100.00)
                 ->where('response.currency', 'GBP')
                 ->where('response.type', 'withdraw')
                 ->where('response.reference', 'Withdraw reference')
                 ->where('response.userId', $user->id)
                 ->has('response.createdTimestamp')
        );

        $this->assertDatabaseHas('transactions', [
            'account_id' => $account->id,
            'transaction_type_id' => $transactionType->id,
            'reference' => $payload['reference'],
            'amount' => 10000,
        ]);

        $this->assertDatabaseHas('accounts', [
            'balance' => 190000
        ]);
    }

    public function testCanNotWithdrawInsufficientFunds(): void 
    {
        $token = $this->authenticate([
            'email' => 'user@example.com',
            'password' => 'password'
        ]);

        $user = $this->loggedInUser;

        $transactionType = TransactionType::factory()->create([
            'slug' => 'withdraw'
        ]);

        $currency = Currency::factory()->create([
            'code' => 'GBP',
            'decimal_places' => 2
        ]);

        $account = Account::factory()->create([
            'user_id' => $user->id,
            'currency_id' => $currency->id,
            'balance' => 2000,
        ]);

        $payload = [
            'amount' => 100.00,
            'currency' => 'GBP',
            'type' => 'withdraw',
            'reference' => 'Withdraw reference'
        ];

        // Act: perform the request as the authenticated user
        $response = $this->withHeaders($this->withAuthHeader($token))
                         ->postJson("/v1/accounts/{$account->id}/transactions", $payload);

        $response->assertStatus(422)
                 ->assertJson([
                     'status' => 422,
                     'message' => 'Insufficient funds.'
                 ]);
    }
}