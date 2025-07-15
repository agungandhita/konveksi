<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use RealRashid\SweetAlert\Facades\Alert;

class PesananController extends Controller
{
    /**
     * Menampilkan form pemesanan
     */
    public function index()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Silakan login terlebih dahulu untuk melakukan pemesanan.');
        }

        // Ambil semua layanan aktif untuk dropdown
        $layanan = Layanan::aktif()->orderBy('nama_layanan', 'asc')->get();

        return view('frontend.pesanan.index', compact('layanan'));
    }

    /**
     * Menyimpan data pemesanan
     */
    public function store(Request $request)
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Silakan login terlebih dahulu untuk melakukan pemesanan.');
        }

        // Validasi input
        $validated = $request->validate([
            'layanan_id' => 'required|exists:layanan,id',
            'nomor_whatsapp' => [
                'required',
                'string',
                'regex:/^(\+62|62|08)[0-9]{8,13}$/'
            ],
            'jumlah_order' => 'required|integer|min:1',
            'ukuran_baju' => 'required|in:S,M,L,XL,XXL,Custom',
            'ukuran_custom' => 'required_if:ukuran_baju,Custom|nullable|string|max:100',
            'file_desain_baju' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB
            'tambahan_bordir' => 'boolean',
            'file_desain_bordir' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120', // 5MB
            'keterangan_bordir' => 'nullable|string|max:500',
            'file_nama_tag' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048', // 2MB
            'keterangan_tambahan' => 'nullable|string|max:300'
        ], [
            'layanan_id.required' => 'Layanan harus dipilih.',
            'layanan_id.exists' => 'Layanan yang dipilih tidak valid.',
            'nomor_whatsapp.required' => 'Nomor WhatsApp harus diisi.',
            'nomor_whatsapp.regex' => 'Format nomor WhatsApp tidak valid. Gunakan format 08xxxxxxxxx atau +62xxxxxxxxx.',
            'jumlah_order.required' => 'Jumlah order harus diisi.',
            'jumlah_order.min' => 'Jumlah order minimal 1.',
            'ukuran_baju.required' => 'Ukuran baju harus dipilih.',
            'ukuran_custom.required_if' => 'Ukuran custom harus diisi jika memilih ukuran Custom.',
            'file_desain_baju.required' => 'File desain baju harus diunggah.',
            'file_desain_baju.mimes' => 'File desain baju harus berformat JPG, PNG, atau PDF.',
            'file_desain_baju.max' => 'Ukuran file desain baju maksimal 5MB.',
            'file_desain_bordir.mimes' => 'File desain bordir harus berformat JPG, PNG, atau PDF.',
            'file_desain_bordir.max' => 'Ukuran file desain bordir maksimal 5MB.',
            'file_nama_tag.mimes' => 'File nama tag harus berformat JPG, PNG, atau PDF.',
            'file_nama_tag.max' => 'Ukuran file nama tag maksimal 2MB.',
            'keterangan_tambahan.max' => 'Keterangan tambahan maksimal 300 karakter.'
        ]);

        // Validasi tambahan untuk bordir
        if ($request->has('tambahan_bordir') && $request->tambahan_bordir) {
            $request->validate([
                'file_desain_bordir' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120'
            ], [
                'file_desain_bordir.required' => 'File desain bordir harus diunggah jika memilih tambahan bordir.'
            ]);
        }

        try {
            // Upload file desain baju
            $fileDesainBaju = null;
            if ($request->hasFile('file_desain_baju')) {
                $fileDesainBaju = $request->file('file_desain_baju')->store('pesanan/desain-baju', 'public');
            }

            // Upload file desain bordir (jika ada)
            $fileDesainBordir = null;
            if ($request->hasFile('file_desain_bordir')) {
                $fileDesainBordir = $request->file('file_desain_bordir')->store('pesanan/desain-bordir', 'public');
            }

            // Upload file nama tag (jika ada)
            $fileNamaTag = null;
            if ($request->hasFile('file_nama_tag')) {
                $fileNamaTag = $request->file('file_nama_tag')->store('pesanan/nama-tag', 'public');
            }

            // Simpan data pesanan
            $pesanan = Pesanan::create([
                'user_id' => Auth::id(),
                'layanan_id' => $validated['layanan_id'],
                'nama_pemesan' => Auth::user()->name,
                'nomor_whatsapp' => $validated['nomor_whatsapp'],
                'jumlah_order' => $validated['jumlah_order'],
                'ukuran_baju' => $validated['ukuran_baju'],
                'ukuran_custom' => $validated['ukuran_custom'] ?? null,
                'file_desain_baju' => $fileDesainBaju,
                'tambahan_bordir' => $request->has('tambahan_bordir'),
                'file_desain_bordir' => $fileDesainBordir,
                'keterangan_bordir' => $validated['keterangan_bordir'] ?? null,
                'file_nama_tag' => $fileNamaTag,
                'keterangan_tambahan' => $validated['keterangan_tambahan'] ?? null,
                'status' => 'menunggu_pembayaran'
            ]);

            // Kalkulasi dan simpan total harga
            $totalHarga = $pesanan->calculateTotalPrice();
            $pesanan->update(['total_harga' => $totalHarga]);

            Alert::success('Berhasil!', 'Pesanan berhasil dibuat! Silakan lanjutkan ke pembayaran.');
            return redirect()->route('pembayaran.index', $pesanan->id);

        } catch (\Exception $e) {
            return back()->withInput()
                        ->withErrors(['error' => 'Terjadi kesalahan saat menyimpan pesanan. Silakan coba lagi.']);
        }
    }

    /**
     * Halaman sukses setelah pemesanan
     */
    public function success($id)
    {
        $pesanan = Pesanan::with(['layanan', 'user'])->findOrFail($id);

        // Pastikan pesanan milik user yang sedang login
        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('frontend.pesanan.success', compact('pesanan'));
    }

    /**
     * Riwayat pesanan user
     */
    public function riwayat()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Silakan login terlebih dahulu.');
        }

        $pesanan = Pesanan::with(['layanan', 'pembayaran'])
                         ->where('user_id', Auth::id())
                         ->orderBy('created_at', 'desc')
                         ->paginate(10);

        return view('frontend.pesanan.riwayat', compact('pesanan'));
    }

    /**
     * Detail pesanan
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['layanan', 'user'])->findOrFail($id);

        // Pastikan pesanan milik user yang sedang login
        if ($pesanan->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        return view('frontend.pesanan.detail', compact('pesanan'));
    }
}
