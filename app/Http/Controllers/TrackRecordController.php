<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrackRecordController extends Controller
{
    public function index()
    {
        $data = [
            'namaUser' => 'Nicho',
            'insight' => 'Hari ini mood kamu cenderung stabil. Konsistensi tidurmu sangat baik!',
            'persenHabit' => 80
        ];
        return view('track_record.index', $data);
    }
}