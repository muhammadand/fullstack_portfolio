<!-- ================= VIEW 9: TITIP PAKET KILAT (SAME-DAY CARGO) ================= -->
<section id="viewPackage" class="flex-1 hidden flex-col bg-slate-50">
    <!-- Top Nav Bar (Sky Blue) -->
    <div class="bg-gradient-to-r from-sky-600 to-sky-500 text-white px-4 py-2.5 sticky top-0 z-30 flex items-center gap-2.5 shadow-sm">
        <button type="button" onclick="switchView('viewHome')" class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-xs shrink-0 active:scale-95 cursor-pointer">
            <i class="fas fa-arrow-left"></i>
        </button>
        <div class="flex-1 min-w-0">
            <h3 class="text-xs font-extrabold text-white">Titip Paket Kilat (Same-Day)</h3>
            <p class="text-[10px] text-sky-100 truncate">Kirim Pagi Sampai Siang • Door to Door</p>
        </div>
    </div>

    <div class="p-3.5 space-y-3 flex-1">
        <form id="packageBookingForm" onsubmit="proceedPackageBooking(event)" class="space-y-3">

            <!-- 1. Kategori Ukuran Paket -->
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 shadow-xs">
                <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-2 mb-2.5 flex items-center justify-between">
                    <span>1. Kategori & Jenis Paket</span>
                    <span class="text-[9px] text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full">Garansi Cepat & Aman</span>
                </h4>

                <div class="grid grid-cols-2 gap-2">
                    <!-- Category 1: Dokumen -->
                    <label class="package-cat-card p-2.5 rounded-xl border-2 border-sky-500 bg-sky-50/50 cursor-pointer transition flex flex-col justify-between">
                        <div class="flex items-center gap-1.5 mb-1">
                            <input type="radio" name="packageCategory" value="dokumen" checked onchange="updatePackageTotal()" class="text-sky-600 focus:ring-sky-500">
                            <i class="fas fa-file-shield text-sky-600 text-xs"></i>
                        </div>
                        <p class="text-[11px] font-bold text-slate-900">Dokumen / Surat</p>
                        <p class="text-[9px] text-slate-500">Berat &lt; 1 Kg</p>
                        <p class="text-xs font-black text-sky-600 mt-1">Rp 35.000</p>
                    </label>

                    <!-- Category 2: Reguler -->
                    <label class="package-cat-card p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition flex flex-col justify-between">
                        <div class="flex items-center gap-1.5 mb-1">
                            <input type="radio" name="packageCategory" value="reguler" onchange="updatePackageTotal()" class="text-sky-600 focus:ring-sky-500">
                            <i class="fas fa-box text-emerald-600 text-xs"></i>
                        </div>
                        <p class="text-[11px] font-bold text-slate-900">Paket Standar</p>
                        <p class="text-[9px] text-slate-500">Dus 1 - 5 Kg</p>
                        <p class="text-xs font-black text-sky-600 mt-1">Rp 65.000</p>
                    </label>

                    <!-- Category 3: Makanan Khas -->
                    <label class="package-cat-card p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition flex flex-col justify-between">
                        <div class="flex items-center gap-1.5 mb-1">
                            <input type="radio" name="packageCategory" value="makanan" onchange="updatePackageTotal()" class="text-sky-600 focus:ring-sky-500">
                            <i class="fas fa-bowl-food text-amber-600 text-xs"></i>
                        </div>
                        <p class="text-[11px] font-bold text-slate-900">Makanan / Box</p>
                        <p class="text-[9px] text-slate-500">Same-day Fresh</p>
                        <p class="text-xs font-black text-sky-600 mt-1">Rp 85.000</p>
                    </label>

                    <!-- Category 4: Kargo Besar -->
                    <label class="package-cat-card p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 transition flex flex-col justify-between">
                        <div class="flex items-center gap-1.5 mb-1">
                            <input type="radio" name="packageCategory" value="kargo" onchange="updatePackageTotal()" class="text-sky-600 focus:ring-sky-500">
                            <i class="fas fa-boxes-stacked text-indigo-600 text-xs"></i>
                        </div>
                        <p class="text-[11px] font-bold text-slate-900">Kargo Jumbo</p>
                        <p class="text-[9px] text-slate-500">Berat 5 - 15 Kg</p>
                        <p class="text-xs font-black text-sky-600 mt-1">Rp 120.000</p>
                    </label>
                </div>
            </div>

            <!-- 2. Rute & Tanggal Kirim -->
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">2. Rute Pengiriman Paket</h4>

                <div class="grid grid-cols-2 gap-2">
                    <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                        <label class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Kota Asal (Jemput)</label>
                        <select id="pkgOrigin" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                            <option value="Ciamis" selected>Ciamis</option>
                            <option value="Bandung">Bandung</option>
                            <option value="Tasikmalaya">Tasikmalaya</option>
                            <option value="Kuningan">Kuningan</option>
                            <option value="Jakarta">Jakarta</option>
                        </select>
                    </div>
                    <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                        <label class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Kota Tujuan (Antar)</label>
                        <select id="pkgDestination" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer">
                            <option value="Bandung" selected>Bandung</option>
                            <option value="Ciamis">Ciamis</option>
                            <option value="Jakarta">Jakarta</option>
                            <option value="Tasikmalaya">Tasikmalaya</option>
                            <option value="Kuningan">Kuningan</option>
                        </select>
                    </div>
                </div>

                <div class="bg-slate-50 border border-slate-200/90 rounded-xl px-2.5 py-1.5">
                    <label for="pkgDate" class="block text-[8px] font-bold uppercase tracking-wider text-slate-400">Tanggal Pengiriman</label>
                    <input type="date" id="pkgDate" min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" class="w-full bg-transparent text-xs font-bold text-slate-800 focus:outline-none cursor-pointer" onchange="validatePackageDate(this.value)">
                </div>
            </div>

            <!-- 3. Data Pengirim & Penerima -->
            <div class="bg-white rounded-2xl p-3.5 border border-slate-200/80 space-y-2.5 shadow-xs">
                <h4 class="text-xs font-extrabold text-slate-900 border-b border-slate-100 pb-1.5">3. Data Pengirim & Penerima</h4>

                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">Nama Pengirim *</label>
                        <input type="text" id="pkgSenderName" required placeholder="Nama Anda" value="Andi Pratama" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-semibold focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">WA Pengirim *</label>
                        <input type="tel" id="pkgSenderPhone" required placeholder="0812xxxx" value="081234567890" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-semibold focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">Alamat Pengambilan Paket (Door Pickup)</label>
                    <input type="text" id="pkgPickupAddress" required placeholder="Alamat lengkap penjemputan paket..." value="Jl. Jenderal Sudirman No. 88, Ciamis" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-medium focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                </div>

                <div class="grid grid-cols-2 gap-2 pt-1 border-t border-slate-100">
                    <div>
                        <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">Nama Penerima *</label>
                        <input type="text" id="pkgRecipientName" required placeholder="Nama Penerima" value="Budi Santoso" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-semibold focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                    </div>
                    <div>
                        <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">WA Penerima *</label>
                        <input type="tel" id="pkgRecipientPhone" required placeholder="0813xxxx" value="081398765432" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-semibold focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                    </div>
                </div>

                <div>
                    <label class="block text-[8px] font-bold text-slate-500 mb-0.5 uppercase">Alamat Pengantaran Tujuan (Door Delivery)</label>
                    <input type="text" id="pkgDropoffAddress" required placeholder="Alamat lengkap penerima..." value="Jl. Dipatiukur No. 45, Coblong, Bandung" class="w-full h-8 bg-slate-50 border border-slate-200 rounded-lg px-2 text-xs text-slate-900 font-medium focus:ring-1 focus:ring-sky-500 focus:bg-white focus:outline-none">
                </div>
            </div>

            <!-- Total & Action Button -->
            <div class="bg-white border border-slate-200 rounded-2xl p-3.5 shadow-sm space-y-2.5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[9px] text-slate-400 font-bold uppercase">Ongkir Same-Day Delivery</p>
                        <p class="text-base font-black text-sky-600" id="pkgTotalPriceDisplay">Rp 35.000</p>
                    </div>
                    <span class="text-[9px] text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full font-bold">Door to Door Express</span>
                </div>
                <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer">
                    <span>Bayar Ongkir QRIS & Terbitkan Resi</span>
                    <i class="fas fa-qrcode"></i>
                </button>
            </div>
        </form>
    </div>
</section>
