<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mood extends Model
{
    protected $table = 'mood';
    protected $primaryKey = 'id_mood';
    
    protected $fillable = [
        'id_user', 'id_emosi', 'id_aktivitas', 'tanggal', 
        'jam', 'faktor_sistem', 'faktor_note', 'hal_disyukuri'
    ];

    // Relasi ke Emosi (untuk ambil skor/ikon)
    public function emosi()
    {
        return $this->belongsTo(Emosi::class, 'id_emosi');
    }

    // Relasi ke Master Aktivitas (untuk ambil label kategori)
    public function aktivitas()
    {
        return $this->belongsTo(MasterAktivitas::class, 'id_aktivitas');
    }
}