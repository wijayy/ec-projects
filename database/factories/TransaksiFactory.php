<?php

namespace Database\Factories;

use App\Models\Provinsi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaksi>
 */
class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ['belum diproses', 'diproses', 'selesai'];
        $platform = ['offline', 'shopee', 'tiktok', 'tokopedia', 'whatsapp'];
        $payment = ['cash', 'transfer'];
        return [
            'nomor_transaksi' => date('Ynd') . fake()->randomLetter() . fake()->randomLetter() . fake()->randomLetter(),
            'customer' => fake()->name(),
            'status' => $status[mt_rand(0, 2)],
            'diskon' => 0,
            "total" => mt_rand(100, 300) * 1000,
            'platform' => $platform[mt_rand(0, 4)],
            'payment' => $payment[mt_rand(0, 1)],
            'catatan' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aliquid, magnam!',
            'provinsi_id' => Provinsi::factory(),
            'created_at' => fake()->date()
        ];
    }
}