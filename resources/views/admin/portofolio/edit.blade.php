@extends('admin.layouts.main')

@section('title', 'Edit Portofolio')

@section('container')
<div class="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Portofolio</h1>
            <p class="text-gray-600 mt-1">Perbarui informasi portofolio: {{ $portofolio->judul }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.portofolio.show', $portofolio->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-eye mr-2"></i>Lihat
            </a>
            <a href="{{ route('admin.portofolio.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white shadow rounded-lg">
        <div class="p-6">
            <form action="{{ route('admin.portofolio.update', $portofolio->id) }}" method="POST" enctype="multipart/form-data" id="portofolioForm">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Judul Portofolio -->
                        <div>
                            <label for="judul" class="block text-sm font-medium text-gray-700 mb-2">
                                Judul Portofolio <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="judul" id="judul" 
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('judul') border-red-500 @enderror"
                                   value="{{ old('judul', $portofolio->judul) }}" placeholder="Masukkan judul portofolio">
                            @error('judul')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Deskripsi Singkat -->
                        <div>
                            <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Singkat
                            </label>
                            <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="4"
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('deskripsi_singkat') border-red-500 @enderror"
                                      placeholder="Deskripsikan hasil pekerjaan ini...">{{ old('deskripsi_singkat', $portofolio->deskripsi_singkat) }}</textarea>
                            @error('deskripsi_singkat')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter</p>
                        </div>

                        <!-- Tanggal Proyek -->
                        <div>
                            <label for="tanggal_proyek" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Proyek <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_proyek" id="tanggal_proyek" 
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('tanggal_proyek') border-red-500 @enderror"
                                   value="{{ old('tanggal_proyek', $portofolio->tanggal_proyek ? $portofolio->tanggal_proyek->format('Y-m-d') : '') }}">
                            @error('tanggal_proyek')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status" id="status" 
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('status') border-red-500 @enderror">
                                <option value="">Pilih Status</option>
                                <option value="aktif" {{ old('status', $portofolio->status) === 'aktif' ? 'selected' : '' }}>Aktif (Tampilkan)</option>
                                <option value="non-aktif" {{ old('status', $portofolio->status) === 'non-aktif' ? 'selected' : '' }}>Non-Aktif (Sembunyikan)</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Gambar Utama -->
                        <div>
                            <label for="gambar_utama" class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Utama
                            </label>
                            
                            <!-- Current Image -->
                            @if($portofolio->gambar_utama)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Gambar saat ini:</p>
                                <div class="relative inline-block">
                                    <img src="{{ $portofolio->gambar_utama_url }}" alt="Current Image" class="h-32 w-auto rounded-lg shadow-sm border">
                                    <button type="button" onclick="removeCurrentImage()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600 transition duration-200">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="remove_image" id="remove_image" value="0">
                            </div>
                            @endif
                            
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                                <div class="space-y-1 text-center">
                                    <div id="imagePreview" class="hidden">
                                        <img id="previewImg" src="" alt="Preview" class="mx-auto h-32 w-auto rounded-lg shadow-sm">
                                    </div>
                                    <div id="imageUploadArea">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="gambar_utama" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>{{ $portofolio->gambar_utama ? 'Ganti gambar' : 'Upload gambar' }}</span>
                                                <input id="gambar_utama" name="gambar_utama" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG hingga 2MB</p>
                                    </div>
                                </div>
                            </div>
                            @error('gambar_utama')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Video Section -->
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Video (Opsional)</h3>
                            
                            <!-- Current Video Display -->
                            @if($portofolio->video_url || $portofolio->video_file)
                            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-600 mb-2">Video saat ini:</p>
                                @if($portofolio->video_url)
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-blue-600">YouTube: {{ Str::limit($portofolio->video_url, 50) }}</span>
                                        <button type="button" onclick="removeCurrentVideo('url')" class="text-red-500 hover:text-red-700 text-sm">
                                            <i class="fas fa-times"></i> Hapus
                                        </button>
                                    </div>
                                @endif
                                @if($portofolio->video_file)
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-green-600">File: {{ basename($portofolio->video_file) }}</span>
                                        <button type="button" onclick="removeCurrentVideo('file')" class="text-red-500 hover:text-red-700 text-sm">
                                            <i class="fas fa-times"></i> Hapus
                                        </button>
                                    </div>
                                @endif
                                <input type="hidden" name="remove_video_url" id="remove_video_url" value="0">
                                <input type="hidden" name="remove_video_file" id="remove_video_file" value="0">
                            </div>
                            @endif
                            
                            <!-- Video URL -->
                            <div class="mb-4">
                                <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    Link YouTube
                                </label>
                                <input type="url" name="video_url" id="video_url" 
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('video_url') border-red-500 @enderror"
                                       value="{{ old('video_url', $portofolio->video_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                                @error('video_url')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="text-center text-gray-500 text-sm mb-4">ATAU</div>

                            <!-- Video File Upload -->
                            <div>
                                <label for="video_file" class="block text-sm font-medium text-gray-700 mb-2">
                                    Upload Video File
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="video_file" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                <span>{{ $portofolio->video_file ? 'Ganti video' : 'Upload video' }}</span>
                                                <input id="video_file" name="video_file" type="file" class="sr-only" accept="video/mp4,video/avi,video/mov,video/wmv">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">MP4, AVI, MOV, WMV hingga 10MB</p>
                                    </div>
                                </div>
                                @error('video_file')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>



                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.portofolio.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-lg transition duration-200">
                        Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>Update Portofolio
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Image preview functionality
document.getElementById('gambar_utama').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
            document.getElementById('imageUploadArea').classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Reset image preview
function resetImagePreview() {
    document.getElementById('imagePreview').classList.add('hidden');
    document.getElementById('imageUploadArea').classList.remove('hidden');
    document.getElementById('gambar_utama').value = '';
}

// Remove current image
function removeCurrentImage() {
    if (confirm('Hapus gambar saat ini?')) {
        document.getElementById('remove_image').value = '1';
        // Hide current image display
        const currentImageDiv = document.querySelector('.relative.inline-block');
        if (currentImageDiv) {
            currentImageDiv.style.display = 'none';
        }
    }
}

// Remove current video
function removeCurrentVideo(type) {
    if (confirm('Hapus video saat ini?')) {
        if (type === 'url') {
            document.getElementById('remove_video_url').value = '1';
            document.getElementById('video_url').value = '';
        } else if (type === 'file') {
            document.getElementById('remove_video_file').value = '1';
        }
        
        // Hide the current video display
        const currentVideoDiv = document.querySelector('.bg-gray-50.rounded-lg');
        if (currentVideoDiv) {
            currentVideoDiv.style.display = 'none';
        }
    }
}

// Add click to reset image preview
document.getElementById('imagePreview').addEventListener('click', function() {
    if (confirm('Hapus gambar yang dipilih?')) {
        resetImagePreview();
    }
});

// Form validation
document.getElementById('portofolioForm').addEventListener('submit', function(e) {
    const judul = document.getElementById('judul').value.trim();
    const tanggalProyek = document.getElementById('tanggal_proyek').value;
    const status = document.getElementById('status').value;
    
    if (!judul) {
        alert('Judul portofolio wajib diisi.');
        e.preventDefault();
        return;
    }
    
    if (!tanggalProyek) {
        alert('Tanggal proyek wajib diisi.');
        e.preventDefault();
        return;
    }
    
    if (!status) {
        alert('Status wajib dipilih.');
        e.preventDefault();
        return;
    }
    

});

// Auto-resize textarea
document.querySelectorAll('textarea').forEach(textarea => {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = this.scrollHeight + 'px';
    });
});
</script>
@endpush
@endsection