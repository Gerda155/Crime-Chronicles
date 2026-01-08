<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ModeratorController;
use App\Http\Middleware\ModeratorMiddleware;
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

Route::middleware([ModeratorMiddleware::class])->prefix('moderator')->group(function() {

    Route::get('/cases', [ModeratorController::class,'casesIndex'])->name('moderator.cases.index');
    Route::get('/cases/{case}/edit', [ModeratorController::class,'editCase'])->name('moderator.cases.edit');
    Route::put('/cases/{case}/update', [ModeratorController::class,'updateCase'])->name('moderator.cases.update');
    Route::put('/cases/{case}/deactivate', [ModeratorController::class,'deactivateCase'])->name('moderator.cases.deactivate');

    Route::get('/users', [ModeratorController::class,'usersIndex'])->name('moderator.users.index');
    Route::put('/users/{user}/deactivate', [ModeratorController::class,'deactivateUser'])->name('moderator.users.deactivate');
    Route::put('/cases/{case}/activate', [ModeratorController::class,'activateCase'])->name('moderator.cases.activate');

    Route::get('/stats', [ModeratorController::class,'stats'])->name('moderator.stats');
});

require __DIR__ . '/auth.php';
