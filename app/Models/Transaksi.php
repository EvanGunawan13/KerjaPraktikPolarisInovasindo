<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
    'nomor_invoice',
    'produk_id',
    'jumlah_jual',
    'nama_toko',
    'nomor_nota',
    'total_harga',
    'bayar',
    'dp',
    'tanggal_pembayaran',
    'user_id',
];

public function produk()
{
    return $this->belongsTo(Produk::class, 'produk_id');
}

    public function user() {
        return $this->belongsTo(User::class);
    }
}