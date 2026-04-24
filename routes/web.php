<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FoodLogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [FoodLogController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/food-logs', [FoodLogController::class, 'store'])->name('food-logs.store');
    Route::put('/food-logs/{foodLog}', [FoodLogController::class, 'update'])->name('food-logs.update');
    Route::delete('/food-logs/{foodLog}', [FoodLogController::class, 'destroy'])->name('food-logs.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
