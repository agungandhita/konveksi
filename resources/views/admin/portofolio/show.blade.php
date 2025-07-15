@extends('admin.layouts.main')

@section('title', 'Detail Portofolio')

@section('container')
<div class="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Detail Portofolio</h1>
            <p class="text-gray-600 mt-1">{{ $portofolio->judul }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.portofolio.edit', $portofolio->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
            <a href="{{ route('admin.portofolio.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Media Section -->
        <div class="lg:col-span-2">
            <!-- Image -->
            @if($portofolio->gambar_utama)
            <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Gambar Utama</h3>
                </div>
                <div class="px-4 pb-4">
                    <img src="{{ $portofolio->gambar_utama_url }}" alt="{{ $portofolio->judul }}" class="w-full h-auto rounded-lg shadow-sm">
                </div>
            </div>
            @endif

            <!-- Video Section -->
            @if($portofolio->video_url || $portofolio->video_file)
            <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                <div class="p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Video</h3>
                </div>
                <div class="px-4 pb-4">
                    @if($portofolio->video_url)
                        <!-- YouTube Video -->
                        <div class="aspect-w-16 aspect-h-9">
                            <iframe src="{{ $portofolio->youtube_embed_url }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen
                                    class="w-full h-64 rounded-lg">
                            </iframe>
                        </div>
                        <p class="mt-2 text-sm text-gray-600">
                            <i class="fab fa-youtube text-red-500 mr-1"></i>
                            <a href="{{ $portofolio->video_url }}" target="_blank" class="text-blue-600 hover:text-blue-800">Lihat di YouTube</a>
                        </p>
                    @elseif($portofolio->video_file)
                        <!-- Video File -->
                        <video controls class="w-full h-auto rounded-lg shadow-sm">
                            <source src="{{ $portofolio->video_file_url }}" type="video/mp4">
                            Browser Anda tidak mendukung tag video.
                        </video>
                        <p class="mt-2 text-sm text-gray-600">
                            <i class="fas fa-file-video text-blue-500 mr-1"></i>
                            File: {{ basename($portofolio->video_file) }}
                        </p>
                    @endif
                </div>
            </div>
            @endif

            <!-- Description -->
            @if($portofolio->deskripsi_singkat)
            <div class="bg-white shadow rounded-lg overflow-hidden mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-3">Deskripsi</h3>
                    <div class="prose max-w-none">
                        <p class="text-gray-700 leading-relaxed">{{ $portofolio->deskripsi_singkat }}</p>
                    </div>
                </div>
            </div>
            @endif


        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Project Info -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Proyek</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Judul</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $portofolio->judul }}</dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal Proyek</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <i class="fas fa-calendar mr-1 text-gray-400"></i>
                                {{ $portofolio->formatted_date }}
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1">
                                @if($portofolio->status === 'aktif')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="fas fa-eye mr-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fas fa-eye-slash mr-1"></i>Non-Aktif
                                    </span>
                                @endif
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <i class="fas fa-clock mr-1 text-gray-400"></i>
                                {{ $portofolio->created_at->format('d M Y, H:i') }}
                            </dd>
                        </div>
                        
                        @if($portofolio->updated_at != $portofolio->created_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Terakhir Diupdate</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <i class="fas fa-edit mr-1 text-gray-400"></i>
                                {{ $portofolio->updated_at->format('d M Y, H:i') }}
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Media Info -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Media</h3>
                    <div class="space-y-3">
                        <!-- Image Info -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Gambar</span>
                            @if($portofolio->gambar_utama)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check mr-1"></i>Ada
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-times mr-1"></i>Tidak Ada
                                </span>
                            @endif
                        </div>
                        
                        <!-- Video Info -->
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Video</span>
                            @if($portofolio->has_media)
                                @if($portofolio->video_url)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        <i class="fab fa-youtube mr-1"></i>YouTube
                                    </span>
                                @elseif($portofolio->video_file)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="fas fa-file-video mr-1"></i>File
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-times mr-1"></i>Tidak Ada
                                </span>
                            @endif
                        </div>
                        

                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Aksi</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.portofolio.edit', $portofolio->id) }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center justify-center transition duration-200">
                            <i class="fas fa-edit mr-2"></i>Edit Portofolio
                        </a>
                        
                        @if($portofolio->status === 'aktif')
                            <form action="{{ route('admin.portofolio.update', $portofolio->id) }}" method="POST" class="inline-block w-full">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="non-aktif">
                                <input type="hidden" name="judul" value="{{ $portofolio->judul }}">
                                <input type="hidden" name="tanggal_proyek" value="{{ $portofolio->tanggal_proyek ? $portofolio->tanggal_proyek->format('Y-m-d') : '' }}">
                                <button type="submit" 
                                        class="w-full bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg flex items-center justify-center transition duration-200"
                                        onclick="return confirm('Sembunyikan portofolio ini dari galeri?')">
                                    <i class="fas fa-eye-slash mr-2"></i>Sembunyikan
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.portofolio.update', $portofolio->id) }}" method="POST" class="inline-block w-full">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="aktif">
                                <input type="hidden" name="judul" value="{{ $portofolio->judul }}">
                                <input type="hidden" name="tanggal_proyek" value="{{ $portofolio->tanggal_proyek ? $portofolio->tanggal_proyek->format('Y-m-d') : '' }}">
                                <button type="submit" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center justify-center transition duration-200"
                                        onclick="return confirm('Tampilkan portofolio ini di galeri?')">
                                    <i class="fas fa-eye mr-2"></i>Tampilkan
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.portofolio.destroy', $portofolio->id) }}" method="POST" class="inline-block w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg flex items-center justify-center transition duration-200"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus portofolio ini? Tindakan ini tidak dapat dibatalkan.')">
                                <i class="fas fa-trash mr-2"></i>Hapus Portofolio
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection