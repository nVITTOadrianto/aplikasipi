<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SuratKeluarController;
use App\Http\Controllers\Admin\SuratMasukController;
use App\Http\Controllers\LoginController;
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
    return view('home');
})->name('home');

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [LoginController::class, 'index'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'authenticate'])
        ->name('login.post');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Route::get('/profile', [DashboardController::class, 'indexProfile'])
    //     ->name('profile');

    // Route::put('/profile', [DashboardController::class,'updateProfile'])
    //     ->name('profile.update');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::prefix('surat-masuk')->name('surat-masuk.')->group(function () {
        Route::get('/', [SuratMasukController::class, 'index'])
            ->name('index');

        Route::get('/create', [SuratMasukController::class, 'create'])
            ->name('create');

        Route::post('/', [SuratMasukController::class, 'store'])
            ->name('store');

        Route::get('/details/{id}', [SuratMasukController::class, 'show'])
            ->name('show');

        Route::get('/edit/{id}', [SuratMasukController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [SuratMasukController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [SuratMasukController::class, 'destroy'])
            ->name('destroy');
    });

    Route::prefix('surat-keluar')->name('surat-keluar.')->group(function () {
        Route::get('/', [SuratKeluarController::class, 'index'])
            ->name('index');

        Route::get('/create', [SuratKeluarController::class, 'create'])
            ->name('create');

        Route::post('/', [SuratKeluarController::class, 'store'])
            ->name('store');

        Route::get('/details/{id}', [SuratKeluarController::class, 'show'])
            ->name('show');

        Route::get('/edit/{id}', [SuratKeluarController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [SuratKeluarController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [SuratKeluarController::class, 'destroy'])
            ->name('destroy');
    });
});
