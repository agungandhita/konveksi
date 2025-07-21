@extends('admin.layouts.main')

@section('title', 'Manajemen Pesanan')

@section('container')
<div class="p-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
        <h1 class="text-2xl font-bold text-slate-800 mb-4 sm:mb-0">Manajemen Pesanan</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.pesanan.export', request()->query()) }}" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                <i class="fas fa-download mr-2"></i> Export CSV
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200 mb-6">
        <div class="px-6 py-4 border-b border-slate-200">
            <h3 class="text-lg font-semibold text-slate-800">Filter Pesanan</h3>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('admin.pesanan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="layanan_id" class="block text-sm font-medium text-slate-700 mb-2">Layanan</label>
                    <select name="layanan_id" id="layanan_id" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Semua Layanan</option>
                        @foreach($layanan as $item)
                            <option value="{{ $item->id }}" {{ request('layanan_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_layanan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="search" class="block text-sm font-medium text-slate-700 mb-2">Pencarian</label>
                    <input type="text" name="search" id="search" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Nama pemesan, nomor WA, email..." value="{{ request('search') }}">
                </div>
                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fas fa-search mr-2"></i> Filter
                    </button>
                    <a href="{{ route('admin.pesanan.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white text-sm font-medium rounded-lg transition-colors">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 uppercase tracking-wider">Total Pesanan</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $pesanan->total() }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-shopping-cart text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 uppercase tracking-wider">Pending</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $pesanan->where('status', 'pending')->count() }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <i class="fas fa-clock text-2xl text-yellow-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 uppercase tracking-wider">Diproses</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $pesanan->where('status', 'diproses')->count() }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <i class="fas fa-cogs text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-slate-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-600 uppercase tracking-wider">Selesai</p>
                    <p class="text-2xl font-bold text-slate-800 mt-1">{{ $pesanan->where('status', 'selesai')->count() }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <i class="fas fa-check-circle text-2xl text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Pesanan Table -->
    <div class="bg-white rounded-lg shadow-sm border border-slate-200">
        <div class="px-6 py-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h3 class="text-lg font-semibold text-slate-800 mb-4 sm:mb-0">Daftar Pesanan</h3>
            <div class="flex gap-2">
                <button type="button" class="hidden px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors" id="bulkDeleteBtn">
                    <i class="fas fa-trash mr-2"></i> Hapus Terpilih
                </button>
                <div class="relative">
                    <button class="hidden px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors" type="button" id="bulkActionDropdown">
                        <i class="fas fa-edit mr-2"></i> Aksi Massal <i class="fas fa-chevron-down ml-2"></i>
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-slate-200 z-10 hidden" id="bulkActionMenu">
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100" onclick="bulkUpdateStatus('pending')">Set Pending</a>
                            <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100" onclick="bulkUpdateStatus('diproses')">Set Diproses</a>
                            <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100" onclick="bulkUpdateStatus('selesai')">Set Selesai</a>
                            <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-100" onclick="bulkUpdateStatus('dibatalkan')">Set Dibatalkan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="p-6">
            @if($pesanan->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-slate-200">
                                <th class="text-left py-3 px-4 font-medium text-slate-600 w-12">
                                    <input type="checkbox" id="selectAll" class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="text-left py-3 px-4 font-medium text-slate-600">ID</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-600">Pemesan</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-600">Layanan</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-600">Jumlah</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-600">Status</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-600">Tanggal</th>
                                <th class="text-left py-3 px-4 font-medium text-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesanan as $item)
                                <tr class="border-b border-slate-100 hover:bg-slate-50">
                                    <td class="py-4 px-4">
                                        <input type="checkbox" class="item-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500" value="{{ $item->id }}">
                                    </td>
                                    <td class="py-4 px-4">
                                        <span class="font-semibold text-slate-800">#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div>
                                            <div class="font-medium text-slate-800">{{ $item->nama_pemesan }}</div>
                                            <div class="text-sm text-slate-500">{{ $item->user->email }}</div>
                                            <div class="text-sm text-slate-500">{{ $item->nomor_whatsapp }}</div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-700">{{ $item->layanan->nama_layanan }}</td>
                                    <td class="py-4 px-4">
                                        <div class="text-slate-700">{{ $item->jumlah_order }} {{ $item->layanan->satuan_order }}</div>
                                        <div class="text-sm text-slate-500">Ukuran: {{ $item->ukuran_baju }}</div>
                                        @if($item->ukuran_custom)
                                            <div class="text-sm text-slate-500">Custom: {{ $item->ukuran_custom }}</div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-4">
                                        @php
                                            $statusClasses = [
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'diproses' => 'bg-blue-100 text-blue-800',
                                                'selesai' => 'bg-green-100 text-green-800',
                                                'dibatalkan' => 'bg-red-100 text-red-800'
                                            ];
                                        @endphp
                                        <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full {{ $statusClasses[$item->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="text-slate-700">{{ $item->created_at->format('d/m/Y') }}</div>
                                        <div class="text-sm text-slate-500">{{ $item->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admin.pesanan.show', $item->id) }}"
                                               class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                               title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <div class="relative inline-block text-left">
                                                <button type="button"
                                                        class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-yellow-600 rounded-md hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 dropdown-toggle"
                                                        onclick="toggleDropdown(this)"
                                                        title="Update Status">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <div class="dropdown-menu absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden">
                                                    @foreach($statusOptions as $value => $label)
                                                        @if($value != $item->status)
                                                            <form method="POST" action="{{ route('admin.pesanan.update-status', $item->id) }}" class="block">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="status" value="{{ $value }}">
                                                                <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-slate-700 hover:bg-slate-100">
                                                                    Set {{ $label }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                            <form method="POST" action="{{ route('admin.pesanan.destroy', $item->id) }}"
                                                  class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 text-sm font-medium text-white bg-red-600 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mt-6 px-6 py-4 bg-slate-50 border-t gap-4">
                    <div class="text-sm text-slate-600">
                        Menampilkan {{ $pesanan->firstItem() }} - {{ $pesanan->lastItem() }}
                        dari {{ $pesanan->total() }} pesanan
                    </div>
                    <div class="pagination-wrapper">
                        {{ $pesanan->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-shopping-cart text-6xl text-slate-300 mb-4"></i>
                    <h5 class="text-xl font-medium text-slate-600 mb-2">Belum ada pesanan</h5>
                    <p class="text-slate-500">Pesanan akan muncul di sini setelah pelanggan melakukan pemesanan.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Action Form -->
<form id="bulkActionForm" method="POST" action="{{ route('admin.pesanan.bulk-action') }}" style="display: none;">
    @csrf
    <input type="hidden" name="action" id="bulkAction">
    <input type="hidden" name="status" id="bulkStatus">
    <div id="selectedItems"></div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select All Checkbox
    const selectAllCheckbox = document.getElementById('selectAll');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', function() {
            const itemCheckboxes = document.querySelectorAll('.item-checkbox');
            itemCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
            toggleBulkActions();
        });
    }

    // Individual Checkboxes
    const itemCheckboxes = document.querySelectorAll('.item-checkbox');
    itemCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleBulkActions();

            // Update select all checkbox
            const totalCheckboxes = itemCheckboxes.length;
            const checkedCheckboxes = document.querySelectorAll('.item-checkbox:checked').length;
            if (selectAllCheckbox) {
                selectAllCheckbox.checked = totalCheckboxes === checkedCheckboxes;
            }
        });
    });

    // Bulk Delete
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener('click', function() {
            if (confirm('Yakin ingin menghapus pesanan yang dipilih?')) {
                submitBulkAction('delete');
            }
        });
    }

    // Bulk Action Dropdown
    const bulkActionDropdown = document.getElementById('bulkActionDropdown');
    const bulkActionMenu = document.getElementById('bulkActionMenu');

    if (bulkActionDropdown && bulkActionMenu) {
        bulkActionDropdown.addEventListener('click', function() {
            bulkActionMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            if (!bulkActionDropdown.contains(event.target) && !bulkActionMenu.contains(event.target)) {
                bulkActionMenu.classList.add('hidden');
            }
        });
    }
});

function toggleBulkActions() {
    const checkedItems = document.querySelectorAll('.item-checkbox:checked').length;
    const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
    const bulkActionDropdown = document.getElementById('bulkActionDropdown');

    if (checkedItems > 0) {
        if (bulkDeleteBtn) bulkDeleteBtn.classList.remove('hidden');
        if (bulkActionDropdown) bulkActionDropdown.classList.remove('hidden');
    } else {
        if (bulkDeleteBtn) bulkDeleteBtn.classList.add('hidden');
        if (bulkActionDropdown) bulkActionDropdown.classList.add('hidden');
    }
}

function bulkUpdateStatus(status) {
    if (confirm(`Yakin ingin mengubah status pesanan yang dipilih menjadi ${status}?`)) {
        const bulkStatusInput = document.getElementById('bulkStatus');
        if (bulkStatusInput) {
            bulkStatusInput.value = status;
        }
        submitBulkAction('update_status');
    }

    // Close dropdown
    const bulkActionMenu = document.getElementById('bulkActionMenu');
    if (bulkActionMenu) {
        bulkActionMenu.classList.add('hidden');
    }
}

function submitBulkAction(action) {
    const selectedItems = [];
    const checkedBoxes = document.querySelectorAll('.item-checkbox:checked');

    checkedBoxes.forEach(checkbox => {
        selectedItems.push(checkbox.value);
    });

    if (selectedItems.length === 0) {
        alert('Pilih minimal satu pesanan.');
        return;
    }

    const bulkActionInput = document.getElementById('bulkAction');
    const selectedItemsContainer = document.getElementById('selectedItems');
    const bulkActionForm = document.getElementById('bulkActionForm');

    if (bulkActionInput) {
        bulkActionInput.value = action;
    }

    if (selectedItemsContainer) {
        selectedItemsContainer.innerHTML = '';
        selectedItems.forEach(function(id) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'selected_items[]';
            input.value = id;
            selectedItemsContainer.appendChild(input);
        });
    }

    if (bulkActionForm) {
        bulkActionForm.submit();
    }
}

// Dropdown toggle function for individual status update dropdowns
function toggleDropdown(button) {
    const dropdown = button.nextElementSibling;
    if (dropdown) {
        dropdown.classList.toggle('hidden');

        // Close other dropdowns
        const allDropdowns = document.querySelectorAll('.dropdown-menu');
        allDropdowns.forEach(menu => {
            if (menu !== dropdown) {
                menu.classList.add('hidden');
            }
        });
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.dropdown-toggle')) {
        const dropdowns = document.querySelectorAll('.dropdown-menu');
        dropdowns.forEach(dropdown => {
            dropdown.classList.add('hidden');
        });
    }
});
</script>
@endpush
