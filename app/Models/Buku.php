<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Buku extends Authenticatable
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "buku";
    protected $primaryKey = 'id_buku';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'tahun_terbit',
        'kategori',
        'lokasi_buku',
    ];

    public function detailPeminjaman()
    {
        return $this->hasMany(DetailPeminjaman::class);
    }
}
