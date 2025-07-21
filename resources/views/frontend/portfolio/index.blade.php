@extends('frontend.layouts.main')

@section('container')
<!-- Header Section -->
<div class="bg-white py-8 border-b">
    <div class="max-w-6xl mx-auto px-4">
        <h1 class="text-3xl font-bold text-gray-900 text-center mb-2">
            Portfolio Kami
        </h1>
        <p class="text-gray-600 text-center">
            Hasil karya terbaik dalam bidang konveksi
        </p>
    </div>
</div>

<!-- Portfolio Gallery -->
<div class="max-w-6xl mx-auto px-4 py-8">
    @if($portfolio->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($portfolio as $item)
                <div class="bg-white border rounded-lg shadow hover:shadow-md transition-shadow">
                    <a href="{{ route('frontend.portfolio.show', $item->id) }}" class="block">
                        <div class="h-48 bg-gray-100 rounded-t-lg flex items-center justify-center">
                            @if($item->gambar_utama)
                                <img src="{{ $item->gambar_utama_url }}" 
                                     alt="{{ $item->judul }}" 
                                     class="w-full h-full object-cover rounded-t-lg">
                            @else
                                <div class="text-gray-400 text-center">
                                    <svg class="w-16 h-16 mx-auto mb-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/>
                                    </svg>
                                    <p class="text-sm">Foto Portfolio</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 hover:text-blue-600">{{ $item->judul }}</h3>
                            
                            @if($item->deskripsi_singkat)
                                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($item->deskripsi_singkat, 80) }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between">
                                @if($item->tanggal_proyek)
                                    <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs">
                                        {{ $item->tanggal_proyek->format('d M Y') }}
                                    </span>
                                @endif
                                
                                <span class="text-blue-600 text-sm font-medium">
                                    Lihat Detail →
                                </span>
                            </div>
                        </div>
                        </a>
                    </div>
                @endforeach
            </div>
    @else
        <div class="text-center py-12">
            <div class="text-gray-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Portfolio</h3>
            <p class="text-gray-600">Portfolio akan segera ditampilkan.</p>
        </div>
    @endif
</div>
@endsection