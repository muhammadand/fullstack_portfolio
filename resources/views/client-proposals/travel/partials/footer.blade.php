<!-- Footer -->
<footer class="bg-slate-950 text-slate-400 pt-16 pb-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            
            <!-- Col 1: Brand Info -->
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-travel-600 text-white flex items-center justify-center text-lg">
                        <i class="fas fa-van-shuttle"></i>
                    </div>
                    <span class="font-heading font-extrabold text-xl text-white tracking-tight">
                        {{ $brandName }}
                    </span>
                </div>
                <p class="text-xs leading-relaxed text-slate-400 mb-4">
                    Layanan travel shuttle spesialis Isuzu Elf Long, Elf Short & Minibus antar kota terpercaya. Menghubungkan Ciamis, Kuningan, Tasikmalaya, Bandung, Jakarta, dan Bandara dengan fasilitas all-in gratis makan & snack.
                </p>
                <div class="flex items-center gap-3 text-white">
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-travel-600 flex items-center justify-center transition text-xs"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-travel-600 flex items-center justify-center transition text-xs"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-travel-600 flex items-center justify-center transition text-xs"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <!-- Col 2: Rute Populer -->
            <div>
                <h4 class="font-heading font-bold text-sm text-white uppercase tracking-wider mb-4">Rute Elf Harian</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#jadwal" class="hover:text-travel-400 transition flex items-center gap-2"><i class="fas fa-angle-right text-[10px] text-travel-500"></i> Travel Elf Ciamis ➔ Jakarta (PP)</a></li>
                    <li><a href="#jadwal" class="hover:text-travel-400 transition flex items-center gap-2"><i class="fas fa-angle-right text-[10px] text-travel-500"></i> Travel Elf Kuningan ➔ Bandung (PP)</a></li>
                    <li><a href="#jadwal" class="hover:text-travel-400 transition flex items-center gap-2"><i class="fas fa-angle-right text-[10px] text-travel-500"></i> Travel Elf Bandung ➔ Ciamis (PP)</a></li>
                    <li><a href="#jadwal" class="hover:text-travel-400 transition flex items-center gap-2"><i class="fas fa-angle-right text-[10px] text-travel-500"></i> Travel Elf Jakarta ➔ Kuningan (PP)</a></li>
                    <li><a href="#jadwal" class="hover:text-travel-400 transition flex items-center gap-2"><i class="fas fa-angle-right text-[10px] text-travel-500"></i> Shuttle Bandara Soetta & Kertajati</a></li>
                </ul>
            </div>

            <!-- Col 3: Layanan Kami -->
            <div>
                <h4 class="font-heading font-bold text-sm text-white uppercase tracking-wider mb-4">Fasilitas & Layanan</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#fasilitas" class="hover:text-travel-400 transition flex items-center gap-2"><i class="fas fa-angle-right text-[10px] text-travel-500"></i> Gratis Paket Makan Rest Area</a></li>
                    <li><a href="#fasilitas" class="hover:text-travel-400 transition flex items-center gap-2"><i class="fas fa-angle-right text-[10px] text-travel-500"></i> Gratis Snack Box & Air Mineral</a></li>
                    <li><a href="#membership" class="hover:text-travel-400 transition flex items-center gap-2"><i class="fas fa-angle-right text-[10px] text-travel-500"></i> Program Member 10x Naik Free 1x</a></li>
                    <li><a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin charter 1 unit mobil Elf.') }}" target="_blank" class="hover:text-travel-400 transition flex items-center gap-2"><i class="fas fa-angle-right text-[10px] text-travel-500"></i> Sewa Private Charter 1 Mobil Elf</a></li>
                    <li><a href="{{ route('proposal.dynamic', $client->slug) }}" class="text-sky-400 hover:text-white transition font-semibold flex items-center gap-2"><i class="fas fa-file-invoice text-[10px]"></i> Proposal Proyek Website Travel</a></li>
                </ul>
            </div>

            <!-- Col 4: Kantor & Kontak -->
            <div>
                <h4 class="font-heading font-bold text-sm text-white uppercase tracking-wider mb-4">Kontak & Pool Elf</h4>
                <ul class="space-y-3 text-xs">
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-map-marker-alt text-travel-500 mt-0.5 shrink-0"></i>
                        <span>Jl. Raya Utama Antar Kota, Pool Pusat Operasional Elf Travel</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fas fa-phone-alt text-travel-500 shrink-0"></i>
                        <span>+{{ $cleanWa }} (Hotline 24 Jam)</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fab fa-whatsapp text-emerald-400 shrink-0 text-sm"></i>
                        <span>+{{ $cleanWa }} (WhatsApp Booking)</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fas fa-clock text-travel-500 shrink-0"></i>
                        <span>Operasional: Setiap Hari 24 Jam</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="pt-8 border-t border-slate-900 text-center text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p>&copy; {{ date('Y') }} {{ $brandName }}. All rights reserved.</p>
            <p>Designed with excellence for Travel & Shuttle Industry by <span class="text-slate-400 font-semibold">Scalify Intelligence</span>.</p>
        </div>
    </div>
</footer>
