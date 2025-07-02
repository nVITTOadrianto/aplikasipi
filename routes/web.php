<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\Subkeg1\Subkeg1SuratKeluarController;
use App\Http\Controllers\Admin\Subkeg1\Subkeg1SuratMasukController;
use App\Http\Controllers\Admin\SubkegLain\SubkegLainSuratKeluarController;
use App\Http\Controllers\Admin\SubkegLain\SubkegLainSuratLainController;
use App\Http\Controllers\Admin\SubkegLain\SubkegLainSuratMasukController;
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

    Route::prefix('/subkeg-1')->name('subkeg-1.')->group(function () {
        Route::prefix('/surat-masuk')->name('surat-masuk.')->group(function () {
            Route::get('/', [Subkeg1SuratMasukController::class, 'index'])
                ->name('index');

            Route::get('/create', [Subkeg1SuratMasukController::class, 'create'])
                ->name('create');

            Route::post('/', [Subkeg1SuratMasukController::class, 'store'])
                ->name('store');

            Route::get('/details/{id}', [Subkeg1SuratMasukController::class, 'show'])
                ->name('show');

            Route::get('/edit/{id}', [Subkeg1SuratMasukController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [Subkeg1SuratMasukController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [Subkeg1SuratMasukController::class, 'destroy'])
                ->name('destroy');
        });

        Route::prefix('/surat-keluar')->name('surat-keluar.')->group(function () {
            Route::get('/', [Subkeg1SuratKeluarController::class, 'index'])
                ->name('index');

            Route::get('/create', [Subkeg1SuratKeluarController::class, 'create'])
                ->name('create');

            Route::post('/', [Subkeg1SuratKeluarController::class, 'store'])
                ->name('store');

            Route::get('/details/{id}', [Subkeg1SuratKeluarController::class, 'show'])
                ->name('show');

            Route::get('/edit/{id}', [Subkeg1SuratKeluarController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [Subkeg1SuratKeluarController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [Subkeg1SuratKeluarController::class, 'destroy'])
                ->name('destroy');
        });
    });

    Route::prefix('/subkeg-lain')->name('subkeg-lain.')->group(function () {
        Route::prefix('/surat-masuk')->name('surat-masuk.')->group(function () {
            Route::get('/', [SubkegLainSuratMasukController::class, 'index'])
                ->name('index');

            Route::get('/create', [SubkegLainSuratMasukController::class, 'create'])
                ->name('create');

            Route::post('/', [SubkegLainSuratMasukController::class, 'store'])
                ->name('store');

            Route::get('/details/{id}', [SubkegLainSuratMasukController::class, 'show'])
                ->name('show');

            Route::get('/edit/{id}', [SubkegLainSuratMasukController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [SubkegLainSuratMasukController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [SubkegLainSuratMasukController::class, 'destroy'])
                ->name('destroy');
        });

        Route::prefix('/surat-keluar')->name('surat-keluar.')->group(function () {
            Route::get('/', [SubkegLainSuratKeluarController::class, 'index'])
                ->name('index');

            Route::get('/create', [SubkegLainSuratKeluarController::class, 'create'])
                ->name('create');

            Route::post('/', [SubkegLainSuratKeluarController::class, 'store'])
                ->name('store');

            Route::get('/details/{id}', [SubkegLainSuratKeluarController::class, 'show'])
                ->name('show');

            Route::get('/edit/{id}', [SubkegLainSuratKeluarController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [SubkegLainSuratKeluarController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [SubkegLainSuratKeluarController::class, 'destroy'])
                ->name('destroy');
        });

        Route::prefix('/surat-lain')->name('surat-lain.')->group(function() {
            Route::get('/', [SubkegLainSuratLainController::class, 'index'])
                ->name('index');

            Route::prefix('/sppd')->name('sppd.')->group(function() {
                Route::get('/create', [SubkegLainSuratLainController::class, 'createSppd'])
                    ->name('create');

                Route::post('/', [SubkegLainSuratLainController::class, 'storeSppd'])
                    ->name('store');

                Route::get('/details/{id}', [SubkegLainSuratLainController::class, 'showSppd'])
                    ->name('show');

                Route::get('/edit/{id}', [SubkegLainSuratLainController::class, 'editSppd'])
                    ->name('edit');

                Route::put('/{id}', [SubkegLainSuratLainController::class, 'updateSppd'])
                    ->name('update');

                Route::delete('/{id}', [SubkegLainSuratLainController::class, 'destroySppd'])
                    ->name('destroy');
            });
        });
    });
});
