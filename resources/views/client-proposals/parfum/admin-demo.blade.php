<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin & POS Dashboard - {{ $client->brand_name }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            gold: '#D4AF37', // Luxury Gold
                            dark: '#1a1a1a', // Almost black
                            light: '#f8f9fa', // Off-white background
                            gray: '#6c757d', // Text gray
                            border: '#e5e7eb'
                        }
                    }
                    , fontFamily: {
                        sans: ['Inter', 'sans-serif']
                        , serif: ['Playfair Display', 'serif']
                    }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #1a1a1a;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        #tour-overlay {
            position: fixed;
            inset: 0;
            background: rgba(26, 26, 26, 0.85);
            z-index: 9998;
            display: none;
        }

        .tour-highlight {
            position: relative;
            z-index: 9999 !important;
            box-shadow: 0 0 0 4px rgba(212, 175, 55, 0.6);
            border-radius: 0.5rem;
            background-color: white;
            pointer-events: none;
        }

        #tour-tooltip {
            position: absolute;
            z-index: 10000;
            background: #1a1a1a;
            padding: 1.25rem;
            border-radius: 0.5rem;
            width: 300px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
            display: none;
            transition: all 0.3s ease;
            border: 1px solid #D4AF37;
        }

    </style>
</head>
<body class="flex h-screen overflow-hidden antialiased text-[13px]">

    <!-- Sidebar -->
    <aside id="sidebar" class="w-64 bg-brand-dark text-white flex flex-col shrink-0 transition-transform duration-300 absolute z-50 h-full -translate-x-full md:relative md:translate-x-0">
        <button onclick="toggleSidebar()" class="absolute top-4 right-4 md:hidden text-gray-400 hover:text-white"><i class="fas fa-times text-xl"></i></button>
        <div class="h-16 flex items-center justify-center border-b border-gray-800">
            <h1 class="font-serif font-bold text-brand-gold text-lg tracking-widest uppercase">{{ $client->brand_name }}</h1>
        </div>

        <div class="flex-1 overflow-y-auto py-4 hide-scrollbar">
            <!-- Offline / Retail -->
            <div class="px-4 mb-6">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-2">Retail & Offline</p>
                <nav class="space-y-1">
                    <a href="#" class="flex items-center gap-3 px-3 py-2 text-brand-gold bg-brand-gold/10 rounded font-medium transition border-l-2 border-brand-gold" id="tour-pos">
                        <i class="fas fa-cash-register w-5 text-center"></i> Kasir (POS)
                    </a>
                </nav>
            </div>

            <!-- E-Commerce -->
            <div class="px-4 mb-6">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-2">E-Commerce</p>
                <nav class="space-y-1">
                    <a href="#" class="flex items-center justify-between px-3 py-2 text-gray-400 hover:text-white rounded font-medium transition" id="tour-order">
                        <div class="flex items-center gap-3">
                            <i class="fas fa-shopping-cart w-5 text-center"></i> Pesanan Web
                        </div>
                        <span class="bg-red-500 text-white text-[10px] px-1.5 py-0.5 rounded-full font-bold">5</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:text-white rounded font-medium transition" id="tour-pim">
                        <i class="fas fa-box-open w-5 text-center"></i> Manajemen Produk
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:text-white rounded font-medium transition">
                        <i class="fas fa-warehouse w-5 text-center"></i> Stok & Batch
                    </a>
                </nav>
            </div>

            <!-- B2B & Analytics -->
            <div class="px-4 mb-6">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-2">B2B & Analytics</p>
                <nav class="space-y-1">
                    <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:text-white rounded font-medium transition" id="tour-reseller-dash">
                        <i class="fas fa-users w-5 text-center"></i> Reseller & Affiliate
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:text-white rounded font-medium transition" id="tour-analytics">
                        <i class="fas fa-chart-line w-5 text-center"></i> Laporan Repurchase
                    </a>
                </nav>
            </div>
        </div>

        <div class="p-4 border-t border-gray-800">
            <a href="{{ route('landing.dynamic', $client->slug) }}" class="flex items-center justify-center gap-2 w-full py-2 bg-gray-800 hover:bg-gray-700 rounded text-[12px] font-medium transition text-gray-300 hover:text-white">
                <i class="fas fa-globe"></i> Lihat Website
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">

        <!-- Topbar -->
        <header class="h-16 bg-white border-b border-brand-border flex items-center justify-between px-4 md:px-6 shrink-0 shadow-sm relative z-40">
            <div class="flex items-center gap-2 md:gap-4">
                <button onclick="toggleSidebar()" class="md:hidden text-brand-dark text-lg mr-2"><i class="fas fa-bars"></i></button>
                <h2 class="font-bold text-[14px] md:text-[16px] text-brand-dark truncate">Omnichannel <span class="hidden sm:inline">Dashboard</span></h2>
                <span class="hidden sm:inline-block bg-green-100 text-green-700 text-[10px] px-2 py-1 rounded font-bold border border-green-200">SISTEM ONLINE</span>
            </div>

            <div class="flex items-center gap-3 md:gap-5">
                <button onclick="startTour()" class="bg-brand-gold text-black hover:bg-yellow-500 px-3 md:px-4 py-1.5 rounded font-bold text-[10px] md:text-[11px] tracking-wider uppercase transition shadow-sm flex items-center gap-1 md:gap-2">
                    <i class="fas fa-play"></i> <span class="hidden sm:inline">Mulai Tour</span>
                </button>
                <div class="hidden sm:block w-px h-6 bg-gray-200"></div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-brand-gold text-black flex items-center justify-center font-bold text-[12px]">A</div>
                    <div class="text-[12px] hidden sm:block">
                        <p class="font-bold text-brand-dark leading-none">Admin Store</p>
                        <p class="text-[10px] text-brand-gray mt-0.5">Pusat</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto p-4 md:p-6">

            <!-- Split Layout: POS Simulator & Analytics -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- KIRI: Simulasi POS Kasir -->
                <div class="lg:col-span-2 flex flex-col gap-6">

                    <div class="bg-white rounded-lg border border-brand-border shadow-sm flex flex-col h-full" id="tour-pos-ui">
                        <div class="p-4 border-b border-brand-border flex justify-between items-center bg-gray-50 rounded-t-lg">
                            <h3 class="font-bold text-[14px] text-brand-dark flex items-center gap-2">
                                <i class="fas fa-desktop text-brand-gold"></i> Point of Sale (Kasir Offline)
                            </h3>
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-2.5 text-gray-400 text-xs"></i>
                                <input type="text" placeholder="Scan Barcode / Cari Parfum..." class="pl-8 pr-4 py-1.5 border border-brand-border rounded text-[12px] w-64 focus:border-brand-gold focus:outline-none">
                            </div>
                        </div>

                        <div class="flex-1 p-4 flex flex-col md:grid md:grid-cols-3 gap-4">
                            <!-- Product Grid for POS -->
                            <div class="w-full md:col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-3 overflow-y-auto hide-scrollbar h-[300px] md:h-[400px] content-start md:pr-2">
                                <div onclick="addToPosCart('Midnight Enigma', 450000, '50ml')" class="border border-brand-border rounded p-3 cursor-pointer hover:border-brand-gold transition text-center group bg-white shadow-sm">
                                    <div class="h-16 bg-gray-100 rounded mb-2 flex items-center justify-center group-hover:bg-brand-gold/10 transition">
                                        <i class="fas fa-spray-can text-2xl text-gray-400 group-hover:text-brand-gold"></i>
                                    </div>
                                    <p class="font-bold text-[11px] text-brand-dark truncate">Midnight Enigma</p>
                                    <p class="text-[10px] text-gray-500">50ml • Sisa: 12</p>
                                </div>
                                <div onclick="addToPosCart('Ethereal Bloom', 450000, '50ml')" class="border border-brand-border rounded p-3 cursor-pointer hover:border-brand-gold transition text-center group bg-white shadow-sm">
                                    <div class="h-16 bg-gray-100 rounded mb-2 flex items-center justify-center group-hover:bg-brand-gold/10 transition">
                                        <i class="fas fa-spray-can text-2xl text-gray-400 group-hover:text-brand-gold"></i>
                                    </div>
                                    <p class="font-bold text-[11px] text-brand-dark truncate">Ethereal Bloom</p>
                                    <p class="text-[10px] text-gray-500">50ml • Sisa: 8</p>
                                </div>
                                <div onclick="addToPosCart('Oceanic Azure', 420000, '50ml')" class="border border-brand-border rounded p-3 cursor-pointer hover:border-brand-gold transition text-center group bg-white shadow-sm">
                                    <div class="h-16 bg-gray-100 rounded mb-2 flex items-center justify-center group-hover:bg-brand-gold/10 transition">
                                        <i class="fas fa-spray-can text-2xl text-gray-400 group-hover:text-brand-gold"></i>
                                    </div>
                                    <p class="font-bold text-[11px] text-brand-dark truncate">Oceanic Azure</p>
                                    <p class="text-[10px] text-gray-500">50ml • Sisa: 24</p>
                                </div>
                                <div onclick="addToPosCart('Velvet Rose', 480000, '50ml')" class="border border-brand-border rounded p-3 cursor-pointer hover:border-brand-gold transition text-center group bg-white shadow-sm">
                                    <div class="h-16 bg-gray-100 rounded mb-2 flex items-center justify-center group-hover:bg-brand-gold/10 transition">
                                        <i class="fas fa-spray-can text-2xl text-gray-400 group-hover:text-brand-gold"></i>
                                    </div>
                                    <p class="font-bold text-[11px] text-brand-dark truncate">Velvet Rose</p>
                                    <p class="text-[10px] text-gray-500">50ml • Sisa: 5</p>
                                </div>
                                <div onclick="addToPosCart('Sandalwood Dream', 510000, '50ml')" class="border border-brand-border rounded p-3 cursor-pointer hover:border-brand-gold transition text-center group bg-white shadow-sm">
                                    <div class="h-16 bg-gray-100 rounded mb-2 flex items-center justify-center group-hover:bg-brand-gold/10 transition">
                                        <i class="fas fa-spray-can text-2xl text-gray-400 group-hover:text-brand-gold"></i>
                                    </div>
                                    <p class="font-bold text-[11px] text-brand-dark truncate">Sandalwood Dream</p>
                                    <p class="text-[10px] text-gray-500">50ml • Sisa: 10</p>
                                </div>
                                <div onclick="addToPosCart('Discovery Set', 150000, '5x3ml')" class="border border-brand-border rounded p-3 cursor-pointer hover:border-brand-gold transition text-center group bg-white shadow-sm">
                                    <div class="h-16 bg-brand-dark rounded mb-2 flex items-center justify-center group-hover:bg-black transition">
                                        <i class="fas fa-vial text-2xl text-brand-gold"></i>
                                    </div>
                                    <p class="font-bold text-[11px] text-brand-dark truncate">Discovery Set</p>
                                    <p class="text-[10px] text-gray-500">5x3ml • Sisa: 45</p>
                                </div>
                                <div onclick="addToPosCart('Gift Box Special', 850000, '2x50ml')" class="border border-brand-border rounded p-3 cursor-pointer hover:border-brand-gold transition text-center group bg-brand-gold/5 shadow-sm border-brand-gold/50">
                                    <div class="h-16 bg-brand-gold/20 rounded mb-2 flex items-center justify-center group-hover:bg-brand-gold/30 transition">
                                        <i class="fas fa-gift text-2xl text-brand-gold"></i>
                                    </div>
                                    <p class="font-bold text-[11px] text-brand-dark truncate">Gift Box Special</p>
                                    <p class="text-[10px] text-gray-500">2x50ml • Sisa: 3</p>
                                </div>
                            </div>

                            <!-- Cart / Order Summary -->
                            <div class="w-full md:col-span-1 border-t md:border-t-0 md:border-l border-brand-border pt-4 md:pt-0 md:pl-4 flex flex-col h-[300px] md:h-[400px]">
                                <div class="flex justify-between items-center mb-3">
                                    <div>
                                        <span class="font-bold text-[12px]" id="active-customer-name">Pelanggan Walk-in</span>
                                        <span id="active-customer-badge" class="hidden ml-2 bg-gradient-to-r from-yellow-600 to-yellow-400 text-white text-[8px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider">Gold Member</span>
                                    </div>
                                    <i onclick="openMemberLookupModal()" class="fas fa-user-plus text-brand-gold cursor-pointer hover:scale-110 transition"></i>
                                </div>

                                <div class="flex-1 overflow-y-auto hide-scrollbar border-t border-brand-border pt-3" id="pos-cart-items">
                                    <div class="text-center text-gray-400 mt-10 text-[11px]">
                                        <i class="fas fa-shopping-basket text-2xl mb-2 opacity-50"></i>
                                        <p>Keranjang Kosong</p>
                                    </div>
                                </div>

                                <div class="mt-auto bg-gray-50 p-3 rounded border border-brand-border shrink-0">
                                    <div class="flex justify-between text-[11px] mb-1">
                                        <span class="text-gray-500">Subtotal</span>
                                        <span class="font-bold" id="pos-subtotal">Rp 0</span>
                                    </div>
                                    <div id="pos-discount-row" class="flex justify-between text-[11px] mb-1 text-green-600 hidden">
                                        <span>Diskon Member (10%)</span>
                                        <span class="font-bold" id="pos-discount">-Rp 0</span>
                                    </div>
                                    <div class="flex justify-between text-[13px] font-bold mt-2 pt-2 border-t border-gray-200">
                                        <span>Total</span>
                                        <span class="text-brand-gold" id="pos-total">Rp 0</span>
                                    </div>
                                    <button onclick="checkoutPos()" class="w-full bg-brand-dark hover:bg-black text-white font-bold py-2 rounded mt-3 text-[11px] transition shadow-md">BAYAR (F8)</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Online Orders -->
                    <div class="bg-white rounded-lg border border-brand-border p-5 shadow-sm" id="tour-order-ui">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="font-bold text-[14px] text-brand-dark">Pesanan E-Commerce Terbaru</h3>
                            <a href="#" class="text-[11px] text-brand-gold font-bold hover:underline">Lihat Semua</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="border-b border-gray-200 text-[11px] text-gray-500 uppercase tracking-wider">
                                        <th class="pb-2 font-medium">Order ID</th>
                                        <th class="pb-2 font-medium">Pelanggan</th>
                                        <th class="pb-2 font-medium">Item</th>
                                        <th class="pb-2 font-medium">Status</th>
                                        <th class="pb-2 font-medium text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-b border-gray-100">
                                        <td class="py-3 font-medium text-brand-dark">#ORD-001</td>
                                        <td class="py-3">
                                            <p class="font-bold text-brand-dark">Siska A.</p>
                                            <p class="text-[10px] text-gray-500">Bandung</p>
                                        </td>
                                        <td class="py-3 text-gray-600">1x Ethereal Bloom</td>
                                        <td class="py-3"><span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-[9px] font-bold">PERLU DIKIRIM</span></td>
                                        <td class="py-3 text-right">
                                            <button class="bg-brand-gold/10 text-brand-gold hover:bg-brand-gold hover:text-white px-3 py-1 rounded text-[10px] font-bold transition">Cetak Resi</button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="py-3 font-medium text-brand-dark">#ORD-002</td>
                                        <td class="py-3">
                                            <p class="font-bold text-brand-dark">Reza M. <span class="bg-blue-100 text-blue-700 px-1 py-0.5 rounded text-[8px] ml-1">RESELLER</span></p>
                                            <p class="text-[10px] text-gray-500">Jakarta</p>
                                        </td>
                                        <td class="py-3 text-gray-600">5x Discovery Set</td>
                                        <td class="py-3"><span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-[9px] font-bold">DIKIRIM (JNT)</span></td>
                                        <td class="py-3 text-right">
                                            <button class="text-gray-400 hover:text-brand-dark"><i class="fas fa-eye"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- KANAN: Analytics & Reseller -->
                <div class="flex flex-col gap-6">
                    <!-- Reseller Overview -->
                    <div class="bg-gradient-to-br from-brand-dark to-black rounded-lg border border-gray-800 p-5 shadow-sm text-white" id="tour-reseller-ui">
                        <div class="flex justify-between items-center mb-4 border-b border-gray-700 pb-3">
                            <h3 class="font-bold text-[14px] text-brand-gold"><i class="fas fa-crown mr-2"></i> Performa B2B / Reseller</h3>
                            <i class="fas fa-ellipsis-v text-gray-500"></i>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Total Reseller</p>
                                <p class="text-2xl font-bold font-serif">124</p>
                            </div>
                            <div>
                                <p class="text-[10px] text-gray-400 uppercase tracking-wider mb-1">Total Komisi</p>
                                <p class="text-xl font-bold text-green-400">Rp 12.5M</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <p class="text-[11px] font-bold text-gray-300">Top Reseller Bulan Ini</p>
                            <div class="flex items-center justify-between bg-white/5 p-2 rounded">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded bg-brand-gold text-black flex items-center justify-center text-[10px] font-bold">1</div>
                                    <span class="text-[12px] font-medium">Toko Parfum Indah</span>
                                </div>
                                <span class="text-[11px] text-brand-gold font-bold">50 Botol</span>
                            </div>
                            <div class="flex items-center justify-between bg-white/5 p-2 rounded">
                                <div class="flex items-center gap-2">
                                    <div class="w-6 h-6 rounded bg-gray-300 text-black flex items-center justify-center text-[10px] font-bold">2</div>
                                    <span class="text-[12px] font-medium">Budi Dropship</span>
                                </div>
                                <span class="text-[11px] text-gray-300 font-bold">32 Botol</span>
                            </div>
                        </div>
                    </div>

                    <!-- Repurchase Rate Chart -->
                    <div class="bg-white rounded-lg border border-brand-border p-5 shadow-sm flex-1" id="tour-analytics-ui">
                        <h3 class="font-bold text-[14px] text-brand-dark mb-1">Tingkat Pembelian Ulang</h3>
                        <p class="text-[10px] text-gray-500 mb-4">Analisis pelanggan yang membeli botol penuh setelah beli tester.</p>

                        <div class="h-40">
                            <canvas id="repurchaseChart"></canvas>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Interactive Tour UI -->
    <div id="tour-overlay"></div>
    <div id="tour-tooltip" class="flex flex-col">
        <div class="flex items-center gap-2 mb-3">
            <div class="w-6 h-6 rounded-full bg-brand-gold text-black flex items-center justify-center font-bold text-[11px]" id="tour-step-indicator">1</div>
            <h4 class="font-serif font-bold text-[16px] text-brand-gold flex-1" id="tour-title">Judul Tour</h4>
            <button onclick="closeTour()" class="text-gray-400 hover:text-white transition"><i class="fas fa-times"></i></button>
        </div>
        <p class="text-[13px] text-gray-300 mb-5 leading-relaxed" id="tour-content">Isi petunjuk tour.</p>
        <div class="flex justify-between items-center mt-auto border-t border-gray-700 pt-3">
            <button id="tour-prev" onclick="prevStep()" class="text-[11px] font-semibold text-gray-400 hover:text-white transition invisible uppercase tracking-wider">Sebelumnya</button>
            <button id="tour-next" onclick="nextStep()" class="bg-brand-gold text-black px-4 py-1.5 rounded-sm text-[11px] font-bold uppercase tracking-wider hover:bg-white transition">Selanjutnya</button>
        </div>
    </div>

    <!-- Member Lookup Modal (POS) -->
    <div id="memberLookupModal" class="fixed inset-0 z-[200] bg-black/60 backdrop-blur-sm hidden items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-2xl w-full max-w-md overflow-hidden animate-slide-down">
            <div class="p-4 bg-brand-dark flex justify-between items-center text-white">
                <h3 class="font-bold text-[14px] flex items-center gap-2"><i class="fas fa-users text-brand-gold"></i> Cari Member / Pelanggan</h3>
                <button onclick="closeMemberLookupModal()" class="text-gray-400 hover:text-white"><i class="fas fa-times"></i></button>
            </div>
            <div class="p-4">
                <div class="relative mb-4">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    <input type="text" id="member-search-input" onkeyup="searchMember()" placeholder="Cari nama atau No. HP (Coba ketik 'Rangga')..." class="w-full pl-9 pr-4 py-2 border border-brand-border rounded focus:border-brand-gold focus:outline-none text-[12px]">
                </div>

                <div id="member-search-results" class="space-y-2">
                    <!-- Results will appear here -->
                    <div class="text-center text-gray-400 text-[11px] py-4">Mulai mengetik untuk mencari data pelanggan.</div>
                </div>
            </div>
        </div>
    </div>

    <!-- POS Success Toast -->
    <div id="posToast" class="fixed top-6 right-6 bg-green-500 text-white px-6 py-4 rounded shadow-2xl transform translate-x-[150%] transition-transform duration-300 z-[300] flex items-center gap-4">
        <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center"><i class="fas fa-check"></i></div>
        <div>
            <p class="font-bold text-[13px]">Pembayaran Berhasil!</p>
            <p class="text-[11px] text-green-100" id="posToastMessage">Stok web otomatis berkurang.</p>
        </div>
    </div>

    <style>
        .animate-slide-down {
            animation: slideDown 0.3s ease-out forwards;
        }

        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

    </style>

    <script>
        // Chart Config
        const ctx = document.getElementById('repurchaseChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut'
            , data: {
                labels: ['Beli Full Bottle', 'Hanya Tester', 'Tidak Kembali']
                , datasets: [{
                    data: [45, 20, 35]
                    , backgroundColor: ['#D4AF37', '#1a1a1a', '#e5e7eb']
                    , borderWidth: 0
                }]
            }
            , options: {
                responsive: true
                , maintainAspectRatio: false
                , cutout: '70%'
                , plugins: {
                    legend: {
                        position: 'bottom'
                        , labels: {
                            boxWidth: 10
                            , font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });

        // Tour Logic
        const tourSteps = [{
                elementId: 'tour-pos-ui'
                , title: 'Sistem POS (Omnichannel)'
                , content: 'Jika Anda memiliki toko fisik atau ikut pameran, kasir bisa langsung input pesanan di sini. Stok antara toko fisik dan website E-Commerce akan otomatis tersinkronisasi. Mencegah barang habis tapi di web masih bisa dibeli.'
            }
            , {
                elementId: 'tour-pim'
                , title: 'Manajemen Produk (PIM)'
                , content: 'Kelola visualisasi Scent Profile (Top, Middle, Base notes), atur harga per ukuran botol (30ml, 50ml, dll), dan lacak stok berdasarkan nomor Batch produksi.'
            }
            , {
                elementId: 'tour-order-ui'
                , title: 'Order Fulfillment'
                , content: 'Semua pesanan dari website masuk ke sini. Anda dapat memproses pembayaran, mencetak label resi pengiriman otomatis, dan mengupdate resi agar pelanggan dapat notifikasi.'
            }
            , {
                elementId: 'tour-reseller-ui'
                , title: 'Dashboard Reseller'
                , content: 'Pantau performa agen, reseller, dan dropshipper. Sistem secara otomatis menghitung komisi dan menerapkan harga khusus (tiering discount) jika ada pesanan dari mitra.'
            }
            , {
                elementId: 'tour-analytics-ui'
                , title: 'Analitik Pembelian Ulang'
                , content: 'Fitur krusial untuk parfum! Melacak berapa banyak orang yang membeli Full Bottle setelah sebelumnya mencoba Discovery Set (Tester). Membantu Anda mengukur kesuksesan aroma baru.'
            }
        ];

        let currentStep = 0;
        const overlay = document.getElementById('tour-overlay');
        const tooltip = document.getElementById('tour-tooltip');

        function startTour() {
            currentStep = 0;
            overlay.style.display = 'block';
            tooltip.style.display = 'flex';
            showStep(currentStep);
        }

        function closeTour() {
            overlay.style.display = 'none';
            tooltip.style.display = 'none';
            tourSteps.forEach(step => {
                const el = document.getElementById(step.elementId);
                if (el) el.classList.remove('tour-highlight');
            });
        }

        function showStep(index) {
            tourSteps.forEach(step => {
                const el = document.getElementById(step.elementId);
                if (el) el.classList.remove('tour-highlight');
            });

            const step = tourSteps[index];
            const targetEl = document.getElementById(step.elementId);

            if (targetEl) {
                // Handle hidden sidebar on mobile
                const sidebar = document.getElementById('sidebar');
                if (step.elementId === 'tour-pim' && window.innerWidth < 768) {
                    sidebar.classList.remove('-translate-x-full');
                } else if (window.innerWidth < 768) {
                    sidebar.classList.add('-translate-x-full');
                }

                targetEl.classList.add('tour-highlight');

                // Smooth scroll to element on mobile
                if (window.innerWidth < 768) {
                    targetEl.scrollIntoView({
                        behavior: 'smooth'
                        , block: 'center'
                    });
                }

                setTimeout(() => {
                    const rect = targetEl.getBoundingClientRect();
                    let top = rect.bottom + 10;
                    let left = rect.left;

                    if (window.innerWidth < 768) {
                        // Fixed bottom for mobile
                        tooltip.style.position = 'fixed';
                        left = (window.innerWidth - 300) / 2; // Center horizontally
                        top = window.innerHeight - 200; // Place at bottom
                    } else {
                        // Absolute positioning for desktop
                        tooltip.style.position = 'absolute';
                        if (rect.bottom + 200 > window.innerHeight) {
                            top = rect.top - 180;
                        }
                        if (left + 300 > window.innerWidth) {
                            left = window.innerWidth - 320;
                        }
                    }

                    tooltip.style.top = top + 'px';
                    tooltip.style.left = Math.max(10, left) + 'px';

                    document.getElementById('tour-step-indicator').innerText = index + 1;
                    document.getElementById('tour-title').innerText = step.title;
                    document.getElementById('tour-content').innerText = step.content;
                    document.getElementById('tour-prev').style.visibility = index === 0 ? 'hidden' : 'visible';
                    document.getElementById('tour-next').innerText = index === tourSteps.length - 1 ? 'Selesai' : 'Selanjutnya';
                }, 300); // Wait for scroll/sidebar animation
            }
        }

        function nextStep() {
            if (currentStep < tourSteps.length - 1) {
                currentStep++;
                showStep(currentStep);
            } else {
                closeTour();
            }
        }

        // --- Sidebar Mobile Logic ---
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('-translate-x-full');
        }

        // --- POS Logic ---
        let posCart = [];
        let activeMember = null; // null means Walk-in

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency'
                , currency: 'IDR'
                , minimumFractionDigits: 0
            }).format(angka);
        }

        function addToPosCart(name, price, variant) {
            posCart.push({
                name
                , price
                , variant
            });
            updatePosCartUI();
        }

        function removeFromPosCart(index) {
            posCart.splice(index, 1);
            updatePosCartUI();
        }

        function updatePosCartUI() {
            const container = document.getElementById('pos-cart-items');
            container.innerHTML = '';
            let subtotal = 0;

            if (posCart.length === 0) {
                container.innerHTML = `
                    <div class="text-center text-gray-400 mt-10 text-[11px]">
                        <i class="fas fa-shopping-basket text-2xl mb-2 opacity-50"></i>
                        <p>Keranjang Kosong</p>
                    </div>`;
            } else {
                posCart.forEach((item, index) => {
                    subtotal += item.price;
                    container.innerHTML += `
                        <div class="flex justify-between items-start border-b border-brand-border pb-3 mb-3">
                            <div>
                                <p class="font-bold text-[11px]">${item.name}</p>
                                <p class="text-[10px] text-gray-500">1 x ${formatRupiah(item.price)} (${item.variant})</p>
                            </div>
                            <button onclick="removeFromPosCart(${index})" class="text-red-500 hover:scale-110 transition"><i class="fas fa-times text-[10px]"></i></button>
                        </div>
                    `;
                });
            }

            document.getElementById('pos-subtotal').innerText = formatRupiah(subtotal);

            let total = subtotal;
            let discount = 0;

            if (activeMember && activeMember.tier === 'Gold' && subtotal > 0) {
                discount = subtotal * 0.10; // 10% discount for Gold Member
                total = subtotal - discount;
                document.getElementById('pos-discount-row').classList.remove('hidden');
                document.getElementById('pos-discount').innerText = `-${formatRupiah(discount)}`;
            } else {
                document.getElementById('pos-discount-row').classList.add('hidden');
            }

            document.getElementById('pos-total').innerText = formatRupiah(total);
        }

        function checkoutPos() {
            if (posCart.length === 0) {
                alert("Keranjang kosong!");
                return;
            }

            // Show Toast
            let earnedPoints = 0;
            if (activeMember) {
                earnedPoints = Math.floor(posCart.reduce((acc, item) => acc + item.price, 0) / 1000);
            }

            const toast = document.getElementById('posToast');
            const msg = document.getElementById('posToastMessage');

            if (activeMember) {
                msg.innerHTML = `Member <b>${activeMember.name}</b> mendapat +${earnedPoints} poin. Stok otomatis tersinkronisasi.`;
            } else {
                msg.innerHTML = "Stok e-commerce otomatis berkurang.";
            }

            toast.classList.remove('translate-x-[150%]');

            setTimeout(() => {
                toast.classList.add('translate-x-[150%]');
            }, 4000);

            // Reset
            posCart = [];
            activeMember = null;
            document.getElementById('active-customer-name').innerText = "Pelanggan Walk-in";
            document.getElementById('active-customer-badge').classList.add('hidden');
            updatePosCartUI();
        }

        // --- Member Lookup Logic ---
        const dummyMembers = [{
                name: "Rangga Dirgantara"
                , phone: "081234567890"
                , tier: "Gold"
                , points: 1250
            }
            , {
                name: "Siska Amelia"
                , phone: "089876543210"
                , tier: "Silver"
                , points: 300
            }
        ];

        function openMemberLookupModal() {
            document.getElementById('memberLookupModal').classList.remove('hidden');
            document.getElementById('memberLookupModal').classList.add('flex');
            document.getElementById('member-search-input').value = '';
            document.getElementById('member-search-results').innerHTML = '<div class="text-center text-gray-400 text-[11px] py-4">Mulai mengetik untuk mencari data pelanggan.</div>';
            document.getElementById('member-search-input').focus();
        }

        function closeMemberLookupModal() {
            document.getElementById('memberLookupModal').classList.add('hidden');
            document.getElementById('memberLookupModal').classList.remove('flex');
        }

        function searchMember() {
            const query = document.getElementById('member-search-input').value.toLowerCase();
            const resultsContainer = document.getElementById('member-search-results');

            if (query.length < 2) {
                resultsContainer.innerHTML = '<div class="text-center text-gray-400 text-[11px] py-4">Mulai mengetik untuk mencari data pelanggan.</div>';
                return;
            }

            const results = dummyMembers.filter(m => m.name.toLowerCase().includes(query) || m.phone.includes(query));

            if (results.length === 0) {
                resultsContainer.innerHTML = '<div class="text-center text-red-500 text-[11px] py-4">Member tidak ditemukan. <a href="#" class="font-bold underline">Daftarkan Member Baru</a></div>';
                return;
            }

            resultsContainer.innerHTML = '';
            results.forEach((member, index) => {
                const tierColor = member.tier === 'Gold' ? 'from-yellow-600 to-yellow-400 text-white' : 'from-gray-300 to-gray-400 text-black';
                resultsContainer.innerHTML += `
                    <div onclick="selectMember(${index})" class="border border-gray-200 rounded p-3 cursor-pointer hover:border-brand-gold transition flex justify-between items-center group">
                        <div>
                            <p class="font-bold text-[12px] text-brand-dark group-hover:text-brand-gold transition">${member.name}</p>
                            <p class="text-[10px] text-gray-500">${member.phone} • Poin: ${member.points}</p>
                        </div>
                        <span class="bg-gradient-to-r ${tierColor} text-[9px] px-2 py-1 rounded font-bold uppercase tracking-wider">${member.tier}</span>
                    </div>
                `;
            });
        }

        function selectMember(index) {
            activeMember = dummyMembers[index];
            document.getElementById('active-customer-name').innerText = activeMember.name;

            const badge = document.getElementById('active-customer-badge');
            badge.innerText = activeMember.tier + " Member";
            badge.classList.remove('hidden');
            if (activeMember.tier === 'Gold') {
                badge.className = "hidden ml-2 bg-gradient-to-r from-yellow-600 to-yellow-400 text-white text-[8px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider";
            } else {
                badge.className = "hidden ml-2 bg-gradient-to-r from-gray-300 to-gray-400 text-black text-[8px] px-1.5 py-0.5 rounded font-bold uppercase tracking-wider";
            }
            badge.classList.remove('hidden');

            closeMemberLookupModal();
            updatePosCartUI();
        }

    </script>
</body>
</html>
