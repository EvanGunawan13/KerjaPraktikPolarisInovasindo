<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $fillable = ['nomor_invoice', 'user_id', 'total_harga', 'bayar', 'kembalian'];

public function details()
{
    return $this->hasMany(DetailPenjualan::class);
}
}
