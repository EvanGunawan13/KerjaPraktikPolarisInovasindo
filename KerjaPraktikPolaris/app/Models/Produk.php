<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    // Tambahkan baris ini. Sesuaikan 'produk' dengan nama tabel di phpMyAdmin Anda.
    protected $table = 'produk'; 

    protected $fillable = ['kategori_id', 'sku', 'nama_produk', 'stok', 'stok_minimum', 'harga_beli', 'harga_jual'];

    public function Kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function Mutasi()
    {
        return $this->hasMany(MutasiStok::class);
    }
}