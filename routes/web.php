<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Главная страница - редирект на список заявок (если авторизован) или на логин
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('applications.index');
    }
    return redirect()->route('auth.login');
});

// Аутентификация
Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

// Заявки (требуется авторизация)
Route::middleware('auth')->group(function () {
    Route::get('/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('/applications/create', [ApplicationController::class, 'create'])->name('applications.create');
    Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');
    Route::post('/applications/{application}/review', [ApplicationController::class, 'storeReview'])->name('applications.review');
});

// Панель администратора (требуется авторизация)
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::patch('/applications/{application}/status', [AdminController::class, 'updateStatus'])->name('applications.update-status');
    Route::delete('/applications/{application}', [AdminController::class, 'destroy'])->name('applications.destroy');
});
