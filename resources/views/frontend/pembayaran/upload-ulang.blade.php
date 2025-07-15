@extends('frontend.layouts.main')

@section('title', 'Upload Ulang Bukti Pembayaran')

@section('container')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Upload Ulang Bukti Pembayaran</h1>
            <p class="text-gray-600">Pesanan #{{ $pesanan->id }}</p>
        </div>

        <!-- Pesan Penolakan -->
        @if($pesanan->pembayaran->catatan_admin)
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <h3 class="font-medium text-red-800 mb-2">Alasan Penolakan:</h3>
            <p class="text-red-700">{{ $pesanan->pembayaran->catatan_admin }}</p>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Detail Pembayaran -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Detail Pembayaran</h2>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Metode Pembayaran:</span>
                        <span class="font-medium">{{ $pesanan->pembayaran->metode_pembayaran }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Pembayaran:</span>
                        <span class="font-medium text-blue-600">{{ $pesanan->pembayaran->formatted_total_harga }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Status:</span>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $pesanan->pembayaran->status_badge }}">
                            {{ ucfirst($pesanan->pembayaran->status_pembayaran) }}
                        </span>
                    </div>
                </div>

                <hr class="my-4">

                <!-- Informasi Transfer -->
                <h3 class="text-lg font-semibold text-gray-800 mb-3">Informasi Transfer</h3>
                @php
                    $bankInfo = App\Models\Pembayaran::getBankInfo($pesanan->pembayaran->metode_pembayaran);
                @endphp
                @if($bankInfo)
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="text-sm text-blue-700">
                        <div><strong>{{ $bankInfo['nama'] }}</strong></div>
                        <div>Nomor: {{ $bankInfo['nomor'] }}</div>
                        <div>Atas Nama: {{ $bankInfo['atas_nama'] }}</div>
                        <div class="mt-2 font-medium">Nominal: {{ $pesanan->pembayaran->formatted_total_harga }}</div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Form Upload Ulang -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Upload Bukti Pembayaran Baru</h2>

                <form action="{{ route('pembayaran.update-bukti', $pesanan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Upload Bukti Pembayaran -->
                    <div class="mb-6">
                        <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Bukti Pembayaran Baru <span class="text-red-500">*</span>
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

                <!-- Back Button -->
                <a href="{{ route('pesanan.riwayat') }}"
                   class="block w-full text-center bg-gray-200 text-gray-700 py-3 px-4 rounded-lg font-medium hover:bg-gray-300 transition duration-200 mt-3">
                    Kembali ke Riwayat Pesanan
                </a>
            </div>
        </div>

        <!-- Instruksi -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6">
            <h3 class="font-medium text-yellow-800 mb-2">Instruksi Upload Ulang:</h3>
            <ol class="text-sm text-yellow-700 space-y-1 list-decimal list-inside">
                <li>Pastikan bukti pembayaran jelas dan dapat dibaca</li>
                <li>Nominal transfer harus sesuai dengan total pembayaran</li>
                <li>Upload file dalam format JPG, PNG, atau PDF</li>
                <li>Ukuran file maksimal 5MB</li>
                <li>Tunggu verifikasi ulang dari admin</li>
            </ol>
        </div>
    </div>
</div>

<script>
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
