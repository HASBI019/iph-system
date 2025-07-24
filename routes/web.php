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
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| 🛡️ Protected Routes (Middleware auth)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // 🔧 Admin Dashboard & Settings
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('admin.dashboard');

        // ⚙️ Pengaturan Publik
        Route::get('/setting', [SiteSettingController::class, 'edit'])->name('admin.setting.edit');
        Route::post('/setting', [SiteSettingController::class, 'update'])->name('admin.setting.update');
    });

    // 📊 IPH System Routes
    Route::prefix('admin/iph')->group(function () {

        // 📝 Input Form
        Route::get('/mingguan', [IphController::class, 'inputMingguan'])->name('iph-mingguan.input');
        Route::get('/bulanan', [IphController::class, 'inputBulanan'])->name('iph-bulanan.input');

        // 💾 Simpan Data
        Route::post('/save-mingguan', [IphController::class, 'saveMingguan'])->name('iph-mingguan.store');
        Route::post('/save-bulanan', [IphController::class, 'saveBulanan'])->name('iph-bulanan.store');

        // 👁️‍🗨️ Lihat Data
        Route::get('/view-mingguan', [IphController::class, 'viewMingguan'])->name('iph-mingguan.index');
        Route::get('/view-bulanan', [IphController::class, 'viewBulanan'])->name('iph-bulanan.index');

        // ✏️ Edit Data
        Route::get('/edit-mingguan/{id}', [IphController::class, 'editMingguan'])->name('iph-mingguan.edit');
        Route::post('/update-mingguan/{id}', [IphController::class, 'updateMingguan'])->name('iph-mingguan.update');

        Route::get('/edit-bulanan/{id}', [IphController::class, 'editBulanan'])->name('iph-bulanan.edit');
        Route::post('/update-bulanan/{id}', [IphController::class, 'updateBulanan'])->name('iph-bulanan.update');

        // 🗑️ Hapus Data
        Route::get('/delete-mingguan/{id}', [IphController::class, 'deleteMingguan'])->name('iph-mingguan.delete');
        Route::get('/delete-bulanan/{id}', [IphController::class, 'deleteBulanan'])->name('iph-bulanan.delete');

        // 📤 Export Data
        Route::get('/export-mingguan', [ExportController::class, 'mingguan'])->name('iph-mingguan.export');
        Route::get('/export-bulanan', [ExportController::class, 'bulanan'])->name('iph-bulanan.export');
    });
});

/*
|--------------------------------------------------------------------------
| 🌐 Frontend Publik
|--------------------------------------------------------------------------
*/
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/iph', [IphController::class, 'beranda'])->name('iph.beranda');
