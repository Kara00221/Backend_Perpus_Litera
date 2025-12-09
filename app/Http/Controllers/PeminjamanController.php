<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use App\Models\DetailPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        return Peminjaman::with('user')->get();
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_users' => 'required|exists:users,id_users',
            'tanggal_peminjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date',
        ]);

        $peminjaman = Peminjaman::create([
            'id_users' => $validatedData['id_users'],
            'tanggal_peminjaman' => $validatedData['tanggal_peminjaman'],
            'tanggal_pengembalian' => $validatedData['tanggal_pengembalian'],
        ]);

        return response()->json([
            'message' => 'Berhasil membuat peminjaman',
            'post' => $peminjaman,
        ], 201);
    }

    public function show($id)
    {
        $peminjaman = Peminjaman::with('user')->find($id);
        
        if (!$peminjaman) 
        {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }
        
        return response()->json($peminjaman);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'tanggal_pengembalian' => 'required|date',
        ]);

        $user = Auth::user();
        $peminjaman = Peminjaman::find($id);

        if(!$peminjaman)
        {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        if($user->role !== 'pustakawan' && $peminjaman->id_users != $user->id_users)
        {
            return response()->json(['message' => 'Tidak memiliki akses'], 403);
        }

        $peminjaman->update($validatedData);
        return response()->json($peminjaman);
    }

    public function destroy(Request $request, string $id)
    {
        $peminjaman = Peminjaman::find($id);

        if(!$peminjaman)
        {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 404);
        }

        DetailPeminjaman::where('id_peminjaman', $id)->delete();

        $peminjaman->delete();
        return response()->json(['message' => 'Peminjaman berhasil dihapus.']);
    }
}
