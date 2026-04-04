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
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            // Menghubungkan ke tabel 'kategori'
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            
            $table->string('sku')->unique();
            $table->string('nama_produk');
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(0);
            $table->decimal('harga_beli', 15, 2);
            $table->decimal('harga_jual', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // PERBAIKAN: Nama tabel harus sama dengan yang ada di up()
        Schema::dropIfExists('produk');
    }
};