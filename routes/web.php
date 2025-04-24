<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;
// Route::get('/{any}', function () {
//     return view('app'); // app.blade.php loads Vue
// })->where('any', '.*');

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', function () {
    return Inertia::render('Auth/Login');
})->middleware('guest')->name('login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->middleware('guest')->name('register');


Route::get('/products', function () {
    return Inertia::render('Products/Index');
})->middleware('auth');


Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');

Route::get('/products', [ProductController::class, 'index'])->middleware('auth');




Route::get('/',function(){
    return Inertia::render('Home');
});