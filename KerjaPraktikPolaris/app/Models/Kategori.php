<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori'; // Paksa ke nama tabel bahasa Indonesia
    protected $fillable = ['nama_kategori', 'slug'];

    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}