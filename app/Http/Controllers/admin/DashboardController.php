<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard
        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalCustomers = User::where('role', 'user')->count();
        $recentUsers = User::latest()->take(5)->get();

        // Get monthly user registration data for chart
        $monthlyUsers = User::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return view('admin.dashboard.index', compact(
            'totalUsers',
            'totalAdmins',
            'totalCustomers',
            'recentUsers',
            'monthlyUsers'
        ));
    }
}
