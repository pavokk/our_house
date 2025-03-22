<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

Route::get('/', [PostController::class, 'index'])->name('index');
Route::post('/', [PostController::class, 'store'])->name('post.store');

Route::get('/profile/{user}', [UserController::class, 'show'])->name('user.show');

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'showRegisterForm'])->name('user.registerform');
    Route::post('/register', [UserController::class, 'register'])->name('user.register');
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('user.loginform');
    Route::post('/login', [UserController::class, 'login'])->name('user.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
});

