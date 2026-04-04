<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $fillable = ['sale_id', 'product_id', 'jumlah', 'harga_saat_jual', 'subtotal'];

public function product()
{
    return $this->belongsTo(Product::class);
}
}
