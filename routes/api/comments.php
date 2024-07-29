<?php

use Illuminate\Http\Request;
use App\Http\Controllers\CommentController;

Route::get('/comments', [CommentController::class, 'index']);

Route::get('/comments/{comment}', [CommentController::class, 'show']); //condition the routes to only accept numeric parameter

Route::post('/comments', [CommentController::class, 'store']);

Route::patch('/comments/{comment}', [CommentController::class, 'update']);

Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);
