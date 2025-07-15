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
                    <p class="text-2xl font-bold text-slate-900">124</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-shopping-cart text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Produk</p>
                    <p class="text-2xl font-bold text-slate-900">45</p>
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
                    <p class="text-2xl font-bold text-slate-900">89</p>
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
                    <p class="text-2xl font-bold text-slate-900">Rp 2.5M</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-yellow-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="p-6 border-b border-slate-200">
            <h2 class="text-lg font-semibold text-slate-800">Pesanan Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Pelanggan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr>
                        <td class="px-6 py-4 text-sm text-slate-900">#001</td>
                        <td class="px-6 py-4 text-sm text-slate-900">John Doe</td>
                        <td class="px-6 py-4 text-sm text-slate-900">Kaos Polo</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">Proses</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-900">Rp 150.000</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-4 text-sm text-slate-900">#002</td>
                        <td class="px-6 py-4 text-sm text-slate-900">Jane Smith</td>
                        <td class="px-6 py-4 text-sm text-slate-900">Kemeja</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Selesai</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-900">Rp 200.000</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
