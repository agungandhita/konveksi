@extends('frontend.layouts.main')

@section('title', 'Tentang Kami')

@section('container')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-blue-50 to-indigo-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                Tentang <span class="text-blue-600">Konveksi Surabaya</span>
            </h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Lebih dari 10 tahun melayani kebutuhan konveksi berkualitas tinggi dengan dedikasi dan inovasi terdepan
            </p>
        </div>
    </div>
</section>

<!-- Company Story Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Cerita Kami</h2>
                <div class="space-y-4 text-gray-600">
                    <p>
                        Konveksi Surabaya didirikan pada tahun 2013 dengan visi menjadi penyedia layanan konveksi terpercaya di Indonesia. Dimulai dari workshop kecil dengan 3 orang karyawan, kini kami telah berkembang menjadi perusahaan konveksi yang melayani berbagai kebutuhan pakaian custom.
                    </p>
                    <p>
                        Dengan pengalaman lebih dari satu dekade, kami telah melayani ribuan pelanggan dari berbagai kalangan, mulai dari individu, komunitas, sekolah, hingga perusahaan besar. Komitmen kami adalah memberikan produk berkualitas tinggi dengan harga yang kompetitif.
                    </p>
                    <p>
                        Kami bangga menjadi bagian dari pertumbuhan bisnis dan komunitas di Indonesia melalui produk-produk konveksi yang kami hasilkan.
                    </p>
                </div>
            </div>
            <div class="relative">
                <div class="bg-gradient-to-br from-blue-100 to-indigo-200 rounded-2xl p-8 text-center">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <div class="text-3xl font-bold text-blue-600 mb-2">10+</div>
                            <div class="text-sm text-gray-600">Tahun Pengalaman</div>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <div class="text-3xl font-bold text-green-600 mb-2">5000+</div>
                            <div class="text-sm text-gray-600">Pelanggan Puas</div>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <div class="text-3xl font-bold text-purple-600 mb-2">50+</div>
                            <div class="text-sm text-gray-600">Jenis Produk</div>
                        </div>
                        <div class="bg-white rounded-lg p-6 shadow-sm">
                            <div class="text-3xl font-bold text-orange-600 mb-2">24/7</div>
                            <div class="text-sm text-gray-600">Customer Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Visi & Misi Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Komitmen kami untuk memberikan yang terbaik bagi pelanggan dan berkontribusi pada industri konveksi Indonesia
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Vision -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-eye text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Visi</h3>
                <p class="text-gray-600 leading-relaxed">
                    Menjadi perusahaan konveksi terdepan di Indonesia yang dikenal karena kualitas produk, inovasi desain, dan pelayanan pelanggan yang luar biasa, serta berkontribusi pada pengembangan industri fashion lokal.
                </p>
            </div>
            
            <!-- Mission -->
            <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-bullseye text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Misi</h3>
                <ul class="text-gray-600 space-y-2">
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-3 flex-shrink-0"></i>
                        Menghasilkan produk konveksi berkualitas tinggi dengan standar internasional
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-3 flex-shrink-0"></i>
                        Memberikan pelayanan pelanggan yang responsif dan profesional
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-3 flex-shrink-0"></i>
                        Mengembangkan inovasi dalam desain dan teknologi produksi
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-green-500 mt-1 mr-3 flex-shrink-0"></i>
                        Mendukung pertumbuhan ekonomi lokal dan pemberdayaan masyarakat
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Nilai-Nilai Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Prinsip-prinsip yang menjadi fondasi dalam setiap langkah perjalanan bisnis kami
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Quality -->
            <div class="text-center">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-medal text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kualitas</h3>
                <p class="text-gray-600">
                    Komitmen pada standar kualitas tinggi dalam setiap produk yang kami hasilkan
                </p>
            </div>
            
            <!-- Innovation -->
            <div class="text-center">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lightbulb text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Inovasi</h3>
                <p class="text-gray-600">
                    Terus berinovasi dalam desain, teknologi, dan metode produksi untuk hasil terbaik
                </p>
            </div>
            
            <!-- Trust -->
            <div class="text-center">
                <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-handshake text-purple-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kepercayaan</h3>
                <p class="text-gray-600">
                    Membangun hubungan jangka panjang berdasarkan kepercayaan dan transparansi
                </p>
            </div>
            
            <!-- Service -->
            <div class="text-center">
                <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-heart text-orange-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pelayanan</h3>
                <p class="text-gray-600">
                    Mengutamakan kepuasan pelanggan melalui pelayanan yang ramah dan profesional
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Team Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Tim Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Dibalik setiap produk berkualitas, ada tim profesional yang berdedikasi tinggi
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Team Member 1 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Budi Santoso</h3>
                <p class="text-blue-600 font-medium mb-3">Founder & CEO</p>
                <p class="text-gray-600 text-sm">
                    Memimpin visi perusahaan dengan pengalaman 15+ tahun di industri tekstil dan fashion
                </p>
            </div>
            
            <!-- Team Member 2 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Sari Dewi</h3>
                <p class="text-green-600 font-medium mb-3">Head of Design</p>
                <p class="text-gray-600 text-sm">
                    Kreator di balik desain-desain inovatif dengan background fashion design dari universitas terkemuka
                </p>
            </div>
            
            <!-- Team Member 3 -->
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 text-center">
                <div class="w-24 h-24 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user text-white text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Ahmad Rizki</h3>
                <p class="text-purple-600 font-medium mb-3">Production Manager</p>
                <p class="text-gray-600 text-sm">
                    Mengawasi kualitas produksi dengan standar tinggi dan memastikan ketepatan waktu pengiriman
                </p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-blue-600 to-indigo-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">
            Siap Berkolaborasi dengan Kami?
        </h2>
        <p class="text-blue-100 text-xl mb-8 max-w-2xl mx-auto">
            Mari wujudkan ide kreatif Anda menjadi produk konveksi berkualitas tinggi bersama tim profesional kami
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('katalog.index') }}" class="inline-flex items-center px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg hover:bg-gray-50 transition-colors">
                <i class="fas fa-shopping-bag mr-2"></i>
                Lihat Katalog
            </a>
            <a href="{{ route('contact.index') }}" class="inline-flex items-center px-8 py-3 bg-transparent border-2 border-white text-white font-semibold rounded-lg hover:bg-white hover:text-blue-600 transition-colors">
                <i class="fas fa-phone mr-2"></i>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
