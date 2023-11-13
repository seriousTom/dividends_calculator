<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Dividend;
use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dividend>
 */
class DividendFactory extends Factory
{
    protected $model = Dividend::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'amount' => rand(10,100),
            'taxes_amount' => rand(1, 5),
            'currency_id' => 1,
            'user_id' => 1,
            'company_id' => Company::all()->random()->id,
            'portfolio_id' => Portfolio::withoutGlobalScopes()->inRandomOrder()->first()->id,
            'date' => $this->faker->dateTimeBetween('-5 years', 'now')
        ];
    }
}
