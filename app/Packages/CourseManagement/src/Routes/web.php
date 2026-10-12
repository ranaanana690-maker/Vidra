<?php

use App\Packages\CourseManagement\Controllers\CourseController;
use App\Packages\CourseManagement\Controllers\CourseEnrollmentController;
use App\Packages\CourseManagement\Controllers\CourseLevelController;
use App\Packages\CourseManagement\Controllers\QuranProgressController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth'])->prefix('courses')->group(function () {

    Route::middleware('permission:view-courses')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('courses.index');
        Route::get('/enrollments', [CourseEnrollmentController::class, 'index'])->name('courses.enrollments.index');
        Route::get('/{course}', [CourseController::class, 'show'])->name('courses.show');
    });

    Route::middleware('permission:create-courses')->group(function () {
        Route::get('/create/new', [CourseController::class, 'create'])->name('courses.create');
        Route::post('/', [CourseController::class, 'store'])->name('courses.store');
        Route::post('/{course}/levels', [CourseLevelController::class, 'store'])->name('courses.levels.store');
        Route::post('/{course}/enroll', [CourseEnrollmentController::class, 'store'])->name('courses.enrollments.store');
        Route::post('/enrollments/{enrollment}/progress', [QuranProgressController::class, 'store'])->name('courses.progress.store');
    });

    Route::middleware('permission:edit-courses')->group(function () {
        Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('courses.edit');
        Route::put('/{course}', [CourseController::class, 'update'])->name('courses.update');
        Route::put('/{course}/levels/{level}', [CourseLevelController::class, 'update'])->name('courses.levels.update');
        Route::put('/enrollments/{enrollment}', [CourseEnrollmentController::class, 'update'])->name('courses.enrollments.update');
        Route::put('/enrollments/{enrollment}/progress/{progress}', [QuranProgressController::class, 'update'])->name('courses.progress.update');
    });

    Route::middleware('permission:delete-courses')->group(function () {
        Route::delete('/{course}', [CourseController::class, 'destroy'])->name('courses.destroy');
        Route::delete('/{course}/levels/{level}', [CourseLevelController::class, 'destroy'])->name('courses.levels.destroy');
        Route::delete('/enrollments/{enrollment}', [CourseEnrollmentController::class, 'destroy'])->name('courses.enrollments.destroy');
        Route::delete('/enrollments/{enrollment}/progress/{progress}', [QuranProgressController::class, 'destroy'])->name('courses.progress.destroy');
    });
});
