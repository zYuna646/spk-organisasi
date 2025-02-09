<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DisporaController;
use App\Http\Controllers\FrontPageController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MainSliderController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\ReviewSliderController;
use App\Http\Controllers\VideoController;
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

Route::get('/', [FrontPageController::class, 'index'])->name('home');
Route::get('/catalog', [FrontPageController::class, 'catalog'])->name('catalog');
Route::get('/catalog/product/{slug}', [FrontPageController::class, 'productDetail'])->name('product.detail');

/* Authentication Routes... */
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register/submit', [AuthController::class, 'submit'])->name('register.submit');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Auth::routes([
    'register' => false, // Register Routes...
    'reset' => false, // Reset Password Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::middleware(['auth', 'login-check'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

  

    Route::prefix('admin/organisasi')->name('admin.organisasi.')->group(function () {
        Route::get('/', [OrganisasiController::class, 'index'])->name('index');
        Route::get('/add', [OrganisasiController::class, 'create'])->name('create');
        Route::post('/store', [OrganisasiController::class, 'store'])->name('store');
        Route::get('{id}/show', [OrganisasiController::class, 'show'])->name('show');
        Route::get('{id}/edit', [OrganisasiController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [OrganisasiController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [OrganisasiController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/berita')->name('admin.berita.')->group(function () {
        Route::get('/', [BeritaController::class, 'index'])->name('index');
        Route::get('/add', [BeritaController::class, 'create'])->name('create');
        Route::post('/store', [BeritaController::class, 'store'])->name('store');
        Route::get('{id}/show', [BeritaController::class, 'show'])->name('show');
        Route::get('{id}/edit', [BeritaController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [BeritaController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [BeritaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/dispora')->name('admin.dispora.')->group(function () {
        Route::get('/', [DisporaController::class, 'index'])->name('index');
        Route::get('/add', [DisporaController::class, 'create'])->name('create');
        Route::post('/store', [DisporaController::class, 'store'])->name('store');
        Route::get('{id}/show', [DisporaController::class, 'show'])->name('show');
        Route::get('{id}/edit', [DisporaController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [DisporaController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [DisporaController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('admin/kegiatan')->name('admin.kegiatan.')->group(function () {
        Route::get('/', [KegiatanController::class, 'index'])->name('index');
        Route::get('/add', [KegiatanController::class, 'create'])->name('create');
        Route::post('/store', [KegiatanController::class, 'store'])->name('store');
        Route::get('{id}/show', [KegiatanController::class, 'show'])->name('show');
        Route::get('{id}/edit', [KegiatanController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [KegiatanController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [KegiatanController::class, 'destroy'])->name('destroy');
        Route::post('{id}/terima', [KegiatanController::class, 'terima'])->name('terima');
        Route::post('{id}/tolak', [KegiatanController::class, 'tolak'])->name('tolak');
    });

    Route::prefix('admin/proposal')->name('admin.proposal.')->group(function () {
        Route::get('/', [ProposalController::class, 'index'])->name('index');
        Route::get('/add', [ProposalController::class, 'create'])->name('create');
        Route::post('/store', [ProposalController::class, 'store'])->name('store');
        Route::get('{id}/show', [ProposalController::class, 'show'])->name('show');
        Route::get('{id}/edit', [ProposalController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [ProposalController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [ProposalController::class, 'destroy'])->name('destroy');
        Route::post('{id}/terima', [ProposalController::class, 'terima'])->name('terima');
        Route::post('{id}/tolak', [ProposalController::class, 'tolak'])->name('tolak');
    });

    Route::prefix('admin/rangking')->name('admin.rangking.')->group(function () {
        Route::get('/', [AdminController::class, 'rangking'])->name('index');
        Route::get('/add', [ProposalController::class, 'create'])->name('create');
        Route::post('/store', [ProposalController::class, 'store'])->name('store');
        Route::get('{id}/show', [ProposalController::class, 'show'])->name('show');
        Route::get('{id}/edit', [ProposalController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [ProposalController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [ProposalController::class, 'destroy'])->name('destroy');
        Route::post('{id}/terima', [AdminController::class, 'terima'])->name('terima');
        Route::post('{id}/tolak', [ProposalController::class, 'tolak'])->name('tolak');
    });

    Route::prefix('admin/laporan')->name('admin.laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/add', [LaporanController::class, 'create'])->name('create');
        Route::post('/store', [LaporanController::class, 'store'])->name('store');
        Route::get('{id}/show', [LaporanController::class, 'show'])->name('show');
        Route::get('{id}/edit', [LaporanController::class, 'edit'])->name('edit');
        Route::put('{id}/update', [LaporanController::class, 'update'])->name('update');
        Route::delete('{id}/destroy', [LaporanController::class, 'destroy'])->name('destroy');
        Route::post('{id}/terima', [LaporanController::class, 'terima'])->name('terima');
        Route::post('{id}/tolak', [LaporanController::class, 'tolak'])->name('tolak');
    });

    Route::get('/admin/account-setting', [AdminController::class, 'accountSetting'])->name('admin.account-setting');
    Route::put('/admin/change-password/{id}', [AdminController::class, 'changePassword'])->name('admin.change-password');
    Route::put('/admin/change-information/{id}', [AdminController::class, 'changeInformation'])->name('admin.change-information');
});