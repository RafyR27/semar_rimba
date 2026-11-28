<?php

namespace Database\Factories;

use App\Models\Divisi;
use App\Models\Pengurus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pengurus>
 */
class PengurusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->name(),
            'nim' => 'SR-'.fake()->unique()->numerify('2024###'),
            'jabatan' => fake()->randomElement(['Koordinator Matra', 'Anggota Aktif', 'Staf Operasional']),
            'divisi_id' => Divisi::factory(),
            'angkatan' => (string) fake()->numberBetween(2021, 2025),
            'is_active' => true,
        ];
    }
}
