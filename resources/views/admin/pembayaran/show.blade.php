@extends('admin.layouts.main')

@section('title', 'Detail Pembayaran')

@section('container')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Detail Pembayaran</h1>
    </div>
    
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <i class="fas fa-home mr-2"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <a href="{{ route('admin.pembayaran.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Pembayaran</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail #{{ $pembayaran->id }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Order Information -->
        <div>
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-shopping-cart mr-2"></i>
                        Informasi Pesanan
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">ID Pesanan:</span>
                            <span class="text-gray-900">#{{ str_pad($pembayaran->pesanan_id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Layanan:</span>
                            <span class="text-gray-900">{{ $pembayaran->pesanan->layanan->nama_layanan }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Customer:</span>
                            <div class="text-right">
                                <div class="text-gray-900">{{ $pembayaran->pesanan->nama_pemesan }}</div>
                                <div class="text-sm text-gray-500">{{ $pembayaran->pesanan->user->email }}</div>
                            </div>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Jumlah Order:</span>
                            <span class="text-gray-900">{{ $pembayaran->pesanan->jumlah_order }} pcs</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Ukuran:</span>
                            <span class="text-gray-900">
                                {{ $pembayaran->pesanan->ukuran_baju }}
                                @if($pembayaran->pesanan->ukuran_baju === 'Custom' && $pembayaran->pesanan->ukuran_custom)
                                    ({{ $pembayaran->pesanan->ukuran_custom }})
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Tambahan Bordir:</span>
                            <span>
                                @if($pembayaran->pesanan->tambahan_bordir)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Ya</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Tidak</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Status Pesanan:</span>
                            <span>
                                @php
                                    $badgeClass = match($pembayaran->pesanan->status) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'menunggu_pembayaran' => 'bg-blue-100 text-blue-800',
                                        'menunggu_verifikasi' => 'bg-indigo-100 text-indigo-800',
                                        'diproses' => 'bg-green-100 text-green-800',
                                        'selesai' => 'bg-gray-100 text-gray-800',
                                        'dibatalkan' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">{{ ucfirst(str_replace('_', ' ', $pembayaran->pesanan->status)) }}</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div>
            <div class="bg-white shadow rounded-lg mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-credit-card mr-2"></i>
                        Informasi Pembayaran
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Total Pembayaran:</span>
                            <span class="text-xl font-semibold text-blue-600">{{ $pembayaran->formatted_total_harga }}</span>
                        </div>
                        @if($pembayaran->harga_bordir > 0)
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Harga Bordir:</span>
                            <span class="text-gray-900">{{ $pembayaran->formatted_harga_bordir }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Metode Pembayaran:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $pembayaran->metode_pembayaran }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Status Pembayaran:</span>
                            <span>
                                @php
                                    $badgeClass = match($pembayaran->status_pembayaran) {
                                        'menunggu' => 'bg-gray-100 text-gray-800',
                                        'ditinjau' => 'bg-yellow-100 text-yellow-800',
                                        'diterima' => 'bg-green-100 text-green-800',
                                        'ditolak' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badgeClass }}">{{ ucfirst($pembayaran->status_pembayaran) }}</span>
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Tanggal Upload:</span>
                            <span class="text-gray-900">{{ $pembayaran->tanggal_upload ? $pembayaran->tanggal_upload->format('d/m/Y H:i:s') : '-' }}</span>
                        </div>
                        @if($pembayaran->tanggal_verifikasi)
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Tanggal Verifikasi:</span>
                            <span class="text-gray-900">{{ $pembayaran->tanggal_verifikasi->format('d/m/Y H:i:s') }}</span>
                        </div>
                        @endif
                        @if($pembayaran->catatan_admin)
                        <div>
                            <span class="font-medium text-gray-700 block mb-2">Catatan Admin:</span>
                            <div class="bg-blue-50 border border-blue-200 rounded-md p-3">
                                <p class="text-blue-800 text-sm">{{ $pembayaran->catatan_admin }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bank Information -->
    @php
        $bankInfo = App\Models\Pembayaran::getBankInfo($pembayaran->metode_pembayaran);
    @endphp
    @if($bankInfo)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div>
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-university mr-2"></i>
                        Informasi Bank
                    </h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Bank:</span>
                            <span class="text-gray-900">{{ $bankInfo['nama'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Nomor Rekening:</span>
                            <span class="font-mono text-gray-900 bg-gray-100 px-2 py-1 rounded">{{ $bankInfo['nomor'] }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Atas Nama:</span>
                            <span class="text-gray-900">{{ $bankInfo['atas_nama'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Payment Proof -->
    <div class="mb-6">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-file-image mr-2"></i>
                    Bukti Pembayaran
                </h3>
                <a href="{{ route('admin.pembayaran.download-bukti', $pembayaran->id) }}"
                   class="inline-flex items-center px-3 py-2 border border-blue-300 text-sm leading-4 font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-download mr-2"></i> Download
                </a>
            </div>
            <div class="px-6 py-4 text-center">
                    @if($pembayaran->bukti_pembayaran)
                        @php
                            $fileExtension = pathinfo($pembayaran->bukti_pembayaran, PATHINFO_EXTENSION);
                            $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']);
                        @endphp

                        @if($isImage)
                            <img src="{{ Storage::url($pembayaran->bukti_pembayaran) }}"
                                 alt="Bukti Pembayaran"
                                 class="max-w-full h-auto max-h-96 border border-gray-300 rounded-lg shadow-sm">
                        @else
                            <div class="py-12">
                                <i class="fas fa-file-pdf text-6xl text-red-500 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">File PDF</h3>
                                <p class="text-gray-500">Klik tombol download untuk melihat bukti pembayaran</p>
                            </div>
                        @endif
                    @else
                        <div class="py-12">
                            <i class="fas fa-file-image text-6xl text-gray-400 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-500 mb-2">Tidak ada bukti pembayaran</h3>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    <!-- Verification Section -->
    @if($pembayaran->status_pembayaran === 'ditinjau')
    <div class="mb-6">
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    <i class="fas fa-check-circle mr-2"></i>
                    Verifikasi Pembayaran
                </h3>
            </div>
            <div class="px-6 py-4">
                <form method="POST" action="{{ route('admin.pembayaran.verifikasi', $pembayaran->id) }}">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Verifikasi</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="status" name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="diterima">Terima Pembayaran</option>
                                <option value="ditolak">Tolak Pembayaran</option>
                            </select>
                        </div>
                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="catatan" name="catatan" rows="3"
                                      placeholder="Berikan catatan jika diperlukan..."></textarea>
                        </div>
                    </div>

                    <div class="flex space-x-3 mt-6">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-save mr-2"></i> Simpan Verifikasi
                        </button>
                        <a href="{{ route('admin.pembayaran.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @else
    <div class="mb-6">
        <div class="flex space-x-3">
            <a href="{{ route('admin.pembayaran.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Pembayaran
            </a>
            <a href="{{ route('admin.pesanan.show', $pembayaran->pesanan_id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-blue-300 rounded-md font-semibold text-xs text-blue-700 uppercase tracking-widest hover:bg-blue-50 active:bg-blue-100 focus:outline-none focus:border-blue-500 focus:ring ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150">
                <i class="fas fa-eye mr-2"></i> Lihat Detail Pesanan
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
