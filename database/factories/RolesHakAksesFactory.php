<?php

namespace Database\Factories;

use App\Models\HakAkses;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RolesHakAkses>
 */
class RolesHakAksesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'role_id' => Role::factory(),
            'hak_akses_id' => HakAkses::factory(),
        ];
    }
}