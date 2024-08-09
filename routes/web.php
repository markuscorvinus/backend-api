<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\RoutePath;
use \Illuminate\Support\Facades\Lang;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/app', function () {
    return view('app');
});

Route::get(RoutePath::for('password.reset', '/reset-password/{token}'), function ($token) {
    return $token;
})->middleware(['guest:' . config('fortify.guard')])
    ->name('password.reset');

Route::get('/shared/posts/{post}', function (\Illuminate\Http\Request $request, Post $post) {
    return "Specially made just for you :D Post id: {$post->id}";
})->name('shared.post')->middleware('signed');


if (\Illuminate\Support\Facades\App::environment('local')) {
    Route::get('/shared/videos/{video}', function (\Illuminate\Http\Request $request) {
        if (!$request->hasValidSignature()) {
            abort(401);
        }
        return 'git gud';
    })->name('shared_url');

    Route::get('/playground', function () {
        $url = URL::temporarySignedRoute('shared_url', now()->addSeconds(30), [
            'video' => 30
        ]);
        return $url;
        //return (new  \App\Mail\WelcomeMail(User::find(203)))->render();
    });
}

Lang::setLocale('es');
$trans = Lang::get('auth.failed');
//dd($trans);
