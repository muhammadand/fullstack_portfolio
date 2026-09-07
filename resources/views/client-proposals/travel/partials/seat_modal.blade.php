<!-- INTERACTIVE SEAT PICKER & BOOKING MODAL (Visual Seat Diagram for Elf & Minibus) -->
<div id="seatPickerModal" class="fixed inset-0 bg-slate-950/60 z-50 hidden items-center justify-center p-3 sm:p-4 backdrop-blur-md overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 shadow-2xl border border-sky-100 relative my-auto animate-fade-in custom-scrollbar max-h-[95vh] overflow-y-auto">

        <!-- Close Button -->
        <button type="button" onclick="closeSeatModal()" class="absolute top-5 right-5 w-9 h-9 rounded-full bg-slate-100 text-slate-400 hover:text-slate-800 hover:bg-slate-200 flex items-center justify-center transition">
            <i class="fas fa-times text-sm"></i>
        </button>

        <!-- Modal Header -->
        <div class="flex items-center gap-3.5 mb-6 pb-4 border-b border-slate-100">
            <div class="w-12 h-12 rounded-2xl bg-sky-50 text-travel-600 flex items-center justify-center text-xl shadow-xs">
                <i class="fas fa-van-shuttle"></i>
            </div>
            <div>
                <h3 class="font-heading font-black text-lg text-slate-900">Pilih Nomor Kursi & Reservasi</h3>
                <p id="modalSubInfo" class="text-xs text-slate-500 font-semibold">Isuzu Elf Long • Ciamis ➔ Jakarta (07:00 WIB)</p>
            </div>
        </div>

        <!-- Inclusions Highlight Banner -->
        <div class="bg-amber-50/80 border border-amber-200/70 rounded-2xl p-4 mb-6 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center text-base shrink-0 shadow-xs">
                <i class="fas fa-utensils"></i>
            </div>
            <div class="text-xs">
                <p class="font-black text-amber-950">Fasilitas Termasuk:</p>
                <p id="modalInclusionText" class="text-amber-900 font-medium mt-0.5">Gratis Snack Box, Air Mineral & Paket Makan 1x di Rest Area</p>
            </div>
        </div>

        <!-- Visual Seat Selector Container for Elf Layout -->
        <div class="bg-slate-50/80 rounded-2xl p-5 border border-slate-200/80 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-4">
                <h4 class="font-heading font-extrabold text-xs uppercase tracking-wider text-slate-700">Denah Tempat Duduk Minibus</h4>
                <!-- Seat Legends -->
                <div class="flex items-center gap-3 text-[11px] font-semibold">
                    <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-lg bg-emerald-100 border border-emerald-400"></span> Kosong</span>
                    <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-lg bg-slate-300 border border-slate-400"></span> Terisi</span>
                    <span class="flex items-center gap-1.5"><span class="w-3.5 h-3.5 rounded-lg bg-travel-600 border border-travel-700"></span> Pilihan</span>
                </div>
            </div>

            <!-- Car Front Indicator -->
            <div class="text-center mb-3">
                <span class="inline-block px-4 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 text-[10px] font-extrabold uppercase tracking-widest shadow-2xs">
                    <i class="fas fa-steering-wheel mr-1 text-travel-600"></i> Depan Kendaraan / Supir
                </span>
            </div>

            <!-- Interactive Seat Grid -->
            <div id="seatLayoutGrid" class="grid grid-cols-4 gap-2.5 max-w-xs mx-auto p-4 bg-white rounded-2xl border border-slate-200 shadow-2xs">
                <!-- Dynamic Javascript generated seats for Elf Long / Short / Minibus -->
            </div>
        </div>

        <!-- Booking Form Inputs -->
        <form id="passengerBookingForm" onsubmit="handleConfirmBooking(event)" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Penumpang</label>
                    <input type="text" id="passengerName" required placeholder="Contoh: Budi Santoso" class="w-full bg-slate-50/80 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs text-slate-800 font-medium focus:ring-4 focus:ring-travel-500/10 focus:border-travel-500 focus:bg-white focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Nomor WhatsApp Aktif</label>
                    <input type="tel" id="passengerPhone" required placeholder="Contoh: 08123456789" class="w-full bg-slate-50/80 border border-slate-200/80 rounded-2xl px-4 py-3 text-xs text-slate-800 font-medium focus:ring-4 focus:ring-travel-500/10 focus:border-travel-500 focus:bg-white focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Penjemputan (Door to Door)</label>
                    <textarea id="pickupAddress" required rows="2" placeholder="Alamat lengkap penjemputan di rumah..." class="w-full bg-slate-50/80 border border-slate-200/80 rounded-2xl px-4 py-2.5 text-xs text-slate-800 font-medium focus:ring-4 focus:ring-travel-500/10 focus:border-travel-500 focus:bg-white focus:outline-none transition"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Pengantaran Tujuan</label>
                    <textarea id="dropoffAddress" required rows="2" placeholder="Alamat tujuan pengantaran..." class="w-full bg-slate-50/80 border border-slate-200/80 rounded-2xl px-4 py-2.5 text-xs text-slate-800 font-medium focus:ring-4 focus:ring-travel-500/10 focus:border-travel-500 focus:bg-white focus:outline-none transition"></textarea>
                </div>
            </div>

            <!-- Price Summary Bar -->
            <div class="bg-sky-50/60 border border-sky-100 rounded-2xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-[11px] text-slate-500 font-medium">Nomor Kursi Terpilih</p>
                    <p class="font-heading font-black text-sm text-slate-900 mt-0.5">
                        Kursi: <span id="selectedSeatBadge" class="text-amber-800 bg-amber-100/80 border border-amber-200 px-2.5 py-0.5 rounded-full font-black text-xs">Belum Dipilih</span>
                    </p>
                    <p class="text-[10px] text-emerald-700 font-bold mt-1"><i class="fas fa-plus-circle"></i> +100 Poin Member Ditambahkan</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-slate-400 font-bold uppercase">Total Tarif</p>
                    <p id="modalTotalPrice" class="font-heading font-black text-xl text-travel-700">Rp 0</p>
                </div>
            </div>

            <!-- Submit Action Buttons (Compact & Elegant) -->
            <div class="flex items-center justify-end gap-3 pt-3">
                <button type="button" onclick="closeSeatModal()" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 hover:bg-slate-100 text-xs font-bold transition">
                    Batal
                </button>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-heading font-black text-xs shadow-sm hover:shadow-md transition-all flex items-center gap-2">
                    <i class="fab fa-whatsapp text-sm"></i>
                    <span>Pesan Tiket</span>
                </button>
            </div>
        </form>

    </div>
</div>
