@extends('admin.layouts.main')

@section('title', 'Kelola Layanan')

@section('container')
<div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Layanan</h1>
            <p class="text-gray-600 mt-1">Kelola data layanan konveksi</p>
        </div>
        <a href="{{ route('admin.layanan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Layanan
        </a>
    </div>



    <!-- Search and Filter Card -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.layanan.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" name="search"
                               placeholder="Cari nama layanan atau deskripsi..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="md:col-span-3">
                    <select name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="non-aktif" {{ request('status') === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <div class="md:col-span-3">
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200 flex items-center justify-center">
                            <i class="fas fa-filter mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.layanan.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-md transition duration-200 flex items-center justify-center">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions Form -->
    <form method="POST" id="bulkActionForm" action="{{ route('admin.layanan.bulk-action') }}">
        @csrf
        <input type="hidden" name="action" id="bulkAction">

        <!-- Bulk Actions Bar -->
        <div class="bg-white shadow rounded-lg mb-6" id="bulkActionsBar" style="display: none;">
            <div class="px-6 py-3">
                <div class="flex justify-between items-center">
                    <span id="selectedCount" class="text-gray-600">0 layanan dipilih</span>
                    <div class="flex space-x-2">
                        <button type="button" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm transition duration-200 flex items-center" onclick="bulkAction('activate')">
                            <i class="fas fa-check mr-1"></i>Aktifkan
                        </button>
                        <button type="button" class="bg-yellow-600 hover:bg-yellow-700 text-white px-3 py-1 rounded text-sm transition duration-200 flex items-center" onclick="bulkAction('deactivate')">
                            <i class="fas fa-times mr-1"></i>Nonaktifkan
                        </button>
                        <button type="button" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition duration-200 flex items-center" onclick="bulkAction('delete')">
                            <i class="fas fa-trash mr-1"></i>Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="bg-white shadow rounded-lg">
            <div class="p-6">
                @if($layanan->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-10 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Layanan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimasi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Minimal Order</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="w-32 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($layanan as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}"
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 row-checkbox">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $item->nama_layanan }}</div>
                                            @if($item->deskripsi_singkat)
                                                <div class="text-sm text-gray-500">{{ Str::limit($item->deskripsi_singkat, 60) }}</div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">{{ $item->formatted_estimasi }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->formatted_minimal_order }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->perkiraan_harga)
                                            <div class="text-sm font-medium text-green-600">{{ $item->formatted_harga }}</div>
                                        @else
                                            <span class="text-sm text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-2">
                                            @if($item->status === 'aktif')
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                            @else
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Non-Aktif</span>
                                            @endif
                                            <form method="POST" action="{{ route('admin.layanan.toggle-status', $item) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="text-blue-600 hover:text-blue-900 text-xs" title="Toggle Status">
                                                    <i class="fas fa-toggle-{{ $item->status === 'aktif' ? 'on' : 'off' }}"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-1">
                                            <a href="{{ route('admin.layanan.show', $item) }}"
                                               class="text-blue-600 hover:text-blue-900 p-1 rounded" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.layanan.edit', $item) }}"
                                               class="text-yellow-600 hover:text-yellow-900 p-1 rounded" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="text-red-600 hover:text-red-900 p-1 rounded"
                                                    onclick="deleteLayanan({{ $item->id }})" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-6">
                        <div class="text-sm text-gray-700">
                            Menampilkan {{ $layanan->firstItem() }} - {{ $layanan->lastItem() }}
                            dari {{ $layanan->total() }} layanan
                        </div>
                        {{ $layanan->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-inbox text-6xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada layanan</h3>
                        <p class="text-gray-500 mb-6">Mulai dengan menambahkan layanan pertama Anda.</p>
                        <a href="{{ route('admin.layanan.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Layanan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Konfirmasi Hapus</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeDeleteModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <p class="text-gray-700">Apakah Anda yakin ingin menghapus layanan ini?</p>
                <p class="text-red-600 text-sm mt-2">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded transition duration-200" onclick="closeDeleteModal()">Batal</button>
                <form id="deleteForm" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition duration-200">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Action Confirmation Modal -->
<div id="bulkActionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 id="bulkActionTitle" class="text-lg font-medium text-gray-900">Konfirmasi Aksi</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeBulkActionModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="mb-4">
                <p id="bulkActionMessage" class="text-gray-700"></p>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded transition duration-200" onclick="closeBulkActionModal()">Batal</button>
                <button type="button" class="px-4 py-2 rounded transition duration-200" id="confirmBulkAction">Konfirmasi</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Select All Functionality
document.getElementById('selectAll').addEventListener('change', function() {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActionsBar();
});

// Individual checkbox change
document.querySelectorAll('.row-checkbox').forEach(checkbox => {
    checkbox.addEventListener('change', updateBulkActionsBar);
});

// Update bulk actions bar visibility and count
function updateBulkActionsBar() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const bulkActionsBar = document.getElementById('bulkActionsBar');
    const selectedCount = document.getElementById('selectedCount');

    if (checkedBoxes.length > 0) {
        bulkActionsBar.style.display = 'block';
        selectedCount.textContent = `${checkedBoxes.length} layanan dipilih`;
    } else {
        bulkActionsBar.style.display = 'none';
    }

    // Update select all checkbox state
    const selectAll = document.getElementById('selectAll');
    const allCheckboxes = document.querySelectorAll('.row-checkbox');
    selectAll.checked = checkedBoxes.length === allCheckboxes.length;
    selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < allCheckboxes.length;
}

// Delete single layanan
function deleteLayanan(id) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/layanan/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

// Close delete modal
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}

// Close bulk action modal
function closeBulkActionModal() {
    document.getElementById('bulkActionModal').classList.add('hidden');
}

// Bulk actions
function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Pilih minimal satu layanan.');
        return;
    }

    let title, message, buttonClass;

    switch(action) {
        case 'delete':
            title = 'Konfirmasi Hapus';
            message = `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} layanan yang dipilih?`;
            buttonClass = 'bg-red-600 hover:bg-red-700 text-white';
            break;
        case 'activate':
            title = 'Konfirmasi Aktifkan';
            message = `Apakah Anda yakin ingin mengaktifkan ${checkedBoxes.length} layanan yang dipilih?`;
            buttonClass = 'bg-green-600 hover:bg-green-700 text-white';
            break;
        case 'deactivate':
            title = 'Konfirmasi Nonaktifkan';
            message = `Apakah Anda yakin ingin menonaktifkan ${checkedBoxes.length} layanan yang dipilih?`;
            buttonClass = 'bg-yellow-600 hover:bg-yellow-700 text-white';
            break;
    }

    document.getElementById('bulkActionTitle').textContent = title;
    document.getElementById('bulkActionMessage').textContent = message;
    document.getElementById('bulkAction').value = action;

    const confirmButton = document.getElementById('confirmBulkAction');
    confirmButton.className = `px-4 py-2 rounded transition duration-200 ${buttonClass}`;
    confirmButton.onclick = function() {
        document.getElementById('bulkActionForm').submit();
    };

    document.getElementById('bulkActionModal').classList.remove('hidden');
}

// Auto-hide alerts after 5 seconds
setTimeout(function() {
    const alerts = document.querySelectorAll('[role="alert"]');
    alerts.forEach(alert => {
        alert.style.opacity = '0';
        alert.style.transition = 'opacity 0.5s ease';
        setTimeout(() => {
            alert.remove();
        }, 500);
    });
}, 5000);

// Close modal when clicking outside
window.onclick = function(event) {
    const deleteModal = document.getElementById('deleteModal');
    const bulkActionModal = document.getElementById('bulkActionModal');
    
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
    if (event.target === bulkActionModal) {
        closeBulkActionModal();
    }
}
</script>
@endpush
