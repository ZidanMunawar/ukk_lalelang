<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GambarBarang extends Model
{
    use HasFactory;

    protected $table = 'tb_gambar_barang';
    protected $primaryKey = 'id_gambar';

    protected $fillable = [
        'id_barang',
        'gambar',
        'is_primary',
    ];

    // Relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
