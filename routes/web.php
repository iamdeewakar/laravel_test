<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/', function () {
    return redirect()->route('blogs.index');
});

Route::resource('blogs', BlogController::class);

Route::post('blogs/{blog}/comments', [CommentController::class, 'store'])->middleware('auth')->name('comments.store');
Route::post('comments/{comment}/like', [CommentController::class, 'like'])->middleware('auth')->name('comments.like');

Route::get('search/tags', [BlogController::class, 'searchByTag'])->name('blogs.searchByTag');
Route::get('search', [BlogController::class, 'search'])->name('blogs.search');

Route::post('blogs/{blog}/share', [BlogController::class, 'share'])->middleware('auth')->name('blogs.share');


