<aside id="sidebar" class="fixed left-0 top-0 z-30 h-screen w-60 bg-white border-r border-slate-200 shadow-sm transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 border-b border-slate-200">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('img/logo.jpeg') }}" alt="Logo" class="w-8 h-8 rounded-lg">
            <span class="text-lg font-semibold text-slate-800">Konveksi</span>
        </div>
        <button id="sidebar-close" class="lg:hidden p-1 rounded hover:bg-slate-100">
            <i class="fas fa-times text-slate-600"></i>
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="mt-6 px-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'text-blue-700 bg-blue-50 border-r-2 border-blue-500' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-home mr-3"></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pesanan.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.pesanan.*') ? 'text-blue-700 bg-blue-50 border-r-2 border-blue-500' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-shopping-cart mr-3"></i>
                    Pesanan
                    @php
                        $pendingCount = \App\Models\Pesanan::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="ml-auto bg-red-100 text-red-600 text-xs px-2 py-1 rounded-full">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pembayaran.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.pembayaran.*') ? 'text-blue-700 bg-blue-50 border-r-2 border-blue-500' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-credit-card mr-3"></i>
                    Pembayaran
                    @php
                        $pembayaranMenunggu = \App\Models\Pembayaran::whereIn('status_pembayaran', ['menunggu', 'ditinjau'])->count();
                    @endphp
                    @if($pembayaranMenunggu > 0)
                        <span class="ml-auto bg-orange-100 text-orange-600 text-xs px-2 py-1 rounded-full">{{ $pembayaranMenunggu }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.produk.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.produk.*') ? 'text-blue-700 bg-blue-50 border-r-2 border-blue-500' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-box mr-3"></i>
                    Produk
                </a>
            </li>
            <li>
                <a href="{{ route('admin.layanan.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.layanan.*') ? 'text-blue-700 bg-blue-50 border-r-2 border-blue-500' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-concierge-bell mr-3"></i>
                    Layanan
                </a>
            </li>
            <li>
                <a href="{{ route('admin.portofolio.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.portofolio.*') ? 'text-blue-700 bg-blue-50 border-r-2 border-blue-500' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-images mr-3"></i>
                    Kelola Portofolio
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.users.*') ? 'text-blue-700 bg-blue-50 border-r-2 border-blue-500' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-users mr-3"></i>
                    Pengguna
                </a>
            </li>
            <li>
                <a href="{{ route('admin.laporan.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.laporan.*') ? 'text-blue-700 bg-blue-50 border-r-2 border-blue-500' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                    <i class="fas fa-chart-bar mr-3"></i>
                    Laporan
                </a>
            </li>
        </ul>

        <hr class="my-6 border-slate-200">

        <div class="mb-4">
            <h3 class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-3">Pengaturan</h3>
            <ul class="space-y-2">
                <li>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.konfigurasi.*') ? 'text-blue-700 bg-blue-50 border-r-2 border-blue-500' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                        <i class="fas fa-cog mr-3"></i>
                        Konfigurasi
                    </a>
                </li>
                <li>
                    <a href="#" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors duration-200 {{ request()->routeIs('admin.profile.*') ? 'text-blue-700 bg-blue-50 border-r-2 border-blue-500' : 'text-slate-700 hover:bg-blue-50 hover:text-blue-700' }}">
                        <i class="fas fa-user-circle mr-3"></i>
                        Profile
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-slate-200">
        <div class="flex items-center space-x-3 p-3 bg-slate-50 rounded-lg">
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white text-sm"></i>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-slate-900 truncate">Admin User</p>
                <p class="text-xs text-slate-500 truncate">admin@konveksi.com</p>
            </div>
        </div>
    </div>
</aside>

<!-- Sidebar Overlay untuk Mobile -->
<div id="sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-20 lg:hidden hidden"></div>
