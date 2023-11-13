<?php

namespace Database\Seeders;

use App\Models\Dividend;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DividendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Dividend::factory()->count(500)->create();
    }
}
