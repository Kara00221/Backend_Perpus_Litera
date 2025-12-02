<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
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
            'tanggal_peminjaman' => 'required',
        ]);

        $tanggalPinjam = Carbon::parse($validatedData['tanggal_peminjaman']);

        $tanggalKembali = $tanggalPinjam->copy()->addDays(7);

        $userId = Auth::id();
        $peminjaman = Peminjaman::create([
            'id_users' => $userId,
            'tanggal_peminjaman' => $tanggalPinjam,
            'tanggal_pengembalian' => $tanggalKembali,
        ]);

        return response()->json([
            'message' => 'Berhasil membuat peminjaman',
            'post' => $peminjaman,
        ], 201);
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'tanggal_pengembalian' => 'required',
        ]);

        $userId = Auth::id();
        $peminjaman = Peminjaman::find($id);

        if(!$peminjaman || $peminjaman->id_users != $userId)
        {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 403);
        }

        $peminjaman->update($validatedData);
        return response()->json($peminjaman);
    }

    public function destroy(Request $request, string $id)
    {
        $userId = Auth::id();
        $peminjaman = Peminjaman::find($id);

        if(!$peminjaman || $peminjaman->id_users != $userId)
        {
            return response()->json(['message' => 'Peminjaman tidak ditemukan'], 403);
        }

        $peminjaman->delete();
        return response()->json(['message' => 'Peminjaman berhaisl di hapus.']);
    }
}
