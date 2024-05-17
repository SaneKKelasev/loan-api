<?php

namespace Tests;

use App\Models\Loan;
use App\Models\User;
use Laravel\Lumen\Testing\DatabaseTransactions;

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

        $response->assertResponseStatus(201);
        $response->seeJsonStructure([
            'id',
            'user_id',
            'amount',
            'interest_rate',
            'created_at',
            'updated_at',
        ]);

        $this->seeInDatabase('loans', [
            'user_id' => $user->id,
            'amount' => 5000,
            'interest_rate' => 10,
        ]);
    }

    public function testShow()
    {
        $loan = Loan::factory()->create();

        $response = $this->get("/api/loans/{$loan->id}");

        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
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

        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
            'id',
            'user_id',
            'amount',
            'interest_rate',
            'created_at',
            'updated_at',
        ]);

        $this->seeInDatabase('loans', [
            'id' => $loan->id,
            'amount' => 7000,
            'interest_rate' => 12,
        ]);
    }

    public function testDestroy()
    {
        $loan = Loan::factory()->create();

        $response = $this->delete("/api/loans/{$loan->id}");

        $response->assertResponseStatus(204);
        $this->notSeeInDatabase('loans', [
            'id' => $loan->id,
        ]);
    }

    public function testIndex()
    {
        Loan::factory()->count(10)->create();

        $response = $this->get('/api/loans');

        $response->assertResponseStatus(200);
        $response->seeJsonStructure([
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
            'from',
            'last_page',
            "per_page",
            "prev_page_url",
            "to",
            "total"
        ]);
    }
}
