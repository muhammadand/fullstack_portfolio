<footer class="bg-slate-950 text-slate-400 text-xs pt-10 pb-16 md:pb-10 border-t border-slate-900">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            
            <!-- Col 1: Brand Info -->
            <div class="md:col-span-2 space-y-2">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 rounded-md bg-emerald-500 text-slate-950 flex items-center justify-center font-bold text-xs">
                        <i class="fas fa-trophy text-[10px]"></i>
                    </div>
                    <span class="font-bold text-sm text-white">
                        {{ $client->brand_name ?? 'Apex Arena' }}
                    </span>
                </div>
                <p class="text-slate-400 leading-relaxed max-w-md text-xs">
                    Pusat gelanggang olahraga modern untuk Futsal, Badminton BWF, Padel Tennis, Mini Soccer 7v7, dan Bola Voli dengan sistem booking online dan platform komunitas.
                </p>
            </div>

            <!-- Col 2: Navigation -->
            <div class="space-y-2">
                <h4 class="text-xs font-semibold text-white">Navigasi</h4>
                <ul class="space-y-1.5 text-[11px]">
                    <li><a href="#cabor" class="hover:text-emerald-400 transition">Cabang Olahraga</a></li>
                    <li><a href="#lapangan" class="hover:text-emerald-400 transition">Jadwal & Ketersediaan</a></li>
                    <li><a href="#membership" class="hover:text-emerald-400 transition">Membership</a></li>
                    <li><a href="#komunitas" class="hover:text-emerald-400 transition">Komunitas & Mabar</a></li>
                    <li><a href="#fasilitas" class="hover:text-emerald-400 transition">Fasilitas</a></li>
                </ul>
            </div>

            <!-- Col 3: Contact & Hours -->
            <div class="space-y-2">
                <h4 class="text-xs font-semibold text-white">Informasi</h4>
                <p class="text-slate-400 text-[11px]">
                    Jl. Boulevard Sport Arena No. 88
                </p>
                <p class="text-slate-400 text-[11px]">
                    Buka 06:00 - 24:00 WIB
                </p>
                <p class="text-slate-400 text-[11px]">
                    WhatsApp: +{{ $cleanWa }}
                </p>
            </div>

        </div>

        <div class="pt-6 border-t border-slate-900 text-center text-[11px] text-slate-500 flex flex-col sm:flex-row items-center justify-between gap-2">
            <p>&copy; {{ date('Y') }} {{ $client->brand_name ?? 'Apex Arena' }}. All rights reserved.</p>
            <p class="text-slate-500">Sistem Gelanggang Olahraga by <strong class="text-slate-400">Scalify Intelligence</strong></p>
        </div>
    </div>
</footer>
