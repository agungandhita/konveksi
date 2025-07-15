@extends('frontend.layouts.main')

@section('container')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-100 to-slate-200 py-20">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
            Riwayat <span class="text-slate-700">Pesanan</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Lihat semua pesanan yang pernah Anda buat dan status terkininya
        </p>
    </div>
</section>

<!-- Riwayat Section -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        @if($pesanan->count() > 0)
            <!-- Action Buttons -->
            <div class="mb-8 flex flex-col sm:flex-row gap-4 justify-between items-center">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <span class="text-gray-600 font-medium">Total: {{ $pesanan->total() }} pesanan</span>
                </div>

                <a href="{{ route('pesanan.index') }}"
                   class="inline-flex items-center space-x-2 bg-slate-600 hover:bg-slate-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span>Buat Pesanan Baru</span>
                </a>
            </div>

            <!-- Orders List -->
            <div class="space-y-6">
                @foreach($pesanan as $item)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <div class="p-6">
                            <!-- Header -->
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4">
                                <div class="flex items-center space-x-3 mb-2 sm:mb-0">
                                    <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-900">
                                            Pesanan #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                        </h3>
                                        <p class="text-sm text-gray-500">{{ $item->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-center space-x-3">
                                    <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $item->status_badge }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                    @if($item->pembayaran)
                                        <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $item->pembayaran->status_badge }}">
                                            {{ ucfirst(str_replace('_', ' ', $item->pembayaran->status_pembayaran)) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Layanan</p>
                                    <p class="text-gray-900 font-semibold">{{ $item->layanan->nama_layanan }}</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Jumlah Order</p>
                                    <p class="text-gray-900 font-semibold">{{ $item->jumlah_order }} pcs</p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Ukuran</p>
                                    <p class="text-gray-900 font-semibold">
                                        {{ $item->ukuran_baju }}
                                        @if($item->ukuran_baju === 'Custom' && $item->ukuran_custom)
                                            <span class="text-sm text-gray-500">({{ $item->ukuran_custom }})</span>
                                        @endif
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-600 mb-1">Tambahan Bordir</p>
                                    <p class="text-gray-900 font-semibold">
                                        {{ $item->tambahan_bordir ? 'Ya' : 'Tidak' }}
                                    </p>
                                </div>
                            </div>

                            @if($item->keterangan_tambahan)
                                <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Keterangan Tambahan:</p>
                                    <p class="text-gray-700">{{ $item->keterangan_tambahan }}</p>
                                </div>
                            @endif

                            <!-- Payment Info -->
                            @if($item->total_harga)
                                <div class="mb-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-medium text-blue-800">Total Pembayaran:</span>
                                        <span class="text-lg font-bold text-blue-900">{{ $item->formatted_total_harga }}</span>
                                    </div>
                                    @if($item->pembayaran && $item->pembayaran->metode_pembayaran)
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-sm text-blue-700">Metode:</span>
                                            <span class="text-sm font-medium text-blue-800">{{ strtoupper($item->pembayaran->metode_pembayaran) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('pesanan.show', $item->id) }}"
                                   class="inline-flex items-center justify-center space-x-2 bg-slate-600 hover:bg-slate-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    <span>Detail</span>
                                </a>

                                @if($item->status === 'menunggu_pembayaran')
                                    <a href="{{ route('pembayaran.index', $item->id) }}"
                                       class="inline-flex items-center justify-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>Bayar Sekarang</span>
                                    </a>
                                @endif

                                @if($item->pembayaran && $item->pembayaran->status_pembayaran === 'ditolak')
                                    <a href="{{ route('pembayaran.upload-ulang', $item->id) }}"
                                       class="inline-flex items-center justify-center space-x-2 bg-orange-600 hover:bg-orange-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <span>Upload Ulang</span>
                                    </a>
                                @endif

                                @if($item->status === 'pending')
                                    <a href="https://wa.me/{{ $item->formatted_whatsapp }}?text={{ $item->generateWhatsappMessage() }}"
                                       target="_blank"
                                       class="inline-flex items-center justify-center space-x-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                        </svg>
                                        <span>WhatsApp</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($pesanan->hasPages())
                <div class="mt-12">
                    {{ $pesanan->links() }}
                </div>
            @endif

        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="max-w-md mx-auto">
                    <svg class="mx-auto h-24 w-24 text-gray-400 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Belum Ada Pesanan</h3>
                    <p class="text-gray-500 mb-6">Anda belum pernah membuat pesanan. Mulai buat pesanan pertama Anda sekarang!</p>

                    <a href="{{ route('pesanan.index') }}"
                       class="inline-flex items-center space-x-2 bg-slate-600 hover:bg-slate-700 text-white font-semibold py-3 px-6 rounded-xl transition-colors duration-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Buat Pesanan Pertama</span>
                    </a>
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
