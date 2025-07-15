@extends('admin.layouts.main')

@section('title', 'Edit Layanan')

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Layanan</h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.layanan.index') }}" class="text-blue-600 hover:text-blue-800">Kelola Layanan</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                            <span class="text-gray-500">Edit: {{ $layanan->nama_layanan }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.layanan.show', $layanan) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-eye mr-2"></i>Lihat
            </a>
            <a href="{{ route('admin.layanan.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>



    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Card -->
        <div class="lg:col-span-2">
            <div class="bg-white shadow-lg rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-600">Edit Informasi Layanan</h6>
                </div>
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.layanan.update', $layanan) }}" id="layananForm">
                        @csrf
                        @method('PUT')

                        <!-- Nama Layanan -->
                        <div class="mb-6">
                            <label for="nama_layanan" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Layanan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_layanan') border-red-500 @enderror"
                                   id="nama_layanan" name="nama_layanan"
                                   value="{{ old('nama_layanan', $layanan->nama_layanan) }}"
                                   placeholder="Contoh: Sablon Kaos, Bordir Kemeja, dll."
                                   required>
                            @error('nama_layanan')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Deskripsi Singkat -->
                        <div class="mb-6">
                            <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Singkat</label>
                            <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('deskripsi_singkat') border-red-500 @enderror"
                                      id="deskripsi_singkat" name="deskripsi_singkat"
                                      rows="3" maxlength="1000"
                                      placeholder="Jelaskan secara singkat tentang layanan ini...">{{ old('deskripsi_singkat', $layanan->deskripsi_singkat) }}</textarea>
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
                                           value="{{ old('estimasi_waktu', $layanan->estimasi_waktu) }}"
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
                                    <option value="aktif" {{ old('status', $layanan->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="non-aktif" {{ old('status', $layanan->status) === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
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
                                       value="{{ old('minimal_order', $layanan->minimal_order) }}"
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
                                    <option value="pcs" {{ old('satuan_order', $layanan->satuan_order) === 'pcs' ? 'selected' : '' }}>pcs</option>
                                    <option value="lusin" {{ old('satuan_order', $layanan->satuan_order) === 'lusin' ? 'selected' : '' }}>lusin</option>
                                    <option value="kodi" {{ old('satuan_order', $layanan->satuan_order) === 'kodi' ? 'selected' : '' }}>kodi</option>
                                    <option value="meter" {{ old('satuan_order', $layanan->satuan_order) === 'meter' ? 'selected' : '' }}>meter</option>
                                    <option value="kg" {{ old('satuan_order', $layanan->satuan_order) === 'kg' ? 'selected' : '' }}>kg</option>
                                </select>
                                @error('satuan_order')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Perkiraan Harga -->
                        <div class="mb-6">
                            <label for="perkiraan_harga" class="block text-sm font-medium text-gray-700 mb-2">Perkiraan Harga</label>
                            <div class="flex">
                                <span class="px-3 py-2 bg-gray-50 border border-r-0 border-gray-300 rounded-l-md text-gray-500">Rp</span>
                                <input type="number" class="flex-1 px-3 py-2 border border-gray-300 rounded-r-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('perkiraan_harga') border-red-500 @enderror"
                                       id="perkiraan_harga" name="perkiraan_harga"
                                       value="{{ old('perkiraan_harga', $layanan->perkiraan_harga) }}"
                                       min="0" step="1000" placeholder="50000">
                            </div>
                            <div class="text-gray-500 text-sm mt-1">Kosongkan jika harga akan ditentukan berdasarkan konsultasi</div>
                            @error('perkiraan_harga')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex space-x-3">
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                                <i class="fas fa-save mr-2"></i>Update Layanan
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
            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-blue-500">Preview Layanan</h6>
                </div>
                <div class="p-6">
                    <div id="preview-content">
                        <!-- Preview will be populated by JavaScript -->
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-white rounded-lg shadow-md mb-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-yellow-500">Informasi</h6>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <strong class="text-gray-900">Dibuat:</strong><br>
                            <small class="text-gray-600">{{ $layanan->created_at->format('d M Y H:i') }}</small>
                        </div>
                        <div>
                            <strong class="text-gray-900">Diperbarui:</strong><br>
                            <small class="text-gray-600">{{ $layanan->updated_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-md">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-green-500">Aksi Cepat</h6>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <form method="POST" action="{{ route('admin.layanan.toggle-status', $layanan) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 {{ $layanan->status === 'aktif' ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-500 hover:bg-green-600' }} text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out">
                                <i class="fas fa-{{ $layanan->status === 'aktif' ? 'pause' : 'play' }} mr-2"></i>
                                {{ $layanan->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        <button type="button" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out" onclick="showDeleteModal()">
                            <i class="fas fa-trash mr-2"></i>Hapus Layanan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h5 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h5>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeDeleteModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-sm text-gray-700">Apakah Anda yakin ingin menghapus layanan <strong>{{ $layanan->nama_layanan }}</strong>?</p>
                <p class="text-sm text-red-600 mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out" onclick="closeDeleteModal()">Batal</button>
                <form method="POST" action="{{ route('admin.layanan.destroy', $layanan) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition duration-150 ease-in-out">Hapus</button>
                </form>
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
            '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">Aktif</span>' :
            '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Non-Aktif</span>';

        previewContent.innerHTML = `
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex justify-between items-start mb-3">
                    <h6 class="text-lg font-semibold text-gray-900">${nama}</h6>
                    ${statusBadge}
                </div>
                <p class="text-gray-600 text-sm mb-4">${desc}</p>
                <div class="space-y-3 text-sm">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <strong class="text-gray-900">Estimasi:</strong><br>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">${est}</span>
                        </div>
                        <div>
                            <strong class="text-gray-900">Min. Order:</strong><br>
                            <span class="text-gray-700">${minOrder}</span>
                        </div>
                    </div>
                    <div>
                        <strong class="text-gray-900">Harga:</strong><br>
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
    if (confirm('Apakah Anda yakin ingin mereset form? Semua perubahan yang belum disimpan akan hilang.')) {
        location.reload();
    }
}

// Modal functions
function showDeleteModal() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Format number input for harga
document.getElementById('perkiraan_harga').addEventListener('input', function(e) {
    // Remove non-numeric characters except decimal point
    let value = e.target.value.replace(/[^0-9]/g, '');
    e.target.value = value;
});

// Auto hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('.bg-green-100, .bg-red-100');
    alerts.forEach(function(alert) {
        alert.style.transition = 'opacity 0.5s';
        alert.style.opacity = '0';
        setTimeout(function() {
            alert.remove();
        }, 500);
    });
}, 5000);
</script>
@endpush
