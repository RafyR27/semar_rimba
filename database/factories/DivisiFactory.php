<?php

namespace Database\Factories;

use App\Models\Divisi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Divisi>
 */
class DivisiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => 'Matra '.fake()->unique()->word().' '.fake()->unique()->numerify('##'),
            'deskripsi' => fake()->sentence(12),
            'is_active' => true,
        ];
    }
}
