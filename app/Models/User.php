<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    public $timestamps = false;
    protected $table = "users";
    protected $primaryKey = 'id_users';

    protected $fillable = [
        'nama',
        'nomor_telepon',
        'umur',
        'role',
        'email',
        'password',
    ];
}
