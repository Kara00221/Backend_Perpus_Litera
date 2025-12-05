<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailPeminjamanController extends Controller
{
    DetailPeminjaman::with(['peminjaman.user', 'buku'])->get();
    
    public function index()
    {
        return DetailPeminjaman::with(['peminjaman.user', 'buku'])->get();
    }

    public function getByPeminjaman(Request $request, string $id)
    {
        $detailPeminjaman = DetailPeminjaman::where('id_peminjaman', $id)->get();

        if($detailPeminjaman->isEmpty())
        {
            return response()->json(['message'=> 'Detail tidak ditemukan'],404);
        }

        return response()->json($detailPeminjaman);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_peminjaman' => 'required',
            'id_buku' => 'required',
            'jumlah' => 'required',
            'denda' => 'required',
        ]);
        $status = "Dipinjam";

        $userId = Auth::id();
        $detailPeminjaman = DetailPeminjaman::create([
            'id_peminjaman' => $validatedData['id_peminjaman'],
            'id_buku'=> $validatedData['id_buku'],
            'jumlah'=> $validatedData['jumlah'],
            'status'=> $status,
            'denda'=> $validatedData['denda'],
        ]);

        return response()->json([
            'message' => 'Detail berhasil ditambahkan',
            'post' => $detailPeminjaman,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'id_peminjaman' => 'required',
            'id_buku' => 'required',
            'jumlah' => 'required',
            'denda' => 'required',
        ]);

        $userId = Auth::id();
        $detailPeminjaman = DetailPeminjaman::find($id);
        if(!$detailPeminjaman || $detailPeminjaman->id_detail != $userId) 
        {
            return response()->json(['message' => 'Detail tidak ditemukan!']);
        }

        $detailPeminjaman->update($validatedData);
        return response()->json($detailPeminjaman);
    }

    public function destroy(Request $request, string $id)
    {
    $detailPeminjaman = DetailPeminjaman::find($id);
    
    if(!$detailPeminjaman) {
        return response()->json(['message' => 'Detail tidak ditemukan!'], 404);
        }
    }
}
