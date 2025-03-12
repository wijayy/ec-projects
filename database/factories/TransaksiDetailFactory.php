<?php

namespace Database\Factories;

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
        $size = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
        $color = ['Hitam', "Putih", null];
        $arm = ['Pendek', "Panjang", null];
        return [
            'transaksi_id' => Transaksi::factory(),
            'nama' => 'p1',
            'deskripsi' => 'd1',
            'size' => $size[mt_rand(0, 5)],
            'color' => $color[mt_rand(0, 2)],
            'arm' => $arm[mt_rand(0, 2)],
            'qty' => mt_rand(3, 20),
            'harga' => mt_rand(50, 200) * 1000,
        ];
    }
}
