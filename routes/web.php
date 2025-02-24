<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TwoFactorAuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/two-factor.index', [TwoFactorAuthController::class, 'index'])->name('two-factor.index')->middleware('signed');
Route::get('/two-factor', function () {
    return view('auth.two-factor-message');
})->name('two-factor.message');
Route::post('/resend-code', [TwoFactorAuthController::class, 'resend'])->name('two-factor.resend');
Route::post('/two-factor', [TwoFactorAuthController::class, 'verify'])->name('two-factor.verify');

Route::middleware('auth', 'guest')->group(function () {
    // Rutas para el segundo factor de autentificacion
    //
    //Route::get('/two-factor', [TwoFactorAuthController::class, 'index'])->name('two-factor.index');
});
Route::middleware('auth')->group(function () {
    // Puede acceder a estas rutas una vez pasado los 2 factores de autentificacion

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');


    //Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Route::get('/products', [ProductController::class, 'showProducts'])->name('products.index');
});



require __DIR__.'/auth.php';
