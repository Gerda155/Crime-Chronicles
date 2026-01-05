<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AchievementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-cases', [CaseController::class, 'myCases'])->name('cases.my-cases');
    Route::delete('/cases/{id}', [CaseController::class, 'destroy'])->name('cases.destroy');
    Route::get('/cases/{id}/edit', [CaseController::class, 'edit'])->name('cases.edit');
    Route::put('/cases/{id}', [CaseController::class, 'update'])->name('cases.update');

    Route::get('/users/search', [UserController::class, 'search'])
    ->name('users.search')
    ->middleware('auth');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])
    ->name('leaderboard');

    Route::get('/achievements', [AchievementController::class, 'index'])
    ->name('achievements.index');
});

Route::get('/cases', [CaseController::class, 'index'])->name('cases.index');

require __DIR__ . '/auth.php';
