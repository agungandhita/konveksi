@extends('admin.layouts.main')

@section('title', 'Detail Layanan')

@section('container')
<div class="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Layanan</h1>
            <p class="text-gray-600 mt-1">{{ $layanan->nama_layanan }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.layanan.edit', $layanan) }}"
               class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-md transition duration-200 flex items-center">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.layanan.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Informasi Layanan</h3>
                @if($layanan->status === 'aktif')
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <span class="w-2 h-2 bg-green-400 rounded-full mr-2"></span>
                        Aktif
                    </span>
                @else
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                        <span class="w-2 h-2 bg-gray-400 rounded-full mr-2"></span>
                        Non-Aktif
                    </span>
                @endif
            </div>
        </div>

        <div class="px-6 py-6">
            <!-- Nama dan Deskripsi -->
            <div class="mb-6">
                <h4 class="text-xl font-semibold text-gray-900 mb-2">{{ $layanan->nama_layanan }}</h4>
                @if($layanan->deskripsi_singkat)
                    <p class="text-gray-700">{{ $layanan->deskripsi_singkat }}</p>
                @else
                    <p class="text-gray-500 italic">Tidak ada deskripsi</p>
                @endif
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Estimasi Waktu -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-clock text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800">Estimasi Waktu</p>
                            <p class="text-lg font-semibold text-blue-900">{{ $layanan->formatted_estimasi }}</p>
                        </div>
                    </div>
                </div>

                <!-- Minimal Order -->
                <div class="bg-yellow-50 p-4 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-shopping-cart text-yellow-600 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-yellow-800">Minimal Order</p>
                            <p class="text-lg font-semibold text-yellow-900">{{ $layanan->formatted_minimal_order }}</p>
                        </div>
                    </div>
                </div>

                <!-- Perkiraan Harga -->
                <div class="bg-green-50 p-4 rounded-lg md:col-span-2">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <i class="fas fa-money-bill-wave text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">Perkiraan Harga</p>
                            @if($layanan->perkiraan_harga)
                                <p class="text-lg font-semibold text-green-900">{{ $layanan->formatted_harga }}</p>
                            @else
                                <p class="text-gray-600 italic">Harga berdasarkan konsultasi</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Harga per Ukuran -->
            @if($layanan->hargaUkuran->count() > 0)
            <div class="mt-6">
                <h5 class="text-lg font-medium text-gray-900 mb-4">Harga per Ukuran</h5>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($layanan->hargaUkuran as $hargaUkuran)
                    <div class="bg-gray-50 p-3 rounded-lg text-center">
                        <p class="text-sm font-medium text-gray-600">{{ $hargaUkuran->ukuran }}</p>
                        <p class="text-lg font-semibold text-gray-900">{{ $hargaUkuran->formatted_harga }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Informasi Tambahan -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <p class="font-medium text-gray-600">ID Layanan</p>
                        <p class="text-gray-900">#{{ str_pad($layanan->id, 4, '0', STR_PAD_LEFT) }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-600">Satuan Order</p>
                        <p class="text-gray-900">{{ ucfirst($layanan->satuan_order) }}</p>
                    </div>
                    <div>
                        <p class="font-medium text-gray-600">Dibuat</p>
                        <p class="text-gray-900">{{ $layanan->created_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex flex-col sm:flex-row gap-3">
        <a href="{{ route('admin.layanan.edit', $layanan) }}"
           class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-3 rounded-md transition duration-200 flex items-center justify-center">
            <i class="fas fa-edit mr-2"></i>Edit Layanan
        </a>

        <form method="POST" action="{{ route('admin.layanan.toggle-status', $layanan) }}" class="flex-1">
            @csrf
            @method('PATCH')
            <button type="submit"
                    class="w-full {{ $layanan->status === 'aktif' ? 'bg-orange-600 hover:bg-orange-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-3 rounded-md transition duration-200 flex items-center justify-center">
                <i class="fas fa-{{ $layanan->status === 'aktif' ? 'pause' : 'play' }} mr-2"></i>
                {{ $layanan->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
            </button>
        </form>

        <button type="button"
                onclick="if(confirm('Apakah Anda yakin ingin menghapus layanan ini?')) { document.getElementById('delete-form').submit(); }"
                class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-md transition duration-200 flex items-center justify-center">
            <i class="fas fa-trash mr-2"></i>Hapus Layanan
        </button>

        <form id="delete-form" method="POST" action="{{ route('admin.layanan.destroy', $layanan) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</div>
@endsection
