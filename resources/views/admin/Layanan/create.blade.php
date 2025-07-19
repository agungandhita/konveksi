@extends('admin.layouts.main')

@section('title', 'Tambah Layanan')

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Layanan</h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.layanan.index') }}" class="text-blue-600 hover:text-blue-800">Kelola Layanan</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-500">Tambah Layanan</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <a href="{{ route('admin.layanan.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
        </a>
    </div>



    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Card -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-lg rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600">Informasi Layanan</h6>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.layanan.store') }}" id="layananForm">
                        @csrf

                        <!-- Nama Layanan -->
                        <div class="mb-6">
                            <label for="nama_layanan" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Layanan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_layanan') border-red-500 @enderror"
                                   id="nama_layanan" name="nama_layanan"
                                   value="{{ old('nama_layanan') }}"
                                   placeholder="Contoh: Sablon Kaos, Bordir Kemeja, dll."
                                   required>
                            @error('nama_layanan')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi Singkat -->
                        <div class="mb-6">
                            <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Singkat <span class="text-red-500">*</span>
                            </label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi_singkat') border-red-500 @enderror"
                                      id="deskripsi_singkat" name="deskripsi_singkat"
                                      rows="3" maxlength="1000"
                                      placeholder="Jelaskan secara singkat tentang layanan ini..." required>{{ old('deskripsi_singkat') }}</textarea>
                            <div class="text-gray-500 text-sm mt-1">Maksimal 1000 karakter</div>
                            @error('deskripsi_singkat')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Estimasi Waktu -->
                            <div class="mb-6">
                                <label for="estimasi_waktu" class="block text-sm font-medium text-gray-700 mb-2">
                                    Estimasi Waktu Pengerjaan <span class="text-red-500">*</span>
                                </label>
                                <div class="flex">
                                    <input type="number" class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('estimasi_waktu') border-red-500 @enderror"
                                           id="estimasi_waktu" name="estimasi_waktu"
                                           value="{{ old('estimasi_waktu') }}"
                                           min="1" placeholder="7" required>
                                    <span class="px-3 py-2 bg-gray-50 border border-l-0 border-gray-300 rounded-r-md text-gray-500">hari</span>
                                </div>
                                @error('estimasi_waktu')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-6">
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror"
                                        id="status" name="status" required>
                                    <option value="">Pilih Status</option>
                                    <option value="aktif" {{ old('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="non-aktif" {{ old('status') === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                </select>
                                @error('status')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Minimal Order -->
                            <div class="mb-6">
                                <label for="minimal_order" class="block text-sm font-medium text-gray-700 mb-2">
                                    Minimal Order <span class="text-red-500">*</span>
                                </label>
                                <input type="number" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('minimal_order') border-red-500 @enderror"
                                       id="minimal_order" name="minimal_order"
                                       value="{{ old('minimal_order') }}"
                                       min="1" placeholder="10" required>
                                @error('minimal_order')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Satuan Order -->
                            <div class="mb-6">
                                <label for="satuan_order" class="block text-sm font-medium text-gray-700 mb-2">
                                    Satuan Order <span class="text-red-500">*</span>
                                </label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('satuan_order') border-red-500 @enderror"
                                        id="satuan_order" name="satuan_order" required>
                                    <option value="">Pilih Satuan</option>
                                    <option value="pcs" {{ old('satuan_order') === 'pcs' ? 'selected' : '' }}>pcs</option>
                                    <option value="lusin" {{ old('satuan_order') === 'lusin' ? 'selected' : '' }}>lusin</option>
                                    <option value="kodi" {{ old('satuan_order') === 'kodi' ? 'selected' : '' }}>kodi</option>
                                    <option value="meter" {{ old('satuan_order') === 'meter' ? 'selected' : '' }}>meter</option>
                                    <option value="kg" {{ old('satuan_order') === 'kg' ? 'selected' : '' }}>kg</option>
                                </select>
                                @error('satuan_order')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Perkiraan Harga -->
                        <div class="mb-6">
                            <label for="perkiraan_harga" class="block text-sm font-medium text-gray-700 mb-2">Perkiraan Harga (Default)</label>
                            <div class="flex">
                                <span class="px-3 py-2 bg-gray-50 border border-r-0 border-gray-300 rounded-l-md text-gray-500">Rp</span>
                                <input type="number" class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('perkiraan_harga') border-red-500 @enderror"
                                       id="perkiraan_harga" name="perkiraan_harga"
                                       value="{{ old('perkiraan_harga') }}"
                                       min="0" step="1000" placeholder="50000">
                            </div>
                            <div class="text-gray-500 text-sm mt-1">Harga default jika tidak ada harga khusus per ukuran</div>
                            @error('perkiraan_harga')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Harga Berdasarkan Ukuran -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Harga Berdasarkan Ukuran (Opsional)</label>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="text-sm text-gray-600 mb-3">Atur harga khusus untuk setiap ukuran. Kosongkan jika menggunakan harga default.</div>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach($ukuranOptions as $key => $label)
                                    <div>
                                        <label for="harga_{{ $key }}" class="block text-xs font-medium text-gray-600 mb-1">{{ $label }}</label>
                                        <div class="flex">
                                            <span class="px-2 py-1 bg-white border border-r-0 border-gray-300 rounded-l text-xs text-gray-500">Rp</span>
                                            <input type="number" 
                                                   class="flex-1 px-2 py-1 text-sm border border-gray-300 rounded-r focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-transparent"
                                                   id="harga_{{ $key }}" 
                                                   name="harga_ukuran[{{ $key }}]"
                                                   value="{{ old('harga_ukuran.' . $key) }}"
                                                   min="0" 
                                                   step="1000" 
                                                   placeholder="{{ $key == 'Custom' ? '75000' : (50000 + (array_search($key, array_keys($ukuranOptions)) * 5000)) }}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex space-x-3">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                                <i class="fas fa-save mr-2"></i>Simpan Layanan
                            </button>
                            <button type="button" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200" onclick="resetForm()">
                                <i class="fas fa-undo mr-2"></i>Reset
                            </button>
                            <a href="{{ route('admin.layanan.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                                <i class="fas fa-times mr-2"></i>Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="lg:col-span-1">
            <div class="bg-white shadow-lg rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600">Preview Layanan</h6>
                </div>
                <div class="p-6">
                    <div id="preview-content">
                        <div class="text-center text-gray-500 py-4">
                            <i class="fas fa-eye text-2xl mb-3"></i>
                            <p>Preview akan muncul saat Anda mengisi form</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="bg-white shadow-lg rounded-lg mt-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-green-600">Tips Pengisian</h6>
                </div>
                <div class="p-6">
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-lightbulb text-yellow-500 mr-2 mt-1"></i>
                            <small class="text-gray-700">Gunakan nama layanan yang jelas dan mudah dipahami</small>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-clock text-blue-500 mr-2 mt-1"></i>
                            <small class="text-gray-700">Estimasi waktu sebaiknya realistis dan dapat dicapai</small>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-calculator text-blue-600 mr-2 mt-1"></i>
                            <small class="text-gray-700">Minimal order membantu efisiensi produksi</small>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-money-bill text-green-500 mr-2 mt-1"></i>
                            <small class="text-gray-700">Harga dapat dikosongkan jika bervariasi</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Form validation and preview
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('layananForm');
    const previewContent = document.getElementById('preview-content');

    // Form inputs
    const namaLayanan = document.getElementById('nama_layanan');
    const deskripsi = document.getElementById('deskripsi_singkat');
    const estimasi = document.getElementById('estimasi_waktu');
    const minimalOrder = document.getElementById('minimal_order');
    const satuanOrder = document.getElementById('satuan_order');
    const harga = document.getElementById('perkiraan_harga');
    const status = document.getElementById('status');

    // Update preview on input change
    [namaLayanan, deskripsi, estimasi, minimalOrder, satuanOrder, harga, status].forEach(input => {
        input.addEventListener('input', updatePreview);
        input.addEventListener('change', updatePreview);
    });

    function updatePreview() {
        const nama = namaLayanan.value || 'Nama Layanan';
        const desc = deskripsi.value || 'Deskripsi layanan...';
        const est = estimasi.value ? `${estimasi.value} hari` : '-';
        const minOrder = minimalOrder.value && satuanOrder.value ? `${minimalOrder.value} ${satuanOrder.value}` : '-';
        const price = harga.value ? `Rp ${parseInt(harga.value).toLocaleString('id-ID')}` : 'Harga konsultasi';
        const stat = status.value || 'non-aktif';

        const statusBadge = stat === 'aktif' ?
            '<span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Aktif</span>' :
            '<span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">Non-Aktif</span>';

        previewContent.innerHTML = `
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start mb-2">
                    <h6 class="text-lg font-semibold text-gray-900">${nama}</h6>
                    ${statusBadge}
                </div>
                <p class="text-gray-600 text-sm mb-3">${desc}</p>
                <div class="grid grid-cols-2 gap-2 text-sm">
                    <div>
                        <strong class="text-gray-700">Estimasi:</strong><br>
                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">${est}</span>
                    </div>
                    <div>
                        <strong class="text-gray-700">Min. Order:</strong><br>
                        <span class="text-gray-600">${minOrder}</span>
                    </div>
                    <div class="col-span-2 mt-2">
                        <strong class="text-gray-700">Harga:</strong><br>
                        <span class="text-green-600 font-bold">${price}</span>
                    </div>
                </div>
            </div>
        `;
    }

    // Initial preview
    updatePreview();
});

// Reset form function
function resetForm() {
    if (confirm('Apakah Anda yakin ingin mereset form? Semua data yang telah diisi akan hilang.')) {
        document.getElementById('layananForm').reset();
        document.getElementById('preview-content').innerHTML = `
            <div class="text-center text-muted py-4">
                <i class="fas fa-eye fa-2x mb-3"></i>
                <p>Preview akan muncul saat Anda mengisi form</p>
            </div>
        `;
    }
}

// Format number input for harga
document.getElementById('perkiraan_harga').addEventListener('input', function(e) {
    // Remove non-numeric characters except decimal point
    let value = e.target.value.replace(/[^0-9]/g, '');
    e.target.value = value;
});

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(alert => {
        alert.style.opacity = '0';
        alert.style.transition = 'opacity 0.5s';
        setTimeout(() => alert.remove(), 500);
    });
}, 5000);
</script>
@endpush
