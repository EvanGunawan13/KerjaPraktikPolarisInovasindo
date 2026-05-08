<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::withCount('produk')->latest()->get();
        return view('kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori',
        ], [
            'nama_kategori.unique' => 'Kategori ini sudah ada!',
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'slug'          => \Illuminate\Support\Str::slug($request->nama_kategori),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategori,nama_kategori,' . $id,
        ], [
            'nama_kategori.unique'    => 'Nama kategori sudah digunakan!',
            'nama_kategori.required'  => 'Nama kategori wajib diisi.',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'slug'          => \Illuminate\Support\Str::slug($request->nama_kategori),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);

        if ($kategori->produk()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori tidak bisa dihapus karena masih memiliki ' . $kategori->produk()->count() . ' produk!');
        }

        $kategori->delete();
        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}