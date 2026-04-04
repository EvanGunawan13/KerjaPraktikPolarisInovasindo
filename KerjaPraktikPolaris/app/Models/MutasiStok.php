<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiStok extends Model
{
    use HasFactory;


    protected $table = 'MutasiStok';
    protected $fillable = [
        'Produk_id','tipe','jumlah','referensi',
    ];


    public function Produk()
    {
        return $this->belongsTo(Produk::class, 'Produk_id');
    }

    public function scopeMasuk($query)
    {
        return $query->where('tipe', 'masuk');
    }

    public function scopeKeluar($query)
    {
        return $query->where('tipe', 'keluar');
    }
}