<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Produk::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi_singkat', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Sort by latest
        $produk = $query->orderBy('created_at', 'desc')->paginate(10);
        $produk->appends($request->query());

        return view('admin.produk.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.produk.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string|max:1000',
            'harga' => 'required|numeric|min:0',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_pembelian' => 'nullable|url|max:500',
            'status' => 'required|in:aktif,non-aktif'
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'foto_produk.image' => 'File harus berupa gambar.',
            'foto_produk.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
            'foto_produk.max' => 'Ukuran gambar maksimal 2MB.',
            'link_pembelian.url' => 'Link pembelian harus berupa URL yang valid.',
            'status.required' => 'Status wajib dipilih.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();

            // Handle file upload
            if ($request->hasFile('foto_produk')) {
                $file = $request->file('foto_produk');
                $filename = time() . '_' . Str::slug($request->nama_produk) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('produk', $filename, 'public');
                $data['foto_produk'] = $path;
            }

            Produk::create($data);
            Alert::success('Berhasil!', 'Produk berhasil ditambahkan.');
            return redirect()->route('admin.produk.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat menyimpan produk.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        return view('admin.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        return view('admin.produk.edit', compact('produk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string|max:1000',
            'harga' => 'required|numeric|min:0',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link_pembelian' => 'nullable|url|max:500',
            'status' => 'required|in:aktif,non-aktif'
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'nama_produk.max' => 'Nama produk maksimal 255 karakter.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'foto_produk.image' => 'File harus berupa gambar.',
            'foto_produk.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif.',
            'foto_produk.max' => 'Ukuran gambar maksimal 2MB.',
            'link_pembelian.url' => 'Link pembelian harus berupa URL yang valid.',
            'status.required' => 'Status wajib dipilih.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();

            // Handle file upload
            if ($request->hasFile('foto_produk')) {
                // Delete old photo
                $produk->deleteFoto();

                $file = $request->file('foto_produk');
                $filename = time() . '_' . Str::slug($request->nama_produk) . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('produk', $filename, 'public');
                $data['foto_produk'] = $path;
            } else {
                // Keep existing photo
                unset($data['foto_produk']);
            }

            $produk->update($data);
            Alert::success('Berhasil!', 'Produk berhasil diperbarui.');
            return redirect()->route('admin.produk.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat memperbarui produk.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        try {
            // Delete photo file
            $produk->deleteFoto();
            
            $produk->delete();
            Alert::success('Berhasil!', 'Produk berhasil dihapus.');
            return redirect()->route('admin.produk.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat menghapus produk.');
            return redirect()->back();
        }
    }

    /**
     * Bulk actions for multiple produk
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete,activate,deactivate',
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'exists:produk,id'
        ]);

        if ($validator->fails()) {
            Alert::error('Gagal!', 'Pilih minimal satu produk untuk diproses.');
            return redirect()->back();
        }

        try {
            $selectedIds = $request->selected_ids;
            $action = $request->action;
            $count = count($selectedIds);

            switch ($action) {
                case 'delete':
                    // Delete photos before deleting records
                    $produkList = Produk::whereIn('id', $selectedIds)->get();
                    foreach ($produkList as $produk) {
                        $produk->deleteFoto();
                    }
                    Produk::whereIn('id', $selectedIds)->delete();
                    $message = "$count produk berhasil dihapus.";
                    break;
                case 'activate':
                    Produk::whereIn('id', $selectedIds)->update(['status' => 'aktif']);
                    $message = "$count produk berhasil diaktifkan.";
                    break;
                case 'deactivate':
                    Produk::whereIn('id', $selectedIds)->update(['status' => 'non-aktif']);
                    $message = "$count produk berhasil dinonaktifkan.";
                    break;
            }

            Alert::success('Berhasil!', $message);
            return redirect()->route('admin.produk.index');
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat memproses produk.');
            return redirect()->back();
        }
    }

    /**
     * Toggle status produk
     */
    public function toggleStatus(Produk $produk)
    {
        try {
            $newStatus = $produk->status === 'aktif' ? 'non-aktif' : 'aktif';
            $produk->update(['status' => $newStatus]);

            $statusText = $newStatus === 'aktif' ? 'diaktifkan' : 'dinonaktifkan';
            Alert::success('Berhasil!', "Produk berhasil $statusText.");
            return redirect()->back();
        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat mengubah status produk.');
            return redirect()->back();
        }
    }
}