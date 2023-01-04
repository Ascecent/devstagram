<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home')->middleware('auth');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store'])->name('register');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login');
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

Route::get('/{user:slug}', [PostController::class, 'index'])->name('posts.index');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('auth');
Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('auth');
Route::get('/{user:slug}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::post('/{user:slug}/posts/{post}/comments', [CommentController::class, 'store'])->name('posts.comments.store')->middleware('auth');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');

Route::post('/images', [ImageController::class, 'store'])->name('images.store')->middleware('auth');

// Profile
Route::get('/{user:slug}/edit', [ProfileController::class, 'index'])->name('profile.index')->middleware('auth');
Route::post('/{user:slug}/edit', [ProfileController::class, 'store'])->name('profile.store')->middleware('auth');

// Followers
Route::post('/{user:slug}/follow', [FollowerController::class, 'store'])->name('profile.follow.store')->middleware('auth');
Route::delete('/{user:slug}/unfollow', [FollowerController::class, 'destroy'])->name('profile.follow.destroy')->middleware('auth');
