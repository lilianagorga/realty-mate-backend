<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'list' => $this->faker->numberBetween(1, 100),
            'cover' => '/images/customer/default.jpg',
            'icon' => json_encode([
                '<i class="fa-brands fa-facebook-f"></i>',
                '<i class="fa-brands fa-linkedin"></i>',
                '<i class="fa-brands fa-twitter"></i>',
                '<i class="fa-brands fa-instagram"></i>'
            ]),
        ];
    }
}
