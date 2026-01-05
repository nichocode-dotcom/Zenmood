<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $table = 'trans_jurnal'; 
    
    protected $primaryKey = 'id_jurnal';

    protected $fillable = [
        'id_user',
        'tanggal',
        'judul',
        'isi_teks',
        'skor_analisis',
        'rating_user'
    ];
}