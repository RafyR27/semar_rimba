<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3);

        return [
            'user_id' => User::factory(),
            'title' => $title,
            'slug' => Str::slug($title).'-'.Str::lower(Str::random(5)),
            'category' => fake()->randomElement(['Ekspedisi', 'Diklat', 'SAR & Kemanusiaan', 'Konservasi']),
            'location' => fake()->city(),
            'event_date' => fake()->date(),
            'description' => fake()->paragraphs(2, true),
            'image_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
            'image_public_id' => 'activities/sample_'.fake()->uuid(),
            'status' => 'published',
            'is_active' => true,
            'order' => fake()->numberBetween(0, 10),
        ];
    }

    /**
     * Indicate that the activity should be inactive (draft).
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'draft',
            'is_active' => false,
        ]);
    }
}
