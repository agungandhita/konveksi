<?php

namespace App\Http\Controllers\Admin;

use App\Models\Layanan;
use Illuminate\Http\Request;
use App\Models\LayananHargaUkuran;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Layanan::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_layanan', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi_singkat', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort by latest
        $layanan = $query->orderBy('created_at', 'desc')->paginate(10);
        $layanan->appends($request->query());

        return view('admin.layanan.index', compact('layanan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ukuranOptions = LayananHargaUkuran::getUkuranOptions();
        return view('admin.layanan.create', compact('ukuranOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255|unique:layanan,nama_layanan',
            'deskripsi_singkat' => 'nullable|string|max:1000',
            'estimasi_waktu' => 'required|integer|min:1',
            'minimal_order' => 'required|integer|min:1',
            'satuan_order' => 'required|string|max:50',
            'perkiraan_harga' => 'nullable|numeric|min:0',
            'status' => 'required|in:aktif,non-aktif'
        ], [
            'nama_layanan.required' => 'Nama layanan wajib diisi.',
            'nama_layanan.unique' => 'Nama layanan sudah ada.',
            'estimasi_waktu.required' => 'Estimasi waktu wajib diisi.',
            'estimasi_waktu.min' => 'Estimasi waktu minimal 1 hari.',
            'minimal_order.required' => 'Minimal order wajib diisi.',
            'minimal_order.min' => 'Minimal order harus lebih dari 0.',
            'satuan_order.required' => 'Satuan order wajib diisi.',
            'perkiraan_harga.numeric' => 'Harga harus berupa angka.',
            'status.required' => 'Status wajib dipilih.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Layanan::create($request->all());
            Alert::success('Berhasil!', 'Layanan berhasil ditambahkan.');
            return redirect()->route('admin.layanan.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat menyimpan layanan.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        return view('admin.layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan)
    {
        $validator = Validator::make($request->all(), [
            'nama_layanan' => 'required|string|max:255|unique:layanan,nama_layanan,' . $layanan->id,
            'deskripsi_singkat' => 'nullable|string|max:1000',
            'estimasi_waktu' => 'required|integer|min:1',
            'minimal_order' => 'required|integer|min:1',
            'satuan_order' => 'required|string|max:50',
            'perkiraan_harga' => 'nullable|numeric|min:0',
            'status' => 'required|in:aktif,non-aktif',
            'harga_ukuran' => 'nullable|array',
            'harga_ukuran.*' => 'nullable|numeric|min:0'
        ], [
            'nama_layanan.required' => 'Nama layanan wajib diisi.',
            'nama_layanan.unique' => 'Nama layanan sudah ada.',
            'estimasi_waktu.required' => 'Estimasi waktu wajib diisi.',
            'estimasi_waktu.min' => 'Estimasi waktu minimal 1 hari.',
            'minimal_order.required' => 'Minimal order wajib diisi.',
            'minimal_order.min' => 'Minimal order harus lebih dari 0.',
            'satuan_order.required' => 'Satuan order wajib diisi.',
            'perkiraan_harga.numeric' => 'Harga harus berupa angka.',
            'status.required' => 'Status wajib dipilih.',
            'harga_ukuran.*.numeric' => 'Harga ukuran harus berupa angka.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            DB::beginTransaction();

            // Update layanan
            $layanan->update($request->only([
                'nama_layanan', 'deskripsi_singkat', 'estimasi_waktu',
                'minimal_order', 'satuan_order', 'perkiraan_harga', 'status'
            ]));

            // Hapus harga ukuran yang lama
            $layanan->hargaUkuran()->delete();

            // Simpan harga berdasarkan ukuran yang baru
            if ($request->filled('harga_ukuran')) {
                foreach ($request->harga_ukuran as $ukuran => $harga) {
                    if (!empty($harga)) {
                        LayananHargaUkuran::create([
                            'layanan_id' => $layanan->id,
                            'ukuran' => $ukuran,
                            'harga' => $harga
                        ]);
                    }
                }
            }

            DB::commit();
            Alert::success('Berhasil!', 'Layanan berhasil diperbarui.');
            return redirect()->route('admin.layanan.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Gagal!', 'Terjadi kesalahan saat memperbarui layanan.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        try {
            $layanan->delete();
            Alert::success('Berhasil!', 'Layanan berhasil dihapus.');
            return redirect()->route('admin.layanan.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat menghapus layanan.');
            return redirect()->back();
        }
    }

    /**
     * Bulk actions for multiple layanan
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete,activate,deactivate',
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'exists:layanan,id'
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pilih minimal satu layanan untuk diproses.');
            return redirect()->back();
        }

        try {
            $selectedIds = $request->selected_ids;
            $action = $request->action;
            $count = count($selectedIds);

            switch ($action) {
                case 'delete':
                    Layanan::whereIn('id', $selectedIds)->delete();
                    $message = "$count layanan berhasil dihapus.";
                    break;
                case 'activate':
                    Layanan::whereIn('id', $selectedIds)->update(['status' => 'aktif']);
                    $message = "$count layanan berhasil diaktifkan.";
                    break;
                case 'deactivate':
                    Layanan::whereIn('id', $selectedIds)->update(['status' => 'non-aktif']);
                    $message = "$count layanan berhasil dinonaktifkan.";
                    break;
            }

            Alert::success('Berhasil!', $message);
            return redirect()->route('admin.layanan.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat memproses layanan.');
            return redirect()->back();
        }
    }

    /**
     * Toggle status layanan
     */
    public function toggleStatus(Layanan $layanan)
    {
        try {
            $newStatus = $layanan->status === 'aktif' ? 'non-aktif' : 'aktif';
            $layanan->update(['status' => $newStatus]);

            $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
            Alert::success('Berhasil!', "Layanan berhasil $statusText.");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat mengubah status layanan.');
            return redirect()->back();
        }
    }
}
