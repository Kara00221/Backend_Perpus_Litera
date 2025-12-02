<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Peminjaman extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "peminjaman";
    protected $primaryKey = 'id_peminjaman';

    protected $fillable = [
        'id_users',
        'tanggal_peminjaman',
        'tanggal_pengembalian',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_users');
    }

    public function index()
    {
        $allPeminjaman = Peminjaman::with('user')->get();
        return response()->json($allPeminjaman);
    }


    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}
