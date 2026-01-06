<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    use HasFactory;

    // 1. Tentukan nama tabel & primary key
    protected $table = 'mood';
    protected $primaryKey = 'id_mood'; 

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
        'hal_disyukuri',
        'skor',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function emosi()
    {
        return $this->belongsTo(Emosi::class, 'id_emosi', 'id_emosi');
    }
    
    public function aktivitas()
    {
        return $this->belongsTo(MasterAktivitas::class, 'id_aktivitas', 'id_healing');
    }
}