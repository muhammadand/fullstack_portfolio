@extends('pages.layouts.app')
@section('content')
<!-- ABOUT SECTION -->
<section id="about" class="py-20 px-6 bg-white relative overflow-hidden">
    <!-- Background Decorations -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-purple-100 rounded-full opacity-30 blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-100 rounded-full opacity-30 blur-3xl"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-16">
            <span class="inline-block px-4 py-2 bg-purple-100 text-purple-700 rounded-full text-sm font-semibold mb-4">
                GET TO KNOW ME
            </span>
            <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                Tentang <span class="bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">Saya</span>
            </h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Dari passion menjadi profesi, perjalanan membangun solusi digital yang bermakna
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <!-- Left Content -->
            <div class="order-2 lg:order-1">
                <!-- Story -->
                <div class="mb-8">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
                        <span class="w-1 h-8 bg-purple-600 rounded-full"></span>
                        Perjalanan Saya
                    </h3>
                    <div class="space-y-4 text-gray-700 leading-relaxed">
                        <p>
                            Halo! Saya <span class="font-semibold text-purple-600">Muhammad Andi Mubarok</span>. Perjalanan saya di dunia teknologi dimulai sejak SMA ketika saya pertama kali belajar coding. Dari sana, passion saya terhadap problem-solving melalui kode mulai berkembang.
                        </p>
                        <p>
                            Saya lulus dari Sistem Informasi dengan IPK 3.69, dan pengalaman akademik itu memberikan fondasi kuat tentang bagaimana sistem bekerja. Tapi yang lebih penting, saya belajar bahwa teknologi harus melayani manusia, bukan sebaliknya.
                        </p>
                        <p>
                            Tiga tahun lalu, saya memutuskan untuk mendirikan <span class="font-semibold text-purple-600">Barack Digital</span>—sebuah digital agency yang fokus pada kualitas dan hasil nyata. Kenapa? Karena saya melihat banyak bisnis yang kebingungan dengan digital transformation. Mereka butuh mitra yang tidak hanya bisa technical, tapi juga mengerti bisnis.
                        </p>
                    </div>
                </div>

                <!-- Core Values -->
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Nilai yang Saya Pegang</h3>
                    <div class="space-y-4">
                        <div class="flex items-start gap-4 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center text-white flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-award"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 mb-1">Fokus pada Kualitas</p>
                                <p class="text-gray-600 text-sm">Setiap project dikerjakan dengan standar tinggi dan attention to detail.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-white flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-comments"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 mb-1">Komunikasi Transparan</p>
                                <p class="text-gray-600 text-sm">Saya percaya transparansi adalah kunci hubungan klien yang baik.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 group">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center text-white flex-shrink-0 shadow-lg group-hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-rocket"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-gray-900 mb-1">Efisiensi Maksimal</p>
                                <p class="text-gray-600 text-sm">Delivery tepat waktu tanpa mengurangi kualitas hasil kerja.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quote -->
                <div class="bg-gradient-to-r from-purple-50 to-blue-50 border-l-4 border-purple-600 rounded-r-2xl p-6">
                    <p class="text-lg text-gray-800 font-semibold italic flex items-start gap-3">
                        <i class="fas fa-quote-left text-purple-600 text-2xl"></i>
                        <span>Saya di sini untuk membantu bisnis Anda berkembang. Mari kita ciptakan sesuatu yang luar biasa bersama.</span>
                    </p>
                </div>
            </div>

            <!-- Right Image & Stats -->
            <div class="order-1 lg:order-2">
                <!-- Profile Image -->
                <div class="relative mb-8">
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <img src="{{asset('foto.jpg')}}" 
                             alt="Muhammad Andi Mubarok" 
                             class="w-full h-[500px] object-cover hover:scale-105 transition-transform duration-500">
                        
                        <!-- Overlay Gradient -->
                        <div class="absolute inset-0 bg-gradient-to-t from-purple-900/60 via-transparent to-transparent"></div>
                        
                        <!-- Name Badge on Image -->
                        <div class="absolute bottom-6 left-6 right-6">
                            <div class="bg-white/95 backdrop-blur-sm rounded-2xl p-4 shadow-xl">
                                <h3 class="text-xl font-bold text-gray-900 mb-1">Muhammad Andi Mubarok</h3>
                                <p class="text-purple-600 font-semibold">Fullstack Developer & Founder</p>
                            </div>
                        </div>
                    </div>

                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-gradient-to-br from-purple-400 to-blue-500 rounded-3xl opacity-20 blur-2xl -z-10"></div>
                    <div class="absolute -top-4 -left-4 w-32 h-32 bg-gradient-to-br from-blue-400 to-indigo-500 rounded-3xl opacity-20 blur-2xl -z-10"></div>
                </div>

                <!-- Stats Grid -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Education Card -->
                    <div class="bg-white border-2 border-purple-100 rounded-2xl p-6 hover:shadow-xl hover:border-purple-300 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-purple-100 to-purple-200 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-graduation-cap text-purple-600 text-xl"></i>
                        </div>
                        <p class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">S1</p>
                        <p class="text-sm font-semibold text-gray-900">Sistem Informasi</p>
                        <p class="text-xs text-gray-600 mt-1">IPK 3.69</p>
                    </div>

                    <!-- CEO Card -->
                    <div class="bg-white border-2 border-blue-100 rounded-2xl p-6 hover:shadow-xl hover:border-blue-300 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-100 to-blue-200 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-briefcase text-blue-600 text-xl"></i>
                        </div>
                        <p class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">CEO</p>
                        <p class="text-sm font-semibold text-gray-900">Barack Digital</p>
                        <p class="text-xs text-gray-600 mt-1">Sejak 2021</p>
                    </div>

                    <!-- Experience Card -->
                    <div class="bg-white border-2 border-indigo-100 rounded-2xl p-6 hover:shadow-xl hover:border-indigo-300 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-code text-indigo-600 text-xl"></i>
                        </div>
                        <p class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">3+</p>
                        <p class="text-sm font-semibold text-gray-900">Years Experience</p>
                        <p class="text-xs text-gray-600 mt-1">Web Development</p>
                    </div>

                    <!-- Projects Card -->
                    <div class="bg-white border-2 border-green-100 rounded-2xl p-6 hover:shadow-xl hover:border-green-300 transition-all duration-300 group">
                        <div class="w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                        </div>
                        <p class="text-3xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">50+</p>
                        <p class="text-sm font-semibold text-gray-900">Projects Done</p>
                        <p class="text-xs text-gray-600 mt-1">Successfully</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection