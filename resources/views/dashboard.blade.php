@extends('frontend.layouts.main')

@section('title', 'Dashboard')

@section('container')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
            <p class="text-gray-600 mt-2">Selamat datang, {{ auth()->user()->name }}!</p>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            <!-- Buat Pesanan Baru -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus text-blue-600"></i>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Buat Pesanan Baru</h3>
                <p class="text-gray-600 mb-4">Mulai pesanan konveksi baru dengan mudah</p>
                <a href="{{ route('katalog.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Lihat Katalog
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Riwayat Pesanan -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-history text-green-600"></i>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Riwayat Pesanan</h3>
                <p class="text-gray-600 mb-4">Lihat semua pesanan yang pernah Anda buat</p>
                <a href="{{ route('pesanan.riwayat') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                    Lihat Riwayat
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <!-- Layanan -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cogs text-purple-600"></i>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Layanan Kami</h3>
                <p class="text-gray-600 mb-4">Lihat berbagai layanan konveksi yang tersedia</p>
                <a href="{{ route('layanan.index') }}" class="inline-flex items-center px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                    Lihat Layanan
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Pesanan Terbaru</h2>
            </div>
            <div class="p-6">
                @php
                    $recentOrders = auth()->user()->pesanan()->latest()->take(5)->get();
                @endphp
                
                @if($recentOrders->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $pesanan)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-shopping-bag text-blue-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $pesanan->nama_produk }}</h4>
                                    <p class="text-sm text-gray-600">{{ $pesanan->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-medium text-gray-900">{{ $pesanan->formatted_total_harga }}</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($pesanan->status_pesanan == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($pesanan->status_pesanan == 'diproses') bg-blue-100 text-blue-800
                                    @elseif($pesanan->status_pesanan == 'selesai') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($pesanan->status_pesanan) }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-6 text-center">
                        <a href="{{ route('pesanan.riwayat') }}" class="text-blue-600 hover:text-blue-700 font-medium">
                            Lihat Semua Pesanan →
                        </a>
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-shopping-bag text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Pesanan</h3>
                        <p class="text-gray-600 mb-4">Anda belum memiliki pesanan. Mulai berbelanja sekarang!</p>
                        <a href="{{ route('katalog.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Mulai Berbelanja
                            <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection