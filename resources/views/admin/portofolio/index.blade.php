@extends('admin.layouts.main')

@section('title', 'Kelola Portofolio')

@section('container')
<div class="max-w-7xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Kelola Portofolio</h1>
            <p class="text-gray-600 mt-1">Kelola galeri hasil pekerjaan dan proyek konveksi</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.portofolio.preview') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-eye mr-2"></i>Preview Galeri
            </a>
            <a href="{{ route('admin.portofolio.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center transition duration-200">
                <i class="fas fa-plus mr-2"></i>Tambah Portofolio
            </a>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 relative" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times text-green-500 hover:text-green-700"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 relative" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times text-red-500 hover:text-red-700"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Search and Filter Card -->
    <div class="bg-white shadow rounded-lg mb-6">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.portofolio.index') }}" class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                        <input type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500" name="search"
                               placeholder="Cari judul atau deskripsi..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="md:col-span-2">
                    <select name="status" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="non-aktif" {{ request('status') === 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <input type="date" name="tanggal_dari" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Tanggal Dari" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="md:col-span-2">
                    <input type="date" name="tanggal_sampai" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                           placeholder="Tanggal Sampai" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="md:col-span-2">
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200 flex items-center justify-center">
                            <i class="fas fa-filter mr-1"></i>Filter
                        </button>
                        <a href="{{ route('admin.portofolio.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-3 py-2 rounded-md transition duration-200 flex items-center justify-center">
                            <i class="fas fa-times"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bulk Actions Form -->
    <form id="bulkActionForm" method="POST" action="{{ route('admin.portofolio.bulk-action') }}">
        @csrf
        <input type="hidden" name="action" id="bulkAction">

        <!-- Bulk Actions Bar -->
        <div class="bg-white shadow rounded-lg mb-6" id="bulkActionsBar" style="display: none;">
            <div class="px-6 py-3">
                <div class="flex justify-between items-center">
                    <span id="selectedCount" class="text-gray-600">0 portofolio dipilih</span>
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

        <!-- Portfolio Grid -->
        <div class="bg-white shadow rounded-lg">
            <div class="p-6">
                @if($portofolio->count() > 0)
                    <!-- Select All Checkbox -->
                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" id="selectAll" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-600">Pilih Semua</span>
                        </label>
                    </div>

                    <!-- Grid Layout -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($portofolio as $item)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                            <!-- Checkbox -->
                            <div class="absolute top-3 left-3 z-10">
                                <input type="checkbox" name="selected_ids[]" value="{{ $item->id }}"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 row-checkbox">
                            </div>

                            <!-- Media Section -->
                            <div class="relative h-48 bg-gray-100 rounded-t-lg overflow-hidden">
                                @if($item->gambar_utama)
                                    <img src="{{ $item->gambar_utama_url }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                @elseif($item->video_url)
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <i class="fas fa-play-circle text-4xl text-gray-400"></i>
                                        <span class="ml-2 text-gray-500">Video YouTube</span>
                                    </div>
                                @elseif($item->video_file)
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <i class="fas fa-video text-4xl text-gray-400"></i>
                                        <span class="ml-2 text-gray-500">Video File</span>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                        <i class="fas fa-image text-4xl text-gray-400"></i>
                                    </div>
                                @endif

                                <!-- Status Badge -->
                                <div class="absolute top-3 right-3">
                                    @if($item->status === 'aktif')
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Non-Aktif</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">{{ $item->judul }}</h3>
                                
                                @if($item->deskripsi_singkat)
                                    <p class="text-sm text-gray-600 mb-3 line-clamp-2">{{ $item->deskripsi_singkat }}</p>
                                @endif

                                <div class="flex items-center text-sm text-gray-500 mb-3">
                                    <i class="fas fa-calendar mr-1"></i>
                                    <span>{{ $item->formatted_tanggal }}</span>
                                </div>



                                <!-- Action Buttons -->
                                <div class="flex justify-between items-center pt-3 border-t border-gray-100">
                                    <div class="flex space-x-1">
                                        <a href="{{ route('admin.portofolio.show', $item) }}"
                                           class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition duration-200" title="Lihat">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.portofolio.edit', $item) }}"
                                           class="text-yellow-600 hover:text-yellow-900 p-2 rounded-lg hover:bg-yellow-50 transition duration-200" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition duration-200"
                                                onclick="deletePortofolio({{ $item->id }})" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <!-- Media Indicators -->
                                    <div class="flex space-x-1">
                                        @if($item->gambar_utama)
                                            <span class="text-green-500" title="Ada Gambar"><i class="fas fa-image text-sm"></i></span>
                                        @endif
                                        @if($item->video_url || $item->video_file)
                                            <span class="text-purple-500" title="Ada Video"><i class="fas fa-video text-sm"></i></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-between items-center mt-6">
                        <div class="text-sm text-gray-700">
                            Menampilkan {{ $portofolio->firstItem() }} - {{ $portofolio->lastItem() }}
                            dari {{ $portofolio->total() }} portofolio
                        </div>
                        {{ $portofolio->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-images text-6xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada portofolio</h3>
                        <p class="text-gray-500 mb-6">Mulai dengan menambahkan portofolio pertama Anda untuk menampilkan hasil pekerjaan.</p>
                        <a href="{{ route('admin.portofolio.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center transition duration-200">
                            <i class="fas fa-plus mr-2"></i>Tambah Portofolio
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
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Hapus Portofolio</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Apakah Anda yakin ingin menghapus portofolio ini? Tindakan ini tidak dapat dibatalkan.
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

@push('scripts')
<script>
// Bulk actions functionality
const selectAllCheckbox = document.getElementById('selectAll');
const rowCheckboxes = document.querySelectorAll('.row-checkbox');
const bulkActionsBar = document.getElementById('bulkActionsBar');
const selectedCount = document.getElementById('selectedCount');

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
    if (checkedBoxes.length > 0) {
        bulkActionsBar.style.display = 'block';
        selectedCount.textContent = `${checkedBoxes.length} portofolio dipilih`;
    } else {
        bulkActionsBar.style.display = 'none';
    }
}

function bulkAction(action) {
    const checkedBoxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('Pilih minimal satu portofolio untuk diproses.');
        return;
    }

    let message = '';
    switch(action) {
        case 'delete':
            message = `Apakah Anda yakin ingin menghapus ${checkedBoxes.length} portofolio yang dipilih?`;
            break;
        case 'activate':
            message = `Apakah Anda yakin ingin mengaktifkan ${checkedBoxes.length} portofolio yang dipilih?`;
            break;
        case 'deactivate':
            message = `Apakah Anda yakin ingin menonaktifkan ${checkedBoxes.length} portofolio yang dipilih?`;
            break;
    }

    if (confirm(message)) {
        document.getElementById('bulkAction').value = action;
        document.getElementById('bulkActionForm').submit();
    }
}

// Delete single item functionality
function deletePortofolio(id) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `/admin/portofolio/${id}`;
    document.getElementById('deleteModal').classList.remove('hidden');
}

// Modal close functionality
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
@endsection