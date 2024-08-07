<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

class PartnerFactory extends Factory
{
    protected $model = Partner::class;

    public function definition(): array
    {
        $defaultLogos = config('partners_data.default_logos');

        return [
            'name' => $this->faker->company,
            'logo' => $this->faker->randomElement($defaultLogos)
        ];
    }
}
