<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterQuote extends Model
{
    protected $table = 'master_quote';
    protected $primaryKey = 'id_quote';
    public $timestamps = false;
    protected $fillable = ['isi', 'penulis', 'kategori'];
}