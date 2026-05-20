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
    Schema::table('transaksi', function (Blueprint $table) {
        $table->foreignId('produk_id')->nullable()->constrained('produk')->onDelete('set null');
        $table->integer('jumlah_jual')->default(0);
    });
}

public function down(): void
{
    Schema::table('transaksi', function (Blueprint $table) {
        $table->dropForeign(['produk_id']);
        $table->dropColumn(['produk_id', 'jumlah_jual']);
    });
}
};
