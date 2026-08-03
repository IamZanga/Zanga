<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ForcePasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::post('/notes/{note}/ask', [NoteController::class, 'ask'])->name('notes.ask');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notes', [NoteController::class, 'index'])->name('notes');
    Route::get('/notes/{note}/download', [NoteController::class, 'download'])->name('notes.download');

    Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable');
    Route::get('/grades', [GradeController::class, 'index'])->name('grades');

    Route::get('/force-password-change', [ForcePasswordController::class, 'show'])->name('password.force');
    Route::post('/force-password-change', [ForcePasswordController::class, 'update'])->name('password.force.update');
});

require __DIR__.'/auth.php';