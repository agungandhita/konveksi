<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

class PembayaranController extends Controller
{
    /**
     * Tampilkan daftar pembayaran
     */
    public function index(Request $request)
    {
        $query = Pembayaran::with(['pesanan.user', 'pesanan.layanan']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        // Filter berdasarkan metode pembayaran
        if ($request->filled('metode')) {
            $query->where('metode_pembayaran', $request->metode);
        }

        // Search berdasarkan nama pemesan atau user
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pesanan', function($q) use ($search) {
                $q->where('nama_pemesan', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $pembayaran = $query->orderBy('created_at', 'desc')->paginate(15);

        // Data untuk filter
        $statusOptions = ['menunggu', 'ditinjau', 'diterima', 'ditolak'];
        $metodeOptions = ['DANA', 'MANDIRI', 'BCA'];

        return view('admin.pembayaran.index', compact('pembayaran', 'statusOptions', 'metodeOptions'));
    }

    /**
     * Tampilkan detail pembayaran
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::with(['pesanan.user', 'pesanan.layanan'])->findOrFail($id);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    /**
     * Verifikasi pembayaran (terima/tolak)
     */
    public function verifikasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
            'catatan' => 'nullable|string|max:500'
        ]);

        $pembayaran = Pembayaran::with('pesanan')->findOrFail($id);

        // Update status pembayaran
        $pembayaran->update([
            'status_pembayaran' => $request->status,
            'catatan_admin' => $request->catatan,
            'tanggal_verifikasi' => Carbon::now()
        ]);

        // Update status pesanan berdasarkan status pembayaran
        if ($request->status === 'diterima') {
            $pembayaran->pesanan->update(['status' => 'diproses']);
            $message = 'Pembayaran berhasil diterima. Status pesanan diubah menjadi diproses.';
        } else {
            $pembayaran->pesanan->update(['status' => 'menunggu_pembayaran']);
            $message = 'Pembayaran ditolak. Status pesanan dikembalikan ke menunggu pembayaran.';
        }

        Alert::success('Berhasil!', $message);
        return redirect()->route('admin.pembayaran.index');
    }

    /**
     * Download bukti pembayaran
     */
    public function downloadBukti($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        
        if (!$pembayaran->bukti_pembayaran || !Storage::disk('public')->exists($pembayaran->bukti_pembayaran)) {
            Alert::error('Gagal!', 'File bukti pembayaran tidak ditemukan.');
            return back();
        }

        $filePath = storage_path('app/public/' . $pembayaran->bukti_pembayaran);
        $fileName = 'bukti_pembayaran_' . $pembayaran->pesanan_id . '_' . time() . '.' . pathinfo($pembayaran->bukti_pembayaran, PATHINFO_EXTENSION);

        return response()->download($filePath, $fileName);
    }

    /**
     * Bulk action untuk pembayaran
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:terima,tolak',
            'pembayaran_ids' => 'required|array',
            'pembayaran_ids.*' => 'exists:pembayaran,id',
            'catatan_bulk' => 'nullable|string|max:500'
        ]);

        $pembayaranIds = $request->pembayaran_ids;
        $action = $request->action;
        $catatan = $request->catatan_bulk;

        $status = $action === 'terima' ? 'diterima' : 'ditolak';
        $statusPesanan = $action === 'terima' ? 'diproses' : 'menunggu_pembayaran';

        // Update pembayaran
        Pembayaran::whereIn('id', $pembayaranIds)->update([
            'status_pembayaran' => $status,
            'catatan_admin' => $catatan,
            'tanggal_verifikasi' => Carbon::now()
        ]);

        // Update status pesanan terkait
        $pesananIds = Pembayaran::whereIn('id', $pembayaranIds)->pluck('pesanan_id');
        Pesanan::whereIn('id', $pesananIds)->update(['status' => $statusPesanan]);

        $count = count($pembayaranIds);
        $actionText = $action === 'terima' ? 'diterima' : 'ditolak';
        
        Alert::success('Berhasil!', "{$count} pembayaran berhasil {$actionText}.");
        return redirect()->route('admin.pembayaran.index');
    }

    /**
     * Statistik pembayaran
     */
    public function statistics()
    {
        $stats = [
            'total_pembayaran' => Pembayaran::count(),
            'menunggu' => Pembayaran::where('status_pembayaran', 'menunggu')->count(),
            'ditinjau' => Pembayaran::where('status_pembayaran', 'ditinjau')->count(),
            'diterima' => Pembayaran::where('status_pembayaran', 'diterima')->count(),
            'ditolak' => Pembayaran::where('status_pembayaran', 'ditolak')->count(),
            'total_nilai' => Pembayaran::where('status_pembayaran', 'diterima')->sum('total_harga'),
            'pembayaran_hari_ini' => Pembayaran::whereDate('created_at', Carbon::today())->count()
        ];

        return response()->json($stats);
    }
}