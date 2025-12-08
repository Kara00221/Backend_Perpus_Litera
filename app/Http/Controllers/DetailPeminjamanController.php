<?php

namespace App\Http\Controllers;

use App\Models\DetailPeminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailPeminjamanController extends Controller
{    
    public function index()
    {
        return DetailPeminjaman::with(['peminjaman.user', 'buku'])->get();
    }

    public function getByPeminjaman(Request $request, string $id)
    {
        $detailPeminjaman = DetailPeminjaman::with(['peminjaman.user', 'buku'])->where('id_peminjaman', $id)->get();

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

        $user = Auth::user();
        $detailPeminjaman = DetailPeminjaman::find($id);
        
        if(!$detailPeminjaman) {
            return response()->json(['message' => 'Detail tidak ditemukan!'], 404);
        }
        $isPustakawan = $user->role === 'pustakawan';
        $isPemilik = $detailPeminjaman->peminjaman && 
                    $detailPeminjaman->peminjaman->id_users == $user->id_users;
        
        if(!$isPustakawan && !$isPemilik) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
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
        $user = Auth::user();
        $isPustakawan = $user->role === 'pustakawan';
        $isPemilik = $detailPeminjaman->peminjaman && 
                    $detailPeminjaman->peminjaman->id_users == $user->id_users;
        
        if(!$isPustakawan && !$isPemilik) {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }
        
        $detailPeminjaman->delete();
        return response()->json(['message' => 'Detail berhasil dihapus']);
    }
}
