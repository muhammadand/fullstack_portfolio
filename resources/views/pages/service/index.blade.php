@extends('pages.layouts.app')
@section('content')
 
 
     <!-- WHY CHOOSE ME -->
    <section class="py-20 px-6 bg-gradient-to-br from-purple-50 to-blue-50">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-4">Kenapa Memilih Saya?</h2>
            <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">
                Saya tidak hanya membuat website, tapi membangun solusi yang sesuai dengan kebutuhan bisnis Anda.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="card-hover glass-effect p-8 rounded-2xl text-center">
                    <div
                        class="w-16 h-16 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4 text-white text-2xl">
                        <i class="fas fa-rocket"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Cepat & Efisien</h3>
                    <p class="text-gray-600 text-sm">Delivery tepat waktu tanpa mengorbankan kualitas.</p>
                </div>

                <div class="card-hover glass-effect p-8 rounded-2xl text-center">
                    <div
                        class="w-16 h-16 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4 text-white text-2xl">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Komunikasi Terbuka</h3>
                    <p class="text-gray-600 text-sm">Saya selalu siap dengarkan feedback dan update progress.</p>
                </div>

                <div class="card-hover glass-effect p-8 rounded-2xl text-center">
                    <div
                        class="w-16 h-16 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4 text-white text-2xl">
                        <i class="fas fa-sparkles"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Hasil Maksimal</h3>
                    <p class="text-gray-600 text-sm">Fokus pada performa, UX, dan conversion rate.</p>
                </div>

                <div class="card-hover glass-effect p-8 rounded-2xl text-center">
                    <div
                        class="w-16 h-16 gradient-primary rounded-full flex items-center justify-center mx-auto mb-4 text-white text-2xl">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="font-bold text-lg mb-2">Support Berkelanjutan</h3>
                    <p class="text-gray-600 text-sm">Maintenance dan update gratis selama 3 bulan.</p>
                </div>
            </div>
        </div>
    </section>
 <section id="services" class="py-20 px-6">
        <div class="max-w-7xl mx-auto">
            <h2 class="text-4xl font-bold text-center mb-4">Layanan Saya</h2>
            <p class="text-center text-gray-600 mb-16 max-w-2xl mx-auto">
                Dua layanan utama yang akan membantu bisnis Anda berkembang di era digital.
            </p>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Service 1: Website -->
                <div class="card-hover">
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-12 rounded-3xl border border-gray-200">
                        <div
                            class="w-20 h-20 gradient-primary rounded-2xl flex items-center justify-center text-white text-4xl mb-6">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Website Development</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Website yang tidak hanya cantik, tapi juga mengkonversi. Saya bangun dengan teknologi
                            terkini untuk performa maksimal.
                        </p>

                        <div class="mb-8">
                            <p class="font-semibold text-gray-900 mb-4">✨ Yang Anda Dapatkan:</p>
                            <ul class="space-y-3 text-gray-700">
                                <li class="flex items-start gap-3">
                                    <span class="text-purple-600 font-bold">✓</span>
                                    <span>Design responsive dan modern</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-purple-600 font-bold">✓</span>
                                    <span>SEO optimized untuk visibility di Google</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-purple-600 font-bold">✓</span>
                                    <span>Fast loading & mobile-first approach</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-purple-600 font-bold">✓</span>
                                    <span>CMS-friendly untuk mudah diupdate</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-purple-600 font-bold">✓</span>
                                    <span>Integrasi payment & analytics</span>
                                </li>
                            </ul>
                        </div>

                        <div class="flex gap-3 flex-wrap mb-8">
                            <span class="badge-tech">React</span>
                            <span class="badge-tech">Next.js</span>
                            <span class="badge-tech">Tailwind CSS</span>
                            <span class="badge-tech">Node.js</span>
                        </div>

                        <button
                            class="w-full gradient-primary text-white py-3 rounded-lg font-semibold hover:shadow-lg transition">
                            Konsultasi Website
                        </button>
                    </div>
                </div>

                <!-- Service 2: Copywriting -->
                <div class="card-hover">
                    <div class="bg-gradient-to-br from-purple-50 to-blue-50 p-12 rounded-3xl border border-gray-200">
                        <div
                            class="w-20 h-20 gradient-primary rounded-2xl flex items-center justify-center text-white text-4xl mb-6">
                            <i class="fas fa-pen-fancy"></i>
                        </div>
                        <h3 class="text-3xl font-bold mb-4">Copywriting & Script</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Naskah yang tepat sasaran. Dari script video hingga copy sales yang convert—saya tahu cara
                            bicara ke audiens Anda.
                        </p>

                        <div class="mb-8">
                            <p class="font-semibold text-gray-900 mb-4">✨ Yang Anda Dapatkan:</p>
                            <ul class="space-y-3 text-gray-700">
                                <li class="flex items-start gap-3">
                                    <span class="text-purple-600 font-bold">✓</span>
                                    <span>Copy yang persuasif dan authentic</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-purple-600 font-bold">✓</span>
                                    <span>Script untuk video, podcast, & konten media sosial</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-purple-600 font-bold">✓</span>
                                    <span>Riset mendalam tentang target audiens</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-purple-600 font-bold">✓</span>
                                    <span>Tone of voice yang konsisten dengan brand</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span class="text-purple-600 font-bold">✓</span>
                                    <span>Revisi unlimited hingga puas</span>
                                </li>
                            </ul>
                        </div>

                        <div class="flex gap-3 flex-wrap mb-8">
                            <span class="badge-tech">Sales Copy</span>
                            <span class="badge-tech">Script Video</span>
                            <span class="badge-tech">Social Media</span>
                            <span class="badge-tech">Email Campaign</span>
                        </div>

                        <button
                            class="w-full gradient-primary text-white py-3 rounded-lg font-semibold hover:shadow-lg transition">
                            Konsultasi Copywriting
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection