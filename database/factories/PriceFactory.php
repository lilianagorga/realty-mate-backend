<?php

namespace Database\Factories;

use App\Models\Price;
use Illuminate\Database\Eloquent\Factories\Factory;

class PriceFactory extends Factory
{
    protected $model = Price::class;

    public function definition(): array
    {
        return [
            'plan' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'ptext' => $this->faker->sentence,
            'best' => $this->faker->boolean ? 'Best Value' : null
        ];
    }
}
