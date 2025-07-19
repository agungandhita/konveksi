<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LayananHargaUkuran extends Model
{
    use HasFactory;

    protected $table = 'layanan_harga_ukuran';

    protected $fillable = [
        'layanan_id',
        'ukuran',
        'harga'
    ];

    protected $casts = [
        'harga' => 'decimal:2'
    ];

    // Relasi ke layanan
    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }

    // Accessor untuk format harga
    public function getFormattedHargaAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Static method untuk mendapatkan daftar ukuran
    public static function getUkuranOptions()
    {
        return [
            'S' => 'S',
            'M' => 'M', 
            'L' => 'L',
            'XL' => 'XL',
            'XXL' => 'XXL',
            'Custom' => 'Custom'
        ];
    }
}