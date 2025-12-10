@extends('pages.layouts.app')

@section('content')
    <section id="home" class="relative min-h-screen flex items-center pt-32 pb-20 px-6 overflow-hidden bg-gray-50">
        
        <!-- Background Elements -->
        <div class="absolute top-1/4 right-0 w-96 h-96 bg-gradient-to-br from-purple-400 to-blue-500 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-1/4 left-0 w-80 h-80 bg-gradient-to-br from-indigo-400 to-purple-500 rounded-full opacity-15 blur-3xl"></div>

        <div class="max-w-7xl mx-auto w-full relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                
                <!-- Left Content -->
                <div class="order-2 lg:order-1">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 bg-purple-100 text-purple-700 px-4 py-2 rounded-full mb-6">
                        <span class="w-2 h-2 bg-purple-600 rounded-full animate-pulse"></span>
                        <span class="text-sm font-semibold">WHY CHOOSE US</span>
                    </div>

                    <!-- Main Heading -->
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight text-gray-900">
                        Coding dengan 
                        <span class="relative inline-block">
                            <span class="relative z-10 bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">Tujuan</span>
                            <span class="absolute bottom-2 left-0 w-full h-3 bg-purple-200 -z-0"></span>
                        </span>
                        <br>
                        Membangun dengan 
                        <span class="relative inline-block">
                            <span class="relative z-10 bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent">Hati</span>
                            <span class="absolute bottom-2 left-0 w-full h-3 bg-blue-200 -z-0"></span>
                        </span>
                    </h1>

                    <!-- Description -->
                    <p class="text-lg text-gray-700 mb-6 leading-relaxed max-w-xl">
                        Developer fullstack & founder dari Barack Digital. Saya membantu bisnis Anda tumbuh dengan
                        website yang powerful dan copywriting yang persuasif.
                    </p>

                    <!-- Feature Grid -->
                    <div class="grid grid-cols-2 gap-6 mb-8">
                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-rocket text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Business Growth</h3>
                                <p class="text-sm text-gray-600">Scale your business digitally</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-code text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Technology</h3>
                                <p class="text-sm text-gray-600">Latest tech stack</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-users text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Expert Team</h3>
                                <p class="text-sm text-gray-600">3+ years experience</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                <i class="fas fa-phone-alt text-white text-xl"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 mb-1">Call: +62-85221694067</h3>
                                <p class="text-sm text-gray-600">24/7 Support available</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4 mb-8">
                        <a href="#contact" class="inline-flex items-center gap-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white px-8 py-4 rounded-xl font-semibold hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                            Mulai Sekarang
                            <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#portfolio" class="inline-flex items-center gap-2 border-2 border-purple-600 text-purple-600 px-8 py-4 rounded-xl font-semibold hover:bg-purple-50 transition-all duration-300">
                            Lihat Portfolio
                            <i class="fas fa-briefcase"></i>
                        </a>
                    </div>

                    <!-- Social Links -->
                    <div class="flex items-center gap-4">
                        <span class="text-sm font-semibold text-gray-600">Follow us:</span>
                        <div class="flex gap-3">
                            <a href="https://www.instagram.com/muhmmad_and?igsh=eDF6NDE4MXlrc3gw" 
                               class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-600 hover:border-purple-600 hover:text-purple-600 hover:shadow-md transition-all duration-300">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="https://www.linkedin.com/in/muhammad-andi-mubarok/" 
                               class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-600 hover:border-purple-600 hover:text-purple-600 hover:shadow-md transition-all duration-300">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="https://github.com/muhammadand" 
                               class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-600 hover:border-purple-600 hover:text-purple-600 hover:shadow-md transition-all duration-300">
                                <i class="fab fa-github"></i>
                            </a>
                            <a href="https://www.youtube.com/@barackdigital" 
                               class="w-10 h-10 bg-white border border-gray-200 rounded-lg flex items-center justify-center text-gray-600 hover:border-purple-600 hover:text-purple-600 hover:shadow-md transition-all duration-300">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="order-1 lg:order-2 relative">
                    <!-- Main Image Container -->
                    <div class="relative">
                        <!-- Purple/Blue Gradient Background -->
                        <div class="absolute top-0 right-0 w-full h-full bg-gradient-to-br from-purple-600 via-purple-500 to-blue-600 rounded-3xl transform rotate-3"></div>
                        
                        <!-- Image -->
                        <div class="relative rounded-3xl overflow-hidden shadow-2xl transform -rotate-3 hover:rotate-0 transition-transform duration-500">
                            <img src="{{asset('foto.jpg')}}" 
                                 alt="Muhammad Andi Mubarok" 
                                 class="w-full h-[500px] object-cover">
                        </div>

                        <!-- Floating Elements -->
                        <div class="absolute -bottom-4 -left-4 bg-white rounded-xl shadow-xl p-3 animate-bounce" style="animation-duration: 3s;">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-green-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-check text-white text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">50+</p>
                                    <p class="text-xs text-gray-600">Projects Done</p>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -top-4 -right-4 bg-white rounded-xl shadow-xl p-3 animate-bounce" style="animation-duration: 2s; animation-delay: 0.5s;">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-star text-white text-lg"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">30+</p>
                                    <p class="text-xs text-gray-600">Happy Clients</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mt-24 pt-12 border-t border-gray-200">
                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-100 to-purple-200 rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-project-diagram text-purple-600 text-2xl"></i>
                    </div>
                    <p class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">50+</p>
                    <p class="text-gray-600 text-sm font-medium">Project Selesai</p>
                </div>

                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-200 rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-smile text-blue-600 text-2xl"></i>
                    </div>
                    <p class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">30+</p>
                    <p class="text-gray-600 text-sm font-medium">Client Puas</p>
                </div>

                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-award text-indigo-600 text-2xl"></i>
                    </div>
                    <p class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">3+</p>
                    <p class="text-gray-600 text-sm font-medium">Tahun Experience</p>
                </div>

                <div class="text-center group">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-purple-100 to-pink-200 rounded-2xl mb-4 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-heart text-purple-600 text-2xl"></i>
                    </div>
                    <p class="text-4xl font-bold bg-gradient-to-r from-purple-600 to-blue-600 bg-clip-text text-transparent mb-2">100%</p>
                    <p class="text-gray-600 text-sm font-medium">Dedikasi Klien</p>
                </div>
            </div>
        </div>
    </section>
@endsection