@extends('admin.layouts.main')

@section('title', 'Kelola Produk')

@section('container')
<div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Produk</h1>
            <p class="text-gray-600 mt-1">Kelola produk jadi yang akan ditampilkan di katalog</p>
        </div>
        <a href="{{ route('admin.produk.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
            <i class="fas fa-plus mr-2"></i>Tambah Produk
        </a>
    </div>



    <!-- Search and Filter Card -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.produk.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" name="search"
                               placeholder="Cari nama produk atau deskripsi..."
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
                        <a href="{{ route('admin.produk.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-md transition duration-200 flex items-center justify-center">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions Form -->
    <form id="bulkActionForm" method="POST" action="{{ route('admin.produk.bulk-action') }}">
        @csrf
        <input type="hidden" name="action" id="bulkAction">

        <!-- Bulk Actions Bar -->
        <div class="bg-white shadow rounded-lg mb-6" id="bulkActionsBar" style="display: none;">
            <div class="px-6 py-3">
                <div class="flex justify-between items-center">
                    <span id="selectedCount" class="text-gray-600">0 produk dipilih</span>
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
                @if($produk->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="w-10 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="w-32 px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($produk as $item)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}"
                                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 row-checkbox">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex-shrink-0 h-16 w-16">
                                            <img class="h-16 w-16 rounded-lg object-cover border border-gray-200" 
                                                 src="{{ $item->thumbnail_url }}" 
                                                 alt="{{ $item->nama_produk }}">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $item->nama_produk }}</div>
                                            @if($item->deskripsi_singkat)
                                                <div class="text-sm text-gray-500">{{ Str::limit($item->deskripsi_singkat, 60) }}</div>
                                            @endif
                                            @if($item->link_pembelian)
                                                <div class="text-xs text-blue-600 mt-1">
                                                    <i class="fas fa-external-link-alt mr-1"></i>
                                                    <a href="{{ $item->link_pembelian }}" target="_blank" class="hover:underline">Link Pembelian</a>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-green-600">{{ $item->formatted_harga }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($item->status === 'aktif')
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Non-Aktif</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-1">
                                            <a href="{{ route('admin.produk.show', $item) }}"
                                               class="text-blue-600 hover:text-blue-900 p-1 rounded" title="Lihat">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.produk.edit', $item) }}"
                                               class="text-yellow-600 hover:text-yellow-900 p-1 rounded" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="text-red-600 hover:text-red-900 p-1 rounded"
                                                    onclick="deleteProduk({{ $item->id }})" title="Hapus">
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
                            Menampilkan {{ $produk->firstItem() }} - {{ $produk->lastItem() }}
                            dari {{ $produk->total() }} produk
                        </div>
                        {{ $produk->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada produk</h3>
                        <p class="text-gray-500 mb-6">Mulai dengan menambahkan produk pertama Anda.</p>
                        <a href="{{ route('admin.produk.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Produk
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
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Hapus Produk</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus produk ini? Tindakan ini tidak dapat dibatalkan.
                </p>
            </div>
            <div class="flex justify-center space-x-3 mt-4">
                <button id="cancelDelete" class="px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Bulk actions functionality
const selectAllCheckbox = document.getElementById('selectAll');
const rowCheckboxes = document.querySelectorAll('.row-checkbox');
const bulkActionsBar = document.getElementById('bulkActionsBar');
const selectedCountSpan = document.getElementById('selectedCount');

// Select all functionality
selectAllCheckbox.addEventListener('change', function() {
    rowCheckboxes.forEach(checkbox => {
        checkbox.checked = this.checked;
    });
    updateBulkActionsBar();
});

// Individual checkbox functionality
rowCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        updateSelectAllState();
        updateBulkActionsBar();
    });
});

function updateSelectAllState() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    selectAllCheckbox.checked = checkedBoxes.length === rowCheckboxes.length;
    selectAllCheckbox.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < rowCheckboxes.length;
}

function updateBulkActionsBar() {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    const count = checkedBoxes.length;
    
    if (count > 0) {
        bulkActionsBar.style.display = 'block';
        selectedCountSpan.textContent = `${count} produk dipilih`;
    } else {
        bulkActionsBar.style.display = 'none';
    }
}

function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Pilih minimal satu produk untuk diproses.');
        return;
    }
    
    let confirmMessage = '';
    switch(action) {
        case 'delete':
            confirmMessage = `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} produk yang dipilih?`;
            break;
        case 'activate':
            confirmMessage = `Apakah Anda yakin ingin mengaktifkan ${checkedBoxes.length} produk yang dipilih?`;
            break;
        case 'deactivate':
            confirmMessage = `Apakah Anda yakin ingin menonaktifkan ${checkedBoxes.length} produk yang dipilih?`;
            break;
    }
    
    if (confirm(confirmMessage)) {
        document.getElementById('bulkAction').value = action;
        document.getElementById('bulkActionForm').submit();
    }
}

// Delete single item functionality
function deleteProduk(id) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/produk/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

// Cancel delete
document.getElementById('cancelDelete').addEventListener('click', function() {
    document.getElementById('deleteModal').classList.add('hidden');
});

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        this.classList.add('hidden');
    }
});
</script>
@endpush