<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    /**
     * Menampilkan halaman katalog produk
     */
    public function index()
    {
        // Ambil semua produk yang aktif
        $produk = Produk::aktif()->orderBy('created_at', 'desc')->get();
        
        return view('frontend.katalog.index', compact('produk'));
    }
    
    /**
     * Menampilkan detail produk
     */
    public function show($id)
    {
        $produk = Produk::aktif()->findOrFail($id);
        
        return view('frontend.katalog.detail', compact('produk'));
    }
}