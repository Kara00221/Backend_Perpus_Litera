<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPeminjaman extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "detail_peminjaman";
    protected $primaryKey = 'id_detail';

    protected $fillable = [
        'id_peminjaman',
        'id_buku',
        'jumlah',
        'status',
        'denda',
    ];

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }
}
