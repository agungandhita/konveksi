<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Layanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    /**
     * Menampilkan daftar pesanan
     */
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'layanan']);
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan layanan
        if ($request->filled('layanan_id')) {
            $query->where('layanan_id', $request->layanan_id);
        }
        
        // Search berdasarkan nama pemesan atau nomor WA
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pemesan', 'like', "%{$search}%")
                  ->orWhere('nomor_whatsapp', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $pesanan = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Data untuk filter
        $layanan = Layanan::aktif()->orderBy('nama_layanan')->get();
        $statusOptions = [
            'pending' => 'Pending',
            'menunggu_pembayaran' => 'Menunggu Pembayaran',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'diproses' => 'Diproses', 
            'selesai' => 'Selesai',
            'dibatalkan' => 'Dibatalkan'
        ];
        
        return view('admin.pesanan.index', compact('pesanan', 'layanan', 'statusOptions'));
    }

    /**
     * Menampilkan detail pesanan
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'layanan'])->findOrFail($id);
        
        return view('admin.pesanan.show', compact('pesanan'));
    }

    /**
     * Update status pesanan
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,menunggu_pembayaran,menunggu_verifikasi,diproses,selesai,dibatalkan'
        ]);
        
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update([
            'status' => $request->status
        ]);
        
        return redirect()->back()->with('success', 'Status pesanan berhasil diupdate.');
    }

    /**
     * Bulk action untuk pesanan
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,update_status',
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:pesanan,id',
            'status' => 'required_if:action,update_status|in:pending,menunggu_pembayaran,menunggu_verifikasi,diproses,selesai,dibatalkan'
        ]);

        $selectedIds = $request->selected_items;
        
        switch ($request->action) {
            case 'delete':
                // Hapus file yang terkait sebelum menghapus pesanan
                $pesananToDelete = Pesanan::whereIn('id', $selectedIds)->get();
                foreach ($pesananToDelete as $pesanan) {
                    $this->deleteAssociatedFiles($pesanan);
                }
                
                Pesanan::whereIn('id', $selectedIds)->delete();
                $message = 'Pesanan yang dipilih berhasil dihapus.';
                break;
                
            case 'update_status':
                Pesanan::whereIn('id', $selectedIds)->update([
                    'status' => $request->status
                ]);
                $message = 'Status pesanan yang dipilih berhasil diupdate.';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Hapus pesanan
     */
    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        // Hapus file yang terkait
        $this->deleteAssociatedFiles($pesanan);
        
        $pesanan->delete();
        
        return redirect()->route('admin.pesanan.index')
                        ->with('success', 'Pesanan berhasil dihapus.');
    }

    /**
     * Download file pesanan
     */
    public function downloadFile($id, $type)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        $filePath = null;
        $fileName = null;
        
        switch ($type) {
            case 'desain_baju':
                $filePath = $pesanan->file_desain_baju;
                $fileName = "desain_baju_pesanan_{$pesanan->id}." . pathinfo($filePath, PATHINFO_EXTENSION);
                break;
            case 'desain_bordir':
                $filePath = $pesanan->file_desain_bordir;
                $fileName = "desain_bordir_pesanan_{$pesanan->id}." . pathinfo($filePath, PATHINFO_EXTENSION);
                break;
            case 'nama_tag':
                $filePath = $pesanan->file_nama_tag;
                $fileName = "nama_tag_pesanan_{$pesanan->id}." . pathinfo($filePath, PATHINFO_EXTENSION);
                break;
        }
        
        if (!$filePath || !Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }
        
        return response()->download(storage_path('app/public/' . $filePath), $fileName);
    }

    /**
     * Export pesanan ke CSV
     */
    public function export(Request $request)
    {
        $query = Pesanan::with(['user', 'layanan']);
        
        // Apply same filters as index
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('layanan_id')) {
            $query->where('layanan_id', $request->layanan_id);
        }
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pemesan', 'like', "%{$search}%")
                  ->orWhere('nomor_whatsapp', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }
        
        $pesanan = $query->orderBy('created_at', 'desc')->get();
        
        $filename = 'pesanan_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        $callback = function() use ($pesanan) {
            $file = fopen('php://output', 'w');
            
            // Header CSV
            fputcsv($file, [
                'ID Pesanan',
                'Nama Pemesan',
                'Email User',
                'Nomor WhatsApp',
                'Layanan',
                'Jumlah Order',
                'Ukuran Baju',
                'Ukuran Custom',
                'Tambahan Bordir',
                'Keterangan Bordir',
                'Keterangan Tambahan',
                'Status',
                'Tanggal Pesanan'
            ]);
            
            // Data CSV
            foreach ($pesanan as $item) {
                fputcsv($file, [
                    str_pad($item->id, 4, '0', STR_PAD_LEFT),
                    $item->nama_pemesan,
                    $item->user->email,
                    $item->nomor_whatsapp,
                    $item->layanan->nama_layanan,
                    $item->jumlah_order,
                    $item->ukuran_baju,
                    $item->ukuran_custom ?? '-',
                    $item->tambahan_bordir ? 'Ya' : 'Tidak',
                    $item->keterangan_bordir ?? '-',
                    $item->keterangan_tambahan ?? '-',
                    ucfirst($item->status),
                    $item->created_at->format('d/m/Y H:i')
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Statistik dashboard pesanan
     */
    public function statistics()
    {
        $stats = [
            'total_pesanan' => Pesanan::count(),
            'pending' => Pesanan::where('status', 'pending')->count(),
            'diproses' => Pesanan::where('status', 'diproses')->count(),
            'selesai' => Pesanan::where('status', 'selesai')->count(),
            'dibatalkan' => Pesanan::where('status', 'dibatalkan')->count(),
            'pesanan_bulan_ini' => Pesanan::whereMonth('created_at', date('m'))
                                         ->whereYear('created_at', date('Y'))
                                         ->count(),
            'pesanan_hari_ini' => Pesanan::whereDate('created_at', today())->count()
        ];
        
        return response()->json($stats);
    }

    /**
     * Hapus file yang terkait dengan pesanan
     */
    private function deleteAssociatedFiles($pesanan)
    {
        $files = [
            $pesanan->file_desain_baju,
            $pesanan->file_desain_bordir,
            $pesanan->file_nama_tag
        ];
        
        foreach ($files as $file) {
            if ($file && Storage::disk('public')->exists($file)) {
                Storage::disk('public')->delete($file);
            }
        }
    }
}