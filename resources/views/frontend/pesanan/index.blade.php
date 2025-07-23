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
                            class="w-full px-4 py-3 border border-blue-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 border-2 shadow-sm">
                        <option value="">Pilih Layanan</option>
                        @foreach($layanan as $item)
                            <option value="{{ $item->id }}" {{ old('layanan_id') == $item->id ? 'selected' : '' }} 
                                    data-harga-dasar="{{ $item->perkiraan_harga }}" 
                                    data-nama="{{ $item->nama_layanan }}">
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

                    <!-- Detail Harga per Ukuran -->
                    <div id="harga_ukuran_detail" class="mt-3 hidden">
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl p-6 shadow-sm">
                            <div class="flex items-center mb-4">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                <h4 class="text-lg font-bold text-blue-800">Daftar Harga per Ukuran</h4>
                            </div>
                            <div id="harga_ukuran_list" class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <!-- Harga ukuran akan dimuat di sini -->
                            </div>
                            <div class="mt-4 p-3 bg-blue-100 rounded-lg">
                                <p class="text-sm text-blue-700 font-medium">💡 <strong>Tips:</strong> Pilih ukuran yang sesuai untuk melihat harga dan estimasi total</p>
                            </div>
                        </div>
                    </div>

                    @error('ukuran_baju')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kalkulasi Harga -->
                <div id="kalkulasi_harga" class="hidden">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 shadow-lg">
                        <div class="flex items-center mb-4">
                            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <h4 class="text-lg font-bold text-green-800">Kalkulasi Harga</h4>
                        </div>
                        <div class="space-y-3">
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-green-100">
                                <span class="text-sm font-semibold text-green-700">🏷️ Harga dasar layanan:</span>
                                <span id="display_harga_dasar" class="text-lg font-bold text-green-900">-</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-green-100">
                                <span class="text-sm font-semibold text-green-700">📏 Biaya tambahan ukuran:</span>
                                <span id="display_biaya_ukuran" class="text-lg font-bold text-green-900">-</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg border border-blue-200">
                                <span class="text-sm font-semibold text-blue-700">💰 Harga per unit:</span>
                                <span id="display_harga_per_unit" class="text-xl font-bold text-blue-900">-</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg border border-yellow-200">
                                <span class="text-sm font-semibold text-yellow-700">📦 Jumlah order:</span>
                                <span id="display_jumlah_order" class="text-lg font-bold text-yellow-900">-</span>
                            </div>
                            <div class="flex items-center justify-between p-4 bg-green-100 rounded-lg border border-green-300">
                                <span class="text-lg font-bold text-green-800">🧮 Total Estimasi:</span>
                                <span id="display_total_estimasi" class="text-2xl font-bold text-green-900">-</span>
                            </div>
                        </div>
                        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-xs text-yellow-700 font-medium">⚠️ <strong>Catatan:</strong> Harga ini adalah estimasi awal. Harga final akan dikonfirmasi setelah konsultasi desain.</p>
                        </div>
                    </div>
                </div>

                <!-- Ukuran Custom -->
                <div>
                    <label for="ukuran_custom" class="block text-sm font-semibold text-gray-700 mb-2">
                        Keterangan Ukuran Tambahan <span class="text-gray-500">(Opsional)</span>
                    </label>
                    <input type="text" name="ukuran_custom" id="ukuran_custom"
                           value="{{ old('ukuran_custom') }}"
                           placeholder="Contoh: Lingkar dada 100cm, Panjang 70cm, atau keterangan ukuran khusus lainnya"
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

                <!-- Fields Bordir -->
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
    // Element references
    const layananSelect = document.getElementById('layanan_id');
    const ukuranSelect = document.getElementById('ukuran_baju');
    const jumlahOrderInput = document.getElementById('jumlah_order');
    const tambahBordir = document.getElementById('tambahan_bordir');
    const bordirFields = document.getElementById('bordir_fields');
    const fileDesainBordir = document.getElementById('file_desain_bordir');
    const keteranganTambahan = document.getElementById('keterangan_tambahan');
    const charCount = document.getElementById('char_count');
    const submitBtn = document.getElementById('submitBtn');
    
    // Display elements
    const hargaUkuranDetail = document.getElementById('harga_ukuran_detail');
    const hargaUkuranList = document.getElementById('harga_ukuran_list');
    const kalkulasiHarga = document.getElementById('kalkulasi_harga');
    
    // Data harga ukuran dari backend
    const layananHargaData = @json($layanan->mapWithKeys(function($item) {
        return [$item->id => $item->hargaUkuran->pluck('harga', 'ukuran')];
    }));
    
    // State variables
    let currentCalculation = {
        hargaDasar: 0,
        biayaUkuran: 0,
        hargaPerUnit: 0,
        jumlahOrder: 0,
        totalEstimasi: 0
    };

    // Utility functions
    function formatCurrency(amount) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
    }

    function showLoading(element, message = 'Memuat data...') {
        element.innerHTML = `
            <div class="col-span-full text-center p-8">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto mb-3"></div>
                <p class="text-blue-600 font-medium">${message}</p>
            </div>
        `;
    }

    // Calculation functions
    function calculatePrices() {
        const layananId = layananSelect.value;
        const ukuran = ukuranSelect.value;
        const jumlah = parseInt(jumlahOrderInput.value) || 0;
        
        // Reset calculation
        currentCalculation = {
            hargaDasar: 0,
            biayaUkuran: 0,
            hargaPerUnit: 0,
            jumlahOrder: jumlah,
            totalEstimasi: 0
        };
        
        if (!layananId || !ukuran) {
            updateCalculationDisplay();
            return;
        }
        
        // Get harga dasar layanan
        const selectedOption = layananSelect.options[layananSelect.selectedIndex];
        const hargaDasar = parseInt(selectedOption.getAttribute('data-harga-dasar')) || 0;
        
        // Get biaya ukuran
        let biayaUkuran = 0;
        if (layananHargaData[layananId] && layananHargaData[layananId][ukuran]) {
            biayaUkuran = parseInt(layananHargaData[layananId][ukuran]) || 0;
        }
        
        // Calculate totals
        const hargaPerUnit = hargaDasar + biayaUkuran;
        const totalEstimasi = hargaPerUnit * jumlah;
        
        // Update state
        currentCalculation = {
            hargaDasar: hargaDasar,
            biayaUkuran: biayaUkuran,
            hargaPerUnit: hargaPerUnit,
            jumlahOrder: jumlah,
            totalEstimasi: totalEstimasi
        };
        
        updateCalculationDisplay();
    }

    function updateCalculationDisplay() {
        // Update display elements
        document.getElementById('display_harga_dasar').textContent = formatCurrency(currentCalculation.hargaDasar);
        document.getElementById('display_biaya_ukuran').textContent = formatCurrency(currentCalculation.biayaUkuran);
        document.getElementById('display_harga_per_unit').textContent = formatCurrency(currentCalculation.hargaPerUnit);
        document.getElementById('display_jumlah_order').textContent = currentCalculation.jumlahOrder + ' unit';
        document.getElementById('display_total_estimasi').textContent = formatCurrency(currentCalculation.totalEstimasi);
        
        // Show/hide calculation display
        if (currentCalculation.hargaPerUnit > 0 && currentCalculation.jumlahOrder > 0) {
            kalkulasiHarga.classList.remove('hidden');
        } else {
            kalkulasiHarga.classList.add('hidden');
        }
    }

    function updateHargaUkuranList() {
        const layananId = layananSelect.value;
        
        if (!layananId || !layananHargaData[layananId]) {
            hargaUkuranDetail.classList.add('hidden');
            return;
        }
        
        const hargaData = layananHargaData[layananId];
        
        // Show loading
        hargaUkuranDetail.classList.remove('hidden');
        showLoading(hargaUkuranList, 'Memuat data harga ukuran...');
        
        // Simulate loading delay for better UX
        setTimeout(() => {
            let hargaHtml = '';
            const ukuranOrder = ['XS', 'S', 'M', 'L', 'XL', '2XL', '3XL', '4XL'];
            
            ukuranOrder.forEach(ukuran => {
                if (hargaData[ukuran]) {
                    const harga = hargaData[ukuran];
                    hargaHtml += `
                        <div class="bg-white border border-blue-200 rounded-xl p-4 text-center shadow-sm hover:shadow-md transition-all duration-200 hover:border-blue-300">
                            <div class="text-lg font-bold text-blue-900 mb-1">${ukuran}</div>
                            <div class="text-sm font-semibold text-blue-700">${formatCurrency(harga)}</div>
                            <div class="mt-2 w-full h-1 bg-blue-100 rounded-full"></div>
                        </div>
                    `;
                } else {
                    hargaHtml += `
                        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center opacity-60">
                            <div class="text-lg font-bold text-gray-400 mb-1">${ukuran}</div>
                            <div class="text-sm text-gray-400">Tidak tersedia</div>
                            <div class="mt-2 w-full h-1 bg-gray-200 rounded-full"></div>
                        </div>
                    `;
                }
            });
            
            if (hargaHtml === '') {
                hargaHtml = `
                    <div class="col-span-full text-center p-8">
                        <div class="text-gray-400 mb-2">
                            <svg class="w-12 h-12 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500 font-medium">Belum ada data harga untuk layanan ini</p>
                        <p class="text-gray-400 text-sm mt-1">Silakan hubungi admin untuk informasi harga</p>
                    </div>
                `;
            }
            
            hargaUkuranList.innerHTML = hargaHtml;
        }, 300);
    }

    // Event handlers
    function handleLayananChange() {
        updateHargaUkuranList();
        calculatePrices();
        validateForm();
    }

    function handleUkuranChange() {
        calculatePrices();
        validateForm();
    }

    function handleJumlahChange() {
        calculatePrices();
        validateForm();
    }

    function handleBordirChange() {
        if (tambahBordir.checked) {
            bordirFields.classList.remove('hidden');
            fileDesainBordir.required = true;
        } else {
            bordirFields.classList.add('hidden');
            fileDesainBordir.required = false;
            fileDesainBordir.value = '';
            document.getElementById('keterangan_bordir').value = '';
            // Clear preview
            const preview = document.getElementById('preview_desain_bordir');
            if (preview) preview.classList.add('hidden');
        }
        validateForm();
    }

    function handleCharacterCount() {
        const length = keteranganTambahan.value.length;
        charCount.textContent = length + '/300';
        
        if (length > 300) {
            charCount.classList.add('text-red-500');
            charCount.classList.remove('text-gray-500');
        } else {
            charCount.classList.remove('text-red-500');
            charCount.classList.add('text-gray-500');
        }
    }

    // File preview setup
    function setupFilePreview(inputId, previewId, imgId) {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const img = document.getElementById(imgId);
        
        if (!input || !preview || !img) return;
        
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

    // Form validation
    function validateForm() {
        const layananId = layananSelect.value;
        const nomorWa = document.getElementById('nomor_whatsapp').value.trim();
        const jumlahOrder = jumlahOrderInput.value;
        const ukuranBaju = ukuranSelect.value;
        const fileDesainBaju = document.getElementById('file_desain_baju').files.length;
        
        let isValid = layananId && nomorWa && jumlahOrder && ukuranBaju && fileDesainBaju;
        
        // Check bordir files if bordir is selected
        if (tambahBordir.checked) {
            const fileDesainBordirCount = fileDesainBordir.files.length;
            isValid = isValid && fileDesainBordirCount;
        }
        
        // Check character limit
        if (keteranganTambahan.value.length > 300) {
            isValid = false;
        }
        
        submitBtn.disabled = !isValid;
        updateButtonStatus();
    }

    function updateButtonStatus() {
        const buttonStatus = document.getElementById('buttonStatus');
        
        if (submitBtn.disabled) {
            buttonStatus.innerHTML = '<p class="text-xs text-red-500 font-medium">⚠️ Lengkapi semua field yang wajib diisi untuk mengaktifkan tombol</p>';
        } else {
            buttonStatus.innerHTML = '<p class="text-xs text-green-600 font-medium">✅ Semua field sudah lengkap, siap untuk dikirim!</p>';
        }
    }

    // Event listeners
    layananSelect.addEventListener('change', handleLayananChange);
    ukuranSelect.addEventListener('change', handleUkuranChange);
    jumlahOrderInput.addEventListener('input', handleJumlahChange);
    tambahBordir.addEventListener('change', handleBordirChange);
    keteranganTambahan.addEventListener('input', handleCharacterCount);
    
    // Add validation listeners
    ['layanan_id', 'nomor_whatsapp', 'jumlah_order', 'ukuran_baju', 'file_desain_baju'].forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            element.addEventListener('change', validateForm);
            element.addEventListener('input', validateForm);
        }
    });
    
    // Setup file previews
    setupFilePreview('file_desain_baju', 'preview_desain_baju', 'img_preview_desain_baju');
    setupFilePreview('file_desain_bordir', 'preview_desain_bordir', 'img_preview_desain_bordir');
    setupFilePreview('file_nama_tag', 'preview_nama_tag', 'img_preview_nama_tag');
    
    // Initialize
    handleCharacterCount();
    validateForm();
    
    // Trigger initial calculation if values are already selected
    if (layananSelect.value) {
        handleLayananChange();
    }
});
</script>
@endpush
@endsection
