@extends('frontend.layouts.main')

@section('container')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-100 to-slate-200 py-20">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 mb-6">
            Hubungi <span class="text-slate-700">Kami</span>
        </h1>
        <p class="text-xl text-gray-600 max-w-3xl mx-auto">
            Siap membantu mewujudkan kebutuhan seragam berkualitas tinggi untuk Anda
        </p>
    </div>
</section>

<!-- Contact Information -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Info -->
            <div class="space-y-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-6">Informasi Kontak</h2>
                    <p class="text-gray-600 mb-8">
                        Jangan ragu untuk menghubungi kami. Tim kami siap membantu Anda dengan pelayanan terbaik.
                    </p>
                </div>
                
                <div class="space-y-6">
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Alamat</h3>
                            <p class="text-gray-600">Jl. Raya Surabaya No. 123<br>Surabaya, Jawa Timur 60111</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Telepon</h3>
                            <p class="text-gray-600">(031) 123-4567<br>0812-3456-7890</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Email</h3>
                            <p class="text-gray-600">info@konveksisurabaya.com<br>order@konveksisurabaya.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start space-x-4">
                        <div class="w-12 h-12 bg-slate-100 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-1">Jam Operasional</h3>
                            <p class="text-gray-600">Senin - Sabtu: 08:00 - 17:00<br>Minggu: 09:00 - 15:00</p>
                        </div>
                    </div>
                </div>
                
                <div class="pt-6">
                    <a href="https://wa.me/6281234567890" class="bg-slate-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-slate-800 transition-colors inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                        </svg>
                        Chat WhatsApp
                    </a>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="bg-slate-50 rounded-2xl p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Kirim Pesan</h3>
                <form class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="Masukkan nama lengkap">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon</label>
                            <input type="tel" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="Masukkan nomor telepon">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="Masukkan email">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
                        <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent">
                            <option>Pilih jenis layanan</option>
                            <option>Seragam Instansi</option>
                            <option>Seragam Perusahaan</option>
                            <option>Seragam Sekolah</option>
                            <option>Seragam Mahasiswa</option>
                            <option>Kaos Custom</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pesan</label>
                        <textarea rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-slate-500 focus:border-transparent" placeholder="Jelaskan kebutuhan Anda..."></textarea>
                    </div>
                    <button type="submit" class="w-full bg-slate-700 text-white py-3 px-6 rounded-lg font-semibold hover:bg-slate-800 transition-colors">
                        Kirim Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- About Us Section -->
<section class="py-20 bg-slate-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Tentang Kami</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Konveksi terpercaya dengan pengalaman puluhan tahun melayani berbagai kebutuhan seragam berkualitas
            </p>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-16">
            <div class="space-y-6">
                <h3 class="text-3xl font-bold text-gray-900">Sejarah Perusahaan</h3>
                <p class="text-gray-600 leading-relaxed">
                    Didirikan pada tahun 2008, Konveksi Surabaya telah menjadi pilihan utama untuk kebutuhan seragam berkualitas tinggi di Surabaya dan sekitarnya. Dengan pengalaman lebih dari 15 tahun, kami telah melayani ratusan klien dari berbagai kalangan.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Komitmen kami adalah memberikan produk berkualitas tinggi dengan pelayanan terbaik. Setiap produk yang kami hasilkan melalui proses kontrol kualitas yang ketat untuk memastikan kepuasan pelanggan.
                </p>
            </div>
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Konveksi Surabaya" class="w-full h-48 object-contain rounded-lg mb-6">
                <div class="text-center">
                    <h4 class="text-xl font-bold text-gray-900 mb-2">Konveksi Surabaya</h4>
                    <p class="text-gray-600">Sejak 2008 - Kualitas Terpercaya</p>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <div class="text-center">
                <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Visi</h4>
                <p class="text-gray-600">
                    Menjadi konveksi terdepan di Indonesia yang mengutamakan kualitas, inovasi, dan kepuasan pelanggan.
                </p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Misi</h4>
                <p class="text-gray-600">
                    Memberikan produk seragam berkualitas tinggi dengan pelayanan terbaik dan harga yang kompetitif.
                </p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-3">Nilai</h4>
                <p class="text-gray-600">
                    Integritas, kualitas, inovasi, dan komitmen untuk memberikan yang terbaik bagi setiap pelanggan.
                </p>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl p-8">
            <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Tim Profesional</h3>
            <p class="text-gray-600 text-center mb-8 max-w-3xl mx-auto">
                Tim kami terdiri dari profesional berpengalaman yang siap membantu mewujudkan kebutuhan seragam Anda dengan standar kualitas terbaik.
            </p>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-700 mb-2">15+</div>
                    <div class="text-gray-600">Tahun Pengalaman</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-700 mb-2">500+</div>
                    <div class="text-gray-600">Klien Puas</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-700 mb-2">50+</div>
                    <div class="text-gray-600">Karyawan Ahli</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-700 mb-2">24/7</div>
                    <div class="text-gray-600">Layanan Konsultasi</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-20 bg-slate-700">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">
            Siap Berkolaborasi dengan Kami?
        </h2>
        <p class="text-xl text-slate-200 mb-8 max-w-2xl mx-auto">
            Hubungi kami sekarang untuk konsultasi gratis dan dapatkan penawaran terbaik untuk kebutuhan seragam Anda
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/6281234567890" class="bg-green-500 text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-600 transition-colors inline-flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
                Chat WhatsApp
            </a>
            <a href="tel:+6281234567890" class="bg-white text-slate-700 px-8 py-4 rounded-lg font-semibold hover:bg-slate-100 transition-colors inline-flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Telepon Sekarang
            </a>
        </div>
    </div>
</section>
@endsection
