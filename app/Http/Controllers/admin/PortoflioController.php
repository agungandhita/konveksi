<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PortoflioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Portofolio::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi_singkat', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_proyek', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_proyek', '<=', $request->tanggal_sampai);
        }

        // Sort by latest
        $portofolio = $query->orderBy('tanggal_proyek', 'desc')->paginate(12);
        $portofolio->appends($request->query());

        return view('admin.portofolio.index', compact('portofolio'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.portofolio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string|max:1000',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|mimes:mp4,avi,mov,wmv|max:10240',
            'tanggal_proyek' => 'required|date',
            'status' => 'required|in:aktif,non-aktif'
        ], [
            'judul.required' => 'Judul portofolio wajib diisi.',
            'gambar_utama.image' => 'File harus berupa gambar.',
            'gambar_utama.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar_utama.max' => 'Ukuran gambar maksimal 2MB.',
            'video_url.url' => 'URL video tidak valid.',
            'video_file.mimes' => 'Format video harus MP4, AVI, MOV, atau WMV.',
            'video_file.max' => 'Ukuran video maksimal 10MB.',
            'tanggal_proyek.required' => 'Tanggal proyek wajib diisi.',
            'status.required' => 'Status wajib dipilih.'
        ]);



        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('gambar_utama')) {
                $image = $request->file('gambar_utama');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $data['gambar_utama'] = $image->storeAs('portofolio/images', $imageName, 'public');
            }

            // Handle video upload
            if ($request->hasFile('video_file')) {
                $video = $request->file('video_file');
                $videoName = time() . '_' . Str::random(10) . '.' . $video->getClientOriginalExtension();
                $data['video_file'] = $video->storeAs('portofolio/videos', $videoName, 'public');
            }

            Portofolio::create($data);
            return redirect()->route('admin.portofolio.index')
                ->with('success', 'Portofolio berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menyimpan portofolio.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Portofolio $portofolio)
    {
        return view('admin.portofolio.show', compact('portofolio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Portofolio $portofolio)
    {
        return view('admin.portofolio.edit', compact('portofolio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Portofolio $portofolio)
    {
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string|max:1000',
            'gambar_utama' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'video_url' => 'nullable|url',
            'video_file' => 'nullable|mimes:mp4,avi,mov,wmv|max:10240',
            'tanggal_proyek' => 'required|date',
            'status' => 'required|in:aktif,non-aktif'
        ], [
            'judul.required' => 'Judul portofolio wajib diisi.',
            'gambar_utama.image' => 'File harus berupa gambar.',
            'gambar_utama.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar_utama.max' => 'Ukuran gambar maksimal 2MB.',
            'video_url.url' => 'URL video tidak valid.',
            'video_file.mimes' => 'Format video harus MP4, AVI, MOV, atau WMV.',
            'video_file.max' => 'Ukuran video maksimal 10MB.',
            'tanggal_proyek.required' => 'Tanggal proyek wajib diisi.',
            'status.required' => 'Status wajib dipilih.'
        ]);



        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->all();

            // Handle image upload
            if ($request->hasFile('gambar_utama')) {
                // Delete old image
                if ($portofolio->gambar_utama) {
                    Storage::disk('public')->delete($portofolio->gambar_utama);
                }
                
                $image = $request->file('gambar_utama');
                $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
                $data['gambar_utama'] = $image->storeAs('portofolio/images', $imageName, 'public');
            }

            // Handle video upload
            if ($request->hasFile('video_file')) {
                // Delete old video
                if ($portofolio->video_file) {
                    Storage::disk('public')->delete($portofolio->video_file);
                }
                
                $video = $request->file('video_file');
                $videoName = time() . '_' . Str::random(10) . '.' . $video->getClientOriginalExtension();
                $data['video_file'] = $video->storeAs('portofolio/videos', $videoName, 'public');
            }

            $portofolio->update($data);
            return redirect()->route('admin.portofolio.index')
                ->with('success', 'Portofolio berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui portofolio.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Portofolio $portofolio)
    {
        try {
            // Delete associated files
            if ($portofolio->gambar_utama) {
                Storage::disk('public')->delete($portofolio->gambar_utama);
            }
            if ($portofolio->video_file) {
                Storage::disk('public')->delete($portofolio->video_file);
            }

            $portofolio->delete();
            return redirect()->route('admin.portofolio.index')
                ->with('success', 'Portofolio berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus portofolio.');
        }
    }

    /**
     * Bulk actions for multiple portofolio
     */
    public function bulkAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'action' => 'required|in:delete,activate,deactivate',
            'selected_ids' => 'required|array|min:1',
            'selected_ids.*' => 'exists:portofolio,id'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->with('error', 'Pilih minimal satu portofolio untuk diproses.');
        }

        try {
            $selectedIds = $request->selected_ids;
            $action = $request->action;
            $count = count($selectedIds);

            switch ($action) {
                case 'delete':
                    $portofolios = Portofolio::whereIn('id', $selectedIds)->get();
                    foreach ($portofolios as $portofolio) {
                        // Delete associated files
                        if ($portofolio->gambar_utama) {
                            Storage::disk('public')->delete($portofolio->gambar_utama);
                        }
                        if ($portofolio->video_file) {
                            Storage::disk('public')->delete($portofolio->video_file);
                        }
                    }
                    Portofolio::whereIn('id', $selectedIds)->delete();
                    $message = "$count portofolio berhasil dihapus.";
                    break;
                case 'activate':
                    Portofolio::whereIn('id', $selectedIds)->update(['status' => 'aktif']);
                    $message = "$count portofolio berhasil diaktifkan.";
                    break;
                case 'deactivate':
                    Portofolio::whereIn('id', $selectedIds)->update(['status' => 'non-aktif']);
                    $message = "$count portofolio berhasil dinonaktifkan.";
                    break;
            }

            return redirect()->route('admin.portofolio.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses portofolio.');
        }
    }

    /**
     * Preview gallery before publish
     */
    public function preview(Request $request)
    {
        $query = Portofolio::aktif();
        
        // Add search functionality like in index method
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', '%' . $search . '%')
                  ->orWhere('deskripsi_singkat', 'like', '%' . $search . '%');
            });
        }
        
        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_proyek', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_proyek', '<=', $request->date_to);
        }
        
        // Use paginate instead of get to support total() method
        $portfolios = $query->orderBy('tanggal_proyek', 'desc')->paginate(12);
        $portfolios->appends($request->query());
        
        return view('admin.portofolio.preview', compact('portfolios'));
    }
}