<?php

namespace Database\Factories;

use App\Models\HeroBanner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HeroBanner>
 */
class HeroBannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'subtitle' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'image_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
            'image_public_id' => 'hero_banners/sample_'.fake()->uuid(),
            'button_text' => 'Mengenal Profil Kami',
            'button_url' => '#tentang',
            'is_active' => true,
            'order' => fake()->numberBetween(0, 10),
        ];
    }

    /**
     * Indicate that the banner should be inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
