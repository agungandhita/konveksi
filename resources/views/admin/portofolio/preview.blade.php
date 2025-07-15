@extends('admin.layouts.main')

@section('title', 'Preview Galeri Portofolio')

@section('container')
<div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Preview Galeri Portofolio</h1>
            <p class="text-gray-600 mt-1">Tampilan galeri seperti yang akan dilihat pengunjung website</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.portofolio.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-plus mr-2"></i>Tambah Portofolio
            </a>
            <a href="{{ route('admin.portofolio.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Admin
            </a>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.portofolio.preview') }}" class="flex flex-wrap gap-4 items-end">
                <!-- Search -->
                <div class="flex-1 min-w-64">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Portofolio</label>
                    <input type="text" name="search" id="search" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ request('search') }}" placeholder="Cari berdasarkan judul atau deskripsi...">
                </div>
                
                <!-- Date Range -->
                <div>
                    <label for="date_from" class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" id="date_from" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ request('date_from') }}">
                </div>
                
                <div>
                    <label for="date_to" class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="date_to" id="date_to" 
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           value="{{ request('date_to') }}">
                </div>
                
                <!-- Actions -->
                <div class="flex space-x-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-search mr-1"></i>Filter
                    </button>
                    <a href="{{ route('admin.portofolio.preview') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg transition duration-200">
                        <i class="fas fa-times mr-1"></i>Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Gallery Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-images text-blue-500 text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Portofolio</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $portfolios->total() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-eye text-green-500 text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Aktif</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $portfolios->where('status', 'aktif')->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-video text-red-500 text-2xl"></i>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Dengan Video</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $portfolios->filter(function($p) { return $p->video_url || $p->video_file; })->count() }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        

    </div>

    @if($portfolios->count() > 0)
        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @foreach($portfolios as $portfolio)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                <!-- Media Section -->
                <div class="relative">
                    @if($portfolio->gambar_utama)
                        <img src="{{ $portfolio->gambar_utama_url }}" alt="{{ $portfolio->judul }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-4xl"></i>
                        </div>
                    @endif
                    
                    <!-- Media Indicators -->
                    <div class="absolute top-2 right-2 flex space-x-1">
                        @if($portfolio->video_url)
                            <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs flex items-center">
                                <i class="fab fa-youtube mr-1"></i>YouTube
                            </span>
                        @elseif($portfolio->video_file)
                            <span class="bg-blue-500 text-white px-2 py-1 rounded-full text-xs flex items-center">
                                <i class="fas fa-video mr-1"></i>Video
                            </span>
                        @endif
                        

                    </div>
                    
                    <!-- Status Badge -->
                    <div class="absolute top-2 left-2">
                        @if($portfolio->status === 'aktif')
                            <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs flex items-center">
                                <i class="fas fa-eye mr-1"></i>Aktif
                            </span>
                        @else
                            <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs flex items-center">
                                <i class="fas fa-eye-slash mr-1"></i>Non-Aktif
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Content -->
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $portfolio->judul }}</h3>
                    
                    @if($portfolio->deskripsi_singkat)
                        <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($portfolio->deskripsi_singkat, 100) }}</p>
                    @endif
                    
                    <div class="flex items-center justify-between text-sm text-gray-500 mb-3">
                        <span class="flex items-center">
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $portfolio->formatted_date }}
                        </span>
                    </div>
                    

                    
                    <!-- Actions -->
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.portofolio.show', $portfolio->id) }}" 
                           class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded text-center text-sm transition duration-200">
                            <i class="fas fa-eye mr-1"></i>Lihat Detail
                        </a>
                        <a href="{{ route('admin.portofolio.edit', $portfolio->id) }}" 
                           class="flex-1 bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded text-center text-sm transition duration-200">
                            <i class="fas fa-edit mr-1"></i>Edit
                        </a>
                    </div>
                </div>
                
                <!-- Video Section (if exists) -->
                @if($portfolio->video_url || $portfolio->video_file)
                    <div class="border-t border-gray-200 p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-2">Video</h4>
                        @if($portfolio->video_url)
                            <div class="aspect-w-16 aspect-h-9">
                                <iframe src="{{ $portfolio->youtube_embed_url }}" 
                                        frameborder="0" 
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                        allowfullscreen
                                        class="w-full h-32 rounded">
                                </iframe>
                            </div>
                        @elseif($portfolio->video_file)
                            <video controls class="w-full h-32 rounded">
                                <source src="{{ $portfolio->video_file_url }}" type="video/mp4">
                                Browser Anda tidak mendukung tag video.
                            </video>
                        @endif
                    </div>
                @endif
            </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="flex justify-center">
            {{ $portfolios->appends(request()->query())->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-images text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Portofolio</h3>
            <p class="text-gray-600 mb-6">Mulai tambahkan hasil pekerjaan Anda ke galeri portofolio.</p>
            <a href="{{ route('admin.portofolio.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg inline-flex items-center transition duration-200">
                <i class="fas fa-plus mr-2"></i>Tambah Portofolio Pertama
            </a>
        </div>
    @endif
</div>

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.aspect-w-16 {
    position: relative;
    padding-bottom: 56.25%; /* 16:9 aspect ratio */
}

.aspect-w-16 iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}
</style>
@endpush
@endsection