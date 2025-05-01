<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// Login routes
Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Routes untuk event
Route::middleware(['auth'])->group(function () {
    // Route untuk menampilkan dashboard dan mengirimkan data event
    Route::get('/dashboard', [EventController::class, 'index'])->name('dashboard');
    
    // Route untuk menampilkan form create event
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    
    // Route untuk menyimpan event baru
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    
    // Route untuk menampilkan form edit event (ubah event)
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    
    // Route untuk menyimpan perubahan event
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    
    // Route untuk menghapus event
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});
