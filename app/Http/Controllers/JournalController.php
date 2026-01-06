<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    public function index()
    {
        $date = session('selected_date', Carbon::now()->format('Y-m-d'));
        // UBAH: dari where('id_user', 1) menjadi auth()->id()
        $dbJournals = Journal::where('id_user', auth()->id())
            ->whereDate('tanggal', $date)
            ->latest('created_at')
            ->get();

        $journals = $dbJournals->map(function ($item) {
            return [
                'id' => $item->id_jurnal,
                'title' => $item->judul,
                'content' => $item->isi_teks,
                'rating' => $item->rating_user,
                'date' => Carbon::parse($item->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y'),
                'skor' => $item->skor_analisis 
            ];
        });

        return view('journaling.index', compact('journals', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'rating' => 'required|integer|min:1|max:5',
            'id' => 'nullable|integer',
        ]);

        $skor = $this->analisisSentimen($request->input('content'));

        $date = session('selected_date', Carbon::now()->format('Y-m-d'));

        $journal = Journal::updateOrCreate(
            [
                'id_jurnal' => $request->input('id') // Pastikan form Anda mengirim 'id'
            ],
            [
                'id_user' => auth()->id(), 
                'tanggal' => $date,
                'judul' => $request->title,
                'isi_teks' => $request->input('content'),
                'skor_analisis' => $skor,
                'rating_user' => $request->rating,
            ]
        );
        
        $responseData = [
            'id' => $journal->id_jurnal,
            'title' => $journal->judul,
            'content' => $journal->isi_teks,
            'rating' => $journal->rating_user,
            'date' => Carbon::parse($journal->tanggal)->locale('id')->isoFormat('dddd, D MMMM Y'),
            'skor' => $journal->skor_analisis
        ];

        return response()->json([
            'success' => true,
            'data' => $responseData
        ]);
    }

    private function analisisSentimen($teks)
    {
        $kataPositif = [
            'senang', 'bersyukur', 'bahagia', 'tenang', 'semangat', 'berhasil', 'bagus', 'cinta', 'suka',
            'gembira', 'riang', 'puas', 'bangga', 'lega', 'nyaman', 
            'kagum', 'hebat', 'keren', 'damai', 'ceria', 'antusias', 
            'takjub', 'terpesona', 'sayang', 'menikmati', 'seru', 'asik',
            'berharap', 'semoga', 'ingin', 'berdoa', 'impian', 'cita-cita', 
            'yakin', 'niat', 'optimis', 'percaya', 'alhamdulillah'
        ];

        $kataNegatif = [
            'sedih', 'marah', 'kecewa', 'takut', 'cemas', 
            'gagal', 'benci', 'lelah', 'capek', 'sakit',
            'kesal', 'jengkel', 'dongkol', 'murung', 'gelisah', 'panik', 
            'frustrasi', 'depresi', 'hancur', 'menderita', 'sengsara', 
            'hampa', 'sepi', 'dendam', 'muak', 'jijik', 'nyesek',
            'bingung', 'bimbang', 'ragu', 'gundah', 'resah', 'dilema', 
            'tersesat', 'buntu', 'pasrah', 'overthinking',
            'minder', 'malu', 'bodoh', 'jelek', 'iri', 'beban', 'payah',
            'rindu', 'kangen', 'kepikiran', 'terbayang', 'homesick', 
            'kesepian', 'kenangan', 'teringat', 'astaghfirullah'
        ];

        $skor = 0;
        $words = explode(' ', strtolower($teks)); 

        foreach ($words as $w) {
            $cleanWord = preg_replace('/[^a-z]/', '', $w);

            if (in_array($cleanWord, $kataPositif)) {
                $skor += 2;
            }
            if (in_array($cleanWord, $kataNegatif)) {
                $skor -= 2;
            }
        }

        return max(min($skor, 5), -5);
    }
}