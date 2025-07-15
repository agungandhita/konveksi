@extends('admin.layouts.main')

@section('title', 'Detail Produk')

@section('container')
<div class="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Produk</h1>
            <p class="text-gray-600 mt-1">Informasi lengkap produk: {{ $produk->nama_produk }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.produk.edit', $produk) }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.produk.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times text-green-500 hover:text-green-700"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Product Detail Card -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Image -->
                <div class="space-y-4">
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                        @if($produk->foto_produk)
                            <img src="{{ $produk->foto_url }}" 
                                 alt="{{ $produk->nama_produk }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <div class="text-center">
                                    <i class="fas fa-image text-6xl mb-4"></i>
                                    <p class="text-lg">Tidak ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Status Badge -->
                    <div class="flex justify-center">
                        @if($produk->status === 'aktif')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>
                                Non-Aktif
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Product Information -->
                <div class="space-y-6">
                    <!-- Basic Info -->
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-2">{{ $produk->nama_produk }}</h2>
                        <p class="text-2xl font-semibold text-blue-600">{{ $produk->harga_formatted }}</p>
                    </div>

                    <!-- Description -->
                    @if($produk->deskripsi_singkat)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Deskripsi</h3>
                            <p class="text-gray-700 leading-relaxed">{{ $produk->deskripsi_singkat }}</p>
                        </div>
                    @endif

                    <!-- Purchase Link -->
                    @if($produk->link_pembelian)
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Link Pembelian</h3>
                            <a href="{{ $produk->link_pembelian }}" 
                               target="_blank" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200">
                                @if(str_contains($produk->link_pembelian, 'wa.me') || str_contains($produk->link_pembelian, 'whatsapp'))
                                    <i class="fab fa-whatsapp mr-2"></i>
                                    Beli via WhatsApp
                                @elseif(str_contains($produk->link_pembelian, 'tokopedia'))
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Beli di Tokopedia
                                @elseif(str_contains($produk->link_pembelian, 'shopee'))
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Beli di Shopee
                                @elseif(str_contains($produk->link_pembelian, 'bukalapak'))
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Beli di Bukalapak
                                @else
                                    <i class="fas fa-external-link-alt mr-2"></i>
                                    Beli Sekarang
                                @endif
                                <i class="fas fa-external-link-alt ml-1 text-xs"></i>
                            </a>
                        </div>
                    @endif

                    <!-- Product Details Table -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Produk</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <dl class="grid grid-cols-1 gap-4">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">ID Produk:</dt>
                                    <dd class="text-sm text-gray-900">#{{ $produk->id }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Nama Produk:</dt>
                                    <dd class="text-sm text-gray-900">{{ $produk->nama_produk }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Harga:</dt>
                                    <dd class="text-sm text-gray-900 font-semibold">{{ $produk->harga_formatted }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Status:</dt>
                                    <dd class="text-sm">
                                        @if($produk->status === 'aktif')
                                            <span class="text-green-600 font-medium">Aktif</span>
                                        @else
                                            <span class="text-red-600 font-medium">Non-Aktif</span>
                                        @endif
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Dibuat:</dt>
                                    <dd class="text-sm text-gray-900">{{ $produk->created_at->format('d M Y, H:i') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate:</dt>
                                    <dd class="text-sm text-gray-900">{{ $produk->updated_at->format('d M Y, H:i') }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Bar -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex justify-between items-center">
                <div class="flex space-x-3">
                    <!-- Toggle Status -->
                    <form method="POST" action="{{ route('admin.produk.toggle-status', $produk) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        @if($produk->status === 'aktif')
                            <button type="submit" 
                                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200"
                                    onclick="return confirm('Yakin ingin menonaktifkan produk ini?')">
                                <i class="fas fa-eye-slash mr-2"></i>Nonaktifkan
                            </button>
                        @else
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200"
                                    onclick="return confirm('Yakin ingin mengaktifkan produk ini?')">
                                <i class="fas fa-eye mr-2"></i>Aktifkan
                            </button>
                        @endif
                    </form>
                </div>

                <div class="flex space-x-3">
                    <!-- Edit Button -->
                    <a href="{{ route('admin.produk.edit', $produk) }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                        <i class="fas fa-edit mr-2"></i>Edit Produk
                    </a>
                    
                    <!-- Delete Button -->
                    <form method="POST" action="{{ route('admin.produk.destroy', $produk) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200"
                                onclick="return confirm('Yakin ingin menghapus produk ini? Data yang dihapus tidak dapat dikembalikan.')">
                            <i class="fas fa-trash mr-2"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.aspect-square {
    aspect-ratio: 1 / 1;
}
</style>
@endpush