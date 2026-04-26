<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transaksi', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_invoice')->unique();
        $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
        $table->decimal('total_harga', 15, 2);
        $table->decimal('bayar', 15, 2);
        $table->decimal('kembalian', 15, 2);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
