<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHabit extends Model
{
    protected $table = 'master_habit';
    protected $primaryKey = 'id_habit';
    protected $fillable = ['nama', 'target_harian'];
    public function transHabits()
    {
        return $this->hasMany(TransHabit::class, 'id_habit');
    }
}