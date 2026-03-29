<?php

namespace App\Http\Controllers;

use App\Models\CalorieLog;
use Illuminate\Http\Request;

class CalorieController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $logs = $user->calorieLogs()->orderBy('log_date', 'desc')->paginate(20);
        $today = now()->format('Y-m-d');
        $totalToday = $user->calorieLogs()->whereDate('log_date', $today)->sum('calories');
        $dailyTarget = $user->daily_calorie_target;
            return view('calories.index', compact('logs', 'totalToday', 'dailyTarget'));
    }

    public function create()
    {
        return view('calories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'food_name' => 'required|string|max:255',
            'calories' => 'required|integer|min:1|max:10000',
            'description' => 'nullable|string|max:1000',
            'log_date' => 'required|date|before_or_equal:today',
        ]);
        auth()->user()->calorieLogs()->create($validated);
        return redirect()->route('calories.index')->with('success', 'Calories added successfully!');
    }

    public function edit(CalorieLog $calorieLog)
    {
        $this->authorize('update', $calorieLog);
        return view('calories.edit', compact('calorieLog'));
    }

    public function update(Request $request, CalorieLog $calorieLog)
    {
        $this->authorize('update', $calorieLog);
        $validated = $request->validate([
            'food_name' => 'required|string|max:255',
            'calories' => 'required|integer|min:1|max:10000',
            'description' => 'nullable|string|max:1000',
            'log_date' => 'required|date|before_or_equal:today',
        ]);
        $calorieLog->update($validated);
        return redirect()->route('calories.index')->with('success', 'Calories updated!');
    }

    public function destroy(CalorieLog $calorieLog)
    {
        $this->authorize('delete', $calorieLog);
        $calorieLog->delete();
        return redirect()->route('calories.index')->with('success', 'Calories deleted!');
    }

        public function updateTarget(Request $request)
        {
            $validated = $request->validate([
                'daily_calorie_target' => 'nullable|integer|min:0|max:100000',
            ]);

            $user = auth()->user();
            $user->daily_calorie_target = $validated['daily_calorie_target'] ?? null;
            $user->save();

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['message' => 'Daily calorie target saved!', 'daily_calorie_target' => $user->daily_calorie_target]);
            }

            return redirect()->route('calories.index')->with('success', 'Daily calorie target saved!');
        }

        public function stats()
        {
            $user = auth()->user();
            $today = now();
            $last7Days = now()->subDays(7);
            $last30Days = now()->subMonth();
            $statsToday = $user->calorieLogs()->whereDate('log_date', $today)->sum('calories');
            $stats7Days = $user->calorieLogs()->whereBetween('log_date', [$last7Days, $today])->groupBy('log_date')->selectRaw('log_date, SUM(calories) as total')->get();
            $stats30Days = $user->calorieLogs()->whereBetween('log_date', [$last30Days, $today])->groupBy('log_date')->selectRaw('log_date, SUM(calories) as total')->get();
            return view('calories.stats', compact('statsToday', 'stats7Days', 'stats30Days'));
        }
    
}
