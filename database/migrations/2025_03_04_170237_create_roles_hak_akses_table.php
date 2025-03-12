<?php

use App\Models\HakAkses;
use App\Models\Role;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('roles_hak_akses', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Role::class);
            $table->foreignIdFor(HakAkses::class);
            $table->unique(['role_id', 'hak_akses_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles_hak_akses');
    }
};