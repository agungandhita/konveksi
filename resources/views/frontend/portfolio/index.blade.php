@extends('frontend.layouts.main')

@section('container')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-100 to-slate-200 py-20">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
            Portfolio <span class="text-slate-700">Kami</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Lihat hasil karya terbaik kami dalam bidang konveksi dan produksi seragam berkualitas
        </p>
    </div>
</section>

<!-- Portfolio Gallery -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        @if($portfolio->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($portfolio as $item)
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        @if($item->gambar_utama)
                            <div class="aspect-w-16 aspect-h-12">
                                <img src="{{ $item->gambar_utama_url }}" 
                                     alt="{{ $item->judul }}" 
                                     class="w-full h-64 object-cover">
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $item->judul }}</h3>
                            
                            @if($item->deskripsi_singkat)
                                <p class="text-gray-600 mb-4 line-clamp-3">{{ $item->deskripsi_singkat }}</p>
                            @endif
                            
                            @if($item->tanggal_proyek)
                                <span class="inline-block bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $item->tanggal_proyek->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Portfolio</h3>
                    <p class="text-gray-500">Portfolio akan segera ditampilkan di sini.</p>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection