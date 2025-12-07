<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\User;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BukuController extends Controller
{
    public function index()
    {
        $allBuku = Buku::all();
        return response()->json($allBuku);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required',
            'kategori' => 'required|string|max:255',
            'lokasi_buku' => 'required|string|max:255',
        ]);

        $userId = Auth::id();
        $buku = Buku::create([
            'user_id' => $userId,
            'judul' => $validatedData['judul'],
            'penulis' => $validatedData['penulis'],
            'penerbit' => $validatedData['penerbit'],
            'tahun_terbit' => $validatedData['tahun_terbit'],
            'kategori' => $validatedData['kategori'],
            'lokasi_buku' => $validatedData['lokasi_buku'],
        ]);

        return response()->json([
            'message' => 'Buku berhasil ditambahkan',
            'post' => $buku,
        ]);
    }

    public function show($id)
    {
        $buku = Buku::find($id);

        if (!$buku) {
            return response()->json(['message' => 'Buku tidak ditemukan'], 404);
        }

        return response()->json($buku);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required',
            'kategori' => 'required|string|max:255',
            'lokasi_buku' => 'required|string|max:255',
        ]);

        $userId = Auth::id();
        $buku = Buku::find($id);
        if(!$buku) 
        {
            return response()->json(['message' => 'Buku tidak ditemukan!']);
        }

        $buku->update($validatedData);
        return response()->json($buku);
    }

    public function destroy(Request $request, string $id)
    {
        $userId = Auth::id();
        $buku = Buku::find($id);

        if(!$buku)
        {
            return response()->json(['message' => 'Buku tidak ditemukan!']);
        }

        DetailPeminjaman::where('id_buku', $id)->delete();

        $buku->delete();
        return response()->json(['message' => 'Buku berhasil di hapus']);
    }
}
