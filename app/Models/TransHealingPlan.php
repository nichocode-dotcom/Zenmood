<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransHealingPlan extends Model
{
    protected $table = 'trans_healing_plan';
    protected $primaryKey = 'id_trans_heal';
    
    protected $fillable = ['id_user', 'id_healing', 'tanggal', 'is_utama', 'is_completed'];

    // Relasi balik ke Master untuk ambil detail aktivitas & poin
    public function masterHealing()
    {
        return $this->belongsTo(MasterHealingPlan::class, 'id_healing');
    }
} 