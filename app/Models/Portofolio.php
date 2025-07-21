<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Portofolio extends Model
{
    use HasFactory;

    protected $table = 'portofolio';

    protected $fillable = [
        'judul',
        'deskripsi_singkat',
        'gambar_utama',
        'video_url',
        'video_file',
        'tanggal_proyek',
        'status'
    ];

    protected $casts = [
        'tanggal_proyek' => 'date'
    ];

    // Scope untuk portofolio aktif
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Accessor untuk URL gambar utama
    public function getGambarUtamaUrlAttribute()
    {
        if ($this->gambar_utama) {
            return Storage::url($this->gambar_utama);
        }
        return asset('img/no-image.png');
    }

    // Accessor untuk URL video file
    public function getVideoFileUrlAttribute()
    {
        if ($this->video_file) {
            return Storage::url($this->video_file);
        }
        return null;
    }

    // Accessor untuk format tanggal
    public function getFormattedTanggalAttribute()
    {
        return $this->tanggal_proyek ? $this->tanggal_proyek->format('d M Y') : '-';
    }



    // Method untuk mendapatkan embed URL YouTube
    public function getYoutubeEmbedUrlAttribute()
    {
        if ($this->video_url) {
            // Extract video ID from various YouTube URL formats
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches);
            if (isset($matches[1])) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
        }
        return null;
    }

    // Method untuk cek apakah ada media (gambar atau video)
    public function hasMediaAttribute()
    {
        return $this->gambar_utama || $this->video_url || $this->video_file;
    }
}
