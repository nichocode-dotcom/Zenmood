<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterHabit;
use App\Models\TransHabit;
use Carbon\Carbon;

class HabitLogController extends Controller
{
    public function index()
    {
        // Get current user ID (for now using 1, can be changed to auth()->id() when auth is implemented)
        $userId = 1;
        $today = Carbon::today();
        
        // Get all habits
        $habits = MasterHabit::all();
        
        // Get today's completed habits
        $completedHabits = TransHabit::where('id_user', $userId)
            ->where('tanggal', $today->format('Y-m-d'))
            ->where('status', 1)
            ->pluck('id_habit')
            ->toArray();
        
        // Calculate progress
        $totalHabits = $habits->count();
        $completedCount = count($completedHabits);
        
        // Format date in Indonesian
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
        $userId = $request->input('user_id', 1);
        $habitId = $request->input('habit_id');
        $status = $request->input('status');
        $tanggal = $request->input('tanggal');

        // Find or create the transaction
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

        $habit = MasterHabit::create([
            'nama' => $request->input('nama'),
            'target_harian' => $request->input('target_harian'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Habit berhasil ditambahkan',
            'habit' => $habit
        ]);
    }
}
