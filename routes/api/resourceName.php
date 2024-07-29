<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);

Route::get('/users/{user}', [UserController::class, 'show'])->where('auth', '[0-9]+'); //condition the routes to only accept numeric parameter

Route::post('/users', [UserController::class, 'store']);

Route::patch('/users/{user}', [UserController::class, 'update']);

Route::delete('/users/{user}', [UserController::class, 'destroy']);
