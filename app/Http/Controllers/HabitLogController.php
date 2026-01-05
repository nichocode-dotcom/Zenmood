<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterHabit;
use App\Models\TransHabit;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HabitLogController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $sessionDate = session('selected_date', Carbon::now()->format('Y-m-d'));
        $today = Carbon::parse($sessionDate);

        $cekharian = TransHabit::where('id_user', $userId)
            ->where('tanggal', $today->format('Y-m-d'))
            ->exists();

        if (!$cekharian) {
            $defaultHabits = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

            foreach ($defaultHabits as $habitId) {
                TransHabit::create([
                    'id_user' => $userId,
                    'id_habit' => $habitId,
                    'tanggal' => $today->format('Y-m-d'),
                    'status' => 0
                ]);
            }
        }
        $habits = MasterHabit::join('trans_habit', 'master_habit.id_habit', '=', 'trans_habit.id_habit')
                    ->where('trans_habit.id_user', $userId)
                    ->where('trans_habit.tanggal', $today->format('Y-m-d'))
                    ->select('master_habit.*') // Kita cuma butuh data info habitnya
                    ->get();
        
        $completedHabits = TransHabit::where('id_user', $userId)
            ->where('tanggal', $today->format('Y-m-d'))
            ->where('status', 1)
            ->pluck('id_habit')
            ->toArray();
        
        $totalHabits = $habits->count();
        $completedCount = count($completedHabits);
        
        $formattedDate = $today->locale('id')->isoFormat('dddd, D MMMM YYYY');
        
        return view('habitlog.index', [
            'habits' => $habits,
            'completedHabits' => $completedHabits,
            'totalHabits' => $totalHabits,
            'completedCount' => $completedCount,
            'formattedDate' => $formattedDate,
            'today' => $today->format('Y-m-d'),
            'userId' => $userId
        ]);
    }

    public function toggle(Request $request)
    {
        $userId = auth()->id();
        $habitId = $request->input('habit_id');
        $status = $request->input('status');
        $tanggal = $request->input('tanggal');

        $transHabit = TransHabit::updateOrCreate(
            [
                'id_user' => $userId,
                'id_habit' => $habitId,
                'tanggal' => $tanggal
            ],
            [
                'status' => $status
            ]
        );

        return response()->json([
            'success' => true,
            'status' => $transHabit->status
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'target_harian' => 'required|string|max:255',
        ]);

        $sessionDate = session('selected_date', Carbon::now()->format('Y-m-d'));

        $habit = MasterHabit::create([
            'nama' => $request->input('nama'),
            'target_harian' => $request->input('target_harian'),
        ]);

        TransHabit::create([
            'id_user' => auth()->user()->id_user, 
            'id_habit' => $habit->id_habit,       
            'tanggal' => $sessionDate,
            'status' => 0 
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Habit berhasil ditambahkan',
            'habit' => $habit
        ]);
    }
}
