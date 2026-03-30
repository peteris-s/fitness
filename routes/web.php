<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalorieController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\ExerciseController;
use Illuminate\Support\Facades\Route;

use App\Models\Workout;

Route::get('/', function () {
    $featured = Workout::where('is_public', true)->with('user')->orderByDesc('created_at')->limit(6)->get();
    return view('welcome', ['featured' => $featured]);
});

// Sagatavo featured workouts un lietotāja kaloriju datus Dashboard skatiem.
Route::get('/dashboard', function () {
    $featured = Workout::where('is_public', true)->with('user')->orderByDesc('created_at')->limit(6)->get();

    $user = auth()->user();
    $totalToday = null;
    $dailyTarget = null;
    $recentLogs = collect();
    $recentWorkoutName = null;
    $recentWorkoutDate = null;

    if ($user) {
        $today = now()->format('Y-m-d');
        $totalToday = $user->calorieLogs()->whereDate('log_date', $today)->sum('calories');
        $dailyTarget = $user->daily_calorie_target;
        $recentLogs = $user->calorieLogs()->orderBy('log_date', 'desc')->limit(3)->get();
        $last = $user->userWorkouts()->whereNotNull('completed_at')->orderByDesc('completed_at')->with('workout')->first();
        if ($last && $last->workout) {
            $recentWorkoutName = $last->workout->name;
            $recentWorkoutDate = optional($last->completed_at)->format('Y-m-d');
        }
    }

    return view('dashboard', compact('featured', 'totalToday', 'dailyTarget', 'recentLogs', 'recentWorkoutName', 'recentWorkoutDate'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/calories', [CalorieController::class, 'index'])->name('calories.index');
    Route::get('/calories/create', [CalorieController::class, 'create'])->name('calories.create');
    Route::post('/calories', [CalorieController::class, 'store'])->name('calories.store');
    // Non-parameter routes first so they don't get captured by {calorieLog}
    Route::get('/calories/stats', [CalorieController::class, 'stats'])->name('calories.stats');
    Route::match(['patch','post'], '/calories/target', [CalorieController::class, 'updateTarget'])->name('calories.target');
    // Allow GET to /calories/target to redirect back instead of 404 (helps accidental visits)
    Route::get('/calories/target', function () {
        return redirect()->route('calories.index');
    });

    // Parameterized routes (must come after fixed routes)
    Route::get('/calories/{calorieLog}/edit', [CalorieController::class, 'edit'])->name('calories.edit');
    Route::patch('/calories/{calorieLog}', [CalorieController::class, 'update'])->name('calories.update');
    Route::delete('/calories/{calorieLog}', [CalorieController::class, 'destroy'])->name('calories.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/workouts', [WorkoutController::class, 'index'])->name('workouts.index');
    Route::get('/workouts/create', [WorkoutController::class, 'create'])->name('workouts.create');
    Route::post('/workouts', [WorkoutController::class, 'store'])->name('workouts.store');
    Route::get('/workouts/{workout}', [WorkoutController::class, 'show'])->name('workouts.show')->whereNumber('workout');
    Route::get('/workouts/{workout}/edit', [WorkoutController::class, 'edit'])->name('workouts.edit')->whereNumber('workout');
    Route::patch('/workouts/{workout}', [WorkoutController::class, 'update'])->name('workouts.update')->whereNumber('workout');
    Route::delete('/workouts/{workout}', [WorkoutController::class, 'destroy'])->name('workouts.destroy')->whereNumber('workout');
    Route::post('/workouts/{workout}/complete', [WorkoutController::class, 'complete'])->name('workouts.complete')->whereNumber('workout');
});

Route::get('/workouts/browse', [WorkoutController::class, 'browse'])->name('workouts.browse');
Route::get('/workouts/search', [WorkoutController::class, 'search'])->name('workouts.search');

// Treninu plāni - combined page for user's plans and public plans
Route::middleware('auth')->group(function () {
    Route::get('/treninu-plani', [\App\Http\Controllers\WorkoutController::class, 'plans'])->name('plans.index');
    Route::post('/treninu-plani/copy/{workout}', [\App\Http\Controllers\WorkoutController::class, 'copy'])->name('plans.copy');
});

Route::middleware('auth')->group(function () {
    Route::get('/exercises', [ExerciseController::class, 'index'])->name('exercises.index');
    Route::get('/exercises/create', [ExerciseController::class, 'create'])->name('exercises.create');
    Route::post('/exercises', [ExerciseController::class, 'store'])->name('exercises.store');
    Route::get('/exercises/{exercise}', [ExerciseController::class, 'show'])->name('exercises.show');
    Route::get('/exercises/{exercise}/edit', [ExerciseController::class, 'edit'])->name('exercises.edit');
    Route::patch('/exercises/{exercise}', [ExerciseController::class, 'update'])->name('exercises.update');
    Route::delete('/exercises/{exercise}', [ExerciseController::class, 'destroy'])->name('exercises.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

