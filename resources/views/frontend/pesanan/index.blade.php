@extends('frontend.layouts.main')

@section('container')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-100 to-slate-200 py-20">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
            Form <span class="text-slate-700">Pemesanan</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Isi form di bawah ini untuk melakukan pemesanan konveksi. Pastikan semua data terisi dengan benar.
        </p>
    </div>
</section>

<!-- Form Section -->
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4">
        <form action="{{ route('pesanan.store') }}" method="POST" enctype="multipart/form-data" id="pesananForm">
            @csrf

            <!-- Alert Errors -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <svg class="w-5 h-5 text-red-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada form:</h3>
                            <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-lg p-8 space-y-6">
                <!-- Layanan yang Dipilih -->
                <div>
                    <label for="layanan_id" class="block text-sm font-semibold text-gray-700 mb-2">
                        Layanan yang Dipilih <span class="text-red-500">*</span>
                    </label>
                    <select name="layanan_id" id="layanan_id" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                        <option value="">Pilih Layanan</option>
                        @foreach($layanan as $item)
                            <option value="{{ $item->id }}" {{ old('layanan_id') == $item->id ? 'selected' : '' }} data-harga="{{ $item->perkiraan_harga }}">
                                {{ $item->nama_layanan }} - {{ $item->formatted_harga }}
                            </option>
                        @endforeach
                    </select>
                    @error('layanan_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Pemesan -->
                <div>
                    <label for="nama_pemesan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nama Pemesan
                    </label>
                    <input type="text" id="nama_pemesan" value="{{ Auth::user()->name }}" readonly
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600">
                    <input type="hidden" name="nama_pemesan" value="{{ Auth::user()->name }}">
                    <p class="mt-1 text-sm text-gray-500">Nama diambil dari akun yang sedang login</p>
                </div>

                <!-- Nomor WhatsApp -->
                <div>
                    <label for="nomor_whatsapp" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nomor WhatsApp <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nomor_whatsapp" id="nomor_whatsapp" required
                           value="{{ old('nomor_whatsapp', Auth::user()->phone) }}"
                           placeholder="08xxxxxxxxx atau +62xxxxxxxxx"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Format: 08xxxxxxxxx atau +62xxxxxxxxx</p>
                    @error('nomor_whatsapp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah Order -->
                <div>
                    <label for="jumlah_order" class="block text-sm font-semibold text-gray-700 mb-2">
                        Jumlah Order <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="jumlah_order" id="jumlah_order" required min="1"
                           value="{{ old('jumlah_order') }}"
                           placeholder="Masukkan jumlah order"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                    @error('jumlah_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ukuran Baju -->
                <div>
                    <label for="ukuran_baju" class="block text-sm font-semibold text-gray-700 mb-2">
                        Ukuran Baju <span class="text-red-500">*</span>
                    </label>
                    <select name="ukuran_baju" id="ukuran_baju" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                        <option value="">Pilih Ukuran</option>
                        @foreach($ukuranOptions as $ukuran)
                            <option value="{{ $ukuran }}" {{ old('ukuran_baju') == $ukuran ? 'selected' : '' }}>{{ $ukuran }}</option>
                        @endforeach
                    </select>
                    @error('ukuran_baju')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga Display -->
                <div id="harga_display" class="hidden">
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium text-blue-800">Harga per unit:</span>
                            <span id="harga_per_unit" class="text-lg font-bold text-blue-900">-</span>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-sm font-medium text-blue-800">Total estimasi:</span>
                            <span id="total_estimasi" class="text-lg font-bold text-blue-900">-</span>
                        </div>
                    </div>
                </div>

                <!-- Ukuran Custom (Hidden by default) -->
                <div id="ukuran_custom_field" class="hidden">
                    <label for="ukuran_custom" class="block text-sm font-semibold text-gray-700 mb-2">
                        Ukuran Custom <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="ukuran_custom" id="ukuran_custom"
                           value="{{ old('ukuran_custom') }}"
                           placeholder="Contoh: Lingkar dada 100cm, Panjang 70cm"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                    @error('ukuran_custom')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Desain Baju -->
                <div>
                    <label for="file_desain_baju" class="block text-sm font-semibold text-gray-700 mb-2">
                        Upload Desain Baju <span class="text-red-500">*</span>
                    </label>
                    <input type="file" name="file_desain_baju" id="file_desain_baju" required
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, PDF. Maksimal 5MB</p>
                    @error('file_desain_baju')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div id="preview_desain_baju" class="mt-2 hidden">
                        <img id="img_preview_desain_baju" class="max-w-xs h-auto rounded-lg border" alt="Preview Desain Baju">
                    </div>
                </div>

                <!-- Tambahan Bordir -->
                <div>
                    <div class="flex items-center">
                        <input type="checkbox" name="tambahan_bordir" id="tambahan_bordir" value="1"
                               {{ old('tambahan_bordir') ? 'checked' : '' }}
                               class="w-4 h-4 text-slate-600 bg-gray-100 border-gray-300 rounded focus:ring-slate-500">
                        <label for="tambahan_bordir" class="ml-2 text-sm font-semibold text-gray-700">
                            Ingin Tambahan Bordir?
                        </label>
                    </div>
                </div>

                <!-- Fields Bordir (Hidden by default) -->
                <div id="bordir_fields" class="space-y-4 {{ old('tambahan_bordir') ? '' : 'hidden' }}">
                    <!-- Upload Desain Bordir -->
                    <div>
                        <label for="file_desain_bordir" class="block text-sm font-semibold text-gray-700 mb-2">
                            Upload Desain Bordir <span class="text-red-500">*</span>
                        </label>
                        <input type="file" name="file_desain_bordir" id="file_desain_bordir"
                               accept=".jpg,.jpeg,.png,.pdf"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                        <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, PDF. Maksimal 5MB</p>
                        @error('file_desain_bordir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <div id="preview_desain_bordir" class="mt-2 hidden">
                            <img id="img_preview_desain_bordir" class="max-w-xs h-auto rounded-lg border" alt="Preview Desain Bordir">
                        </div>
                    </div>

                    <!-- Keterangan Bordir -->
                    <div>
                        <label for="keterangan_bordir" class="block text-sm font-semibold text-gray-700 mb-2">
                            Keterangan Bordir
                        </label>
                        <textarea name="keterangan_bordir" id="keterangan_bordir" rows="3"
                                  placeholder="Contoh: Bordir nama di dada kiri, warna benang hitam"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">{{ old('keterangan_bordir') }}</textarea>
                        @error('keterangan_bordir')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Upload Nama Tag -->
                <div>
                    <label for="file_nama_tag" class="block text-sm font-semibold text-gray-700 mb-2">
                        Upload Nama Tag (Opsional)
                    </label>
                    <input type="file" name="file_nama_tag" id="file_nama_tag"
                           accept=".jpg,.jpeg,.png,.pdf"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, PDF. Maksimal 2MB</p>
                    @error('file_nama_tag')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div id="preview_nama_tag" class="mt-2 hidden">
                        <img id="img_preview_nama_tag" class="max-w-xs h-auto rounded-lg border" alt="Preview Nama Tag">
                    </div>
                </div>

                <!-- Keterangan Tambahan -->
                <div>
                    <label for="keterangan_tambahan" class="block text-sm font-semibold text-gray-700 mb-2">
                        Keterangan Tambahan
                    </label>
                    <textarea name="keterangan_tambahan" id="keterangan_tambahan" rows="4" maxlength="300"
                              placeholder="Tambahkan keterangan khusus jika ada..."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">{{ old('keterangan_tambahan') }}</textarea>
                    <div class="flex justify-between mt-1">
                        <span class="text-sm text-gray-500">Maksimal 300 karakter</span>
                        <span id="char_count" class="text-sm text-gray-500">0/300</span>
                    </div>
                    @error('keterangan_tambahan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="pt-6">
                    <button type="submit" id="submitBtn"
                            class="w-full bg-blue-600 hover:bg-blue-700 disabled:bg-gray-300 disabled:cursor-not-allowed text-white font-bold py-4 px-6 rounded-xl transition-colors duration-200 flex items-center justify-center space-x-2 shadow-lg border-2 border-blue-600 disabled:border-gray-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        <span class="text-lg">Kirim Pesanan</span>
                    </button>
                    <p class="mt-3 text-sm text-gray-600 text-center font-medium">
                        Setelah mengirim, Anda akan diarahkan ke WhatsApp untuk konfirmasi
                    </p>

                    <!-- Indikator Status Tombol -->
                    <div id="buttonStatus" class="mt-2 text-center">
                        <p class="text-xs text-red-500 font-medium">
                            ⚠️ Lengkapi semua field yang wajib diisi untuk mengaktifkan tombol
                        </p>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ukuranBaju = document.getElementById('ukuran_baju');
    const ukuranCustomField = document.getElementById('ukuran_custom_field');
    const ukuranCustomInput = document.getElementById('ukuran_custom');

    const tambahBordir = document.getElementById('tambahan_bordir');
    const bordirFields = document.getElementById('bordir_fields');
    const fileDesainBordir = document.getElementById('file_desain_bordir');

    const keteranganTambahan = document.getElementById('keterangan_tambahan');
    const charCount = document.getElementById('char_count');

    const submitBtn = document.getElementById('submitBtn');
    const form = document.getElementById('pesananForm');

    // Handle ukuran custom
    ukuranBaju.addEventListener('change', function() {
        if (this.value === 'Custom') {
            ukuranCustomField.classList.remove('hidden');
            ukuranCustomInput.required = true;
        } else {
            ukuranCustomField.classList.add('hidden');
            ukuranCustomInput.required = false;
            ukuranCustomInput.value = '';
        }
        validateForm();
    });

    // Handle tambahan bordir
    tambahBordir.addEventListener('change', function() {
        if (this.checked) {
            bordirFields.classList.remove('hidden');
            fileDesainBordir.required = true;
        } else {
            bordirFields.classList.add('hidden');
            fileDesainBordir.required = false;
            fileDesainBordir.value = '';
            document.getElementById('keterangan_bordir').value = '';
        }
        validateForm();
    });

    // Character counter
    keteranganTambahan.addEventListener('input', function() {
        const length = this.value.length;
        charCount.textContent = length + '/300';

        if (length > 300) {
            charCount.classList.add('text-red-500');
        } else {
            charCount.classList.remove('text-red-500');
        }
    });

    // File preview functions
    function setupFilePreview(inputId, previewId, imgId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const img = document.getElementById(imgId);

        input.addEventListener('change', function() {
            const file = this.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
            validateForm();
        });
    }

    // Setup file previews
    setupFilePreview('file_desain_baju', 'preview_desain_baju', 'img_preview_desain_baju');
    setupFilePreview('file_desain_bordir', 'preview_desain_bordir', 'img_preview_desain_bordir');
    setupFilePreview('file_nama_tag', 'preview_nama_tag', 'img_preview_nama_tag');

    // Form validation
    function validateForm() {
        const layananId = document.getElementById('layanan_id').value;
        const nomorWa = document.getElementById('nomor_whatsapp').value;
        const jumlahOrder = document.getElementById('jumlah_order').value;
        const ukuranBaju = document.getElementById('ukuran_baju').value;
        const fileDesainBaju = document.getElementById('file_desain_baju').files.length;

        let isValid = layananId && nomorWa && jumlahOrder && ukuranBaju && fileDesainBaju;

        // Check ukuran custom
        if (ukuranBaju === 'Custom') {
            const ukuranCustom = document.getElementById('ukuran_custom').value;
            isValid = isValid && ukuranCustom;
        }

        // Check bordir files
        if (tambahBordir.checked) {
            const fileDesainBordir = document.getElementById('file_desain_bordir').files.length;
            isValid = isValid && fileDesainBordir;
        }

        submitBtn.disabled = !isValid;
        updateButtonStatus();
    }

    // Update button status indicator
    function updateButtonStatus() {
        const buttonStatus = document.getElementById('buttonStatus');
        
        if (submitBtn.disabled) {
            buttonStatus.innerHTML = '<p class="text-xs text-red-500 font-medium">⚠️ Lengkapi semua field yang wajib diisi untuk mengaktifkan tombol</p>';
        } else {
            buttonStatus.innerHTML = '<p class="text-xs text-green-600 font-medium">✅ Form sudah lengkap, siap untuk dikirim!</p>';
        }
    }

    // Add event listeners for validation
    const requiredFields = ['layanan_id', 'nomor_whatsapp', 'jumlah_order', 'ukuran_baju', 'file_desain_baju'];
    requiredFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener('change', validateForm);
            field.addEventListener('input', validateForm);
        }
    });

    // Update harga berdasarkan layanan dan ukuran
    function updateHarga() {
        const layananSelect = document.getElementById('layanan_id');
        const ukuranSelect = document.getElementById('ukuran_baju');
        const jumlahInput = document.getElementById('jumlah_order');
        const hargaDisplay = document.getElementById('harga_display');
        const hargaPerUnit = document.getElementById('harga_per_unit');
        const totalEstimasi = document.getElementById('total_estimasi');

        if (layananSelect.value && ukuranSelect.value) {
            // Ambil harga dari API
            fetch('/api/pesanan/harga-ukuran', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    layanan_id: layananSelect.value,
                    ukuran: ukuranSelect.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const harga = data.harga;
                    const jumlah = parseInt(jumlahInput.value) || 1;
                    const total = harga * jumlah;

                    hargaPerUnit.textContent = 'Rp ' + harga.toLocaleString('id-ID');
                    totalEstimasi.textContent = 'Rp ' + total.toLocaleString('id-ID');
                    hargaDisplay.classList.remove('hidden');
                } else {
                    // Fallback ke harga default
                    const selectedOption = layananSelect.options[layananSelect.selectedIndex];
                    const defaultHarga = parseInt(selectedOption.dataset.harga) || 0;
                    const jumlah = parseInt(jumlahInput.value) || 1;
                    const total = defaultHarga * jumlah;

                    if (defaultHarga > 0) {
                        hargaPerUnit.textContent = 'Rp ' + defaultHarga.toLocaleString('id-ID');
                        totalEstimasi.textContent = 'Rp ' + total.toLocaleString('id-ID');
                        hargaDisplay.classList.remove('hidden');
                    } else {
                        hargaDisplay.classList.add('hidden');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                hargaDisplay.classList.add('hidden');
            });
        } else {
            hargaDisplay.classList.add('hidden');
        }
    }

    // Event listeners untuk update harga
    document.getElementById('layanan_id').addEventListener('change', updateHarga);
    document.getElementById('ukuran_baju').addEventListener('change', updateHarga);
    document.getElementById('jumlah_order').addEventListener('input', updateHarga);

    // Initial validation
    validateForm();

    // Update character count on page load
    const currentLength = keteranganTambahan.value.length;
    charCount.textContent = currentLength + '/300';
});
</script>
@endpush
@endsection
