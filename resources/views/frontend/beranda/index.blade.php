@extends('frontend.layouts.main')

@section('container')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-slate-100 to-slate-200 py-20">
    <div class="max-w-6xl mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-8">
                <div class="space-y-4">
                    <h1 class="text-4xl lg:text-5xl font-bold text-gray-900 leading-tight">
                        Jasa Konveksi <span class="text-slate-700">Terpercaya</span> di Surabaya
                    </h1>
                    <p class="text-xl text-gray-600 leading-relaxed">
                        Melayani pembuatan seragam berkualitas tinggi untuk instansi, perusahaan, sekolah, dan mahasiswa dengan pengalaman puluhan tahun.
                    </p>
                </div>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="#layanan" class="bg-slate-700 text-white px-8 py-4 rounded-lg font-semibold hover:bg-slate-800 transition-colors text-center">
                        Lihat Layanan Kami
                    </a>
                    <a href="#kontak" class="border-2 border-slate-700 text-slate-700 px-8 py-4 rounded-lg font-semibold hover:bg-slate-700 hover:text-white transition-colors text-center">
                        Hubungi Kami
                    </a>
                </div>
                <div class="grid grid-cols-3 gap-6 pt-8">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-slate-700">15+</div>
                        <div class="text-gray-600">Tahun Pengalaman</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-slate-700">500+</div>
                        <div class="text-gray-600">Klien Puas</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-slate-700">24</div>
                        <div class="text-gray-600">Jam Layanan</div>
                    </div>
                </div>
            </div>
            <div class="relative">
                <div class="bg-white rounded-2xl shadow-2xl p-8">
                    <img src="{{ asset('img/logo.jpeg') }}" alt="Logo Konveksi Surabaya" class="w-full h-64 object-contain rounded-lg">
                    <div class="mt-6 text-center">
                        <h3 class="text-2xl font-bold text-gray-900">Konveksi Surabaya</h3>
                        <p class="text-gray-600 mt-2">Kualitas Terjamin, Harga Terjangkau</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Layanan Section -->
<section id="layanan" class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Layanan Kami</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Kami menyediakan berbagai jenis layanan konveksi dengan kualitas terbaik dan harga yang kompetitif
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Seragam Instansi</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pembuatan seragam untuk berbagai instansi pemerintah dan swasta dengan standar kualitas tinggi.
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Seragam Perusahaan</h3>
                <p class="text-gray-600 leading-relaxed">
                    Seragam kerja untuk perusahaan swasta dengan desain profesional dan bahan berkualitas.
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Seragam Sekolah</h3>
                <p class="text-gray-600 leading-relaxed">
                    Seragam sekolah untuk berbagai tingkat pendidikan dengan bahan yang nyaman dan tahan lama.
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Seragam Mahasiswa</h3>
                <p class="text-gray-600 leading-relaxed">
                    Jas almamater, seragam praktikum, dan berbagai kebutuhan seragam mahasiswa.
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Kaos Custom</h3>
                <p class="text-gray-600 leading-relaxed">
                    Pembuatan kaos custom untuk event, komunitas, dan keperluan promosi dengan desain sesuai keinginan.
                </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-8 hover:shadow-lg transition-shadow">
                <div class="w-16 h-16 bg-slate-100 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-4">Konsultasi Gratis</h3>
                <p class="text-gray-600 leading-relaxed">
                    Konsultasi gratis untuk pemilihan bahan, desain, dan estimasi biaya sesuai kebutuhan Anda.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Mengapa Memilih Kami -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Mengapa Memilih Kami?</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Kepercayaan ratusan klien adalah bukti komitmen kami terhadap kualitas dan pelayanan terbaik
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center">
                <div class="w-20 h-20 bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kualitas Terjamin</h3>
                <p class="text-gray-600">Menggunakan bahan berkualitas tinggi dengan jahitan rapi dan tahan lama</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-slate-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pengerjaan Cepat</h3>
                <p class="text-gray-600">Proses produksi yang efisien dengan waktu pengerjaan sesuai kesepakatan</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-slate-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Kompetitif</h3>
                <p class="text-gray-600">Harga yang terjangkau dengan kualitas premium untuk semua kalangan</p>
            </div>
            <div class="text-center">
                <div class="w-20 h-20 bg-slate-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Pelayanan Ramah</h3>
                <p class="text-gray-600">Tim yang berpengalaman dan siap membantu dari konsultasi hingga selesai</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimoni -->
<section class="py-20 bg-white">
    <div class="max-w-6xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Apa Kata Klien Kami</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Kepuasan klien adalah prioritas utama kami
            </p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-gray-50 rounded-xl p-8">
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                    </div>
                </div>
                <p class="text-gray-600 mb-6 italic">
                    "Pelayanan sangat memuaskan! Seragam untuk kantor kami dibuat dengan kualitas yang sangat baik dan tepat waktu. Highly recommended!"
                </p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-slate-700 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        A
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Ahmad Susanto</h4>
                        <p class="text-gray-600 text-sm">HRD PT. Maju Bersama</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-8">
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                    </div>
                </div>
                <p class="text-gray-600 mb-6 italic">
                    "Sudah beberapa kali order seragam sekolah di sini. Kualitas bagus, harga terjangkau, dan pelayanannya ramah. Terima kasih!"
                </p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-slate-600 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        S
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Siti Nurhaliza</h4>
                        <p class="text-gray-600 text-sm">Kepala Sekolah SDN 1 Surabaya</p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-8">
                <div class="flex items-center mb-4">
                    <div class="flex text-yellow-400">
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                    </div>
                </div>
                <p class="text-gray-600 mb-6 italic">
                    "Jas almamater untuk wisuda dibuat dengan sangat rapi dan sesuai ukuran. Proses pemesanan juga mudah dan cepat. Recommended!"
                </p>
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-slate-500 rounded-full flex items-center justify-center text-white font-bold mr-4">
                        R
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">Rizki Pratama</h4>
                        <p class="text-gray-600 text-sm">Mahasiswa Universitas Airlangga</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section id="kontak" class="py-20 bg-slate-700">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">
            Siap Mewujudkan Seragam Impian Anda?
        </h2>
        <p class="text-xl text-slate-200 mb-8 max-w-2xl mx-auto">
            Hubungi kami sekarang untuk konsultasi gratis dan dapatkan penawaran terbaik untuk kebutuhan seragam Anda
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="https://wa.me/6281234567890" class="bg-green-500 text-white px-8 py-4 rounded-lg font-semibold hover:bg-green-600 transition-colors inline-flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                </svg>
                WhatsApp Kami
            </a>
            <a href="tel:+6231234567890" class="bg-white text-blue-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                </svg>
                Telepon Kami
            </a>
        </div>
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
            <div class="bg-blue-700 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-blue-200 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-white">Alamat</h3>
                </div>
                <p class="text-blue-100">
                    Jl. Raya Surabaya No. 123<br>
                    Surabaya, Jawa Timur 60111
                </p>
            </div>
            <div class="bg-blue-700 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-blue-200 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-white">Jam Operasional</h3>
                </div>
                <p class="text-blue-100">
                    Senin - Sabtu: 08:00 - 17:00<br>
                    Minggu: 09:00 - 15:00
                </p>
            </div>
            <div class="bg-blue-700 rounded-lg p-6">
                <div class="flex items-center mb-4">
                    <svg class="w-6 h-6 text-blue-200 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-white">Email</h3>
                </div>
                <p class="text-blue-100">
                    info@konveksisurabaya.com<br>
                    order@konveksisurabaya.com
                </p>
            </div>
        </div>
    </div>
</section>
@endsection
