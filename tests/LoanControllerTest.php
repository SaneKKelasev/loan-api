<?php

namespace Tests;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LoanControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function testStore()
    {
        $user = User::factory()->create();

            $response = $this->post('/api/loans', [
                'user_id' => $user->id,
                'amount' => 5000,
                'interest_rate' => 10,
            ]);

        $response->assertStatus(201);
        $response->assertJsonStructure([
            'id',
            'user_id',
            'amount',
            'interest_rate',
            'created_at',
            'updated_at',
        ]);

        $this->assertDatabaseHas('loans', [
            'user_id' => $user->id,
            'amount' => 5000,
            'interest_rate' => 10,
        ]);
    }

    public function testShow()
    {
        $loan = Loan::factory()->create();

        $response = $this->get("/api/loans/{$loan->id}");

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'user_id',
            'amount',
            'interest_rate',
            'created_at',
            'updated_at',
        ]);
    }

    public function testUpdate()
    {
        $loan = Loan::factory()->create();

        $response = $this->put("/api/loans/{$loan->id}", [
            'amount' => 7000,
            'interest_rate' => 12,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'id',
            'user_id',
            'amount',
            'interest_rate',
            'created_at',
            'updated_at',
        ]);

        $this->assertDatabaseHas('loans', [
            'id' => $loan->id,
            'amount' => 7000,
            'interest_rate' => 12,
        ]);
    }

    public function testDestroy()
    {
        $loan = Loan::factory()->create();

        $response = $this->delete("/api/loans/{$loan->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('loans', [
            'id' => $loan->id,
        ]);
    }

    public function testIndex()
    {
        Loan::factory()->count(10)->create();

        $response = $this->get('/api/loans');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'current_page',
            'data' => [
                '*' => [
                    'id',
                    'user_id',
                    'amount',
                    'interest_rate',
                    'created_at',
                    'updated_at',
                ],
            ],
            'first_page_url',
            'from',
            'last_page',
            'last_page_url',
            'links' => [],
            'next_page_url',
            'path',
            'per_page',
            'prev_page_url',
            'to',
            'total',
        ]);
    }
}
