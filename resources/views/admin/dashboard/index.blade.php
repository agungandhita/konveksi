@extends('admin.layouts.main')
@section('container')
<div class="p-6">
    <!-- Header Dashboard -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
        <p class="text-slate-600 mt-1">Selamat datang di panel admin konveksi</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Pesanan</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalPesanan }}</p>
                    <div class="flex gap-2 mt-2">
                        <span class="text-xs px-2 py-1 bg-yellow-100 text-yellow-800 rounded">Menunggu: {{ $pesananStats['menunggu'] }}</span>
                        <span class="text-xs px-2 py-1 bg-blue-100 text-blue-800 rounded">Diproses: {{ $pesananStats['diproses'] }}</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Produk & Layanan</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalProduk + $totalLayanan }}</p>
                    <div class="flex gap-2 mt-2">
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded">Produk: {{ $totalProduk }}</span>
                        <span class="text-xs px-2 py-1 bg-emerald-100 text-emerald-800 rounded">Layanan: {{ $totalLayanan }}</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-green-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Pengguna</p>
                    <p class="text-2xl font-bold text-slate-900">{{ $totalUsers }}</p>
                    <p class="text-xs text-slate-500 mt-2">Customer terdaftar</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-purple-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Pendapatan</p>
                    <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    <div class="flex gap-2 mt-2">
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-800 rounded">Diterima: {{ $pembayaranStats['diterima'] }}</span>
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-800 rounded">Ditolak: {{ $pembayaranStats['ditolak'] }}</span>
                    </div>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-yellow-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Pesanan Terbaru</h3>
            <div class="space-y-4">
                @forelse($recentPesanan as $pesanan)
                <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                    <div>
                        <p class="font-medium text-slate-900">#{{ $pesanan->id }}</p>
                        <p class="text-sm text-slate-600">{{ $pesanan->user->name }}</p>
                        <p class="text-xs text-slate-500">{{ $pesanan->layanan->nama_layanan }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-slate-900">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                        @if($pesanan->status == 'menunggu')
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Menunggu</span>
                        @elseif($pesanan->status == 'diproses')
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Diproses</span>
                        @elseif($pesanan->status == 'selesai')
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Selesai</span>
                        @else
                            <span class="inline-block px-2 py-1 text-xs font-medium bg-red-100 text-red-800 rounded-full">Dibatalkan</span>
                        @endif
                        <p class="text-xs text-slate-500 mt-1">{{ $pesanan->created_at->format('d M Y') }}</p>
                    </div>
                </div>
                @empty
                <div class="text-center py-8">
                    <p class="text-slate-500">Belum ada pesanan</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Statistik Bulanan</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Pesanan Bulan Ini</span>
                    <span class="font-medium text-slate-900">{{ $pesananBulanIni }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Pendapatan Bulan Ini</span>
                    <span class="font-medium text-slate-900">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-600">Rata-rata per Pesanan</span>
                    <span class="font-medium text-slate-900">Rp {{ number_format($rataRataPesanan, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
