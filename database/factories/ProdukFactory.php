<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->sentence(2, false),
            'deskripsi' => fake()->sentences(1, true),
            'size' => 'S,M,L,XL,XXL,XXXL',
            'color' => "hitam,putih,merah",
            'arm' => 'pendek,panjang'
        ];
    }
}