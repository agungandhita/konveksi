@extends('admin.layouts.main')

@section('title', 'Edit Produk')

@section('container')
<div class="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
            <p class="text-gray-600 mt-1">Edit informasi produk: {{ $produk->nama_produk }}</p>
        </div>
        <a href="{{ route('admin.produk.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>



    <!-- Form Card -->
    <div class="bg-white shadow rounded-lg">
        <div class="p-6">
            <form method="POST" action="{{ route('admin.produk.update', $produk) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nama Produk -->
                    <div class="md:col-span-2">
                        <label for="nama_produk" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_produk" id="nama_produk" 
                               class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('nama_produk') border-red-500 @enderror"
                               value="{{ old('nama_produk', $produk->nama_produk) }}" 
                               placeholder="Masukkan nama produk">
                        @error('nama_produk')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga (IDR) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="harga" id="harga" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('harga') border-red-500 @enderror"
                                   value="{{ old('harga', $produk->harga) }}" 
                                   placeholder="0" min="0" step="1000">
                        </div>
                        @error('harga')
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
                            <option value="aktif" {{ old('status', $produk->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="non-aktif" {{ old('status', $produk->status) === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Singkat -->
                    <div class="md:col-span-2">
                        <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Singkat
                        </label>
                        <textarea name="deskripsi_singkat" id="deskripsi_singkat" rows="3"
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('deskripsi_singkat') border-red-500 @enderror"
                                  placeholder="Masukkan deskripsi singkat produk (opsional)">{{ old('deskripsi_singkat', $produk->deskripsi_singkat) }}</textarea>
                        @error('deskripsi_singkat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Maksimal 1000 karakter</p>
                    </div>

                    <!-- Foto Produk -->
                    <div class="md:col-span-2">
                        <label for="foto_produk" class="block text-sm font-medium text-gray-700 mb-2">
                            Foto Produk
                        </label>
                        
                        <!-- Current Image -->
                        @if($produk->foto_produk)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Foto saat ini:</p>
                                <img src="{{ $produk->foto_url }}" alt="{{ $produk->nama_produk }}" 
                                     class="h-32 w-32 object-cover rounded-lg border border-gray-200">
                            </div>
                        @endif
                        
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors duration-200">
                            <div class="space-y-1 text-center">
                                <div id="imagePreview" class="hidden mb-4">
                                    <img id="previewImg" class="mx-auto h-32 w-32 object-cover rounded-lg border border-gray-200" src="" alt="Preview">
                                </div>
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="foto_produk" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>{{ $produk->foto_produk ? 'Ganti foto' : 'Upload foto' }}</span>
                                        <input id="foto_produk" name="foto_produk" type="file" class="sr-only" accept="image/*">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 2MB</p>
                                @if($produk->foto_produk)
                                    <p class="text-xs text-gray-500">Kosongkan jika tidak ingin mengubah foto</p>
                                @endif
                            </div>
                        </div>
                        @error('foto_produk')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link Pembelian -->
                    <div class="md:col-span-2">
                        <label for="link_pembelian" class="block text-sm font-medium text-gray-700 mb-2">
                            Link Pembelian (WhatsApp/Marketplace)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-link text-gray-400"></i>
                            </div>
                            <input type="url" name="link_pembelian" id="link_pembelian" 
                                   class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @error('link_pembelian') border-red-500 @enderror"
                                   value="{{ old('link_pembelian', $produk->link_pembelian) }}" 
                                   placeholder="https://wa.me/6281234567890 atau https://tokopedia.com/...">
                        </div>
                        @error('link_pembelian')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Link WhatsApp atau marketplace untuk pembelian produk (opsional)</p>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.produk.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded-md transition duration-200 flex items-center">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md transition duration-200 flex items-center">
                        <i class="fas fa-save mr-2"></i>Update Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Image preview functionality
document.getElementById('foto_produk').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreview').classList.add('hidden');
    }
});

// Format harga input
document.getElementById('harga').addEventListener('input', function(e) {
    let value = e.target.value.replace(/[^0-9]/g, '');
    if (value) {
        e.target.value = parseInt(value);
    }
});

// Auto-format link pembelian
document.getElementById('link_pembelian').addEventListener('blur', function(e) {
    let value = e.target.value.trim();
    if (value && !value.startsWith('http://') && !value.startsWith('https://')) {
        e.target.value = 'https://' + value;
    }
});
</script>
@endpush