<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [AuthController::class, 'showLoginForm']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Yang sudah login (semua role)
Route::middleware('loggedin')->group(function () {
    Route::get('/dashboard', [EventController::class, 'index'])->name('dashboard');
    Route::post('/events/{id}/register', [EventController::class, 'register'])->name('events.register');

    Route::get('/my-events', [EventController::class, 'myEvents'])->name('events.mine');
    Route::get('/data-peserta', [EventController::class, 'participants'])->name('events.participants');
});

// Admin only
Route::middleware(['loggedin', 'role:admin'])->group(function () {
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
});
