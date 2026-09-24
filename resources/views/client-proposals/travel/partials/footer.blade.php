<!-- Footer -->
<footer class="bg-slate-950 text-slate-400 pt-16 pb-12 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            
            <!-- Col 1: Brand Info -->
            <div>
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 rounded-xl bg-slate-900 text-white flex items-center justify-center text-sm border border-slate-700">
                        <i class="fas fa-van-shuttle"></i>
                    </div>
                    <div>
                        <span class="font-bold text-lg text-white tracking-tight block leading-tight">
                            {{ $brandName }}
                        </span>
                        <span class="text-[10px] text-slate-400 uppercase tracking-wider block">
                            Executive Minibus & Shuttle
                        </span>
                    </div>
                </div>
                <p class="text-xs leading-relaxed text-slate-400 mb-4">
                    Layanan travel shuttle spesialis Toyota HiAce Premio & Isuzu Elf Long antar kota. Penjemputan door to door, kuota kursi real-time, dan gratis paket makan di rest area.
                </p>
                <div class="flex items-center gap-2.5 text-white">
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-travel-700 flex items-center justify-center transition text-xs border border-slate-800"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-travel-700 flex items-center justify-center transition text-xs border border-slate-800"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="w-8 h-8 rounded-lg bg-slate-900 hover:bg-travel-700 flex items-center justify-center transition text-xs border border-slate-800"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>

            <!-- Col 2: Rute Populer -->
            <div>
                <h4 class="font-bold text-xs text-white uppercase tracking-wider mb-4">Rute Shuttle Harian</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#jadwal" class="hover:text-white transition flex items-center gap-2 text-slate-400"><i class="fas fa-chevron-right text-[9px] text-slate-600"></i> Shuttle Ciamis ➔ Jakarta (PP)</a></li>
                    <li><a href="#jadwal" class="hover:text-white transition flex items-center gap-2 text-slate-400"><i class="fas fa-chevron-right text-[9px] text-slate-600"></i> Shuttle Kuningan ➔ Bandung (PP)</a></li>
                    <li><a href="#jadwal" class="hover:text-white transition flex items-center gap-2 text-slate-400"><i class="fas fa-chevron-right text-[9px] text-slate-600"></i> Shuttle Bandung ➔ Ciamis (PP)</a></li>
                    <li><a href="#jadwal" class="hover:text-white transition flex items-center gap-2 text-slate-400"><i class="fas fa-chevron-right text-[9px] text-slate-600"></i> Shuttle Jakarta ➔ Kuningan (PP)</a></li>
                    <li><a href="#jadwal" class="hover:text-white transition flex items-center gap-2 text-slate-400"><i class="fas fa-chevron-right text-[9px] text-slate-600"></i> Shuttle Bandara Soetta & Kertajati</a></li>
                </ul>
            </div>

            <!-- Col 3: Layanan Kami -->
            <div>
                <h4 class="font-bold text-xs text-white uppercase tracking-wider mb-4">Fasilitas & Layanan</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="#fasilitas" class="hover:text-white transition flex items-center gap-2 text-slate-400"><i class="fas fa-chevron-right text-[9px] text-slate-600"></i> Gratis Paket Makan Rest Area</a></li>
                    <li><a href="#fasilitas" class="hover:text-white transition flex items-center gap-2 text-slate-400"><i class="fas fa-chevron-right text-[9px] text-slate-600"></i> Gratis Snack Box & Air Mineral</a></li>
                    <li><a href="#membership" class="hover:text-white transition flex items-center gap-2 text-slate-400"><i class="fas fa-chevron-right text-[9px] text-slate-600"></i> Program Member 10x Naik Free 1x</a></li>
                    <li><a href="https://wa.me/{{ $cleanWa }}?text={{ urlencode('Halo ' . $brandName . ', saya ingin charter 1 unit mobil Elf/HiAce.') }}" target="_blank" class="hover:text-white transition flex items-center gap-2 text-slate-400"><i class="fas fa-chevron-right text-[9px] text-slate-600"></i> Private Charter 1 Unit Elf / HiAce</a></li>
                    @if(isset($client->slug))
                    <li><a href="{{ route('proposal.dynamic', $client->slug) }}" class="text-sky-400 hover:text-sky-300 transition font-medium flex items-center gap-2"><i class="fas fa-file-invoice text-[10px]"></i> Proposal Proyek Website Travel</a></li>
                    @endif
                </ul>
            </div>

            <!-- Col 4: Kantor & Kontak -->
            <div>
                <h4 class="font-bold text-xs text-white uppercase tracking-wider mb-4">Kontak Operasional</h4>
                <ul class="space-y-2.5 text-xs text-slate-400">
                    <li class="flex items-start gap-2.5">
                        <i class="fas fa-map-marker-alt text-slate-500 mt-0.5 shrink-0"></i>
                        <span>Pool Pusat Operasional Shuttle & Minibus Antar Kota</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fas fa-phone-alt text-slate-500 shrink-0"></i>
                        <span>+{{ $cleanWa }} (Hotline 24 Jam)</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fab fa-whatsapp text-emerald-400 shrink-0 text-sm"></i>
                        <span>+{{ $cleanWa }} (WhatsApp Booking)</span>
                    </li>
                    <li class="flex items-center gap-2.5">
                        <i class="fas fa-clock text-slate-500 shrink-0"></i>
                        <span>Layanan Beroperasi Setiap Hari (24 Jam)</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="pt-8 border-t border-slate-900 text-center text-xs text-slate-500 flex flex-col sm:flex-row justify-between items-center gap-3">
            <p>&copy; {{ date('Y') }} {{ $brandName }}. All rights reserved.</p>
            <p>Developed with modern web architecture for Travel & Transport Solutions.</p>
        </div>
    </div>
</footer>
