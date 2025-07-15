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
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 group cursor-pointer">
                        <a href="{{ route('frontend.portfolio.show', $item->id) }}" class="block">
                            @if($item->gambar_utama)
                                <div class="aspect-w-16 aspect-h-12 relative overflow-hidden">
                                    <img src="{{ $item->gambar_utama_url }}" 
                                         alt="{{ $item->judul }}" 
                                         class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-slate-700 transition-colors">{{ $item->judul }}</h3>
                                
                                @if($item->deskripsi_singkat)
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ Str::limit($item->deskripsi_singkat, 120) }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    @if($item->tanggal_proyek)
                                        <span class="inline-block bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm font-medium">
                                            {{ $item->tanggal_proyek->format('d M Y') }}
                                        </span>
                                    @endif
                                    
                                    <span class="text-slate-600 group-hover:text-slate-800 font-medium text-sm transition-colors flex items-center">
                                        Lihat Detail
                                        <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </a>
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