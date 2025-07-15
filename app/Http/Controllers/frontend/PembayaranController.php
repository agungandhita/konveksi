<?php

namespace App\Http\Controllers\frontend;

use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Controllers\Controller;

class PembayaranController extends Controller
{
    /**
     * Tampilkan halaman pembayaran untuk pesanan tertentu
     */
    public function index($pesananId)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil pesanan dengan relasi layanan
        $pesanan = Pesanan::with('layanan')->where('id', $pesananId)
                          ->where('user_id', Auth::id())
                          ->first();

        if (!$pesanan) {
            return redirect()->route('pesanan.riwayat')->with('error', 'Pesanan tidak ditemukan.');
        }

        // Pastikan pesanan dalam status menunggu pembayaran
        if ($pesanan->status !== 'menunggu_pembayaran') {
            return redirect()->route('pesanan.riwayat')->with('error', 'Pesanan tidak dalam status menunggu pembayaran.');
        }

        // Hitung total harga jika belum ada
        if (!$pesanan->total_harga) {
            $pesanan->total_harga = $pesanan->calculateTotalPrice();
            $pesanan->save();
        }

        return view('frontend.pembayaran.index', compact('pesanan'));
    }

    /**
     * Proses pembayaran baru
     */
    public function store(Request $request, $pesananId)
    {
        // Validasi input
        $request->validate([
            'metode_pembayaran' => 'required|in:DANA,MANDIRI,BCA',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120' // 5MB
        ]);

        // Ambil pesanan
        $pesanan = Pesanan::where('id', $pesananId)
                          ->where('user_id', Auth::id())
                          ->first();

        if (!$pesanan || $pesanan->status !== 'menunggu_pembayaran') {
            return back()->with('error', 'Pesanan tidak valid atau tidak dalam status menunggu pembayaran.');
        }

        try {
            // Upload bukti pembayaran
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            // Get bank info
            $bankInfo = Pembayaran::getBankInfo($request->metode_pembayaran);

            // Buat record pembayaran
            $pembayaran = Pembayaran::create([
                'pesanan_id' => $pesanan->id,
                'total_harga' => $pesanan->total_harga,
                'harga_bordir' => $pesanan->getHargaBordir(),
                'metode_pembayaran' => $request->metode_pembayaran,
                'nomor_rekening' => $bankInfo['nomor'],
                'nama_pemilik_rekening' => $bankInfo['atas_nama'],
                'bukti_pembayaran' => $buktiPath,
                'status_pembayaran' => 'ditinjau',
                'tanggal_upload' => Carbon::now()
            ]);

            // Update status pesanan
            $pesanan->update(['status' => 'menunggu_verifikasi']);

            return redirect()->route('pesanan.riwayat')
                           ->with('success', 'Bukti pembayaran berhasil diupload. Pembayaran sedang ditinjau oleh admin.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengupload bukti pembayaran. Silakan coba lagi.');
        }
    }

    /**
     * Tampilkan halaman upload ulang bukti pembayaran
     */
    public function uploadUlang($pesananId)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil pesanan dengan relasi pembayaran
        $pesanan = Pesanan::with(['layanan', 'pembayaran'])
                          ->where('id', $pesananId)
                          ->where('user_id', Auth::id())
                          ->first();

        if (!$pesanan || !$pesanan->pembayaran) {
            return redirect()->route('pesanan.riwayat')->with('error', 'Pesanan atau data pembayaran tidak ditemukan.');
        }

        // Pastikan pembayaran ditolak
        if ($pesanan->pembayaran->status_pembayaran !== 'ditolak') {
            return redirect()->route('pesanan.riwayat')->with('error', 'Pembayaran tidak dalam status ditolak.');
        }

        return view('frontend.pembayaran.upload-ulang', compact('pesanan'));
    }

    /**
     * Update bukti pembayaran yang ditolak
     */
    public function updateBukti(Request $request, $pesananId)
    {
        // Validasi input
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120' // 5MB
        ]);

        // Ambil pesanan dengan pembayaran
        $pesanan = Pesanan::with('pembayaran')
                          ->where('id', $pesananId)
                          ->where('user_id', Auth::id())
                          ->first();

        if (!$pesanan || !$pesanan->pembayaran || $pesanan->pembayaran->status_pembayaran !== 'ditolak') {
            return back()->with('error', 'Pesanan tidak valid atau pembayaran tidak dalam status ditolak.');
        }

        try {
            // Hapus bukti pembayaran lama
            if ($pesanan->pembayaran->bukti_pembayaran) {
                Storage::disk('public')->delete($pesanan->pembayaran->bukti_pembayaran);
            }

            // Upload bukti pembayaran baru
            $buktiPath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

            // Update pembayaran
            $pesanan->pembayaran->update([
                'bukti_pembayaran' => $buktiPath,
                'status_pembayaran' => 'ditinjau',
                'tanggal_upload' => Carbon::now(),
                'catatan_admin' => null // Reset catatan admin
            ]);

            // Update status pesanan
            $pesanan->update(['status' => 'menunggu_verifikasi']);

            return redirect()->route('pesanan.riwayat')
                           ->with('success', 'Bukti pembayaran berhasil diupload ulang. Pembayaran sedang ditinjau oleh admin.');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat mengupload bukti pembayaran. Silakan coba lagi.');
        }
    }
}