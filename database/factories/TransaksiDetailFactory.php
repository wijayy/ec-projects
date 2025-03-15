<?php

namespace Database\Factories;

use App\Models\Stok;
use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiDetail>
 */
class TransaksiDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaksi_id' => Transaksi::factory(),
            'stok_id' => Stok::factory(),
            'qty' => mt_rand(3, 20),
            'harga' => mt_rand(50, 200) * 1000,
        ];
    }
}