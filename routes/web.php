<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\LayananController;
use App\Http\Controllers\admin\ProdukController;
use App\Http\Controllers\admin\PortoflioController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('frontend.beranda.index');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [App\Http\Controllers\admin\DashboardController::class, 'index'])->name('admin.dashboard');

    // User Management Routes
    Route::resource('admin/users', UserController::class, [
        'names' => [
            'index' => 'admin.users.index',
            'create' => 'admin.users.create',
            'store' => 'admin.users.store',
            'show' => 'admin.users.show',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]
    ]);

    // Layanan Management Routes
    Route::resource('admin/layanan', LayananController::class, [
        'names' => [
            'index' => 'admin.layanan.index',
            'create' => 'admin.layanan.create',
            'store' => 'admin.layanan.store',
            'show' => 'admin.layanan.show',
            'edit' => 'admin.layanan.edit',
            'update' => 'admin.layanan.update',
            'destroy' => 'admin.layanan.destroy',
        ]
    ]);

    // Additional Layanan Routes
    Route::post('admin/layanan/bulk-action', [LayananController::class, 'bulkAction'])->name('admin.layanan.bulk-action');
    Route::patch('admin/layanan/{layanan}/toggle-status', [LayananController::class, 'toggleStatus'])->name('admin.layanan.toggle-status');

    // Produk Management Routes
    Route::resource('admin/produk', ProdukController::class, [
        'names' => [
            'index' => 'admin.produk.index',
            'create' => 'admin.produk.create',
            'store' => 'admin.produk.store',
            'show' => 'admin.produk.show',
            'edit' => 'admin.produk.edit',
            'update' => 'admin.produk.update',
            'destroy' => 'admin.produk.destroy',
        ]
    ]);

    // Additional Produk Routes
    Route::post('admin/produk/bulk-action', [ProdukController::class, 'bulkAction'])->name('admin.produk.bulk-action');
    Route::patch('admin/produk/{produk}/toggle-status', [ProdukController::class, 'toggleStatus'])->name('admin.produk.toggle-status');

    // Portofolio Management Routes
    Route::resource('admin/portofolio', PortoflioController::class, [
        'names' => [
            'index' => 'admin.portofolio.index',
            'create' => 'admin.portofolio.create',
            'store' => 'admin.portofolio.store',
            'show' => 'admin.portofolio.show',
            'edit' => 'admin.portofolio.edit',
            'update' => 'admin.portofolio.update',
            'destroy' => 'admin.portofolio.destroy',
        ]
    ]);

    // Additional Portofolio Routes
    Route::post('admin/portofolio/bulk-action', [PortoflioController::class, 'bulkAction'])->name('admin.portofolio.bulk-action');
    Route::get('admin/portofolio-preview', [PortoflioController::class, 'preview'])->name('admin.portofolio.preview');
});
