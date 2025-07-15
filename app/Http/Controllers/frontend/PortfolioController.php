<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Portofolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Menampilkan halaman portfolio
     */
    public function index()
    {
        // Ambil semua portfolio yang aktif
        $portfolio = Portofolio::aktif()->orderBy('created_at', 'desc')->get();
        
        return view('frontend.portfolio.index', compact('portfolio'));
    }
}