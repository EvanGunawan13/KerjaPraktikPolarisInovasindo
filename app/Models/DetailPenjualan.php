<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $fillable = ['penjualan_id', 'produk_id', 'jumlah', 'harga_saat_jual', 'subtotal'];

public function Produk()
{
    return $this->belongsTo(Produk::class);
}
}
