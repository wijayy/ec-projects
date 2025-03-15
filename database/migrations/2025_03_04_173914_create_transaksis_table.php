<?php

use App\Models\Provinsi;
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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['belum diproses', 'diproses', 'selesai']);
            $table->integer('diskon');
            $table->integer('total');
            // $table->integer('total');
            $table->enum('platform', ['offline', 'shopee', 'tiktok', 'tokopedia', 'whatsapp']);
            $table->enum('payment', ['cash', 'transfer']);
            $table->string('customer');
            $table->string('nomor_transaksi');
            $table->string('slug')->unique();
            $table->string('catatan')->nullable();
            $table->foreignIdFor(Provinsi::class);
            $table->dateTime('selesai')->nullable();
            $table->boolean('lunas')->default(1);
            $table->integer('dp')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};