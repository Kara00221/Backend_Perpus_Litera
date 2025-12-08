<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;

class LaporanController extends Controller
{
    public function laporan()
    {
        $jumlahAnggota = User::where('role', 'anggota')->count();
        $jumlahBukuFiksi = Buku::where('kategori', 'Fiksi')->count();
        $jumlahBukuNonFiksi = Buku::where('kategori', 'Non-Fiksi')->count();
        $jumlahPeminjaman = Peminjaman::count();

        return response()->json([
            'jumlah_anggota'      => $jumlahAnggota,
            'jumlah_buku_fiksi'   => $jumlahBukuFiksi,
            'jumlah_buku_non_fiksi' => $jumlahBukuNonFiksi,
            'jumlah_peminjaman'   => $jumlahPeminjaman,
        ]);
    }
}
