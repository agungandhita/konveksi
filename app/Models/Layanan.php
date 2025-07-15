<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanan';

    protected $fillable = [
        'nama_layanan',
        'deskripsi_singkat',
        'estimasi_waktu',
        'minimal_order',
        'satuan_order',
        'perkiraan_harga',
        'status'
    ];

    protected $casts = [
        'estimasi_waktu' => 'integer',
        'minimal_order' => 'integer',
        'perkiraan_harga' => 'decimal:2'
    ];

    // Scope untuk layanan aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Accessor untuk format harga
    public function getFormattedHargaAttribute()
    {
        return $this->perkiraan_harga ? 'Rp ' . number_format($this->perkiraan_harga, 0, ',', '.') : '-';
    }

    // Accessor untuk format estimasi
    public function getFormattedEstimasiAttribute()
    {
        return $this->estimasi_waktu . ' hari';
    }

    // Accessor untuk format minimal order
    public function getFormattedMinimalOrderAttribute()
    {
        return $this->minimal_order . ' ' . $this->satuan_order;
    }
}