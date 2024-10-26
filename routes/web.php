<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JokeController;

Route::get('/', function () {
    return view('auth.login'); // Adjust this to the correct welcome view
});


Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Grouping together the authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', [JokeController::class, 'index'])->name('dashboard');
    Route::post('/joke', [JokeController::class, 'fetchJoke'])->name('joke.fetch');
});