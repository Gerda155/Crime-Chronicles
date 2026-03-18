<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CaseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\ModeratorMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('welcome');
Route::get('/dashboard', fn() => view('welcome'))->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts');
Route::post('/contacts', [ContactController::class, 'send'])->name('contacts.send');

Route::get('/achievements', [AchievementController::class, 'index'])->name('achievements.index');

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/my-cases', [CaseController::class, 'myCases'])->name('cases.my-cases');
    Route::get('/cases/{case}/play', [CaseController::class, 'play'])->name('cases.play');
    Route::post('/cases/{case}/submit', [CaseController::class, 'submit'])->name('cases.submit');
    Route::get('/cases/{id}/edit', [CaseController::class, 'edit'])->name('cases.edit');
    Route::put('/cases/{id}', [CaseController::class, 'update'])->name('cases.update');
    Route::delete('/cases/{id}', [CaseController::class, 'destroy'])->name('cases.destroy');

    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
});

Route::get('/cases', [CaseController::class, 'index'])->name('cases.index');

Route::middleware(['auth', ModeratorMiddleware::class])
    ->prefix('moderator')->name('moderator.')->group(function () {

    Route::get('/cases', [ModeratorController::class, 'casesIndex'])->name('cases.index');
    Route::get('/cases/create', [ModeratorController::class, 'createCase'])->name('cases.create');
    Route::post('/cases', [ModeratorController::class, 'storeCase'])->name('cases.store');
    Route::get('/cases/{case}/edit', [ModeratorController::class, 'editCase'])->name('cases.edit');
    Route::put('/cases/{case}', [ModeratorController::class, 'updateCase'])->name('cases.update');
    Route::put('/cases/{case}/deactivate', [ModeratorController::class, 'deactivateCase'])->name('cases.deactivate');
    Route::put('/cases/{case}/activate', [ModeratorController::class, 'activateCase'])->name('cases.activate');

    Route::get('users', [ModeratorController::class, 'usersIndex'])->name('users.index');
    Route::get('users/{user}', [ModeratorController::class, 'showUser'])->name('users.show');
    Route::put('users/{user}/deactivate', [ModeratorController::class, 'deactivateUser'])->name('users.deactivate');
    Route::put('users/{user}/activate', [ModeratorController::class, 'activateUser'])->name('users.activate');

    Route::get('/stats', [ModeratorController::class, 'stats'])->name('stats');

    Route::get('/achievements', [ModeratorController::class, 'achievementsIndex'])->name('achievements.index');
    Route::get('/achievements/create', [ModeratorController::class, 'createAchievement'])->name('achievements.create');
    Route::post('/achievements', [ModeratorController::class, 'storeAchievement'])->name('achievements.store');
    Route::get('/achievements/{achievement}/edit', [ModeratorController::class, 'editAchievement'])->name('achievements.edit');
    Route::put('/achievements/{achievement}', [ModeratorController::class, 'updateAchievement'])->name('achievements.update');
    Route::delete('/achievements/{achievement}', [ModeratorController::class, 'destroyAchievement'])->name('achievements.destroy');
});

Route::prefix('admin')->middleware('auth')->name('admin.')->group(function () {

    Route::get('moderators', [AdminController::class, 'moderatorsIndex'])->name('moderators.index');
    Route::get('moderators/create', [AdminController::class, 'createModerator'])->name('moderators.create');
    Route::post('moderators', [AdminController::class, 'storeModerator'])->name('moderators.store');
    Route::put('moderators/{user}/deactivate', [AdminController::class, 'deactivateModerator'])->name('moderators.deactivate');
    Route::put('moderators/{user}/activate', [AdminController::class, 'activateModerator'])->name('moderators.activate');

    Route::get('users', [AdminController::class, 'usersIndex'])->name('users.index'); 
    Route::get('users/{user}', [AdminController::class, 'showUser'])->name('users.show');
    Route::get('users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::put('users/{user}/deactivate', [AdminController::class, 'deactivateUser'])->name('users.deactivate');
    Route::put('users/{user}/activate', [AdminController::class, 'activateUser'])->name('users.activate');
});

require __DIR__ . '/auth.php';
