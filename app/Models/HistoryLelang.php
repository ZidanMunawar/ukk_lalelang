<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryLelang extends Model
{
    use HasFactory;

    protected $table = 'history_lelang';
    protected $primaryKey = 'id_history';

    protected $fillable = [
        'id_lelang',
        'id_barang',
        'id_user',
        'penawaran_harga',
    ];

    // Relasi ke lelang
    public function lelang()
    {
        return $this->belongsTo(Lelang::class, 'id_lelang', 'id_lelang');
    }

    // Relasi ke barang
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    // Relasi ke user (pembid)
    public function user()
    {
        return $this->belongsTo(Masyarakat::class, 'id_user', 'id_user');
    }
}
