<!-- ================= VIEW 9: TITIP PAKET KILAT (SAME-DAY CARGO - TAILWIND GLASS) ================= -->
<section id="viewPackage" class="flex-1 hidden flex-col space-y-4 pb-20">

    <!-- Top Nav Bar -->
    <div class="glass-panel rounded-2xl p-3 border border-white/10 flex items-center gap-3 shadow-lg">
        <button type="button" onclick="switchView('viewHome')" class="w-8 h-8 rounded-xl glass-panel flex items-center justify-center text-slate-300 hover:text-white text-xs shrink-0 active:scale-95 transition cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-black text-white truncate">Titip Paket Kilat (Same-Day)</h3>
            <p class="text-[10px] text-slate-400 truncate">Kirim Pagi Sampai Siang • Door to Door</p>
        </div>
    </div>

    <form id="packageBookingForm" onsubmit="proceedPackageBooking(event)" class="space-y-4">

        <!-- 1. Kategori Ukuran Paket -->
        <div class="glass-panel rounded-2xl p-4 border border-white/10 space-y-3 shadow-lg">
            <div class="flex items-center justify-between pb-2 border-b border-white/10">
                <span class="text-xs font-extrabold text-white">1. Kategori & Jenis Paket</span>
                <span class="text-[9px] text-emerald-300 font-bold bg-emerald-500/20 border border-emerald-400/30 px-2 py-0.5 rounded-full">Garansi Cepat & Aman</span>
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <!-- Category 1: Dokumen -->
                <label class="package-cat-card p-3 rounded-xl border border-blue-500 bg-blue-500/15 cursor-pointer transition flex flex-col justify-between">
                    <div class="flex items-center gap-2 mb-1">
                        <input type="radio" name="packageCategory" value="dokumen" checked onchange="updatePackageTotal()" class="text-blue-600 focus:ring-blue-500">
                        <i class="fas fa-file-shield text-blue-400 text-xs"></i>
                    </div>
                    <p class="text-xs font-bold text-white">Dokumen / Surat</p>
                    <p class="text-[10px] text-slate-400">Berat &lt; 1 Kg</p>
                    <p class="text-xs font-black text-blue-400 mt-2 font-mono">Rp 35.000</p>
                </label>

                <!-- Category 2: Reguler -->
                <label class="package-cat-card p-3 rounded-xl border border-white/10 glass-panel cursor-pointer hover:border-blue-400/50 transition flex flex-col justify-between">
                    <div class="flex items-center gap-2 mb-1">
                        <input type="radio" name="packageCategory" value="reguler" onchange="updatePackageTotal()" class="text-blue-600 focus:ring-blue-500">
                        <i class="fas fa-box text-emerald-400 text-xs"></i>
                    </div>
                    <p class="text-xs font-bold text-white">Paket Standar</p>
                    <p class="text-[10px] text-slate-400">Dus 1 - 5 Kg</p>
                    <p class="text-xs font-black text-blue-400 mt-2 font-mono">Rp 65.000</p>
                </label>

                <!-- Category 3: Makanan Khas -->
                <label class="package-cat-card p-3 rounded-xl border border-white/10 glass-panel cursor-pointer hover:border-blue-400/50 transition flex flex-col justify-between">
                    <div class="flex items-center gap-2 mb-1">
                        <input type="radio" name="packageCategory" value="makanan" onchange="updatePackageTotal()" class="text-blue-600 focus:ring-blue-500">
                        <i class="fas fa-bowl-food text-amber-400 text-xs"></i>
                    </div>
                    <p class="text-xs font-bold text-white">Makanan / Box</p>
                    <p class="text-[10px] text-slate-400">Same-day Fresh</p>
                    <p class="text-xs font-black text-blue-400 mt-2 font-mono">Rp 85.000</p>
                </label>

                <!-- Category 4: Kargo Besar -->
                <label class="package-cat-card p-3 rounded-xl border border-white/10 glass-panel cursor-pointer hover:border-blue-400/50 transition flex flex-col justify-between">
                    <div class="flex items-center gap-2 mb-1">
                        <input type="radio" name="packageCategory" value="kargo" onchange="updatePackageTotal()" class="text-blue-600 focus:ring-blue-500">
                        <i class="fas fa-boxes-stacked text-indigo-400 text-xs"></i>
                    </div>
                    <p class="text-xs font-bold text-white">Kargo Jumbo</p>
                    <p class="text-[10px] text-slate-400">Berat 5 - 15 Kg</p>
                    <p class="text-xs font-black text-blue-400 mt-2 font-mono">Rp 120.000</p>
                </label>
            </div>
        </div>

        <!-- 2. Rute & Tanggal Kirim -->
        <div class="glass-panel rounded-2xl p-4 border border-white/10 space-y-3 shadow-lg">
            <h4 class="text-xs font-extrabold text-white border-b border-white/10 pb-2">2. Rute Pengiriman Paket</h4>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Kota Asal (Jemput)</label>
                    <select id="pkgOrigin" class="w-full h-10 bg-slate-900 border border-white/15 rounded-xl px-2.5 text-xs font-bold text-white focus:outline-none focus:border-blue-500 cursor-pointer">
                        <option value="Ciamis" selected>Ciamis</option>
                        <option value="Bandung">Bandung</option>
                        <option value="Tasikmalaya">Tasikmalaya</option>
                        <option value="Kuningan">Kuningan</option>
                        <option value="Jakarta">Jakarta</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Kota Tujuan (Antar)</label>
                    <select id="pkgDestination" class="w-full h-10 bg-slate-900 border border-white/15 rounded-xl px-2.5 text-xs font-bold text-white focus:outline-none focus:border-blue-500 cursor-pointer">
                        <option value="Bandung" selected>Bandung</option>
                        <option value="Ciamis">Ciamis</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Tasikmalaya">Tasikmalaya</option>
                        <option value="Kuningan">Kuningan</option>
                    </select>
                </div>
            </div>

            <div>
                <label for="pkgDate" class="block text-[9px] font-bold uppercase tracking-wider text-slate-400 mb-1">Tanggal Pengiriman</label>
                <input type="date" id="pkgDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl px-3 text-xs font-bold text-white focus:outline-none focus:border-blue-500 cursor-pointer" onchange="validatePackageDate(this.value)">
            </div>
        </div>

        <!-- 3. Data Pengirim & Penerima -->
        <div class="glass-panel rounded-2xl p-4 border border-white/10 space-y-3 shadow-lg">
            <h4 class="text-xs font-extrabold text-white border-b border-white/10 pb-2">3. Data Pengirim & Penerima</h4>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Nama Pengirim *</label>
                    <input type="text" id="pkgSenderName" required placeholder="Nama Anda" value="Andi Pratama" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl px-3 text-xs text-white placeholder-slate-500 font-semibold focus:outline-none focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">WA Pengirim *</label>
                    <input type="tel" id="pkgSenderPhone" required placeholder="0812xxxx" value="081234567890" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl px-3 text-xs text-white placeholder-slate-500 font-mono font-semibold focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Alamat Pengambilan Paket (Door Pickup) *</label>
                <input type="text" id="pkgPickupAddress" required placeholder="Alamat lengkap penjemputan paket..." value="Jl. Jenderal Sudirman No. 88, Ciamis" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl px-3 text-xs text-white placeholder-slate-500 font-medium focus:outline-none focus:border-blue-500 transition">
            </div>

            <div class="grid grid-cols-2 gap-2.5 pt-2 border-t border-white/10">
                <div>
                    <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Nama Penerima *</label>
                    <input type="text" id="pkgRecipientName" required placeholder="Nama Penerima" value="Budi Santoso" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl px-3 text-xs text-white placeholder-slate-500 font-semibold focus:outline-none focus:border-blue-500 transition">
                </div>
                <div>
                    <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">WA Penerima *</label>
                    <input type="tel" id="pkgRecipientPhone" required placeholder="0813xxxx" value="081398765432" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl px-3 text-xs text-white placeholder-slate-500 font-mono font-semibold focus:outline-none focus:border-blue-500 transition">
                </div>
            </div>

            <div>
                <label class="block text-[9px] font-bold text-slate-400 mb-1 uppercase tracking-wider">Alamat Pengantaran Tujuan (Door Delivery) *</label>
                <input type="text" id="pkgDropoffAddress" required placeholder="Alamat lengkap penerima..." value="Jl. Dipatiukur No. 45, Coblong, Bandung" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl px-3 text-xs text-white placeholder-slate-500 font-medium focus:outline-none focus:border-blue-500 transition">
            </div>
        </div>

        <!-- Total & Action Button -->
        <div class="glass-card rounded-2xl p-4 border border-white/15 shadow-xl space-y-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-wider">Ongkir Same-Day Delivery</p>
                    <p class="text-xl font-black text-white tracking-tight" id="pkgTotalPriceDisplay">Rp 35.000</p>
                </div>
                <span class="text-[10px] text-emerald-300 bg-emerald-500/20 border border-emerald-400/30 px-3 py-1 rounded-full font-bold">Door to Door Express</span>
            </div>
            <button type="submit" class="w-full h-12 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 active:scale-[0.99] transition cursor-pointer">
                <span>Bayar Ongkir QRIS & Terbitkan Resi</span>
                <i class="fas fa-qrcode text-xs"></i>
            </button>
        </div>
    </form>
</section>
