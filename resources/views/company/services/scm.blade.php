@extends('layouts.app')

@section('meta_tags')
<title>Implementasi Metode SCM & Rumus Algoritma untuk Skripsi - Sobat Scalify</title>
<meta name="title" content="Implementasi Metode SCM & Rumus Algoritma untuk Skripsi - Sobat Scalify" />
<meta name="description" content="Pelajari penerapan metode Supply Chain Management (SCM) seperti EOQ, ROP, Safety Stock, JIT, dan MRP untuk sistem cerdas bisnis UMKM dan project Skripsi IT Anda." />
<meta name="keywords" content="metode scm, eoq, rop, safety stock, jit, mrp, rumus eoq skripsi, jasa pembuatan skripsi scm, aplikasi inventory cerdas, sobat scalify" />
<meta name="author" content="Sobat Scalify" />
@endsection

@section('content')
<div class="bg-[#F8FAFC] text-gray-800 min-h-screen font-sans">

    {{-- Full Width Hero Section (Matching SobatScalify) --}}
    <section class="relative pt-32 pb-24 lg:pt-40 lg:pb-32 overflow-hidden bg-[#0A0E2A]">
        {{-- Background Effects --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="absolute top-1/4 right-0 w-96 h-96 bg-blue-600 rounded-full mix-blend-screen filter blur-[120px] opacity-40 animate-blob"></div>
            <div class="absolute bottom-1/4 left-0 w-96 h-96 bg-indigo-600 rounded-full mix-blend-screen filter blur-[120px] opacity-40 animate-blob animation-delay-2000"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-sm font-semibold mb-8 tracking-wider uppercase shadow-sm backdrop-blur-md">
                <i class="fa-solid fa-boxes-packing mr-2"></i> Supply Chain Management
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-display text-white mb-6 leading-tight drop-shadow-lg">
                Metode <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-300 relative inline-block">Pengendalian Persediaan</span>
            </h1>
            <p class="text-xl text-blue-100/80 max-w-3xl mx-auto leading-relaxed font-light">
                Pelajari bagaimana kami mengimplementasikan berbagai algoritma cerdas ke dalam sistem informasi pergudangan untuk digitalisasi Bisnis UMKM dan penyelesaian Tugas Akhir IT Anda.
            </p>
        </div>

        {{-- Elegant Wave/Curve bottom --}}
        <div class="absolute bottom-0 w-full overflow-hidden leading-[0]">
            <svg class="relative block w-full h-[60px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="fill-[#F8FAFC]"></path>
            </svg>
        </div>
    </section>

    {{-- Accordion Section (Alpine.js) --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-20 pb-24">

        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-[#191970] font-display mb-4">Metode & Algoritma SCM Populer</h2>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto">Klik pada setiap metode di bawah ini untuk mempelajari definisi, rumus matematis, beserta implementasi <i>study case</i>-nya.</p>
        </div>

        <div x-data="{ activeAccordion: 'eoq' }" class="space-y-6">

            {{-- 1. EOQ --}}
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden transition-all duration-300" :class="activeAccordion === 'eoq' ? 'ring-2 ring-blue-500/30 transform -translate-y-1' : 'hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                <button @click="activeAccordion = activeAccordion === 'eoq' ? '' : 'eoq'" class="w-full flex items-center justify-between p-6 md:p-8 text-left focus:outline-none">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 text-blue-600 flex items-center justify-center shrink-0 shadow-inner">
                            <i class="fa-solid fa-box-open text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800 font-display">EOQ (Economic Order Quantity)</h3>
                            <p class="text-slate-500 mt-1 hidden sm:block">Optimalisasi jumlah pesanan untuk menekan biaya operasional.</p>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center shrink-0 transition-transform duration-500 shadow-sm" :class="activeAccordion === 'eoq' ? 'rotate-180 bg-blue-50 text-blue-600' : 'text-slate-400'">
                        <i class="fa-solid fa-chevron-down text-lg"></i>
                    </div>
                </button>
                <div x-show="activeAccordion === 'eoq'" x-collapse x-cloak>
                    <div class="p-6 md:p-8 pt-0 bg-white">
                        <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-slate-200 to-transparent mb-6"></div>
                        <p class="text-slate-600 mb-6 leading-relaxed text-lg">
                            <strong>EOQ</strong> adalah metode penghitungan matematis yang digunakan untuk menentukan jumlah pemesanan bahan baku paling optimal. Tujuannya adalah meminimalkan total biaya persediaan, yang terdiri dari biaya pesan dan biaya simpan.
                        </p>
                        <div class="bg-[#1E293B] rounded-2xl p-6 text-emerald-400 font-mono text-sm sm:text-base mb-6 overflow-x-auto shadow-inner relative group">
                            <div class="absolute top-0 right-0 bg-slate-700/50 text-slate-400 px-3 py-1 rounded-bl-2xl rounded-tr-2xl text-xs">RUMUS</div>
                            <span class="text-blue-300 font-bold block mb-4">EOQ = √ ( (2 * R * S) / (P * I) )</span>
                            <span class="text-slate-400 block mb-2">// Keterangan:</span>
                            <ul class="text-slate-300 space-y-1 ml-4 list-disc">
                                <li><strong>R</strong> = Total kebutuhan barang per periode</li>
                                <li><strong>S</strong> = Biaya pemesanan setiap kali pesan</li>
                                <li><strong>P</strong> = Harga beli per unit barang</li>
                                <li><strong>I</strong> = Persentase biaya penyimpanan</li>
                            </ul>
                        </div>
                        <div class="bg-blue-50/80 border border-blue-100 p-6 rounded-2xl flex gap-4 items-start">
                            <div class="text-blue-500 mt-1"><i class="fa-solid fa-lightbulb text-xl"></i></div>
                            <div>
                                <h4 class="font-bold text-blue-900 mb-2">Study Case Skripsi / UMKM</h4>
                                <p class="text-blue-800/80 leading-relaxed">Pembuatan Sistem Informasi Inventory pada Gudang Swalayan atau Apotek. Aplikasi akan secara otomatis merekomendasikan: <i>"Berapa banyak kotak obat yang harus dibeli ke supplier bulan ini agar paling hemat biaya?"</i>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2. ROP --}}
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden transition-all duration-300" :class="activeAccordion === 'rop' ? 'ring-2 ring-indigo-500/30 transform -translate-y-1' : 'hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                <button @click="activeAccordion = activeAccordion === 'rop' ? '' : 'rop'" class="w-full flex items-center justify-between p-6 md:p-8 text-left focus:outline-none">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-indigo-50 to-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 shadow-inner">
                            <i class="fa-solid fa-bell-concierge text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800 font-display">ROP (Reorder Point)</h3>
                            <p class="text-slate-500 mt-1 hidden sm:block">Titik peringatan untuk memesan kembali secara otomatis.</p>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center shrink-0 transition-transform duration-500 shadow-sm" :class="activeAccordion === 'rop' ? 'rotate-180 bg-indigo-50 text-indigo-600' : 'text-slate-400'">
                        <i class="fa-solid fa-chevron-down text-lg"></i>
                    </div>
                </button>
                <div x-show="activeAccordion === 'rop'" x-collapse x-cloak>
                    <div class="p-6 md:p-8 pt-0 bg-white">
                        <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-slate-200 to-transparent mb-6"></div>
                        <p class="text-slate-600 mb-6 leading-relaxed text-lg">
                            <strong>ROP</strong> menentukan titik aman kapan pesanan bahan baku harus segera dilakukan lagi. Jika stok di gudang sudah menyusut menyentuh angka ROP, maka aplikasi harus mengirim notifikasi pengingat ke admin gudang.
                        </p>
                        <div class="bg-[#1E293B] rounded-2xl p-6 text-emerald-400 font-mono text-sm sm:text-base mb-6 overflow-x-auto shadow-inner relative group">
                            <div class="absolute top-0 right-0 bg-slate-700/50 text-slate-400 px-3 py-1 rounded-bl-2xl rounded-tr-2xl text-xs">RUMUS</div>
                            <span class="text-indigo-300 font-bold block mb-4">ROP = (d * L) + SS</span>
                            <span class="text-slate-400 block mb-2">// Keterangan:</span>
                            <ul class="text-slate-300 space-y-1 ml-4 list-disc">
                                <li><strong>d</strong> = Rata-rata pemakaian barang per hari</li>
                                <li><strong>L</strong> = Lead time (Waktu pengiriman dari supplier)</li>
                                <li><strong>SS</strong> = Safety Stock (Stok pengaman)</li>
                            </ul>
                        </div>
                        <div class="bg-indigo-50/80 border border-indigo-100 p-6 rounded-2xl flex gap-4 items-start">
                            <div class="text-indigo-500 mt-1"><i class="fa-solid fa-lightbulb text-xl"></i></div>
                            <div>
                                <h4 class="font-bold text-indigo-900 mb-2">Study Case Skripsi / UMKM</h4>
                                <p class="text-indigo-800/80 leading-relaxed">Sering dikawinkan dengan algoritma EOQ. Misalnya pada toko bangunan: ketika stok semen menyentuh sisa 50 sak (hasil perhitungan ROP), sistem akan memunculkan alert warna merah berbunyi peringatan <i>"Segera Restock Semen!"</i>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 3. Safety Stock --}}
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden transition-all duration-300" :class="activeAccordion === 'ss' ? 'ring-2 ring-emerald-500/30 transform -translate-y-1' : 'hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                <button @click="activeAccordion = activeAccordion === 'ss' ? '' : 'ss'" class="w-full flex items-center justify-between p-6 md:p-8 text-left focus:outline-none">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 shadow-inner">
                            <i class="fa-solid fa-shield-halved text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800 font-display">Safety Stock</h3>
                            <p class="text-slate-500 mt-1 hidden sm:block">Perhitungan stok cadangan/pengaman gudang.</p>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center shrink-0 transition-transform duration-500 shadow-sm" :class="activeAccordion === 'ss' ? 'rotate-180 bg-emerald-50 text-emerald-600' : 'text-slate-400'">
                        <i class="fa-solid fa-chevron-down text-lg"></i>
                    </div>
                </button>
                <div x-show="activeAccordion === 'ss'" x-collapse x-cloak>
                    <div class="p-6 md:p-8 pt-0 bg-white">
                        <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-slate-200 to-transparent mb-6"></div>
                        <p class="text-slate-600 mb-6 leading-relaxed text-lg">
                            <strong>Safety Stock</strong> adalah persediaan ekstra yang harus disiapkan di gudang untuk mencegah terjadinya kehabisan stok (Stockout) akibat lonjakan permintaan tak terduga atau telatnya kurir pengiriman.
                        </p>
                        <div class="bg-[#1E293B] rounded-2xl p-6 text-emerald-400 font-mono text-sm sm:text-base mb-6 overflow-x-auto shadow-inner relative group">
                            <div class="absolute top-0 right-0 bg-slate-700/50 text-slate-400 px-3 py-1 rounded-bl-2xl rounded-tr-2xl text-xs">RUMUS</div>
                            <span class="text-emerald-300 font-bold block mb-4">SS = (Pemakaian Maksimal - Rata-rata Pemakaian) * L</span>
                            <span class="text-slate-400 block mb-2">// Keterangan:</span>
                            <ul class="text-slate-300 space-y-1 ml-4 list-disc">
                                <li>Data historis pemakaian maksimal per hari</li>
                                <li>Data rata-rata pemakaian normal per hari</li>
                                <li><strong>L</strong> = Lead Time (Waktu pengiriman)</li>
                            </ul>
                        </div>
                        <div class="bg-emerald-50/80 border border-emerald-100 p-6 rounded-2xl flex gap-4 items-start">
                            <div class="text-emerald-500 mt-1"><i class="fa-solid fa-lightbulb text-xl"></i></div>
                            <div>
                                <h4 class="font-bold text-emerald-900 mb-2">Study Case Skripsi / UMKM</h4>
                                <p class="text-emerald-800/80 leading-relaxed">Toko sparepart motor sering kehabisan oli saat musim mudik lebaran. Menggunakan algoritma Safety Stock, sistem inventori mereka dapat menjamin ketersediaan barang di musim puncak tanpa khawatir menyetok barang hingga gudang overload di bulan biasa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 4. JIT --}}
            <div class="bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden transition-all duration-300" :class="activeAccordion === 'jit' ? 'ring-2 ring-purple-500/30 transform -translate-y-1' : 'hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)]'">
                <button @click="activeAccordion = activeAccordion === 'jit' ? '' : 'jit'" class="w-full flex items-center justify-between p-6 md:p-8 text-left focus:outline-none">
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 text-purple-600 flex items-center justify-center shrink-0 shadow-inner">
                            <i class="fa-solid fa-stopwatch text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-800 font-display">JIT (Just In Time)</h3>
                            <p class="text-slate-500 mt-1 hidden sm:block">Manajemen cerdas menekan biaya gudang jadi nol.</p>
                        </div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center shrink-0 transition-transform duration-500 shadow-sm" :class="activeAccordion === 'jit' ? 'rotate-180 bg-purple-50 text-purple-600' : 'text-slate-400'">
                        <i class="fa-solid fa-chevron-down text-lg"></i>
                    </div>
                </button>
                <div x-show="activeAccordion === 'jit'" x-collapse x-cloak>
                    <div class="p-6 md:p-8 pt-0 bg-white">
                        <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-slate-200 to-transparent mb-6"></div>
                        <p class="text-slate-600 mb-6 leading-relaxed text-lg">
                            <strong>JIT</strong> adalah filosofi manajemen inventori ekstrem di mana bahan baku hanya dipesan dan akan tiba tepat pada saat lini produksi membutuhkannya. Tujuannya mereduksi, bahkan menghilangkan kebutuhan ruang gudang dan kerugian akibat limbah kadaluarsa.
                        </p>
                        <div class="bg-purple-50/80 border border-purple-100 p-6 rounded-2xl flex gap-4 items-start">
                            <div class="text-purple-500 mt-1"><i class="fa-solid fa-lightbulb text-xl"></i></div>
                            <div>
                                <h4 class="font-bold text-purple-900 mb-2">Study Case Skripsi / UMKM</h4>
                                <p class="text-purple-800/80 leading-relaxed">Sangat cocok untuk bisnis kuliner seperti Katering, Pabrik Roti Fresh, atau Perakitan PC. Daripada menyetok telur/daging hingga busuk, sistem akan mengirimkan PO (Purchase Order) otomatis ke supplier telur tepat H-1 sebelum jadwal produksi masakan dijalankan keesokan harinya.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Premium CTA Section --}}
        <div class="mt-20 bg-gradient-to-br from-slate-900 to-[#0A0E2A] rounded-3xl p-10 md:p-14 text-center shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>

            <div class="relative z-10">
                <h3 class="text-3xl font-bold text-white mb-4 font-display">Butuh Bantuan Implementasi Algoritma SCM?</h3>
                <p class="text-blue-100/80 mb-10 max-w-2xl mx-auto text-lg leading-relaxed">
                    Jangan buang waktu <i>coding</i> dari nol. Tim Sobat Scalify siap merancang, menterjemahkan rumus matematis ke dalam barisan kode, hingga membangun aplikasi <i>End-to-End</i> yang rapi untuk Skripsi maupun Bisnis Anda.
                </p>
                @php
                $refCode = request()->cookie('affiliate_ref') ?? request('ref');
                $waTextRef = $refCode ? "%0A%0A[Referral: " . urlencode($refCode) . "]" : "";
                @endphp
                <a href="https://wa.me/6285221694067?text=Halo%20Sobat%20Scalify,%20saya%20butuh%20jasa%20pembuatan%20website%20dengan%20metode%20SCM/Inventory.{{ $waTextRef }}" target="_blank" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-[#0A0E2A] font-bold rounded-xl shadow-[0_8px_30px_rgb(255,255,255,0.2)] hover:shadow-[0_8px_30px_rgb(255,255,255,0.4)] hover:-translate-y-1 transition-all duration-300 transform">
                    <i class="fa-brands fa-whatsapp text-2xl text-green-500"></i> Konsultasi Project Sekarang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
