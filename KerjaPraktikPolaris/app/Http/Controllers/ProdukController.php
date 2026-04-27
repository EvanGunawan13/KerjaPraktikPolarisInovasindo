<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')->latest()->get();
        $kategori = Kategori::all();
        return view('produk.index', compact('produk', 'kategori'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nama_produk' => 'required',
        'sku'         => 'required|unique:produk',
        'kategori_id' => 'required|exists:kategori,id',
        'stok'        => 'required|numeric',
        'stok_minimum'=> 'required|numeric',
        'harga_beli'  => 'required|numeric',
        'harga_jual'  => 'required|numeric',
    ]);

    // Menggunakan create agar semua field masuk
    Produk::create($request->all());

    return redirect()->back()->with('success', 'Barang Polaris berhasil masuk sistem!');
}

    public function update(Request $request, $id)
{
    $request->validate([
        'nama_produk'  => 'required',
        'sku'          => 'required|unique:produk,sku,' . $id,
        'kategori_id'  => 'required',
        'stok'         => 'required|numeric',
        'stok_minimum' => 'required|numeric',
        'harga_beli'   => 'required|numeric',
        'harga_jual'   => 'required|numeric',
    ]);

    $produk = Produk::findOrFail($id);
    $produk->update([
        'nama_produk'  => $request->nama_produk,
        'sku'          => $request->sku,
        'kategori_id'  => $request->kategori_id,
        'stok'         => $request->stok,
        'stok_minimum' => $request->stok_minimum,
        'harga_beli'   => $request->harga_beli,
        'harga_jual'   => $request->harga_jual,
    ]);

    return redirect()->back()->with('success', 'Data barang berhasil diperbarui!');
}

    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->back()->with('success', 'Barang berhasil dihapus dari sistem!');
    }
}