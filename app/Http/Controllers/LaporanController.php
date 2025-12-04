<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Buku;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {

        $peminjaman = Peminjaman::with('buku')->get();

        return response()->json($peminjaman);
    }
}
