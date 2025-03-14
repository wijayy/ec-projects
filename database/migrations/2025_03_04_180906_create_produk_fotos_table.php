<?php

use App\Models\Produk;
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
        Schema::create('produk_fotos', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('filename');
            $table->foreignIdFor(Produk::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_fotos');
    }
};