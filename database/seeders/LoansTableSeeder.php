<?php

namespace Database\Seeders;

use App\Models\Loan;
use Illuminate\Database\Seeder;

class LoansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Loan::factory()->count(50)->create();
    }
}
