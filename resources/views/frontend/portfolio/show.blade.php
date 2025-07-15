@extends('frontend.layouts.main')

@section('container')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-100 to-slate-200 py-20">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-8">
            <a href="{{ route('frontend.portfolio.index') }}" 
               class="inline-flex items-center text-slate-600 hover:text-slate-800 mb-4 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Portfolio
            </a>
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                {{ $portfolio->judul }}
            </h1>
            @if($portfolio->tanggal_proyek)
                <p class="text-xl text-gray-600">
                    Proyek {{ $portfolio->formatted_tanggal }}
                </p>
            @endif
        </div>
    </div>
</section>

<!-- Portfolio Detail -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Media Section -->
            <div class="space-y-6">
                @if($portfolio->gambar_utama)
                    <div class="aspect-w-16 aspect-h-12 rounded-2xl overflow-hidden shadow-lg">
                        <img src="{{ $portfolio->gambar_utama_url }}" 
                             alt="{{ $portfolio->judul }}" 
                             class="w-full h-96 object-cover">
                    </div>
                @endif
                
                @if($portfolio->video_url)
                    <div class="aspect-w-16 aspect-h-9 rounded-2xl overflow-hidden shadow-lg">
                        <iframe src="{{ $portfolio->youtube_embed_url }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen
                                class="w-full h-64">
                        </iframe>
                    </div>
                @endif
                
                @if($portfolio->video_file)
                    <div class="rounded-2xl overflow-hidden shadow-lg">
                        <video controls class="w-full h-auto">
                            <source src="{{ $portfolio->video_file_url }}" type="video/mp4">
                            Browser Anda tidak mendukung video.
                        </video>
                    </div>
                @endif
            </div>
            
            <!-- Content Section -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 mb-4">Detail Proyek</h2>
                    @if($portfolio->deskripsi_singkat)
                        <p class="text-gray-600 leading-relaxed text-lg">
                            {{ $portfolio->deskripsi_singkat }}
                        </p>
                    @else
                        <p class="text-gray-500 italic">
                            Deskripsi tidak tersedia.
                        </p>
                    @endif
                </div>
                
                <div class="bg-slate-50 rounded-xl p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Informasi Proyek</h3>
                    <div class="space-y-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-slate-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span class="text-gray-700">
                                <strong>Tanggal:</strong> {{ $portfolio->formatted_tanggal }}
                            </span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-slate-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">
                                <strong>Status:</strong> 
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-2">
                                    {{ ucfirst($portfolio->status) }}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection