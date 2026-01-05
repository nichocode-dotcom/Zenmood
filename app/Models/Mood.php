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

    // 3. Relasi ke tabel Users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // 4. Relasi ke tabel Emosi
    public function emosi()
    {
        return $this->belongsTo(Emosi::class, 'id_emosi', 'id_emosi');
    }
    
    // 5. Relasi ke tabel Aktivitas (Ternyata mengarah ke tabel Healing Plan)
    public function aktivitas()
    {
        // Parameter 2: Foreign Key di tabel MOOD (id_aktivitas)
        // Parameter 3: Primary Key di tabel TUJUAN/MASTER (id_healing)
        
        // PENTING: Gunakan 'id_healing' karena tabel targetnya adalah master_healing_plan
        return $this->belongsTo(MasterAktivitas::class, 'id_aktivitas', 'id_healing');
    }
}