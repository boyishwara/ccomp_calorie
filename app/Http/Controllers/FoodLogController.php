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
        $foodLogs = auth()->user()->foodLogs()->orderBy('consumed_at', 'desc')->get();
        return view('dashboard', compact('foodLogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
