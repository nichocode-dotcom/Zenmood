<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emosi extends Model
{
    protected $table = 'emosi';
    protected $primaryKey = 'id_emosi';
    public $timestamps = false; // Di migration emosi gak ada $table->timestamps()
}