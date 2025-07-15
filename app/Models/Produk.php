<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'nama_produk',
        'deskripsi_singkat',
        'harga',
        'foto_produk',
        'link_pembelian',
        'status'
    ];

    protected $casts = [
        'harga' => 'decimal:2'
    ];

    // Scope untuk produk aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Accessor untuk format harga
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Accessor untuk URL foto
    public function getFotoUrlAttribute()
    {
        if ($this->foto_produk && Storage::disk('public')->exists($this->foto_produk)) {
            return Storage::url($this->foto_produk);
        }
        return asset('img/no-image.png'); // Default image jika tidak ada foto
    }

    // Accessor untuk thumbnail foto
    public function getThumbnailUrlAttribute()
    {
        return $this->foto_url; // Bisa dikembangkan untuk resize image
    }

    // Mutator untuk validasi link pembelian
    public function setLinkPembelianAttribute($value)
    {
        // Jika link tidak kosong dan tidak dimulai dengan http/https, tambahkan https://
        if (!empty($value) && !preg_match('/^https?:\/\//i', $value)) {
            $value = 'https://' . $value;
        }
        $this->attributes['link_pembelian'] = $value;
    }

    // Method untuk menghapus foto lama
    public function deleteFoto()
    {
        if ($this->foto_produk && Storage::disk('public')->exists($this->foto_produk)) {
            Storage::disk('public')->delete($this->foto_produk);
        }
    }
}