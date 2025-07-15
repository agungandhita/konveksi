@extends('admin.layouts.main')

@section('title', 'Laporan Pembayaran')

@section('container')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-800">Laporan Pembayaran</h1>
        <p class="text-slate-600 mt-1">Kelola dan export data pembayaran</p>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Filter Laporan</h3>
        
        <form method="GET" action="{{ route('admin.laporan.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Tanggal Mulai -->
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" 
                           value="{{ request('tanggal_mulai') }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Tanggal Selesai -->
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-slate-700 mb-2">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" 
                           value="{{ request('tanggal_selesai') }}"
                           class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                
                <!-- Status Pembayaran -->
                <div>
                    <label for="status_pembayaran" class="block text-sm font-medium text-slate-700 mb-2">Status Pembayaran</label>
                    <select id="status_pembayaran" name="status_pembayaran" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status_pembayaran') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="ditinjau" {{ request('status_pembayaran') == 'ditinjau' ? 'selected' : '' }}>Ditinjau</option>
                        <option value="diterima" {{ request('status_pembayaran') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status_pembayaran') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
                
                <!-- Metode Pembayaran -->
                <div>
                    <label for="metode_pembayaran" class="block text-sm font-medium text-slate-700 mb-2">Metode Pembayaran</label>
                    <select id="metode_pembayaran" name="metode_pembayaran" 
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Metode</option>
                        <option value="DANA" {{ request('metode_pembayaran') == 'DANA' ? 'selected' : '' }}>DANA</option>
                        <option value="MANDIRI" {{ request('metode_pembayaran') == 'MANDIRI' ? 'selected' : '' }}>MANDIRI</option>
                        <option value="BCA" {{ request('metode_pembayaran') == 'BCA' ? 'selected' : '' }}>BCA</option>
                    </select>
                </div>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                    <i class="fas fa-search mr-2"></i>Filter
                </button>
                <a href="{{ route('admin.laporan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                    <i class="fas fa-refresh mr-2"></i>Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-slate-900">{{ number_format($totalPembayaran) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-credit-card text-blue-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Total Nominal</p>
                    <p class="text-2xl font-bold text-slate-900">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Pembayaran Diterima</p>
                    <p class="text-2xl font-bold text-green-600">{{ number_format($pembayaranDiterima) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600"></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-6 rounded-lg shadow-sm border border-slate-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600">Pembayaran Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">{{ number_format($pembayaranDitolak) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-times-circle text-red-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6 mb-6">
        <h3 class="text-lg font-semibold text-slate-800 mb-4">Export Laporan</h3>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.laporan.export.csv', request()->query()) }}" 
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-file-csv mr-2"></i>Export CSV
            </a>
            <a href="{{ route('admin.laporan.export.excel', request()->query()) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-file-excel mr-2"></i>Export Excel
            </a>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-800">Data Pembayaran</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Pemesan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Layanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Total Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Metode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-200">
                    @forelse($pembayaran as $item)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                            #{{ $item->id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">{{ $item->pesanan->nama_pemesan ?? '-' }}</div>
                            <div class="text-sm text-slate-500">{{ $item->pesanan->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">{{ $item->pesanan->layanan->nama_layanan ?? '-' }}</div>
                            <div class="text-sm text-slate-500">{{ $item->pesanan->jumlah_order ?? 0 }} pcs</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</div>
                            @if($item->harga_bordir > 0)
                            <div class="text-sm text-slate-500">Bordir: Rp {{ number_format($item->harga_bordir, 0, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $item->metode_pembayaran }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->status_badge }}">
                                {{ ucfirst($item->status_pembayaran) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                            <div>{{ $item->created_at->format('d/m/Y') }}</div>
                            <div>{{ $item->created_at->format('H:i') }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-4xl text-slate-300 mb-4"></i>
                                <p class="text-slate-500 text-lg font-medium">Tidak ada data pembayaran</p>
                                <p class="text-slate-400 text-sm">Data akan muncul setelah ada pembayaran yang masuk</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($pembayaran->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $pembayaran->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Auto submit form when date changes
    document.getElementById('tanggal_mulai').addEventListener('change', function() {
        if (this.value && document.getElementById('tanggal_selesai').value) {
            this.form.submit();
        }
    });
    
    document.getElementById('tanggal_selesai').addEventListener('change', function() {
        if (this.value && document.getElementById('tanggal_mulai').value) {
            this.form.submit();
        }
    });
</script>
@endpush