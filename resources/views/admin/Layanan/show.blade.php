@extends('admin.layouts.main')

@section('title', 'Detail Layanan')

@section('container')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header dengan animasi -->
    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-8 gap-4 animate-fade-in">
        <div>
            <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">Detail Layanan</h1>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.layanan.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                            <i class="fas fa-home mr-1"></i>Kelola Layanan
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $layanan->nama_layanan }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('admin.layanan.edit', $layanan) }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white text-sm font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="fas fa-edit mr-2"></i>Edit Layanan
            </a>
            <a href="{{ route('admin.layanan.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white text-sm font-medium rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>
    </div>


                </button>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in-up">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Layanan Info Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 mb-8 border border-white/20">
                <div class="flex justify-between items-center px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-t-2xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-info-circle text-white"></i>
                        </div>
                        <h6 class="text-xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Informasi Layanan</h6>
                    </div>
                    @if($layanan->status === 'aktif')
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200 shadow-sm">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></div>Aktif
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200 shadow-sm">
                            <div class="w-2 h-2 bg-gray-500 rounded-full mr-2"></div>Non-Aktif
                        </span>
                    @endif
                </div>
                <div class="p-8">
                    <div class="mb-8">
                        <h4 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3">{{ $layanan->nama_layanan }}</h4>
                        @if($layanan->deskripsi_singkat)
                            <p class="text-gray-700 text-lg leading-relaxed">{{ $layanan->deskripsi_singkat }}</p>
                        @else
                            <p class="text-gray-500 italic text-lg">Tidak ada deskripsi</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Estimasi Waktu -->
                        <div class="transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center p-6 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl border border-blue-200 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-clock text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-5 flex-1">
                                    <h6 class="text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">Estimasi Waktu</h6>
                                    <p class="text-xl font-bold text-blue-700">{{ $layanan->formatted_estimasi }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Minimal Order -->
                        <div class="transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center p-6 bg-gradient-to-br from-yellow-50 to-orange-100 rounded-xl border border-yellow-200 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 bg-gradient-to-r from-yellow-500 to-orange-500 text-white rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-shopping-cart text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-5 flex-1">
                                    <h6 class="text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">Minimal Order</h6>
                                    <p class="text-xl font-bold text-orange-700">{{ $layanan->formatted_minimal_order }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Perkiraan Harga -->
                        <div class="md:col-span-2 transform hover:scale-105 transition-transform duration-200">
                            <div class="flex items-center p-6 bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl border border-green-200 shadow-lg hover:shadow-xl transition-shadow duration-300">
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-money-bill-wave text-xl"></i>
                                    </div>
                                </div>
                                <div class="ml-5 flex-1">
                                    <h6 class="text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wide">Perkiraan Harga</h6>
                                    @if($layanan->perkiraan_harga)
                                        <p class="text-2xl font-bold text-green-700">{{ $layanan->formatted_harga }}</p>
                                    @else
                                        <p class="text-gray-600 italic text-lg">Harga berdasarkan konsultasi</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Timeline/History Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-white/20">
                <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-purple-50 to-pink-50 rounded-t-2xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-history text-white"></i>
                        </div>
                        <h6 class="text-xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent">Riwayat Aktivitas</h6>
                    </div>
                </div>
                <div class="p-8">
                    <div class="relative pl-10">
                        <div class="relative pb-8">
                            <div class="absolute left-0 top-2 w-4 h-4 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full border-3 border-white shadow-lg animate-pulse"></div>
                            <div class="absolute left-2 top-6 w-0.5 h-full bg-gradient-to-b from-green-300 to-blue-300"></div>
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-200">
                                <h6 class="text-base font-bold text-gray-900 mb-2 flex items-center">
                                    <i class="fas fa-plus-circle text-green-600 mr-2"></i>Layanan Dibuat
                                </h6>
                                <p class="text-sm text-gray-700 font-medium">{{ $layanan->created_at->format('d F Y, H:i') }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $layanan->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($layanan->updated_at != $layanan->created_at)
                        <div class="relative">
                            <div class="absolute left-0 top-2 w-4 h-4 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full border-3 border-white shadow-lg"></div>
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                                <h6 class="text-base font-bold text-gray-900 mb-2 flex items-center">
                                    <i class="fas fa-edit text-blue-600 mr-2"></i>Terakhir Diperbarui
                                </h6>
                                <p class="text-sm text-gray-700 font-medium">{{ $layanan->updated_at->format('d F Y, H:i') }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ $layanan->updated_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Quick Actions Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-white/20">
                <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-indigo-50 to-blue-50 rounded-t-2xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-bolt text-white"></i>
                        </div>
                        <h6 class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent">Aksi Cepat</h6>
                    </div>
                </div>
                <div class="p-8">
                    <div class="space-y-4">
                        <a href="{{ route('admin.layanan.edit', $layanan) }}" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                            <i class="fas fa-edit mr-3"></i>Edit Layanan
                        </a>

                        <form method="POST" action="{{ route('admin.layanan.toggle-status', $layanan) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-4 {{ $layanan->status === 'aktif' ? 'bg-gradient-to-r from-yellow-100 to-orange-100 border-2 border-yellow-400 text-yellow-700 hover:from-yellow-200 hover:to-orange-200' : 'bg-gradient-to-r from-green-100 to-emerald-100 border-2 border-green-400 text-green-700 hover:from-green-200 hover:to-emerald-200' }} text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200">
                                <i class="fas fa-{{ $layanan->status === 'aktif' ? 'pause' : 'play' }} mr-3"></i>
                                {{ $layanan->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>

                        <div class="border-t border-gray-200 pt-4">
                            <button type="button" class="w-full inline-flex items-center justify-center px-6 py-4 bg-gradient-to-r from-red-100 to-pink-100 border-2 border-red-400 text-red-700 hover:from-red-200 hover:to-pink-200 text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200" onclick="openDeleteModal()">
                                <i class="fas fa-trash mr-3"></i>Hapus Layanan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-white/20">
                <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-cyan-50 to-blue-50 rounded-t-2xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-cyan-500 to-blue-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-chart-bar text-white"></i>
                        </div>
                        <h6 class="text-xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-transparent">Statistik Layanan</h6>
                    </div>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-2 gap-6 text-center">
                        <div class="transform hover:scale-105 transition-transform duration-200">
                            <div class="bg-gradient-to-br from-blue-50 to-indigo-100 p-4 rounded-xl border border-blue-200">
                                <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-calendar-alt text-white"></i>
                                </div>
                                <h4 class="text-3xl font-bold text-blue-600 mb-2">{{ $layanan->estimasi_waktu }}</h4>
                                <small class="text-gray-600 font-semibold uppercase tracking-wide">Hari Pengerjaan</small>
                            </div>
                        </div>
                        <div class="transform hover:scale-105 transition-transform duration-200">
                            <div class="bg-gradient-to-br from-yellow-50 to-orange-100 p-4 rounded-xl border border-yellow-200">
                                <div class="w-12 h-12 bg-gradient-to-r from-yellow-500 to-orange-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-box text-white"></i>
                                </div>
                                <h4 class="text-3xl font-bold text-orange-600 mb-2">{{ $layanan->minimal_order }}</h4>
                                <small class="text-gray-600 font-semibold uppercase tracking-wide">Min. Order</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Card -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 border border-white/20">
                <div class="px-8 py-6 border-b border-gray-100 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-t-2xl">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-info text-white"></i>
                        </div>
                        <h6 class="text-xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">Detail Informasi</h6>
                    </div>
                </div>
                <div class="p-8">
                    <div class="space-y-6">
                        <div class="bg-gradient-to-r from-gray-50 to-slate-50 p-4 rounded-xl border border-gray-200">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-hashtag text-gray-600 mr-2"></i>
                                <small class="text-gray-600 font-semibold uppercase tracking-wide">ID Layanan</small>
                            </div>
                            <strong class="text-gray-900 text-lg">#{{ str_pad($layanan->id, 4, '0', STR_PAD_LEFT) }}</strong>
                        </div>
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-xl border border-blue-200">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-ruler text-blue-600 mr-2"></i>
                                <small class="text-blue-600 font-semibold uppercase tracking-wide">Satuan Order</small>
                            </div>
                            <strong class="text-blue-900 text-lg">{{ ucfirst($layanan->satuan_order) }}</strong>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="bg-gradient-to-r from-green-50 to-emerald-50 p-4 rounded-xl border border-green-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-calendar-plus text-green-600 mr-2"></i>
                                    <small class="text-green-600 font-semibold uppercase tracking-wide">Dibuat</small>
                                </div>
                                <strong class="text-green-900 text-sm">{{ $layanan->created_at->diffForHumans() }}</strong>
                            </div>
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 p-4 rounded-xl border border-purple-200">
                                <div class="flex items-center mb-2">
                                    <i class="fas fa-calendar-check text-purple-600 mr-2"></i>
                                    <small class="text-purple-600 font-semibold uppercase tracking-wide">Diperbarui</small>
                                </div>
                                <strong class="text-purple-900 text-sm">{{ $layanan->updated_at->diffForHumans() }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden transition-all duration-300">
    <div class="relative top-20 mx-auto p-6 border w-96 shadow-2xl rounded-2xl bg-white/90 backdrop-blur-md transform transition-all duration-300 scale-95 opacity-0" id="modalContent">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-pink-600 rounded-full flex items-center justify-center mr-3">
                        <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                    <h5 class="text-xl font-bold bg-gradient-to-r from-red-600 to-pink-600 bg-clip-text text-transparent">Konfirmasi Hapus</h5>
                </div>
                <button type="button" class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-2 rounded-full hover:bg-red-50" onclick="closeDeleteModal()">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 p-4 rounded-xl border border-red-200">
                <p class="text-gray-700 mb-2">Apakah Anda yakin ingin menghapus layanan <strong class="text-red-700">{{ $layanan->nama_layanan }}</strong>?</p>
                <p class="text-red-600 text-sm font-medium flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" class="px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200" onclick="closeDeleteModal()">Batal</button>
                <form method="POST" action="{{ route('admin.layanan.destroy', $layanan) }}" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white text-sm font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">Hapus Layanan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Custom animations and styles */
@keyframes fade-in {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fade-in-up {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slide-down {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fade-in 0.6s ease-out;
}

.animate-fade-in-up {
    animation: fade-in-up 0.8s ease-out;
}

.animate-slide-down {
    animation: slide-down 0.5s ease-out;
}

/* Glass morphism effect */
.backdrop-blur-sm {
    backdrop-filter: blur(8px);
}

.backdrop-blur-md {
    backdrop-filter: blur(12px);
}

/* Custom border width */
.border-3 {
    border-width: 3px;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Custom gradient text */
.bg-clip-text {
    -webkit-background-clip: text;
    background-clip: text;
}
</style>
@endpush

@push('scripts')
<script>
// Delete layanan function
function openDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('modalContent');
    
    modal.classList.remove('hidden');
    
    // Trigger animation
    setTimeout(() => {
        modalContent.classList.remove('scale-95', 'opacity-0');
        modalContent.classList.add('scale-100', 'opacity-100');
    }, 10);
}

// Close delete modal function
function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    const modalContent = document.getElementById('modalContent');
    
    // Animate out
    modalContent.classList.remove('scale-100', 'opacity-100');
    modalContent.classList.add('scale-95', 'opacity-0');
    
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Close modal when clicking outside
    document.getElementById('deleteModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });

    // Add entrance animations to cards
    const cards = document.querySelectorAll('.bg-white\/80');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });

    // Auto-hide alerts after 5 seconds with smooth animation
    setTimeout(function() {
        const alerts = document.querySelectorAll('[role="alert"]');
        alerts.forEach(function(alert) {
            alert.style.transition = 'all 0.5s ease-out';
            alert.style.transform = 'translateY(-20px)';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        });
    }, 5000);
});
</script>
@endpush
