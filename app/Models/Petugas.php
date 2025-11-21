<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Petugas extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel di database
    protected $table = 'tb_petugas';

    // Primary key tabel
    protected $primaryKey = 'id_petugas';

    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'nama_petugas',
        'username',
        'password',
        'id_level',
    ];

    // Field yang disembunyikan saat serialize
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke tabel level
    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id_level');
    }

    // Relasi ke tabel lelang
    public function lelang()
    {
        return $this->hasMany(Lelang::class, 'id_petugas', 'id_petugas');
    }
}
