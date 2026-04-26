<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $fillable = [
    'nomor_invoice', 
    'nama_toko', 
    'nomor_nota', 
    'total_harga', 
    'bayar', 
    'kembalian', 
    'tanggal_pembayaran', 
    'user_id'
];

    public function user() {
        return $this->belongsTo(User::class);
    }
}