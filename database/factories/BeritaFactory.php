<?php

namespace Database\Factories;

use App\Models\Berita;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Berita>
 */
class BeritaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $judul = 'Ekspedisi Rimba '.fake()->unique()->words(2, true);

        return [
            'judul' => Str::title($judul),
            'slug' => Str::slug($judul),
            'konten' => fake()->paragraphs(4, true),
            'thumbnail_url' => 'https://res.cloudinary.com/demo/image/upload/sample.jpg',
            'thumbnail_public_id' => 'beritas/sample_'.fake()->unique()->numerify('#####'),
            'tanggal_terbit' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            'is_published' => true,
        ];
    }

    /**
     * Indicate that the news is still a draft.
     */
    public function draft(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_published' => false,
        ]);
    }
}
