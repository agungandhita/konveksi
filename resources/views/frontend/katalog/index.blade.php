@extends('frontend.layouts.main')

@section('container')
<!-- Header Section -->
<div class="bg-white py-8 border-b">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 text-center mb-2">
            Katalog Produk
        </h1>
        <p class="text-gray-600 text-center">
            Produk berkualitas untuk kebutuhan konveksi Anda
        </p>
    </div>
</div>

<!-- Products Section -->
<div class="max-w-6xl mx-auto px-4 py-8">
    @if($produk->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($produk as $item)
            <div class="bg-white border rounded-lg shadow hover:shadow-md transition-shadow">
                <!-- Product Image -->
                <div class="h-48 bg-gray-100 rounded-t-lg flex items-center justify-center">
                    @if($item->foto_produk)
                        <img src="{{ $item->foto_url }}"
                             alt="{{ $item->nama_produk }}"
                             class="w-full h-full object-cover rounded-t-lg">
                    @else
                        <div class="text-gray-400 text-center">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                            </svg>
                            <p class="text-sm">Foto Produk</p>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        <a href="{{ route('katalog.show', $item->id) }}" class="hover:text-blue-600">
                            {{ $item->nama_produk }}
                        </a>
                    </h3>

                    <div class="text-xl font-bold text-red-600 mb-2">
                        {{ $item->formatted_harga }}
                    </div>

                    @if($item->deskripsi_singkat)
                        <p class="text-gray-600 text-sm mb-3">
                            {{ Str::limit($item->deskripsi_singkat, 80) }}
                        </p>
                    @endif

                    <!-- Action Buttons -->
                    <div class="flex gap-2">
                        @if($item->link_pembelian)
                            <a href="{{ $item->link_pembelian }}" target="_blank" 
                               class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm py-2 px-3 rounded text-center">
                                Beli
                            </a>
                        @else
                            <a href="https://wa.me/6281234567890?text=Halo, saya tertarik dengan produk {{ urlencode($item->nama_produk) }}" target="_blank" 
                               class="flex-1 bg-green-600 hover:bg-green-700 text-white text-sm py-2 px-3 rounded text-center">
                                WhatsApp
                            </a>
                        @endif
                        <a href="{{ route('katalog.show', $item->id) }}" 
                           class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm py-2 px-3 rounded text-center">
                            Detail
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Produk</h3>
            <p class="text-gray-600">Produk akan segera hadir.</p>
        </div>
    @endif
</div>
@endsection
