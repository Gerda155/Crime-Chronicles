<?php
use App\Http\Controllers\ProfileControllerManual;
use App\Http\Controllers\CaseController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('welcome');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileControllerManual::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileControllerManual::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileControllerManual::class, 'destroy'])->name('profile.destroy');

    Route::get('/cases', [CaseController::class, 'index'])->name('cases.index');
});

require __DIR__.'/auth.php';
