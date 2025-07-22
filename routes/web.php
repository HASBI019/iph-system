<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\IphController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Frontend\BerandaController;

/*
|--------------------------------------------------------------------------
| 🔐 Login & Logout
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'loginSubmit']);
Route::post('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| 🛡️ Protected Routes (Middleware auth)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::prefix('admin')->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        });

        // ✅ Pengaturan tampilan publik
        Route::get('/setting', [SiteSettingController::class, 'edit'])->name('admin.setting.edit');
        Route::post('/setting', [SiteSettingController::class, 'update'])->name('admin.setting.update');
    });

    Route::prefix('admin/iph')->group(function () {
        // ✏️ Input Data IPH
        Route::get('/mingguan', [IphController::class, 'inputMingguan']);
        Route::get('/bulanan', [IphController::class, 'inputBulanan']);

        // 💾 Simpan Data
        Route::post('/save-mingguan', [IphController::class, 'saveMingguan']);
        Route::post('/save-bulanan', [IphController::class, 'saveBulanan']);

        // 👀 Lihat Data
        Route::get('/view-mingguan', [IphController::class, 'viewMingguan']);
        Route::get('/view-bulanan', [IphController::class, 'viewBulanan']);

        // ✏️ Edit Data
        Route::get('/edit-mingguan/{id}', [IphController::class, 'editMingguan'])->name('admin.iph.edit.mingguan');
        Route::post('/update-mingguan/{id}', [IphController::class, 'updateMingguan'])->name('admin.iph.update.mingguan');

        Route::get('/edit-bulanan/{id}', [IphController::class, 'editBulanan'])->name('admin.iph.edit.bulanan');
        Route::post('/update-bulanan/{id}', [IphController::class, 'updateBulanan'])->name('admin.iph.update.bulanan');

        // 🗑️ Hapus Data
        Route::get('/delete-mingguan/{id}', [IphController::class, 'deleteMingguan']);
        Route::get('/delete-bulanan/{id}', [IphController::class, 'deleteBulanan']);

        // 📤 Export
        Route::get('/export-mingguan', [ExportController::class, 'mingguan']);
        Route::get('/export-bulanan', [ExportController::class, 'bulanan']);
    });
});

/*
|--------------------------------------------------------------------------
| 🌐 Frontend Publik
|--------------------------------------------------------------------------
*/

Route::get('/', [BerandaController::class, 'index']);
