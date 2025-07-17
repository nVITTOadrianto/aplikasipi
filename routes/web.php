<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\Subkeg1\Subkeg1SPPDController;
use App\Http\Controllers\Admin\Subkeg1\Subkeg1SuratKeluarController;
use App\Http\Controllers\Admin\Subkeg1\Subkeg1SuratMasukController;
use App\Http\Controllers\Admin\SubkegLain\SubkegLainSPPDController;
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

    Route::get('/profile', [DashboardController::class, 'indexProfile'])
        ->name('profile');

    Route::put('/profile', [DashboardController::class,'updateProfile'])
        ->name('profile.update');

    Route::get('/change-password', [DashboardController::class, 'indexPassword'])
        ->name('change-password');

    Route::put('/change-password', [DashboardController::class, 'updatePassword'])
        ->name('change-password.update');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');

    Route::prefix('/pegawai')->name('pegawai.')->group(function () {
        Route::get('/', [PegawaiController::class, 'index'])
            ->name('index');

        Route::get('/create', [PegawaiController::class, 'create'])
            ->name('create');

        Route::post('/', [PegawaiController::class, 'store'])
            ->name('store');

        Route::post('/import', [PegawaiController::class, 'import'])
            ->name('import');

        Route::get('/export', [PegawaiController::class, 'export'])
            ->name('export');

        Route::get('/details/{id}', [PegawaiController::class, 'show'])
            ->name('show');

        Route::get('/edit/{id}', [PegawaiController::class, 'edit'])
            ->name('edit');

        Route::put('/{id}', [PegawaiController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [PegawaiController::class, 'destroy'])
            ->name('destroy');
    });

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
            
            Route::get('/file/{id}', [Subkeg1SuratMasukController::class, 'file'])
                ->name('file');

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

            Route::get('/file/{id}', [Subkeg1SuratKeluarController::class, 'file'])
                ->name('file');

            Route::get('/edit/{id}', [Subkeg1SuratKeluarController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [Subkeg1SuratKeluarController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [Subkeg1SuratKeluarController::class, 'destroy'])
                ->name('destroy');
        });

        Route::prefix('/sppd')->name('sppd.')->group(function () {
            Route::get('/', [Subkeg1SPPDController::class, 'index'])
                ->name('index');

            Route::get('/create', [Subkeg1SPPDController::class, 'create'])
                ->name('create');

            Route::post('/', [Subkeg1SPPDController::class, 'store'])
                ->name('store');

            Route::get('/details/{id}', [Subkeg1SPPDController::class, 'show'])
                ->name('show');

            Route::get('/edit/{id}', [Subkeg1SPPDController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [Subkeg1SPPDController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [Subkeg1SPPDController::class, 'destroy'])
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
                
            Route::get('/file/{id}', [SubkegLainSuratMasukController::class, 'file'])
                ->name('file');

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

            Route::get('/file/{id}', [SubkegLainSuratKeluarController::class, 'file'])
                ->name('file');

            Route::get('/edit/{id}', [SubkegLainSuratKeluarController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [SubkegLainSuratKeluarController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [SubkegLainSuratKeluarController::class, 'destroy'])
                ->name('destroy');
        });

        Route::prefix('/sppd')->name('sppd.')->group(function () {
            Route::get('/', [SubkegLainSPPDController::class, 'index'])
                ->name('index');

            Route::get('/create', [SubkegLainSPPDController::class, 'create'])
                ->name('create');

            Route::post('/', [SubkegLainSPPDController::class, 'store'])
                ->name('store');

            Route::get('/details/{id}', [SubkegLainSPPDController::class, 'show'])
                ->name('show');

            Route::get('/edit/{id}', [SubkegLainSPPDController::class, 'edit'])
                ->name('edit');

            Route::put('/{id}', [SubkegLainSPPDController::class, 'update'])
                ->name('update');

            Route::delete('/{id}', [SubkegLainSPPDController::class, 'destroy'])
                ->name('destroy');
        });
    });
});
