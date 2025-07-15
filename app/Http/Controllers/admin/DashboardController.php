<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Pembayaran;
use App\Models\Layanan;
use App\Models\Produk;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard
        $totalPesanan = Pesanan::count();
        $totalProduk = Produk::count();
        $totalLayanan = Layanan::count();
        $totalUsers = User::where('role', 'user')->count();
        
        // Get total pendapatan from pembayaran yang diterima
        $totalPendapatan = Pembayaran::where('status_pembayaran', 'diterima')
            ->sum('total_harga');
        
        // Get pesanan terbaru dengan relasi
        $recentPesanan = Pesanan::with(['user', 'layanan', 'pembayaran'])
            ->latest()
            ->take(5)
            ->get();
        
        // Get monthly pesanan data for chart
        $monthlyPesanan = Pesanan::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();
        
        // Get pembayaran statistics
        $pembayaranStats = [
            'menunggu' => Pembayaran::where('status_pembayaran', 'menunggu')->count(),
            'ditinjau' => Pembayaran::where('status_pembayaran', 'ditinjau')->count(),
            'diterima' => Pembayaran::where('status_pembayaran', 'diterima')->count(),
            'ditolak' => Pembayaran::where('status_pembayaran', 'ditolak')->count(),
        ];
        
        // Get pesanan statistics
        $pesananStats = [
            'menunggu' => Pesanan::where('status', 'menunggu')->count(),
            'diproses' => Pesanan::where('status', 'diproses')->count(),
            'selesai' => Pesanan::where('status', 'selesai')->count(),
            'dibatalkan' => Pesanan::where('status', 'dibatalkan')->count(),
        ];

        // Monthly statistics
        $pesananBulanIni = Pesanan::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->count();

        $pendapatanBulanIni = Pembayaran::where('status_pembayaran', 'diterima')
            ->whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_harga'); // Changed from 'nominal' to 'total_harga'

        $rataRataPesanan = $totalPesanan > 0 ? $totalPendapatan / $totalPesanan : 0;

        return view('admin.dashboard.index', compact(
            'totalPesanan',
            'totalProduk',
            'totalLayanan',
            'totalUsers',
            'totalPendapatan',
            'recentPesanan',
            'monthlyPesanan',
            'pembayaranStats',
            'pesananStats',
            'pesananBulanIni',
            'pendapatanBulanIni',
            'rataRataPesanan'
        ));
    }
}
