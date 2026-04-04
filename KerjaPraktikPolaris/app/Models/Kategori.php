<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    public function Produk()
{
    return $this->hasMany(Produk::class);
}
}
