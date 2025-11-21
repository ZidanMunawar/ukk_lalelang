<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Masyarakat extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel di database
    protected $table = 'tb_masyarakat';

    // Primary key tabel
    protected $primaryKey = 'id_user';

    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'nama_lengkap',
        'nik',
        'password',
        'telp',
        'alamat',
        'status',
    ];

    // Field yang disembunyikan saat serialize
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi ke tabel lelang
    public function lelang()
    {
        return $this->hasMany(Lelang::class, 'id_user', 'id_user');
    }

    // Relasi ke tabel history lelang
    public function historyLelang()
    {
        return $this->hasMany(HistoryLelang::class, 'id_user', 'id_user');
    }
}
