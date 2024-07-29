<?php

use App\Helpers\Routes\RouteHelper;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes                                                    
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::get('/users', function () {
//     return new \Illuminate\Http\JsonResponse(['data' => 'hello']);
// });

/* Route::get('/users/{id}', function (User $id) {
    return new \Illuminate\Http\JsonResponse(['data' => $id]);
});

Route::post('/users/{id}', function (User $id) {
    return new \Illuminate\Http\JsonResponse(['data' => 'posted']);
});

Route::patch('/users/{id}', function (User $id) {
    return new \Illuminate\Http\JsonResponse(['data' => 'patched']);
});

Route::delete('/users/{id}', function (User $id) {
    return new \Illuminate\Http\JsonResponse(['data' => 'deleted']);
});
 */

//for better handling of multiple api routes per resource:
require __DIR__ . '/api/resourceName.php';

//for looping all api/v1/ routes files, use iterator
RouteHelper::requireDirectory(__DIR__ . '/api/');


// Route::get('/users', [UserController::class, 'index']);

// Route::get('/users/{user}', [UserController::class, 'show']);

// Route::post('/users/{user}', [UserController::class, 'store']);

// Route::patch('/users/{user}', [UserController::class, 'update']);

// Route::delete('/users/{user}', [UserController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
