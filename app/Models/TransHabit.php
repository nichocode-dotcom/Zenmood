<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransHabit extends Model
{
    protected $table = 'trans_habit';
    protected $primaryKey = 'idtrans_habit';
    protected $fillable = ['id_user', 'id_habit', 'tanggal', 'status'];

    public function habit()
    {
        return $this->belongsTo(MasterHabit::class, 'id_habit');
    }
}
