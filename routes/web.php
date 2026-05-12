<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Case\CaseController;
use App\Http\Controllers\Case\CasePlayController;
use App\Http\Controllers\Case\CaseSuspectController;
use App\Http\Controllers\Case\CaseEvidenceController;
use App\Http\Controllers\Case\CaseQuestionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\Moderator\ModeratorUserController;
use App\Http\Controllers\Moderator\ModeratorCaseController;
use App\Http\Controllers\Moderator\ModeratorAchievementController;
use App\Http\Controllers\Moderator\ModeratorGenreController;
use App\Http\Controllers\Moderator\ModeratorRangController;
use App\Http\Controllers\Moderator\ModeratorStatsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RatingController;
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
    Route::get('/cases/{case}/play', [CasePlayController::class, 'play'])->name('cases.play');
    Route::post('/cases/{case}/submit', [CasePlayController::class, 'submit'])->name('cases.submit');
    Route::get('/cases/{id}/edit', [CaseController::class, 'edit'])->name('cases.edit');
    Route::put('/cases/{id}', [CaseController::class, 'update'])->name('cases.update');
    Route::delete('/cases/{id}', [CaseController::class, 'destroy'])->name('cases.destroy');
    Route::post('/progress/update', [CasePlayController::class, 'updateProgress']);

    Route::get('/users/search', [UserController::class, 'search'])->name('users.search');

    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');

    Route::post('/ratings', [RatingController::class, 'store'])->name('ratings.store');

    Route::get('/tutorial', [CasePlayController::class, 'tutorial'])->name('cases.tutorial');

    Route::get('/cases/create', [CaseController::class, 'create'])->name('user.cases.create');
    Route::post('/cases', [CaseController::class, 'store'])->name('user.cases.store');

    Route::get('/cases/{case}/suspects', [CaseSuspectController::class, 'suspects'])->name('cases.suspects');
    Route::post('/cases/{case}/suspects', [CaseSuspectController::class, 'storeSuspect'])->name('cases.suspects.store');
    Route::post('/cases/{case}/set-answer', [CaseSuspectController::class, 'setAnswer'])->name('cases.suspects.setAnswer');

    Route::get('/cases/{case}/evidence', [CaseEvidenceController::class, 'evidence'])->name('cases.evidence');
    Route::post('/cases/{case}/evidence', [CaseEvidenceController::class, 'storeEvidence'])->name('cases.evidence.store');

    Route::get('/cases/{case}/questions', [CaseQuestionController::class, 'questions'])->name('cases.questions');
    Route::post('/cases/{case}/questions', [CaseQuestionController::class, 'storeQuestion'])->name('cases.questions.store');

    Route::post('/cases/{case}/submit-final', [CaseController::class, 'submitFinal'])->name('cases.submit.final');

    Route::patch('/cases/{case}/toggle-status', [CaseController::class, 'toggleStatus'])->name('cases.toggle-status');

    Route::get('/cases/{id}/comments', [CaseController::class, 'comments'])->name('cases.comments');

    Route::get('/my-ratings', [RatingController::class, 'index'])->name('ratings.index');
    Route::get('/my-ratings/{id}/edit', [RatingController::class, 'edit'])->name('ratings.edit');
    Route::put('/my-ratings/{id}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('/my-ratings/{id}', [RatingController::class, 'destroy'])->name('ratings.destroy');
});

Route::get('/cases', [CaseController::class, 'index'])->name('cases.index');

