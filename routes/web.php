<?php

use App\Http\Controllers;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [Controllers\Auth\AuthenticatedSessionController::class, 'create']);

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [Controllers\Auth\Admin\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [Controllers\Auth\Admin\AuthenticatedSessionController::class, 'store'])->name('login.attempt');

    Route::middleware(['adminRole'])->group(function () {

        Route::get('/dashboard', [Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [Controllers\Auth\Admin\AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::prefix('student')->name('student.')->group(function () {
            Route::get('/', [Controllers\Admin\StudentController::class, 'index'])->name('index');
        });

        Route::prefix('lecturer')->name('lect.')->group(function () {
            Route::get('/', [Controllers\Admin\LecturerController::class, 'index'])->name('index');
            Route::get('/create', [Controllers\Admin\LecturerController::class, 'create'])->name('create');
            Route::post('/create', [Controllers\Admin\LecturerController::class, 'store'])->name('store');
            Route::get('/{lecturer}/edit', [Controllers\Admin\LecturerController::class, 'edit'])->name('edit');
            Route::post('/{lecturer}/update', [Controllers\Admin\LecturerController::class, 'update'])->name('update');
        });

        Route::prefix('class')->name('class.')->group(function () {
            Route::get('/', [Controllers\Admin\ClassController::class, 'index'])->name('index');
            Route::get('/create', [Controllers\Admin\ClassController::class, 'create'])->name('create');
            Route::post('/create', [Controllers\Admin\ClassController::class, 'store'])->name('store');
            Route::get('/{classSubject}/edit', [Controllers\Admin\ClassController::class, 'edit'])->name('edit');
            Route::post('/{classSubject}/update', [Controllers\Admin\ClassController::class, 'update'])->name('update');
        });
    });
});


Route::prefix('lecturer')->name('lect.')->group(function () {

    Route::get('/login', [Controllers\Auth\Lecturer\AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [Controllers\Auth\Lecturer\AuthenticatedSessionController::class, 'attempt'])->name('login.attempt');
    Route::get('/register', [Controllers\Auth\Lecturer\AuthenticatedSessionController::class, 'register'])->name('register');
    Route::post('/register', [Controllers\Auth\Lecturer\AuthenticatedSessionController::class, 'store'])->name('store');


    Route::middleware(['userRole:lecturer'])->group(function () {

        Route::get('/dashboard', [Controllers\Lecturer\DashboardController::class, 'index'])->name('dashboard');
        Route::post('/logout', [Controllers\Auth\Lecturer\AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::prefix('class')->name('class.')->group(function () {
            Route::get('/', [Controllers\Lecturer\ClassSubjectController::class, 'index'])->name('index');
            Route::get('/{classSubject}/view', [Controllers\Lecturer\ClassSubjectController::class, 'view'])->name('view');
            Route::post('/request', [Controllers\ClassStudentController::class, 'requestJoin'])->name('request');
        });

        Route::prefix('exam')->name('exam.')->group(function () {
            Route::get('/', [Controllers\Lecturer\ExamController::class, 'index'])->name('index');
            Route::get('/create', [Controllers\Lecturer\ExamController::class, 'create'])->name('create');
            Route::post('/create', [Controllers\Lecturer\ExamController::class, 'store'])->name('store');
            Route::get('/edit/{examSession}', [Controllers\Lecturer\ExamController::class, 'edit'])->name('edit');
            Route::post('/edit/{examSession}', [Controllers\Lecturer\ExamController::class, 'update'])->name('update');
            Route::post('/update/{examSession}/question', [Controllers\Lecturer\ExamController::class, 'updateQuestion'])->name('question');
            Route::post('/remove/question', [Controllers\Lecturer\ExamController::class, 'removeQuestion'])->name('question.remove');

            Route::get('/attempt/{examSession}', [Controllers\Lecturer\ExamController::class, 'listAttempt'])->name('attempt');
            Route::get('/attempt/{studentAttempt}/answer', [Controllers\Lecturer\ExamController::class, 'detailAttempt'])->name('attempt.detail');
            Route::post('/attempt/{studentAttempt}/result', [Controllers\Lecturer\ExamController::class, 'submitResult'])->name('attempt.result');

        });    
        
        Route::get('/profile', [Controllers\ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [Controllers\ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::put('password', [Controllers\Auth\PasswordController::class, 'update'])->name('password.update');

    });
});



require __DIR__ . '/auth.php'; // put student route here
