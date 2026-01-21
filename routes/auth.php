<?php

use App\Http\Controllers;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::middleware(['auth', 'userRole:student'])->group(function () {

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', [Controllers\DashboardController::class, 'index'])->name('dashboard');
    
    Route::name('class.')->group(function () {
        
        Route::prefix('myclass')->group(function () {
            Route::get('/', [Controllers\ClassStudentController::class, 'index'])->name('index');
        });

        Route::prefix('class')->group(function () {
            Route::get('/list', [Controllers\ClassStudentController::class, 'list'])->name('list');
            Route::post('/request', [Controllers\ClassStudentController::class, 'requestJoin'])->name('request');
        });
    });
    

    Route::prefix('exam')->name('exam.')->group(function () {
        Route::get('/', [Controllers\ExamController::class, 'index'])->name('index');
        Route::get('/attempt/{examSession}', [Controllers\ExamController::class, 'view'])->name('view');
        Route::post('/submit/{examSession}', [Controllers\ExamController::class, 'submit'])->name('submit');
        Route::post('/session', [Controllers\ExamController::class, 'saveSession'])->name('session');
    });

    
    Route::get('/profile', [Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');

});
