<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini terdaftar rute web untuk aplikasi LESTARI. Rute dimuat oleh
| RouteServiceProvider dalam grup middleware "web".
|
*/

// =========================================================================
// 1. Antarmuka Publik Ruang Cerita (Narasumber)
// =========================================================================
Route::get('/', [StoryController::class, 'index'])->name('home');

Route::post('/stories', [StoryController::class, 'store'])
    ->middleware('throttle:30,1')
    ->name('stories.store');

// =========================================================================
// 2. Autentikasi Fasilitator / Admin
// =========================================================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// 3. Panel Dashboard Admin & Fasilitator (Terproteksi Auth)
// =========================================================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard & Statistik Visual
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // Eksplorasi & Filter Cerita Peserta
    Route::get('/stories', [AdminController::class, 'stories'])->name('stories');
    Route::delete('/stories/{story}', [AdminController::class, 'destroyStory'])->name('stories.destroy');

    // Manajemen Bank Motivasi & Quotes (CRUD)
    Route::get('/motivations', [AdminController::class, 'motivations'])->name('motivations');
    Route::post('/motivations', [AdminController::class, 'storeMotivation'])->name('motivations.store');
    Route::put('/motivations/{motivation}', [AdminController::class, 'updateMotivation'])->name('motivations.update');
    Route::patch('/motivations/{motivation}/toggle', [AdminController::class, 'toggleMotivation'])->name('motivations.toggle');
    Route::delete('/motivations/{motivation}', [AdminController::class, 'destroyMotivation'])->name('motivations.destroy');
});


