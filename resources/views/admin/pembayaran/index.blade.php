@extends('admin.layouts.main')

@section('title', 'Manajemen Pembayaran')

@section('container')
<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Manajemen Pembayaran</h1>
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Pembayaran</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <i class="fas fa-filter text-gray-500 mr-2"></i>
                <h3 class="text-lg font-medium text-gray-900">Filter Pembayaran</h3>
            </div>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('admin.pembayaran.index') }}">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status Pembayaran</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="status" name="status">
                            <option value="">Semua Status</option>
                            @foreach($statusOptions as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="metode" class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                        <select class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="metode" name="metode">
                            <option value="">Semua Metode</option>
                            @foreach($metodeOptions as $metode)
                                <option value="{{ $metode }}" {{ request('metode') == $metode ? 'selected' : '' }}>
                                    {{ $metode }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Pembayaran</label>
                        <input type="text" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="search" name="search"
                               value="{{ request('search') }}" placeholder="Nama pemesan atau email...">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                            <i class="fas fa-search mr-2"></i>Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Action Form -->
    <form id="bulkActionForm" method="POST" action="{{ route('admin.pembayaran.bulk-action') }}">
        @csrf
        <input type="hidden" name="action" id="bulkAction">
        <input type="hidden" name="catatan_bulk" id="bulkCatatan">


        <!-- Pembayaran Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <div class="flex items-center">
                    <i class="fas fa-credit-card text-gray-500 mr-2"></i>
                    <h3 class="text-lg font-medium text-gray-900">Daftar Pembayaran</h3>
                </div>
                <div class="flex space-x-2">
                    <button type="button" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out text-sm" onclick="bulkAction('terima')">
                        <i class="fas fa-check mr-1"></i>Terima Terpilih
                    </button>
                    <button type="button" class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out text-sm" onclick="bulkAction('tolak')">
                        <i class="fas fa-times mr-1"></i>Tolak Terpilih
                    </button>
                </div>
            </div>
            <div class="p-6">
                @if($pembayaran->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Pesanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pembayaran</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Metode</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Upload</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($pembayaran as $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" name="pembayaran_ids[]" value="{{ $item->id }}" class="pembayaran-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900">#{{ str_pad($item->pesanan_id, 4, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $item->pesanan->nama_pemesan }}</div>
                                                <div class="text-sm text-gray-500">{{ $item->pesanan->user->email }}</div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-semibold text-blue-600">{{ $item->formatted_total_harga }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $item->metode_pembayaran }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $badgeClass = match($item->status_pembayaran) {
                                                    'menunggu' => 'bg-gray-100 text-gray-800',
                                                    'ditinjau' => 'bg-yellow-100 text-yellow-800',
                                                    'diterima' => 'bg-green-100 text-green-800',
                                                    'ditolak' => 'bg-red-100 text-red-800',
                                                    default => 'bg-gray-100 text-gray-800'
                                                };
                                            @endphp
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $badgeClass }}">{{ ucfirst($item->status_pembayaran) }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $item->tanggal_upload ? $item->tanggal_upload->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.pembayaran.show', $item->id) }}"
                                                   class="text-blue-600 hover:text-blue-900 p-1 rounded" title="Detail">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.pembayaran.download-bukti', $item->id) }}"
                                                   class="text-indigo-600 hover:text-indigo-900 p-1 rounded" title="Download Bukti">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                @if($item->status_pembayaran === 'ditinjau')
                                                    <button type="button" class="text-green-600 hover:text-green-900 p-1 rounded"
                                                            onclick="showVerificationModal({{ $item->id }}, 'diterima')" title="Terima">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                    <button type="button" class="text-red-600 hover:text-red-900 p-1 rounded"
                                                            onclick="showVerificationModal({{ $item->id }}, 'ditolak')" title="Tolak">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center mt-6">
                        {{ $pembayaran->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-credit-card text-6xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data pembayaran</h3>
                        <p class="text-gray-500">Data pembayaran akan muncul di sini setelah customer melakukan pembayaran.</p>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- Verification Modal -->
<div id="verificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <form id="verificationForm" method="POST">
            @csrf
            @method('PATCH')
            <div class="flex justify-between items-center pb-3">
                <h3 class="text-lg font-medium text-gray-900" id="verificationModalTitle">Verifikasi Pembayaran</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="py-4">
                <input type="hidden" name="status" id="verificationStatus">
                <div class="mb-4">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                    <textarea class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" id="catatan" name="catatan" rows="3"
                              placeholder="Berikan catatan jika diperlukan..."></textarea>
                </div>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition duration-150 ease-in-out" onclick="closeModal()">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-md transition duration-150 ease-in-out" id="verificationSubmitBtn">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

<script>
// Select All functionality
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.pembayaran-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

// Bulk Action
function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.pembayaran-checkbox:checked');

    if (checkedBoxes.length === 0) {
        alert('Pilih minimal satu pembayaran untuk diproses.');
        return;
    }

    const actionText = action === 'terima' ? 'menerima' : 'menolak';
    const catatan = prompt(`Catatan untuk ${actionText} pembayaran (opsional):`);

    if (confirm(`Apakah Anda yakin ingin ${actionText} ${checkedBoxes.length} pembayaran yang dipilih?`)) {
        document.getElementById('bulkAction').value = action;
        document.getElementById('bulkCatatan').value = catatan || '';
        document.getElementById('bulkActionForm').submit();
    }
}

// Show Verification Modal
function showVerificationModal(pembayaranId, status) {
    const modal = document.getElementById('verificationModal');
    const form = document.getElementById('verificationForm');
    const title = document.getElementById('verificationModalTitle');
    const submitBtn = document.getElementById('verificationSubmitBtn');
    const statusInput = document.getElementById('verificationStatus');

    // Set form action
    form.action = `/admin/pembayaran/${pembayaranId}/verifikasi`;

    // Set status
    statusInput.value = status;

    // Update modal content based on status
    if (status === 'diterima') {
        title.textContent = 'Terima Pembayaran';
        submitBtn.textContent = 'Terima Pembayaran';
        submitBtn.className = 'px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition duration-150 ease-in-out';
    } else {
        title.textContent = 'Tolak Pembayaran';
        submitBtn.textContent = 'Tolak Pembayaran';
        submitBtn.className = 'px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition duration-150 ease-in-out';
    }

    // Clear previous input
    document.getElementById('catatan').value = '';

    // Show modal
    modal.classList.remove('hidden');
}

// Close Modal
function closeModal() {
    const modal = document.getElementById('verificationModal');
    modal.classList.add('hidden');
}
</script>
@endsection
