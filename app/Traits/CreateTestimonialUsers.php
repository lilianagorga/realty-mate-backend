<?php

namespace App\Traits;

use App\Models\Testimonial;

trait CreateTestimonialUsers
{
    public function createTestimonialUsers(): void
    {
        $testimonials = config('testimonials_data.testimonials');
        $defaultImages = config('testimonials_data.default_images');

        foreach ($testimonials as $testimonial) {
            $image = $testimonial['image'] ?? $defaultImages[array_rand($defaultImages)];
            Testimonial::updateOrCreate(
                ['name' => $testimonial['name'], 'company' => $testimonial['company']],
                array_merge($testimonial, ['image' => $image])
            );
        }
    }
}
