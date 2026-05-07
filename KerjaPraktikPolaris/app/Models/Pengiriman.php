<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengiriman';

    protected $fillable = [
        'transaksi_id',
        'produk_id',
        'user_id',
        'nomor_resi',
        'nama_penerima',
        'nama_toko',
        'alamat_tujuan',
        'jumlah',
        'status',
        'tanggal_kirim',
        'tanggal_sampai',
        'catatan',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Badge color helper
    public function statusColor(): string
    {
        return match($this->status) {
            'Menunggu'   => 'yellow',
            'Perjalanan' => 'blue',
            'Sampai'     => 'green',
            default      => 'gray',
        };
    }
}