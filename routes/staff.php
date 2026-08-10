<?php

use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TeacherAssignmentController;
use App\Http\Controllers\Admin\TermController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\Staff\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Staff\ForcePasswordController;
use App\Http\Controllers\Teacher\TimetableController as TeacherTimetableController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:staff')->group(function () {
    Route::get('staff/login', [AuthenticatedSessionController::class, 'create'])
        ->name('staff.login');

    Route::post('staff/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth:staff')->group(function () {
    Route::post('staff/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('staff.logout');

    Route::get('staff/force-password-change', [ForcePasswordController::class, 'show'])
        ->name('staff.password.force');

    Route::post('staff/force-password-change', [ForcePasswordController::class, 'update'])
        ->name('staff.password.force.update');

    Route::middleware(['force.password.change', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        Route::resource('classes', ClassRoomController::class)
            ->except('show')
            ->parameters(['classes' => 'classRoom']);

        Route::resource('subjects', SubjectController::class)->except('show');

        Route::resource('terms', TermController::class)->except('show');

        Route::resource('teacher-assignments', TeacherAssignmentController::class)
            ->except('show')
            ->parameters(['teacher-assignments' => 'teacherAssignment']);

        Route::resource('students', StudentController::class)->except('show');

        Route::post('students/{student}/reset-password', [StudentController::class, 'resetPassword'])
            ->name('students.reset-password');

        Route::get('timetables', [TimetableController::class, 'index'])->name('timetables.index');
        Route::get('timetables/{classRoom}', [TimetableController::class, 'show'])->name('timetables.show');
        Route::get('timetables/{classRoom}/create', [TimetableController::class, 'create'])->name('timetables.create');
        Route::post('timetables/{classRoom}', [TimetableController::class, 'store'])->name('timetables.store');
        Route::get('timetables/{classRoom}/{timetable}/edit', [TimetableController::class, 'edit'])->name('timetables.edit');
        Route::put('timetables/{classRoom}/{timetable}', [TimetableController::class, 'update'])->name('timetables.update');
        Route::delete('timetables/{classRoom}/{timetable}', [TimetableController::class, 'destroy'])->name('timetables.destroy');
        Route::post('timetables/{classRoom}/generate', [TimetableController::class, 'generate'])->name('timetables.generate');
    });

    Route::middleware(['force.password.change', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('dashboard', function () {
            return view('teacher.dashboard');
        })->name('dashboard');

        Route::get('timetable', [TeacherTimetableController::class, 'index'])->name('timetable.index');
    });
});
