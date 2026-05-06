<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UmkmController;

// HOME
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.alias');

// LOGIN
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// REGISTER
Route::get('/register', function () {
    return redirect('/login');
});

// LOGOUT
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// DASHBOARD ADMIN
Route::middleware(['admin'])->group(function () {
    Route::get('/admin/dashboard', [UmkmController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/admin/data-umkm', [UmkmController::class, 'index'])->name('admin.data.umkm');
    Route::get('/admin/peta-umkm', [UmkmController::class, 'adminMap'])->name('admin.map.umkm');
});

// PETA UMKM
Route::get('/peta-umkm', [UmkmController::class, 'map'])->name('map.umkm');

// KATALOG
Route::get('/katalog-umkm', function () {
    return view('katalog');
})->name('katalog.umkm');

// DASHBOARD POTENSI
Route::get('/dashboard-potensi', [UmkmController::class, 'dashboardPotensi'])->name('dashboard.potensi');
Route::get('/dashboard-potensi/pdf', [UmkmController::class, 'exportDashboardPdf'])
    ->name('dashboard.potensi.pdf');

Route::get('/dashboard-potensi/excel', [UmkmController::class, 'export'])
    ->name('dashboard.potensi.excel');

// DATA UMKM
Route::get('/admin/data-umkm', [UmkmController::class, 'index'])->name('admin.data.umkm');
Route::get('/admin/data-umkm/create', [UmkmController::class, 'create'])->name('umkm.create');
Route::get('/admin/data-umkm/{id}/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
Route::put('/admin/data-umkm/{id}', [UmkmController::class, 'update'])->name('umkm.update');
Route::delete('/admin/data-umkm/{id}', [UmkmController::class, 'destroy'])->name('umkm.destroy');
Route::post('/admin/data-umkm', [UmkmController::class, 'store'])->name('umkm.store');
Route::post('/admin/data-umkm/import', [UmkmController::class, 'import'])->name('umkm.import');
Route::get('/admin/data-umkm/export', [UmkmController::class, 'export'])
    ->name('umkm.export');
