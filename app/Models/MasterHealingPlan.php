<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHealingPlan extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel di database kamu
    protected $table = 'master_healing_plan';
    protected $primaryKey = 'id_healing';

    protected $fillable = [
        'judul_aktivitas',
        'deskripsi_detail',
        'kategori',
        'poin_baterai'
    ];
}