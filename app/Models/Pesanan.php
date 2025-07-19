<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'layanan_id',
        'nama_pemesan',
        'nomor_whatsapp',
        'jumlah_order',
        'ukuran_baju',
        'ukuran_custom',
        'file_desain_baju',
        'tambahan_bordir',
        'file_desain_bordir',
        'keterangan_bordir',
        'file_nama_tag',
        'keterangan_tambahan',
        'total_harga',
        'status'
    ];

    protected $casts = [
        'tambahan_bordir' => 'boolean',
        'jumlah_order' => 'integer',
        'total_harga' => 'decimal:2'
    ];

    /**
     * Relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke Layanan
     */
    public function layanan(): BelongsTo
    {
        return $this->belongsTo(Layanan::class);
    }

    /**
     * Relasi ke Pembayaran
     */
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }

    /**
     * Scope untuk pesanan berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk pesanan pending
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope untuk pesanan diproses
     */
    public function scopeDiproses($query)
    {
        return $query->where('status', 'diproses');
    }

    /**
     * Accessor untuk format nomor WhatsApp
     */
    public function getFormattedWhatsappAttribute()
    {
        $nomor = $this->nomor_whatsapp;
        
        // Hapus karakter non-digit
        $nomor = preg_replace('/[^0-9]/', '', $nomor);
        
        // Jika dimulai dengan 08, ganti dengan 628
        if (substr($nomor, 0, 2) === '08') {
            $nomor = '628' . substr($nomor, 2);
        }
        
        // Jika dimulai dengan 62, pastikan tidak ada duplikasi
        if (substr($nomor, 0, 2) === '62' && substr($nomor, 0, 3) !== '628') {
            $nomor = '628' . substr($nomor, 2);
        }
        
        return $nomor;
    }

    /**
     * Accessor untuk status badge
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'menunggu_pembayaran' => 'bg-orange-100 text-orange-800',
            'menunggu_verifikasi' => 'bg-purple-100 text-purple-800',
            'diproses' => 'bg-blue-100 text-blue-800',
            'selesai' => 'bg-green-100 text-green-800',
            'dibatalkan' => 'bg-red-100 text-red-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Kalkulasi total harga pesanan
     */
    public function calculateTotalPrice()
    {
        // Dapatkan harga berdasarkan ukuran, jika tidak ada gunakan harga default
        $hargaPerPcs = $this->layanan->getHargaByUkuran($this->ukuran_baju);
        $hargaLayanan = $hargaPerPcs * $this->jumlah_order;
        $hargaBordir = $this->tambahan_bordir ? 15000 * $this->jumlah_order : 0; // Rp 15.000 per pcs untuk bordir
        
        return $hargaLayanan + $hargaBordir;
    }

    /**
     * Accessor untuk format total harga
     */
    public function getFormattedTotalHargaAttribute()
    {
        return $this->total_harga ? 'Rp ' . number_format($this->total_harga, 0, ',', '.') : '-';
    }

    /**
     * Get harga bordir
     */
    public function getHargaBordir()
    {
        return $this->tambahan_bordir ? 15000 * $this->jumlah_order : 0;
    }

    /**
     * Accessor untuk format harga bordir
     */
    public function getFormattedHargaBordirAttribute()
    {
        return 'Rp ' . number_format($this->getHargaBordir(), 0, ',', '.');
    }

    /**
     * Generate pesan WhatsApp otomatis
     */
    public function generateWhatsappMessage()
    {
        $message = "*FORM PEMESANAN KONVEKSI*\n\n";
        $message .= "Nama Pemesan: {$this->nama_pemesan}\n";
        $message .= "Layanan: {$this->layanan->nama_layanan}\n";
        $message .= "Jumlah Order: {$this->jumlah_order}\n";
        $message .= "Ukuran: {$this->ukuran_baju}";
        
        if ($this->ukuran_baju === 'Custom' && $this->ukuran_custom) {
            $message .= " ({$this->ukuran_custom})";
        }
        
        $message .= "\n";
        
        if ($this->tambahan_bordir) {
            $message .= "Tambahan Bordir: Ya\n";
            if ($this->keterangan_bordir) {
                $message .= "Keterangan Bordir: {$this->keterangan_bordir}\n";
            }
        }
        
        if ($this->keterangan_tambahan) {
            $message .= "Keterangan Tambahan: {$this->keterangan_tambahan}\n";
        }
        
        $message .= "\nTerima kasih! Mohon konfirmasi untuk melanjutkan pemesanan.";
        
        return urlencode($message);
    }
}