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

// Route::get('/login', function () {
//     return Inertia::render('Auth/Login');
// })->middleware('guest')->name('login');

Route::get('/register', function () {
    return Inertia::render('Auth/Register');
})->middleware('guest')->name('register');


Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::get('/login', [LoginController::class, 'create'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
});







Route::get('/',function(){
    return Inertia::render('Home');
});