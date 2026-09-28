<section id="fitur-pos" class="py-16 md:py-24 px-4 sm:px-8 bg-[#120E0C] relative">
    <div class="max-w-6xl mx-auto">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            
            <!-- Left Info (6 Cols) -->
            <div class="lg:col-span-6 space-y-6">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-[0.2em] text-[#C59B6C] block">
                        POS Kasir & QRIS Otomatis
                    </span>
                    <h2 class="font-serif text-3xl sm:text-4xl font-bold text-white mt-1 leading-tight">
                        Operasional Kafe Rapi, Bebas Antre & Lunas Seketika.
                    </h2>
                </div>

                <p class="text-xs sm:text-sm text-white/70 leading-relaxed font-light">
                    Kombinasi sistem POS kasir modern dengan pemesanan mandiri pelanggan via QR code meja. Transaksi langsung terverifikasi, order langsung masuk ke barista, dan laporan penjualan terekam rapi secara otomatis.
                </p>

                <!-- 3 Highlights List with Standard FontAwesome -->
                <div class="space-y-3.5">
                    <div class="flex items-start gap-3.5 p-3.5 rounded-xl bg-[#1A1410] border border-white/5">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500/10 text-emerald-400 flex items-center justify-center shrink-0 text-sm">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-white">QRIS Dinamis Otomatis</h4>
                            <p class="text-xs text-white/60 mt-0.5 font-light">Kode QR terbuat seketika sesuai total belanjaan. Pelanggan bisa bayar pakai BCA, Mandiri, GoPay, OVO, Dana tanpa salah nominal transfer.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5 p-3.5 rounded-xl bg-[#1A1410] border border-white/5">
                        <div class="w-8 h-8 rounded-lg bg-amber-500/10 text-amber-400 flex items-center justify-center shrink-0 text-sm">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-white">Struk Kasir Digital & Thermal</h4>
                            <p class="text-xs text-white/60 mt-0.5 font-light">Dukung cetak struk thermal kasir bluetooth atau kirim nota pesanan langsung ke WhatsApp pelanggan.</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5 p-3.5 rounded-xl bg-[#1A1410] border border-white/5">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/10 text-blue-400 flex items-center justify-center shrink-0 text-sm">
                            <i class="fas fa-bell-concierge"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-white">Order Routing Meja ke Barista</h4>
                            <p class="text-xs text-white/60 mt-0.5 font-light">Pesanan dari meja 01 s/d meja 12 langsung tampil di layar barista dengan nomor meja dan catatan kustom.</p>
                        </div>
                    </div>
                </div>

                @if(isset($client->slug))
                <div class="pt-2">
                    <a href="{{ route('demo.customer.cafe', $client->slug) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#C59B6C] hover:bg-[#D8AA73] text-[#140F0C] text-xs font-bold transition">
                        <span>Uji Coba Transaksi di Demo App</span>
                    </a>
                </div>
                @endif
            </div>

            <!-- Right Visual (6 Cols): Clean POS Mockup Card -->
            <div class="lg:col-span-6">
                <div class="bg-[#1A1410] border border-[#3A2C22] rounded-2xl p-6 shadow-xl relative">
                    
                    <!-- Header of POS Mock -->
                    <div class="flex items-center justify-between pb-3 border-b border-white/10">
                        <div>
                            <h4 class="font-bold text-xs sm:text-sm text-white">{{ $brandName }}</h4>
                            <p class="text-[10px] text-emerald-400 font-medium">Terminal Kasir Terkoneksi</p>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-black/50 text-[#D8AA73] border border-white/10">
                            Meja 04
                        </span>
                    </div>

                    <!-- Live Order Simulation Box -->
                    <div class="py-4 space-y-2.5 font-mono text-xs">
                        <div class="bg-[#140F0C] p-2.5 rounded-lg border border-white/5 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-white font-sans text-xs">2x Caramel Macchiato Reserve</p>
                                <p class="text-[10px] text-[#D8AA73] font-sans">Less Sugar 50%, Ice</p>
                            </div>
                            <span class="text-white font-bold">Rp 76.000</span>
                        </div>

                        <div class="bg-[#140F0C] p-2.5 rounded-lg border border-white/5 flex items-center justify-between">
                            <div>
                                <p class="font-bold text-white font-sans text-xs">1x Truffle Fries Garlic Aioli</p>
                                <p class="text-[10px] text-[#D8AA73] font-sans">Extra Parmesan</p>
                            </div>
                            <span class="text-white font-bold">Rp 35.000</span>
                        </div>

                        <!-- Calculations -->
                        <div class="pt-2 border-t border-dashed border-white/10 space-y-1 text-[11px]">
                            <div class="flex justify-between text-white/60">
                                <span class="font-sans">Subtotal</span>
                                <span>Rp 111.000</span>
                            </div>
                            <div class="flex justify-between text-amber-400">
                                <span class="font-sans">Diskon VIP (10%)</span>
                                <span>- Rp 11.100</span>
                            </div>
                            <div class="flex justify-between text-white/60">
                                <span class="font-sans">PB1 Resto (10%)</span>
                                <span>Rp 9.990</span>
                            </div>
                            <div class="flex justify-between text-sm font-bold text-white pt-2 border-t border-white/10">
                                <span class="font-sans">Total Tagihan</span>
                                <span class="text-[#D8AA73]">Rp 109.890</span>
                            </div>
                        </div>
                    </div>

                    <!-- Verified QRIS Banner -->
                    <div class="p-3 rounded-xl bg-emerald-500/10 border border-emerald-500/20 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-emerald-300">Pembayaran QRIS Berhasil</p>
                            <p class="text-[10px] text-white/50 font-mono">Reff: #QRIS-890281 • Lunas</p>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[9px] font-bold bg-white text-slate-900">
                            QRIS
                        </span>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
