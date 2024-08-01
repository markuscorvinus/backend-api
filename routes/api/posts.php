<?php

use Illuminate\Http\Request;
use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);

Route::get('/posts/{post}', [PostController::class, 'show'])->where('auth', '[0-9]+'); //condition the routes to only accept numeric parameter

Route::post('/posts', [PostController::class, 'store'])->name('create.post');

Route::patch('/posts/{post}', [PostController::class, 'update']);

Route::delete('/posts/{post}', [PostController::class, 'destroy']);
