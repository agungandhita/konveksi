@extends('frontend.layouts.main')

@section('title', 'Pembayaran Pesanan')

@section('container')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Pembayaran Pesanan</h1>
            <p class="text-gray-600">Silakan lakukan pembayaran untuk melanjutkan pesanan Anda</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Detail Pesanan -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Pesanan</h2>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Pesanan:</span>
                        <span class="font-medium">#{{ $pesanan->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Layanan:</span>
                        <span class="font-medium">{{ $pesanan->layanan->nama_layanan }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Jumlah:</span>
                        <span class="font-medium">{{ $pesanan->jumlah_order }} pcs</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Ukuran:</span>
                        <span class="font-medium">{{ $pesanan->ukuran_baju }}{{ $pesanan->ukuran_custom ? ' (' . $pesanan->ukuran_custom . ')' : '' }}</span>
                    </div>
                    @if($pesanan->tambahan_bordir)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Bordir:</span>
                        <span class="font-medium text-green-600">Ya</span>
                    </div>
                    @endif
                </div>

                <hr class="my-4">

                <!-- Rincian Harga -->
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Rincian Harga</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Harga Layanan ({{ $pesanan->jumlah_order }} pcs):</span>
                        <span>Rp {{ number_format($pesanan->layanan->perkiraan_harga * $pesanan->jumlah_order, 0, ',', '.') }}</span>
                    </div>
                    @if($pesanan->tambahan_bordir)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Harga Bordir ({{ $pesanan->jumlah_order }} pcs):</span>
                        <span>{{ $pesanan->formatted_harga_bordir }}</span>
                    </div>
                    @endif
                    <hr class="my-2">
                    <div class="flex justify-between text-lg font-bold text-blue-600">
                        <span>Total Pembayaran:</span>
                        <span>{{ $pesanan->formatted_total_harga }}</span>
                    </div>
                </div>
            </div>

            <!-- Form Pembayaran -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Pilih Metode Pembayaran</h2>

                <form action="{{ route('pembayaran.store', $pesanan->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                    @csrf

                    <!-- Metode Pembayaran -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran</label>
                        <div class="space-y-3">
                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 payment-method" data-method="DANA">
                                <input type="radio" name="metode_pembayaran" value="DANA" class="mr-3" required>
                                <div class="flex-1">
                                    <div class="font-medium">DANA</div>
                                    <div class="text-sm text-gray-500">Transfer via DANA</div>
                                </div>
                            </label>

                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 payment-method" data-method="MANDIRI">
                                <input type="radio" name="metode_pembayaran" value="MANDIRI" class="mr-3" required>
                                <div class="flex-1">
                                    <div class="font-medium">Bank Mandiri</div>
                                    <div class="text-sm text-gray-500">Transfer via Bank Mandiri</div>
                                </div>
                            </label>

                            <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50 payment-method" data-method="BCA">
                                <input type="radio" name="metode_pembayaran" value="BCA" class="mr-3" required>
                                <div class="flex-1">
                                    <div class="font-medium">Bank BCA</div>
                                    <div class="text-sm text-gray-500">Transfer via Bank BCA</div>
                                </div>
                            </label>
                        </div>
                        @error('metode_pembayaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Informasi Rekening -->
                    <div id="bankInfo" class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg" style="display: none;">
                        <h3 class="font-medium text-blue-800 mb-2">Informasi Transfer</h3>
                        <div id="bankDetails" class="text-sm text-blue-700"></div>
                        <div class="mt-2 text-xs text-blue-600">
                            <strong>Catatan:</strong> Pastikan nominal transfer sesuai dengan total pembayaran
                        </div>
                    </div>

                    <!-- Upload Bukti Pembayaran -->
                    <div class="mb-6">
                        <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Bukti Pembayaran <span class="text-red-500">*</span>
                        </label>
                        <input type="file"
                               id="bukti_pembayaran"
                               name="bukti_pembayaran"
                               accept=".jpg,.jpeg,.png,.pdf"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF. Maksimal 5MB</p>
                        @error('bukti_pembayaran')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror

                        <!-- Preview -->
                        <div id="filePreview" class="mt-3" style="display: none;">
                            <img id="imagePreview" class="max-w-xs h-auto rounded-lg" style="display: none;">
                            <div id="fileInfo" class="text-sm text-gray-600"></div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition duration-200">
                        Upload Bukti Pembayaran
                    </button>
                </form>
            </div>
        </div>

        <!-- Instruksi -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6">
            <h3 class="font-medium text-yellow-800 mb-2">Instruksi Pembayaran:</h3>
            <ol class="text-sm text-yellow-700 space-y-1 list-decimal list-inside">
                <li>Pilih metode pembayaran yang diinginkan</li>
                <li>Transfer sesuai nominal yang tertera ke rekening yang ditampilkan</li>
                <li>Upload bukti pembayaran (screenshot/foto struk)</li>
                <li>Tunggu verifikasi dari admin (maksimal 1x24 jam)</li>
                <li>Pesanan akan diproses setelah pembayaran diverifikasi</li>
            </ol>
        </div>
    </div>
</div>

<script>
// Data rekening bank
const bankData = {
    'DANA': {
        nama: 'DANA',
        nomor: '081234567890',
        atas_nama: 'CV. Konveksi Berkah'
    },
    'MANDIRI': {
        nama: 'Bank Mandiri',
        nomor: '1234567890123',
        atas_nama: 'CV. Konveksi Berkah'
    },
    'BCA': {
        nama: 'Bank BCA',
        nomor: '1234567890',
        atas_nama: 'CV. Konveksi Berkah'
    }
};

// Handle payment method selection
document.querySelectorAll('input[name="metode_pembayaran"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const method = this.value;
        const bankInfo = document.getElementById('bankInfo');
        const bankDetails = document.getElementById('bankDetails');

        if (bankData[method]) {
            const data = bankData[method];
            bankDetails.innerHTML = `
                <div><strong>${data.nama}</strong></div>
                <div>Nomor: ${data.nomor}</div>
                <div>Atas Nama: ${data.atas_nama}</div>
                <div class="mt-2 font-medium">Nominal: {{ $pesanan->formatted_total_harga }}</div>
            `;
            bankInfo.style.display = 'block';
        }
    });
});

// Handle file input preview
document.getElementById('bukti_pembayaran').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('filePreview');
    const imagePreview = document.getElementById('imagePreview');
    const fileInfo = document.getElementById('fileInfo');

    if (file) {
        preview.style.display = 'block';
        fileInfo.textContent = `File: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;

        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.style.display = 'none';
        }
    } else {
        preview.style.display = 'none';
        imagePreview.style.display = 'none';
    }
});
</script>
@endsection
