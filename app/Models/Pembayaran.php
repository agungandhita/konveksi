<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'pesanan_id',
        'total_harga',
        'harga_bordir',
        'metode_pembayaran',
        'nomor_rekening',
        'nama_pemilik_rekening',
        'bukti_pembayaran',
        'status_pembayaran',
        'catatan_admin',
        'tanggal_upload',
        'tanggal_verifikasi'
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'harga_bordir' => 'decimal:2',
        'tanggal_upload' => 'datetime',
        'tanggal_verifikasi' => 'datetime'
    ];

    /**
     * Relasi ke Pesanan
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

    /**
     * Accessor untuk format total harga
     */
    public function getFormattedTotalHargaAttribute()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    /**
     * Accessor untuk format harga bordir
     */
    public function getFormattedHargaBordirAttribute()
    {
        return 'Rp ' . number_format($this->harga_bordir, 0, ',', '.');
    }

    /**
     * Accessor untuk status badge
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'menunggu' => 'bg-gray-100 text-gray-800',
            'ditinjau' => 'bg-yellow-100 text-yellow-800',
            'diterima' => 'bg-green-100 text-green-800',
            'ditolak' => 'bg-red-100 text-red-800'
        ];

        return $badges[$this->status_pembayaran] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Scope untuk filter berdasarkan status pembayaran
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status_pembayaran', $status);
    }

    /**
     * Get informasi rekening berdasarkan metode pembayaran
     */
    public static function getBankInfo($metode)
    {
        $bankInfo = [
            'DANA' => [
                'nama' => 'DANA',
                'nomor' => '081234567890',
                'atas_nama' => 'CV. Konveksi Berkah'
            ],
            'MANDIRI' => [
                'nama' => 'Bank Mandiri',
                'nomor' => '1234567890123',
                'atas_nama' => 'CV. Konveksi Berkah'
            ],
            'BCA' => [
                'nama' => 'Bank BCA',
                'nomor' => '1234567890',
                'atas_nama' => 'CV. Konveksi Berkah'
            ]
        ];

        return $bankInfo[$metode] ?? null;
    }
}