<?php

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
        Schema::create('MutasiStok', function (Blueprint $table) {
        $table->id();
        $table->foreignId('Produk_id')->constrained('produk')->onDelete('cascade');
        $table->enum('tipe', ['masuk', 'keluar', 'penyesuaian']);
        $table->integer('jumlah');
        $table->string('referensi')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_stock_mutations');
    }
};
