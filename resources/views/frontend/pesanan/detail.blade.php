@extends('frontend.layouts.main')

@section('container')
<!-- Breadcrumb -->
<div class="bg-gray-50 py-4">
    <div class="max-w-6xl mx-auto px-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('pesanan.riwayat') }}" class="inline-flex items-center text-sm font-medium text-slate-600 hover:text-slate-800">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Riwayat Pesanan
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Detail Pesanan #{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Detail Section -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        Detail Pesanan #{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}
                    </h1>
                    <p class="text-gray-600">Dibuat pada {{ $pesanan->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                <div class="mt-4 sm:mt-0">
                    <span class="inline-flex px-4 py-2 rounded-full text-sm font-medium {{ $pesanan->status_badge }}">
                        {{ ucfirst($pesanan->status) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Informasi Pesanan -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">Informasi Pesanan</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Nama Pemesan</label>
                                <p class="text-gray-900 font-semibold">{{ $pesanan->nama_pemesan }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Layanan</label>
                                <p class="text-gray-900 font-semibold">{{ $pesanan->layanan->nama_layanan }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Jumlah Order</label>
                                <p class="text-gray-900 font-semibold">{{ $pesanan->jumlah_order }} pcs</p>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Nomor WhatsApp</label>
                                <p class="text-gray-900 font-semibold">{{ $pesanan->nomor_whatsapp }}</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Ukuran Baju</label>
                                <p class="text-gray-900 font-semibold">
                                    {{ $pesanan->ukuran_baju }}
                                    @if($pesanan->ukuran_baju === 'Custom' && $pesanan->ukuran_custom)
                                        <span class="text-sm text-gray-500 block">({{ $pesanan->ukuran_custom }})</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Tambahan Bordir</label>
                                <p class="text-gray-900 font-semibold">
                                    {{ $pesanan->tambahan_bordir ? 'Ya' : 'Tidak' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @if($pesanan->keterangan_tambahan)
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <label class="block text-sm font-medium text-gray-600 mb-2">Keterangan Tambahan</label>
                            <p class="text-gray-700">{{ $pesanan->keterangan_tambahan }}</p>
                        </div>
                    @endif
                    
                    @if($pesanan->tambahan_bordir && $pesanan->keterangan_bordir)
                        <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                            <label class="block text-sm font-medium text-gray-600 mb-2">Keterangan Bordir</label>
                            <p class="text-gray-700">{{ $pesanan->keterangan_bordir }}</p>
                        </div>
                    @endif
                </div>

                <!-- File yang Diunggah -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-xl font-bold text-gray-900 mb-6">File yang Diunggah</h2>
                    
                    <div class="space-y-6">
                        <!-- Desain Baju -->
                        @if($pesanan->file_desain_baju)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-3">Desain Baju</label>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    @if(in_array(pathinfo($pesanan->file_desain_baju, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ Storage::url($pesanan->file_desain_baju) }}" 
                                             alt="Desain Baju" 
                                             class="max-w-full h-auto max-h-64 rounded-lg mx-auto">
                                    @else
                                        <div class="flex items-center space-x-3 text-gray-600">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>{{ basename($pesanan->file_desain_baju) }}</span>
                                        </div>
                                    @endif
                                    <div class="mt-3">
                                        <a href="{{ Storage::url($pesanan->file_desain_baju) }}" 
                                           target="_blank"
                                           class="inline-flex items-center space-x-2 text-slate-600 hover:text-slate-800 font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>Download File</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Desain Bordir -->
                        @if($pesanan->tambahan_bordir && $pesanan->file_desain_bordir)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-3">Desain Bordir</label>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    @if(in_array(pathinfo($pesanan->file_desain_bordir, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ Storage::url($pesanan->file_desain_bordir) }}" 
                                             alt="Desain Bordir" 
                                             class="max-w-full h-auto max-h-64 rounded-lg mx-auto">
                                    @else
                                        <div class="flex items-center space-x-3 text-gray-600">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>{{ basename($pesanan->file_desain_bordir) }}</span>
                                        </div>
                                    @endif
                                    <div class="mt-3">
                                        <a href="{{ Storage::url($pesanan->file_desain_bordir) }}" 
                                           target="_blank"
                                           class="inline-flex items-center space-x-2 text-slate-600 hover:text-slate-800 font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>Download File</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Nama Tag -->
                        @if($pesanan->file_nama_tag)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-3">Nama Tag</label>
                                <div class="border border-gray-200 rounded-lg p-4">
                                    @if(in_array(pathinfo($pesanan->file_nama_tag, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                                        <img src="{{ Storage::url($pesanan->file_nama_tag) }}" 
                                             alt="Nama Tag" 
                                             class="max-w-full h-auto max-h-64 rounded-lg mx-auto">
                                    @else
                                        <div class="flex items-center space-x-3 text-gray-600">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>{{ basename($pesanan->file_nama_tag) }}</span>
                                        </div>
                                    @endif
                                    <div class="mt-3">
                                        <a href="{{ Storage::url($pesanan->file_nama_tag) }}" 
                                           target="_blank"
                                           class="inline-flex items-center space-x-2 text-slate-600 hover:text-slate-800 font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span>Download File</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Timeline -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Status Pesanan</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 {{ $pesanan->status === 'pending' ? 'bg-yellow-500' : 'bg-gray-300' }} rounded-full"></div>
                            <span class="text-sm {{ $pesanan->status === 'pending' ? 'font-semibold text-yellow-700' : 'text-gray-500' }}">Pending</span>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 {{ $pesanan->status === 'diproses' ? 'bg-blue-500' : 'bg-gray-300' }} rounded-full"></div>
                            <span class="text-sm {{ $pesanan->status === 'diproses' ? 'font-semibold text-blue-700' : 'text-gray-500' }}">Diproses</span>
                        </div>
                        
                        <div class="flex items-center space-x-3">
                            <div class="w-3 h-3 {{ $pesanan->status === 'selesai' ? 'bg-green-500' : 'bg-gray-300' }} rounded-full"></div>
                            <span class="text-sm {{ $pesanan->status === 'selesai' ? 'font-semibold text-green-700' : 'text-gray-500' }}">Selesai</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Aksi</h3>
                    
                    <div class="space-y-3">
                        @if($pesanan->status === 'pending')
                            <a href="https://wa.me/{{ $pesanan->formatted_whatsapp }}?text={{ $pesanan->generateWhatsappMessage() }}" 
                               target="_blank"
                               class="w-full inline-flex items-center justify-center space-x-2 bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                                </svg>
                                <span>Hubungi via WhatsApp</span>
                            </a>
                        @endif
                        
                        <a href="{{ route('pesanan.riwayat') }}" 
                           class="w-full inline-flex items-center justify-center space-x-2 bg-slate-600 hover:bg-slate-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            <span>Kembali ke Riwayat</span>
                        </a>
                        
                        <a href="{{ route('pesanan.index') }}" 
                           class="w-full inline-flex items-center justify-center space-x-2 bg-white hover:bg-gray-50 text-slate-600 font-semibold py-3 px-4 rounded-lg border-2 border-slate-600 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span>Buat Pesanan Baru</span>
                        </a>
                    </div>
                </div>

                <!-- Info Layanan -->
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Info Layanan</h3>
                    
                    <div class="space-y-3">
                        @if($pesanan->layanan->estimasi_waktu)
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>Estimasi: {{ $pesanan->layanan->formatted_estimasi }}</span>
                            </div>
                        @endif
                        
                        @if($pesanan->layanan->minimal_order)
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <span>Min. Order: {{ $pesanan->layanan->formatted_minimal_order }}</span>
                            </div>
                        @endif
                        
                        @if($pesanan->layanan->perkiraan_harga)
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                                <span>Mulai dari: {{ $pesanan->layanan->formatted_harga }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection