@extends('frontend.layouts.main')

@section('container')
<!-- Success Section -->
<section class="py-20 bg-gradient-to-br from-green-50 to-green-100">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <!-- Success Icon -->
        <div class="mb-8">
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                Pesanan Berhasil Dikirim!
            </h1>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                Terima kasih! Pesanan Anda telah berhasil dikirim. Silakan lanjutkan ke WhatsApp untuk konfirmasi dengan tim kami.
            </p>
        </div>

        <!-- Order Summary Card -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 text-left">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 text-center">Ringkasan Pesanan</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">ID Pesanan:</span>
                        <span class="font-semibold text-gray-900">#{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Nama Pemesan:</span>
                        <span class="font-semibold text-gray-900">{{ $pesanan->nama_pemesan }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Layanan:</span>
                        <span class="font-semibold text-gray-900">{{ $pesanan->layanan->nama_layanan }}</span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Jumlah Order:</span>
                        <span class="font-semibold text-gray-900">{{ $pesanan->jumlah_order }} pcs</span>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Ukuran:</span>
                        <span class="font-semibold text-gray-900">
                            {{ $pesanan->ukuran_baju }}
                        @if($pesanan->ukuran_custom)
                            (Custom: {{ $pesanan->ukuran_custom }})
                        @endif
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Tambahan Bordir:</span>
                        <span class="font-semibold text-gray-900">
                            {{ $pesanan->tambahan_bordir ? 'Ya' : 'Tidak' }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Status:</span>
                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            Pending
                        </span>
                    </div>

                    <div class="flex justify-between items-center py-2 border-b border-gray-100">
                        <span class="font-medium text-gray-600">Tanggal Pesanan:</span>
                        <span class="font-semibold text-gray-900">{{ $pesanan->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
            </div>

            @if($pesanan->keterangan_tambahan)
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="font-medium text-gray-700 mb-2">Keterangan Tambahan:</h4>
                    <p class="text-gray-600">{{ $pesanan->keterangan_tambahan }}</p>
                </div>
            @endif
        </div>

        <!-- WhatsApp Button -->
        <div class="space-y-4">
            <a href="https://wa.me/{{ $pesanan->formatted_whatsapp }}?text={{ $pesanan->generateWhatsappMessage() }}"
               target="_blank"
               class="inline-flex items-center justify-center space-x-3 bg-green-600 hover:bg-green-700 text-white font-semibold py-4 px-8 rounded-xl transition-colors duration-200 text-lg">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
                <span>Lanjutkan ke WhatsApp</span>
            </a>

            <p class="text-sm text-gray-600">
                Klik tombol di atas untuk melanjutkan konfirmasi pesanan melalui WhatsApp
            </p>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('pembayaran.index', $pesanan->id) }}"
               class="inline-flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span>Lanjut ke Pembayaran</span>
            </a>

            <a href="{{ route('pesanan.riwayat') }}"
               class="inline-flex items-center justify-center space-x-2 bg-slate-600 hover:bg-slate-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span>Lihat Riwayat Pesanan</span>
            </a>
        </div>
    </div>
</section>

<!-- Information Section -->
<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">Langkah Selanjutnya</h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">1. Konfirmasi WhatsApp</h3>
                <p class="text-gray-600">Klik tombol WhatsApp untuk konfirmasi pesanan dengan tim kami</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">2. Proses Verifikasi</h3>
                <p class="text-gray-600">Tim kami akan memverifikasi detail pesanan dan memberikan estimasi harga</p>
            </div>

            <div class="text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">3. Mulai Produksi</h3>
                <p class="text-gray-600">Setelah deal, kami akan mulai proses produksi sesuai spesifikasi</p>
            </div>
        </div>
    </div>
</section>
@endsection
