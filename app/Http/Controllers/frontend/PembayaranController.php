<?php

namespace App\Http\Controllers\frontend;

use App\Models\Pesanan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PembayaranController extends Controller
{
    /**
     * Tampilkan halaman pembayaran untuk pesanan tertentu
     */
    public function index($pesananId)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            Alert::error('Gagal!', 'Silakan login terlebih dahulu.');
        return redirect()->route('login');
        }

        // Ambil pesanan dengan relasi layanan
        $pesanan = Pesanan::with('layanan')->where('id', $pesananId)
                          ->where('user_id', Auth::id())
                          ->first();

        if (!$pesanan) {
            Alert::error('Gagal!', 'Pesanan tidak ditemukan.');
            return redirect()->route('pesanan.riwayat');
        }

        // Pastikan pesanan dalam status menunggu pembayaran
        if ($pesanan->status !== 'menunggu_pembayaran') {
            Alert::error('Gagal!', 'Pesanan tidak dalam status menunggu pembayaran.');
            return redirect()->route('pesanan.riwayat');
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
            Alert::error('Gagal!', 'Pesanan tidak valid atau tidak dalam status menunggu pembayaran.');
            return back();
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

            Alert::success('Berhasil!', 'Bukti pembayaran berhasil diupload. Pembayaran sedang ditinjau oleh admin.');
            return redirect()->route('pesanan.riwayat');

        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat mengupload bukti pembayaran. Silakan coba lagi.');
            return back();
        }
    }

    /**
     * Tampilkan halaman upload ulang bukti pembayaran
     */
    public function uploadUlang($pesananId)
    {
        // Pastikan user sudah login
        if (!Auth::check()) {
            Alert::error('Gagal!', 'Silakan login terlebih dahulu.');
            return redirect()->route('login');
        }

        // Ambil pesanan dengan relasi pembayaran
        $pesanan = Pesanan::with(['layanan', 'pembayaran'])
                          ->where('id', $pesananId)
                          ->where('user_id', Auth::id())
                          ->first();

        if (!$pesanan || !$pesanan->pembayaran) {
            Alert::error('Gagal!', 'Pesanan atau data pembayaran tidak ditemukan.');
            return redirect()->route('pesanan.riwayat');
        }

        // Pastikan pembayaran ditolak
        if ($pesanan->pembayaran->status_pembayaran !== 'ditolak') {
            Alert::error('Gagal!', 'Pembayaran tidak dalam status ditolak.');
            return redirect()->route('pesanan.riwayat');
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
            Alert::error('Gagal!', 'Pesanan tidak valid atau pembayaran tidak dalam status ditolak.');
            return back();
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

            Alert::success('Berhasil!', 'Bukti pembayaran berhasil diupload ulang. Pembayaran sedang ditinjau oleh admin.');
            return redirect()->route('pesanan.riwayat');

        } catch (\Exception $e) {
            Alert::error('Gagal!', 'Terjadi kesalahan saat mengupload bukti pembayaran. Silakan coba lagi.');
            return back();
        }
    }
}