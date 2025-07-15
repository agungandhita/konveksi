<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    /**
     * Menampilkan halaman layanan
     */
    public function index()
    {
        // Ambil semua layanan yang aktif
        $layanan = Layanan::aktif()->orderBy('created_at', 'desc')->get();
        
        return view('frontend.services.index', compact('layanan'));
    }
}