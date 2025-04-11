<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;

Route::get('/', [PostController::class, 'index'])->name('index');

Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'showRegisterForm'])->name('user.registerform');
    Route::post('/register', [UserController::class, 'register'])->name('user.register');
    Route::get('/login', [UserController::class, 'showLoginForm'])->name('user.loginform');
    Route::post('/login', [UserController::class, 'login'])->name('user.login');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/profile/update', [UserController::class, 'updateDetails'])->name('user.update');
    Route::post('/profile/update-password', [UserController::class, 'updatePassword'])->name('user.update-password');
    Route::post('/profile/update-picture', [UserController::class, 'changeProfilePicture'])->name('user.update-picture');
    Route::get('profile/confirm-delete', [UserController::class, 'confirmDelete'])->name('user.confirm-delete');
    Route::delete('/profile/delete', [UserController::class, 'destroy'])->name('user.delete');

    Route::post('/profile/upload-temp', [ImageController::class, 'uploadTemp'])->name('user.upload-temp');

    Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');

    Route::post('/', [PostController::class, 'store'])->name('post.store');
    Route::delete('/post', [PostController::class, 'delete'])->name('post.delete');

    Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');

    Route::post('/likes', [LikeController::class, 'store'])->name('like.store');
    Route::delete('likes/{like}', [likeController::class, 'destroy'])->name('like.destroy');
});

Route::get('/post/{post:slug}', [PostController::class, 'show'])->name('post.show');

Route::get('/profile/{user:slug}', [UserController::class, 'show'])->name('user.show');