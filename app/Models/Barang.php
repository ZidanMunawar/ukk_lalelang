<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'tb_barang';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'nama_barang',
        'tgl',
        'harga_awal',
        'deskripsi_barang',
    ];

    // Relasi ke gambar barang
    public function gambar()
    {
        return $this->hasMany(GambarBarang::class, 'id_barang', 'id_barang');
    }

    // Ambil gambar primary
    public function gambarPrimary()
    {
        return $this->hasOne(GambarBarang::class, 'id_barang', 'id_barang')->where('is_primary', true);
    }
    // Relasi ke lelang
    public function lelang()
    {
        return $this->hasOne(Lelang::class, 'id_barang', 'id_barang');
    }

    // Relasi ke history lelang
    public function historyLelang()
    {
        return $this->hasMany(HistoryLelang::class, 'id_barang', 'id_barang');
    }
}
