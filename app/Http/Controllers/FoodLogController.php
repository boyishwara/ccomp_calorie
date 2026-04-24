<?php

namespace App\Http\Controllers;

use App\Models\FoodLog;
use Illuminate\Http\Request;

class FoodLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $target = $user->daily_calorie_target ?: 2000;

        // Query only the last 3 days of logs to optimize memory usage and performance
        $threeDaysAgo = now()->subDays(2)->startOfDay();
        $recentLogs = $user->foodLogs()
            ->where('consumed_at', '>=', $threeDaysAgo)
            ->orderBy('consumed_at', 'desc')
            ->get();

        $todayLogs = $recentLogs->filter(fn($log) => $log->consumed_at->isToday());
        $yesterdayLogs = $recentLogs->filter(fn($log) => $log->consumed_at->isYesterday());
        $twoDaysAgoLogs = $recentLogs->filter(fn($log) => $log->consumed_at->isSameDay(now()->subDays(2)));

        $consumedToday = $todayLogs->sum('calories');
        $consumedYesterday = $yesterdayLogs->sum('calories');
        $consumedTwoDaysAgo = $twoDaysAgoLogs->sum('calories');

        $percentage = $target > 0 ? min(100, round(($consumedToday / $target) * 100)) : 0;

        $colorClass = 'text-green-500';
        $strokeClass = 'stroke-green-500';
        $isOverCalorie = false;
        
        if ($consumedToday > $target) {
            $colorClass = 'text-red-500';
            $strokeClass = 'stroke-red-500';
            $isOverCalorie = true;
        } elseif ($percentage >= 85) {
            $colorClass = 'text-yellow-500';
            $strokeClass = 'stroke-yellow-500';
        }

        $breakdown = [
            'breakfast' => $todayLogs->where('meal_type', 'breakfast')->sum('calories'),
            'lunch' => $todayLogs->where('meal_type', 'lunch')->sum('calories'),
            'dinner' => $todayLogs->where('meal_type', 'dinner')->sum('calories'),
            'snack' => $todayLogs->where('meal_type', 'snack')->sum('calories'),
        ];

        return view('dashboard', compact(
            'target',
            'todayLogs',
            'consumedToday',
            'percentage',
            'consumedYesterday',
            'consumedTwoDaysAgo',
            'colorClass',
            'strokeClass',
            'isOverCalorie',
            'breakdown'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('food_logs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'calories' => 'required|integer|min:0',
            'consumed_at' => 'required|date',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
        ]);

        $request->user()->foodLogs()->create($validated);

        return redirect()->route('dashboard')->with('success', 'Food log added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FoodLog $foodLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FoodLog $foodLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FoodLog $foodLog)
    {
        if ($request->user()->id !== $foodLog->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'calories' => 'required|integer|min:0',
            'consumed_at' => 'required|date',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
        ]);

        $foodLog->update($validated);

        return redirect()->route('dashboard')->with('success', 'Food log updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FoodLog $foodLog)
    {
        if (auth()->id() !== $foodLog->user_id) {
            abort(403);
        }

        $foodLog->delete();

        return redirect()->route('dashboard')->with('success', 'Food log deleted successfully!');
    }
}
