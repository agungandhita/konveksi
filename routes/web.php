<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\LayananController;
use App\Http\Controllers\admin\ProdukController;
use App\Http\Controllers\admin\PortoflioController;
use App\Http\Controllers\admin\PesananController as AdminPesananController;
use App\Http\Controllers\frontend\KatalogController;
use App\Http\Controllers\frontend\LayananController as FrontendLayananController;
use App\Http\Controllers\frontend\PortfolioController as FrontendPortfolioController;
use App\Http\Controllers\frontend\AboutController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\PesananController;

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
})->name('home');

// Frontend Routes
Route::get('/layanan', [FrontendLayananController::class, 'index'])->name('layanan.index');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{id}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/portfolio', [FrontendPortfolioController::class, 'index'])->name('portfolio.index');
Route::get('/tentang-kami', [AboutController::class, 'index'])->name('about.index');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');

// Pesanan Routes (Protected)
Route::middleware('auth')->group(function () {
    Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
    Route::post('/pesanan', [PesananController::class, 'store'])->name('pesanan.store');
    Route::get('/pesanan/success/{id}', [PesananController::class, 'success'])->name('pesanan.success');
    Route::get('/pesanan/riwayat', [PesananController::class, 'riwayat'])->name('pesanan.riwayat');
    Route::get('/pesanan/{id}', [PesananController::class, 'show'])->name('pesanan.show');

    // Payment Routes
    Route::get('/pembayaran/{pesanan}', [App\Http\Controllers\frontend\PembayaranController::class, 'index'])->name('pembayaran.index');
    Route::post('/pembayaran/{pesanan}', [App\Http\Controllers\frontend\PembayaranController::class, 'store'])->name('pembayaran.store');
    Route::get('/pembayaran/{pesanan}/upload-ulang', [App\Http\Controllers\frontend\PembayaranController::class, 'uploadUlang'])->name('pembayaran.upload-ulang');
    Route::put('/pembayaran/{pesanan}/update-bukti', [App\Http\Controllers\frontend\PembayaranController::class, 'updateBukti'])->name('pembayaran.update-bukti');

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

    // Pesanan Management Routes
    Route::resource('admin/pesanan', AdminPesananController::class, [
        'names' => [
            'index' => 'admin.pesanan.index',
            'show' => 'admin.pesanan.show',
            'destroy' => 'admin.pesanan.destroy',
        ],
        'only' => ['index', 'show', 'destroy']
    ]);

    // Additional Pesanan Routes
    Route::post('admin/pesanan/bulk-action', [AdminPesananController::class, 'bulkAction'])->name('admin.pesanan.bulk-action');
    Route::patch('admin/pesanan/{pesanan}/update-status', [AdminPesananController::class, 'updateStatus'])->name('admin.pesanan.update-status');
    Route::get('admin/pesanan/{pesanan}/download/{type}', [AdminPesananController::class, 'downloadFile'])->name('admin.pesanan.download-file');

    // Pembayaran Management Routes
    Route::resource('admin/pembayaran', App\Http\Controllers\Admin\PembayaranController::class, [
        'names' => [
            'index' => 'admin.pembayaran.index',
            'show' => 'admin.pembayaran.show',
        ],
        'only' => ['index', 'show']
    ]);

    // Additional Pembayaran Routes
    Route::post('admin/pembayaran/bulk-action', [App\Http\Controllers\Admin\PembayaranController::class, 'bulkAction'])->name('admin.pembayaran.bulk-action');
    Route::patch('admin/pembayaran/{pembayaran}/verifikasi', [App\Http\Controllers\Admin\PembayaranController::class, 'verifikasi'])->name('admin.pembayaran.verifikasi');
    Route::get('admin/pembayaran/{pembayaran}/download-bukti', [App\Http\Controllers\Admin\PembayaranController::class, 'downloadBukti'])->name('admin.pembayaran.download-bukti');
    Route::get('admin/pembayaran/statistics', [App\Http\Controllers\Admin\PembayaranController::class, 'statistics'])->name('admin.pembayaran.statistics');
    Route::get('admin/pesanan/export', [AdminPesananController::class, 'export'])->name('admin.pesanan.export');
    Route::get('admin/pesanan/statistics', [AdminPesananController::class, 'statistics'])->name('admin.pesanan.statistics');


});
