<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'tb_level';

    // Primary key tabel
    protected $primaryKey = 'id_level';

    // Field yang bisa diisi mass assignment
    protected $fillable = [
        'level',
    ];

    // Relasi ke tabel petugas
    public function petugas()
    {
        return $this->hasMany(Petugas::class, 'id_level', 'id_level');
    }
}
