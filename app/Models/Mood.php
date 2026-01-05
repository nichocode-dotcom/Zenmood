<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel & primary key
    protected $table = 'mood';
    protected $primaryKey = 'id_mood'; // Penting! Karena PK kamu bukan 'id'

    // 2. Daftar kolom yang bisa diisi
    protected $fillable = [
        'id_user',
        'id_emosi',
        'id_aktivitas',
        'tanggal',
        'jam',
        'kategori_aktivitas',
        'faktor_sistem',
        'faktor_note',
        'hal_disyukuri'
    ];

    // 3. Relasi ke tabel Users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // 4. Relasi ke tabel Emosi (biar bisa ambil ikon & skor)
    public function emosi()
    {
        return $this->belongsTo(Emosi::class, 'id_emosi', 'id_emosi');
    }
    
    // 5. Relasi ke tabel Aktivitas (Asumsi nama modelnya MasterAktivitas)
    public function aktivitas()
    {
        return $this->belongsTo(MasterAktivitas::class, 'id_aktivitas', 'id_aktivitas');
    }
}