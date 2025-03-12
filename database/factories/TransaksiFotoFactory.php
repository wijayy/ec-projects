<?php

namespace Database\Factories;

use App\Models\Transaksi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiFoto>
 */
class TransaksiFotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file' => 'file/transaksi.jpg',
            'filename' => 'transaksi.jpg',
            'transaksi_id' => Transaksi::factory()
        ];
    }
}