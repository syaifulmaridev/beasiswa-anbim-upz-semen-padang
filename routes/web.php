<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPembinaanController;
use App\Http\Controllers\AdminAlumniController;
use App\Http\Controllers\AdminLogController;
use App\Http\Controllers\PenilaianBeasiswaController;
use App\Http\Controllers\AdminPendaftaranController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserAlumniController;
use App\Http\Controllers\LandingController;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/
Route::get('/', [LandingController::class, 'index'])
    ->name('landing');

Route::get('/statistik', [LandingController::class, 'statistik'])->name('statistik');
Route::get('/informasi-sistem', function () {
    return view('landing.informasi');
})->name('informasi.sistem');
/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::controller(AuthController::class)->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', 'loginPage')->name('login');
        Route::post('/login', 'loginProcess');

        Route::get('/register', 'registerPage')->name('register');
        Route::post('/register', 'registerProcess');
    });

    Route::post('/logout', 'logout')
        ->middleware('auth')
        ->name('logout');
});


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth','role:admin,manager'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ================= DASHBOARD =================
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');


        // ================= REMINDER MANUAL =================
        Route::post('/kirim-reminder', [AdminController::class, 'kirimReminder'])
            ->name('kirim.reminder');


        // ================= PENGATURAN =================
        Route::get('/pengaturan', [AdminController::class, 'pengaturan'])
            ->name('pengaturan');

        Route::post('/pengaturan', [AdminController::class, 'updatePengaturan'])
            ->name('pengaturan.update');


        // ================= PENDAFTARAN =================
        Route::prefix('pendaftaran')->name('pendaftaran.')->group(function () {

            Route::get('/', [AdminPendaftaranController::class, 'index'])->name('index');
            Route::get('/{id}', [AdminPendaftaranController::class, 'show'])->name('show');
            Route::post('/{id}/update-status', [AdminPendaftaranController::class, 'updateStatus'])->name('updateStatus');
            Route::get('/{id}/survey', [AdminPendaftaranController::class, 'survey'])->name('survey');
            Route::post('/{id}/survey', [AdminPendaftaranController::class, 'storeSurvey'])->name('storeSurvey');
        });


        // ================= PEMBINAAN =================
        Route::prefix('pembinaan')->name('pembinaan.')->group(function () {

            Route::get('/export-all', [AdminPembinaanController::class,'exportAll'])->name('exportAll');
            Route::get('/', [AdminPembinaanController::class,'index'])->name('index');
            Route::get('/{user}', [AdminPembinaanController::class,'show'])->name('show');
            Route::post('/{user}', [AdminPembinaanController::class,'store'])->name('store');
            Route::delete('/{pembinaan}', [AdminPembinaanController::class,'destroy'])->name('destroy');
            Route::get('/{user}/export', [AdminPembinaanController::class,'export'])->name('export');
        });


        // ================= ALUMNI =================
        Route::prefix('alumni')->name('alumni.')->group(function () {

            Route::get('/', [AdminAlumniController::class, 'index'])
                ->name('index');

            Route::delete('/{id}', [AdminAlumniController::class, 'destroy'])
                ->name('destroy');
        });


// ================= AKUN =================
Route::get('/akun', [AdminController::class, 'akun'])->name('akun');
Route::get('/akun/create', [AdminController::class, 'createAkun'])->name('akun.create');
Route::post('/akun/store', [AdminController::class, 'storeAkun'])->name('akun.store');
Route::delete('/akun/{id}', [AdminController::class, 'deleteAkun'])->name('akun.delete');
        // ================= VALIDASI AKUN =================
        Route::get('/validasi-akun', [AdminController::class, 'validasi'])->name('validasi.akun');
        Route::post('/validasi-akun/{id}/approve', [AdminController::class, 'approve'])->name('validasi.akun.approve');
        Route::post('/validasi-akun/{id}/reject', [AdminController::class, 'reject'])->name('validasi.akun.reject');


        // ================= VALIDASI BEASISWA =================
        Route::get('/validasi-beasiswa', [PenilaianBeasiswaController::class, 'index'])
            ->name('validasi.beasiswa');


        // ================= LOG =================
        Route::get('/log', [AdminLogController::class, 'index'])
            ->name('log');


        // ================= PROFILE =================
        Route::get('/profile', [AdminController::class, 'editProfile'])
            ->name('profile.edit');

        Route::put('/profile', [AdminController::class, 'updateProfile'])
            ->name('profile.update');

        Route::post('/kirim-reminder', [AdminController::class, 'kirimReminder'])
    ->name('kirim.reminder');
});

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {

        Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');

        Route::get('/pendaftaran', [UserDashboardController::class, 'pendaftaran'])->name('pendaftaran');
        Route::post('/pendaftaran', [UserDashboardController::class, 'storePendaftaran'])->name('pendaftaran.store');

        Route::get('/status', [UserDashboardController::class, 'status'])->name('status');

        Route::get('/pembinaan', [UserDashboardController::class, 'pembinaan'])->name('pembinaan');

       // ================= ALUMNI USER =================
Route::get('/alumni', [UserAlumniController::class, 'index'])
    ->name('alumni');

Route::post('/alumni/store', [UserAlumniController::class, 'store'])
    ->name('alumni.store');

Route::get('/alumni/{id}/edit', [UserAlumniController::class, 'edit'])
    ->name('alumni.edit');

Route::put('/alumni/{id}', [UserAlumniController::class, 'update'])
    ->name('alumni.update');

Route::delete('/alumni/{id}', [UserAlumniController::class, 'destroy'])
    ->name('alumni.destroy');

Route::get('/pernyataan', 
    [UserDashboardController::class, 'formPernyataan']
)->name('pernyataan.form');

Route::post('/pernyataan', 
    [UserDashboardController::class, 'kirimPernyataan']
)->name('pernyataan.kirim');



});