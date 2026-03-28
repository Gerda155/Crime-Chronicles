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
    ->prefix('moderator')
    ->name('moderator.')
    ->group(function () {

        Route::prefix('cases')->group(function () {
            Route::get('/', [ModeratorController::class, 'casesIndex'])->name('cases.index');
            Route::get('/create', [ModeratorController::class, 'createCase'])->name('cases.create');
            Route::post('/', [ModeratorController::class, 'storeCase'])->name('cases.store');
            Route::get('/{case}/edit', [ModeratorController::class, 'editCase'])->name('cases.edit');
            Route::put('/{case}', [ModeratorController::class, 'updateCase'])->name('cases.update');
            Route::put('/{case}/deactivate', [ModeratorController::class, 'deactivateCase'])->name('cases.deactivate');
            Route::put('/{case}/activate', [ModeratorController::class, 'activateCase'])->name('cases.activate');
            Route::delete('/{case}', [ModeratorController::class, 'destroyCase'])->name('cases.destroy');
            Route::post('/{case}/restore', [ModeratorController::class, 'restoreCase'])->name('cases.restore');
        });

        Route::prefix('users')->group(function () {
            Route::get('/', [ModeratorController::class, 'usersIndex'])->name('users.index');
            Route::get('/{user}', [ModeratorController::class, 'showUser'])->name('users.show');
            Route::put('/{user}/deactivate', [ModeratorController::class, 'deactivateUser'])->name('users.deactivate');
            Route::put('/{user}/activate', [ModeratorController::class, 'activateUser'])->name('users.activate');
            Route::delete('/{user}', [ModeratorController::class, 'destroyUser'])->name('users.destroy');
            Route::post('/{user}/restore', [ModeratorController::class, 'restoreUser'])->name('users.restore');
        });

        Route::prefix('achievements')->group(function () {
            Route::get('/', [ModeratorController::class, 'achievementsIndex'])->name('achievements.index');
            Route::get('/create', [ModeratorController::class, 'createAchievement'])->name('achievements.create');
            Route::post('/', [ModeratorController::class, 'storeAchievement'])->name('achievements.store');
            Route::get('/{achievement}/edit', [ModeratorController::class, 'editAchievement'])->name('achievements.edit');
            Route::put('/{achievement}', [ModeratorController::class, 'updateAchievement'])->name('achievements.update');
            Route::post('/{achievement}/deactivate', [ModeratorController::class, 'deactivateAchievement'])->name('achievements.deactivate');
            Route::post('/{achievement}/activate', [ModeratorController::class, 'activateAchievement'])->name('achievements.activate');
            Route::delete('/{achievement}', [ModeratorController::class, 'destroyAchievement'])->name('achievements.destroy');
            Route::post('/{achievement}/restore', [ModeratorController::class, 'restoreAchievement'])->name('achievements.restore');
        });

        Route::prefix('genres')->group(function () {
            Route::get('/', [ModeratorController::class, 'genresIndex'])->name('genres.index');
            Route::post('/', [ModeratorController::class, 'storeGenre'])->name('genres.store');
            Route::get('/{genre}/edit', [ModeratorController::class, 'editGenre'])->name('genres.edit');
            Route::put('/{genre}', [ModeratorController::class, 'updateGenre'])->name('genres.update');
            Route::post('/{genre}/deactivate', [ModeratorController::class, 'deactivateGenre'])->name('genres.deactivate');
            Route::post('/{genre}/activate', [ModeratorController::class, 'activateGenre'])->name('genres.activate');
            Route::delete('/{genre}', [ModeratorController::class, 'destroyGenre'])->name('genres.destroy');
            Route::post('/{genre}/restore', [ModeratorController::class, 'restoreGenre'])->name('genres.restore');
        });

        Route::get('/stats', [ModeratorController::class, 'stats'])->name('stats');
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
    Route::delete('users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
    Route::post('users/{id}/restore', [AdminController::class, 'restoreUser'])->name('users.restore');
});

require __DIR__ . '/auth.php';
