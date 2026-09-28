<footer class="bg-[#0D0A08] border-t border-[#362921]/60 pt-16 pb-12 px-4 sm:px-8 text-white/70">
    <div class="max-w-6xl mx-auto">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            
            <!-- Brand Col -->
            <div class="space-y-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-[#C59B6C] text-[#140F0C] flex items-center justify-center text-sm font-bold shadow-md">
                        <i class="fas fa-coffee"></i>
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-white text-sm leading-tight">{{ strtoupper($brandName) }}</h4>
                        <p class="text-[9px] tracking-wider text-[#C59B6C] uppercase font-semibold">Specialty Coffee</p>
                    </div>
                </div>
                <p class="text-xs text-white/50 leading-relaxed font-light">
                    {{ $cafeDatabase['brand']['description'] ?? 'Artisan coffee roastery with self-order table system and modern POS.' }}
                </p>
                <div class="flex items-center gap-2 pt-1">
                    <a href="#" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-[#C59B6C] hover:text-[#D8AA73] flex items-center justify-center text-xs transition">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-[#C59B6C] hover:text-[#D8AA73] flex items-center justify-center text-xs transition">
                        <i class="fab fa-tiktok"></i>
                    </a>
                    <a href="https://wa.me/{{ $cleanWa }}" target="_blank" class="w-7 h-7 rounded-lg bg-white/5 border border-white/10 hover:border-[#C59B6C] hover:text-[#D8AA73] flex items-center justify-center text-xs transition">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Jam Operasional -->
            <div class="space-y-2">
                <h5 class="text-xs font-bold text-white uppercase tracking-wider">Jam Buka</h5>
                <p class="text-xs text-white/60">Senin - Jumat: 07:00 - 22:00 WIB</p>
                <p class="text-xs text-white/60">Sabtu - Minggu: 07:00 - 23:00 WIB</p>
                <p class="text-[11px] text-emerald-400 font-medium pt-1">• Buka Setiap Hari</p>
            </div>

            <!-- Alamat & Kontak -->
            <div class="space-y-2">
                <h5 class="text-xs font-bold text-white uppercase tracking-wider">Lokasi & Kontak</h5>
                <p class="text-xs text-white/60 leading-relaxed flex items-start gap-2 font-light">
                    <i class="fas fa-map-marker-alt text-[#C59B6C] mt-0.5 shrink-0 text-xs"></i>
                    <span>{{ $cafeDatabase['brand']['address'] ?? 'Jl. Senopati No. 42, Kebayoran Baru, Jakarta Selatan' }}</span>
                </p>
                <p class="text-xs text-white/60 flex items-center gap-2">
                    <i class="fas fa-phone text-[#C59B6C] shrink-0 text-xs"></i>
                    <span>+{{ $cleanWa }}</span>
                </p>
            </div>

            <!-- Quick Links -->
            <div class="space-y-2">
                <h5 class="text-xs font-bold text-white uppercase tracking-wider">Navigasi</h5>
                <ul class="space-y-1.5 text-xs text-white/60 font-light">
                    <li><a href="#menu" class="hover:text-[#D8AA73] transition">Menu Pilihan</a></li>
                    <li><a href="#fitur-pos" class="hover:text-[#D8AA73] transition">Sistem POS & QRIS</a></li>
                    <li><a href="#membership" class="hover:text-[#D8AA73] transition">Loyalty Membership</a></li>
                    @if(isset($client->slug))
                    <li><a href="{{ route('demo.customer.cafe', $client->slug) }}" class="text-amber-400 hover:underline">Demo App Mobile</a></li>
                    <li><a href="{{ route('proposal.dynamic', $client->slug) }}" class="text-[#D8AA73] hover:underline">Proposal Proyek</a></li>
                    @endif
                </ul>
            </div>

        </div>

        <div class="pt-8 border-t border-white/5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/40">
            <p>&copy; 2026 {{ $brandName }}. All rights reserved.</p>
            <p>Designed & Powered by <span class="text-[#D8AA73]">Scalify Intelligence</span></p>
        </div>

    </div>
</footer>