Route::middleware(['auth', ModeratorMiddleware::class])
    ->prefix('moderator')
    ->name('moderator.')
    ->group(function () {

        Route::prefix('cases')->group(function () {
            Route::get('/', [ModeratorCaseController::class, 'casesIndex'])->name('cases.index');
            Route::get('/create', [ModeratorCaseController::class, 'createCase'])->name('cases.create');
            Route::post('/', [ModeratorCaseController::class, 'storeCase'])->name('cases.store');
            Route::get('/{case}/edit', [ModeratorCaseController::class, 'editCase'])->name('cases.edit');
            Route::put('/{case}', [ModeratorCaseController::class, 'updateCase'])->name('cases.update');
            Route::put('/{case}/deactivate', [ModeratorCaseController::class, 'deactivateCase'])->name('cases.deactivate');
            Route::put('/{case}/activate', [ModeratorCaseController::class, 'activateCase'])->name('cases.activate');
            Route::delete('/{case}', [ModeratorCaseController::class, 'destroyCase'])->name('cases.destroy');
            Route::post('/{case}/restore', [ModeratorCaseController::class, 'restoreCase'])->name('cases.restore');
            Route::put('/{id}/tutorial', [ModeratorCaseController::class, 'setTutorial'])->name('cases.setTutorial');
        });

        Route::prefix('users')->group(function () {
            Route::get('/', [ModeratorUserController::class, 'usersIndex'])->name('users.index');
            Route::get('/{user}', [ModeratorUserController::class, 'showUser'])->name('users.show');
            Route::put('/{user}/deactivate', [ModeratorUserController::class, 'deactivateUser'])->name('users.deactivate');
            Route::put('/{user}/activate', [ModeratorUserController::class, 'activateUser'])->name('users.activate');
            Route::delete('/{user}', [ModeratorUserController::class, 'destroyUser'])->name('users.destroy');
            Route::post('/{user}/restore', [ModeratorUserController::class, 'restoreUser'])->name('users.restore');
        });

        Route::prefix('achievements')->group(function () {
            Route::get('/', [ModeratorAchievementController::class, 'achievementsIndex'])->name('achievements.index');
            Route::get('/create', [ModeratorAchievementController::class, 'createAchievement'])->name('achievements.create');
            Route::post('/', [ModeratorAchievementController::class, 'storeAchievement'])->name('achievements.store');
            Route::get('/{achievement}/edit', [ModeratorAchievementController::class, 'editAchievement'])->name('achievements.edit');
            Route::put('/{achievement}', [ModeratorAchievementController::class, 'updateAchievement'])->name('achievements.update');
            Route::post('/{achievement}/deactivate', [ModeratorAchievementController::class, 'deactivateAchievement'])->name('achievements.deactivate');
            Route::post('/{achievement}/activate', [ModeratorAchievementController::class, 'activateAchievement'])->name('achievements.activate');
            Route::delete('/{achievement}', [ModeratorAchievementController::class, 'destroyAchievement'])->name('achievements.destroy');
            Route::post('/{achievement}/restore', [ModeratorAchievementController::class, 'restoreAchievement'])->name('achievements.restore');
        });

        Route::prefix('genres')->group(function () {
            Route::get('/', [ModeratorGenreController::class, 'genresIndex'])->name('genres.index');
            Route::post('/', [ModeratorGenreController::class, 'storeGenre'])->name('genres.store');
            Route::get('/{genre}/edit', [ModeratorGenreController::class, 'editGenre'])->name('genres.edit');
            Route::put('/{genre}', [ModeratorGenreController::class, 'updateGenre'])->name('genres.update');
            Route::post('/{genre}/deactivate', [ModeratorGenreController::class, 'deactivateGenre'])->name('genres.deactivate');
            Route::post('/{genre}/activate', [ModeratorGenreController::class, 'activateGenre'])->name('genres.activate');
            Route::delete('/{genre}', [ModeratorGenreController::class, 'destroyGenre'])->name('genres.destroy');
            Route::post('/{genre}/restore', [ModeratorGenreController::class, 'restoreGenre'])->name('genres.restore');
        });

        Route::get('/stats', [ModeratorStatsController::class, 'stats'])->name('stats');

        Route::prefix('rangs')->group(function () {
            Route::get('/', [ModeratorRangController::class, 'rangsIndex'])->name('rangs.index');
            Route::get('/create', [ModeratorRangController::class, 'createrang'])->name('rangs.create');
            Route::post('/', [ModeratorRangController::class, 'storerang'])->name('rangs.store');
            Route::get('/{rangs}/edit', [ModeratorRangController::class, 'editrang'])->name('rangs.edit');
            Route::put('/{rangs}', [ModeratorRangController::class, 'updaterang'])->name('rangs.update');
            Route::post('/{rangs}/deactivate', [ModeratorRangController::class, 'deactivaterang'])->name('rangs.deactivate');
            Route::post('/{rangs}/activate', [ModeratorRangController::class, 'activaterang'])->name('rangs.activate');
            Route::delete('/{rangs}', [ModeratorRangController::class, 'destroyrang'])->name('rangs.destroy');
            Route::post('/{rangs}/restore', [ModeratorRangController::class, 'restorerang'])->name('rangs.restore');
        });
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
