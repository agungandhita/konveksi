@extends('admin.layouts.main')

@section('title', 'Detail Pesanan #' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT))

@section('container')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800">
            Detail Pesanan #{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}
        </h1>
        <div class="flex space-x-2">
            <a href="{{ route('admin.pesanan.index') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-md hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informasi Pesanan -->
        <div class="space-y-6">
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-slate-800">Informasi Pesanan</h3>
                    @php
                        $statusClasses = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'diproses' => 'bg-blue-100 text-blue-800',
                            'selesai' => 'bg-green-100 text-green-800',
                            'dibatalkan' => 'bg-red-100 text-red-800'
                        ];
                    @endphp
                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $statusClasses[$pesanan->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($pesanan->status) }}
                    </span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div class="flex">
                                <span class="w-36 text-sm font-medium text-slate-600">ID Pesanan:</span>
                                <span class="text-sm text-slate-800">#{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-36 text-sm font-medium text-slate-600">Tanggal Pesanan:</span>
                                <span class="text-sm text-slate-800">{{ $pesanan->created_at->format('d F Y, H:i') }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-36 text-sm font-medium text-slate-600">Nama Pemesan:</span>
                                <span class="text-sm text-slate-800">{{ $pesanan->nama_pemesan }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-36 text-sm font-medium text-slate-600">Email:</span>
                                <span class="text-sm text-slate-800">{{ $pesanan->user->email }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-36 text-sm font-medium text-slate-600">Nomor WhatsApp:</span>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm text-slate-800">{{ $pesanan->nomor_whatsapp }}</span>
                                    <a href="https://wa.me/{{ $pesanan->formatted_whatsapp }}"
                                       target="_blank" class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-green-600 rounded hover:bg-green-700">
                                        <i class="fab fa-whatsapp mr-1"></i> Chat
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div class="flex">
                                <span class="w-36 text-sm font-medium text-slate-600">Layanan:</span>
                                <span class="text-sm text-slate-800">{{ $pesanan->layanan->nama_layanan }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-36 text-sm font-medium text-slate-600">Jumlah Order:</span>
                                <span class="text-sm text-slate-800">{{ $pesanan->jumlah_order }} {{ $pesanan->layanan->satuan_order }}</span>
                            </div>
                            <div class="flex">
                                <span class="w-36 text-sm font-medium text-slate-600">Ukuran Baju:</span>
                                <div>
                                    <span class="text-sm text-slate-800">{{ $pesanan->ukuran_baju }}</span>
                                    @if($pesanan->ukuran_custom)
                                        <div class="text-xs text-slate-500 mt-1">Custom: {{ $pesanan->ukuran_custom }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex">
                                <span class="w-36 text-sm font-medium text-slate-600">Tambahan Bordir:</span>
                                <div>
                                    @if($pesanan->tambahan_bordir)
                                        <span class="inline-flex px-2 py-1 text-xs font-medium text-green-800 bg-green-100 rounded-full">Ya</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-medium text-slate-800 bg-slate-100 rounded-full">Tidak</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex">
                                <span class="w-36 text-sm font-medium text-slate-600">Status:</span>
                                <div>
                                    <span class="inline-flex px-3 py-1 text-sm font-medium rounded-full {{ $statusClasses[$pesanan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($pesanan->status) }}
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($pesanan->keterangan_tambahan)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Keterangan Tambahan:</h4>
                            <div class="bg-slate-50 p-4 rounded-lg border">
                                <p class="text-sm text-slate-700 mb-0">{{ $pesanan->keterangan_tambahan }}</p>
                            </div>
                        </div>
                    @endif

                    @if($pesanan->tambahan_bordir && $pesanan->keterangan_bordir)
                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-slate-600 mb-2">Keterangan Bordir:</h4>
                            <div class="bg-slate-50 p-4 rounded-lg border">
                                <p class="text-sm text-slate-700 mb-0">{{ $pesanan->keterangan_bordir }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- File Upload -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="px-6 py-4 border-b border-slate-200">
                    <h3 class="text-lg font-semibold text-slate-800">File yang Diunggah</h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Desain Baju -->
                        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                            <div class="bg-blue-600 text-white px-4 py-3">
                                <h4 class="text-sm font-medium">Desain Baju</h4>
                            </div>
                            <div class="p-4 text-center">
                                @if($pesanan->file_desain_baju)
                                    @php
                                        $extension = pathinfo($pesanan->file_desain_baju, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    @endphp

                                    @if($isImage)
                                        <img src="{{ Storage::url($pesanan->file_desain_baju) }}"
                                             class="w-full h-32 object-cover rounded mb-3"
                                             alt="Desain Baju">
                                        @else
                                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                            <br><small>{{ strtoupper($extension) }} File</small>
                                        @endif

                                        <div class="mt-2">
                                            <a href="{{ route('admin.pesanan.download-file', [$pesanan->id, 'desain_baju']) }}"
                                               class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
                                                <i class="fas fa-download mr-2"></i> Download
                                            </a>
                                        </div>
                                    @else
                                        <i class="fas fa-image fa-3x text-gray-300 mb-2"></i>
                                        <br><small class="text-muted">Tidak ada file</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Desain Bordir -->
                        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                            <div class="bg-yellow-600 text-white px-4 py-3">
                                <h4 class="text-sm font-medium">Desain Bordir</h4>
                            </div>
                            <div class="p-4 text-center">
                                @if($pesanan->file_desain_bordir)
                                    @php
                                        $extension = pathinfo($pesanan->file_desain_bordir, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    @endphp

                                    @if($isImage)
                                        <img src="{{ Storage::url($pesanan->file_desain_bordir) }}"
                                             class="w-full h-32 object-cover rounded mb-3"
                                             alt="Desain Bordir">
                                    @else
                                        <i class="fas fa-file-pdf fa-3x text-red-500 mb-2"></i>
                                        <br><small>{{ strtoupper($extension) }} File</small>
                                    @endif

                                    <div class="mt-2">
                                        <a href="{{ route('admin.pesanan.download-file', [$pesanan->id, 'desain_bordir']) }}"
                                           class="inline-flex items-center px-3 py-2 bg-yellow-600 text-white text-sm font-medium rounded-md hover:bg-yellow-700 transition-colors">
                                            <i class="fas fa-download mr-2"></i> Download
                                        </a>
                                    </div>
                                @else
                                    <i class="fas fa-image fa-3x text-gray-300 mb-2"></i>
                                    <br><small class="text-gray-500">Tidak ada file</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Nama Tag - Moved to separate row -->
                    <div class="mt-4">
                        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                            <div class="bg-green-600 text-white px-4 py-3">
                                <h4 class="text-sm font-medium">Nama Tag</h4>
                            </div>
                            <div class="p-4 text-center">
                                @if($pesanan->file_nama_tag)
                                    @php
                                        $extension = pathinfo($pesanan->file_nama_tag, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']);
                                    @endphp

                                    @if($isImage)
                                        <img src="{{ Storage::url($pesanan->file_nama_tag) }}"
                                             class="w-full h-32 object-cover rounded mb-3"
                                             alt="Nama Tag">
                                    @else
                                        <i class="fas fa-file-pdf fa-3x text-red-500 mb-2"></i>
                                        <br><small>{{ strtoupper($extension) }} File</small>
                                    @endif

                                    <div class="mt-2">
                                        <a href="{{ route('admin.pesanan.download-file', [$pesanan->id, 'nama_tag']) }}"
                                           class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 transition-colors">
                                            <i class="fas fa-download mr-2"></i> Download
                                        </a>
                                    </div>
                                @else
                                    <i class="fas fa-tag fa-3x text-gray-300 mb-2"></i>
                                    <br><small class="text-gray-500">Tidak ada file</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Update Status -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 rounded-t-lg">
                    <h6 class="text-sm font-semibold text-slate-800 mb-0">Update Status</h6>
                </div>
                <div class="p-4">
                    <form method="POST" action="{{ route('admin.pesanan.update-status', $pesanan->id) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Pesanan</label>
                            <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>
                                    Pending
                                </option>
                                <option value="diproses" {{ $pesanan->status == 'diproses' ? 'selected' : '' }}>
                                    Diproses
                                </option>
                                <option value="selesai" {{ $pesanan->status == 'selesai' ? 'selected' : '' }}>
                                    Selesai
                                </option>
                                <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>
                                    Dibatalkan
                                </option>
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition-colors font-medium">
                            <i class="fas fa-save mr-2"></i> Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Informasi Layanan -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 rounded-t-lg">
                    <h6 class="text-sm font-semibold text-slate-800 mb-0">Informasi Layanan</h6>
                </div>
                <div class="p-4">
                    <table class="w-full text-sm">
                        <tr class="border-b border-gray-100">
                            <td class="py-2 pr-4 font-medium text-gray-700">Nama Layanan:</td>
                            <td class="py-2 text-gray-900">{{ $pesanan->layanan->nama_layanan }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-2 pr-4 font-medium text-gray-700">Estimasi Waktu:</td>
                            <td class="py-2 text-gray-900">{{ $pesanan->layanan->formatted_estimasi_waktu }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-2 pr-4 font-medium text-gray-700">Minimal Order:</td>
                            <td class="py-2 text-gray-900">{{ $pesanan->layanan->formatted_minimal_order }}</td>
                        </tr>
                        <tr>
                            <td class="py-2 pr-4 font-medium text-gray-700">Perkiraan Harga:</td>
                            <td class="py-2 text-gray-900">{{ $pesanan->layanan->formatted_harga }}</td>
                        </tr>
                    </table>

                    @if($pesanan->layanan->deskripsi_singkat)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <p class="font-medium text-gray-700 mb-2">Deskripsi:</p>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $pesanan->layanan->deskripsi_singkat }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline Status -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 rounded-t-lg">
                    <h6 class="text-sm font-semibold text-slate-800 mb-0">Timeline Status</h6>
                </div>
                <div class="p-4">
                    <div class="timeline">
                        <div class="timeline-item {{ $pesanan->status == 'pending' ? 'active' : 'completed' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="text-sm font-medium text-gray-800 mb-1">Pesanan Diterima</h6>
                                <small class="text-gray-500 text-xs">{{ $pesanan->created_at->format('d/m/Y H:i') }}</small>
                            </div>
                        </div>

                        <div class="timeline-item {{ $pesanan->status == 'diproses' ? 'active' : ($pesanan->status == 'selesai' ? 'completed' : '') }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="text-sm font-medium text-gray-800 mb-1">Sedang Diproses</h6>
                                <small class="text-gray-500 text-xs">
                                    @if(in_array($pesanan->status, ['diproses', 'selesai']))
                                        {{ $pesanan->updated_at->format('d/m/Y H:i') }}
                                    @else
                                        Menunggu...
                                    @endif
                                </small>
                            </div>
                        </div>

                        <div class="timeline-item {{ $pesanan->status == 'selesai' ? 'active completed' : '' }}">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <h6 class="text-sm font-medium text-gray-800 mb-1">Pesanan Selesai</h6>
                                <small class="text-gray-500 text-xs">
                                    @if($pesanan->status == 'selesai')
                                        {{ $pesanan->updated_at->format('d/m/Y H:i') }}
                                    @else
                                        Menunggu...
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white rounded-lg shadow-sm border border-slate-200">
                <div class="bg-slate-50 px-4 py-3 border-b border-slate-200 rounded-t-lg">
                    <h6 class="text-sm font-semibold text-slate-800 mb-0">Aksi Cepat</h6>
                </div>
                <div class="p-4">
                    <div class="space-y-3">
                        <a href="https://wa.me/{{ $pesanan->formatted_whatsapp }}?text={{ urlencode($pesanan->generateWhatsappMessage()) }}"
                           target="_blank" class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 transition-colors">
                            <i class="fab fa-whatsapp mr-2"></i> Chat WhatsApp
                        </a>

                        <a href="mailto:{{ $pesanan->user->email }}?subject=Pesanan%20%23{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}"
                           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-medium rounded-md hover:bg-blue-700 transition-colors">
                            <i class="fas fa-envelope mr-2"></i> Kirim Email
                        </a>

                        <form method="POST" action="{{ route('admin.pesanan.destroy', $pesanan->id) }}"
                              class="w-full" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition-colors">
                                <i class="fas fa-trash mr-2"></i> Hapus Pesanan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: #e5e7eb;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -23px;
    top: 5px;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: #e5e7eb;
    border: 3px solid #fff;
    box-shadow: 0 0 0 2px #e5e7eb;
    transition: all 0.3s ease;
}

.timeline-item.active .timeline-marker {
    background: #f59e0b;
    box-shadow: 0 0 0 2px #f59e0b;
}

.timeline-item.completed .timeline-marker {
    background: #10b981;
    box-shadow: 0 0 0 2px #10b981;
}

.timeline-content {
    padding-left: 8px;
}
</style>
@endpush
