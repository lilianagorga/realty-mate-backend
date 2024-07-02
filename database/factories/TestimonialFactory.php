<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'company' => $this->faker->company,
            'testimonial' => $this->faker->paragraph,
            'image' => '/images/testimonials/testimonial1.jpg',
        ];
    }
}
