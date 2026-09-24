<!-- INTERACTIVE SEAT PICKER & BOOKING MODAL -->
<div id="seatPickerModal" class="fixed inset-0 bg-slate-950/70 z-50 hidden items-center justify-center p-3 sm:p-4 backdrop-blur-md overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-xl w-full p-5 sm:p-7 shadow-2xl border border-slate-200 relative my-auto animate-fade-in custom-scrollbar max-h-[92vh] overflow-y-auto">

        <!-- Close Button -->
        <button type="button" onclick="closeSeatModal()" class="absolute top-4 right-4 w-8 h-8 rounded-full bg-slate-100 text-slate-500 hover:text-slate-900 hover:bg-slate-200 flex items-center justify-center transition">
            <i class="fas fa-times text-xs"></i>
        </button>

        <!-- Modal Header -->
        <div class="flex items-center gap-3 mb-5 pb-4 border-b border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center text-sm shadow-xs shrink-0">
                <i class="fas fa-van-shuttle"></i>
            </div>
            <div>
                <h3 class="font-bold text-base sm:text-lg text-slate-900 leading-tight">Pilih Nomor Kursi & Reservasi</h3>
                <p id="modalSubInfo" class="text-xs text-slate-500 font-medium mt-0.5">Isuzu Elf Long • Ciamis ➔ Jakarta (07:00 WIB)</p>
            </div>
        </div>

        <!-- Inclusions Highlight Banner -->
        <div class="bg-amber-50/80 border border-amber-200 rounded-xl p-3 sm:p-3.5 mb-5 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs shrink-0">
                <i class="fas fa-utensils"></i>
            </div>
            <div class="text-xs">
                <p class="font-bold text-amber-950">Fasilitas Termasuk:</p>
                <p id="modalInclusionText" class="text-amber-900 text-[11px] mt-0.5">Gratis Snack Box, Air Mineral & Paket Makan di Rest Area Tol</p>
            </div>
        </div>

        <!-- Visual Seat Selector -->
        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/80 mb-5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-3">
                <h4 class="font-bold text-xs uppercase tracking-wider text-slate-700">Denah Kursi Minibus</h4>
                <!-- Seat Legends -->
                <div class="flex items-center gap-3 text-[11px]">
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-emerald-100 border border-emerald-400"></span> Kosong</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-slate-200 border border-slate-300"></span> Terisi</span>
                    <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-md bg-slate-900 border border-slate-950"></span> Pilihan</span>
                </div>
            </div>

            <!-- Vehicle Front Indicator -->
            <div class="text-center mb-3">
                <span class="inline-block px-3 py-1 rounded-full bg-white border border-slate-200 text-slate-600 text-[10px] font-bold uppercase tracking-wider shadow-2xs">
                    <i class="fas fa-steering-wheel mr-1 text-slate-500"></i> Bagian Depan / Driver
                </span>
            </div>

            <!-- Seat Grid -->
            <div id="seatLayoutGrid" class="grid grid-cols-4 gap-2 max-w-xs mx-auto p-3.5 bg-white rounded-xl border border-slate-200 shadow-2xs">
                <!-- Dynamic seats generated via JS -->
            </div>
        </div>

        <!-- Passenger Booking Form -->
        <form id="passengerBookingForm" onsubmit="handleConfirmBooking(event)" class="space-y-3.5">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Nama Lengkap Penumpang</label>
                    <input type="text" id="passengerName" required placeholder="Nama lengkap..." class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-3.5 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Nomor WhatsApp</label>
                    <input type="tel" id="passengerPhone" required placeholder="0812xxxxxxx" class="w-full h-11 bg-slate-50 border border-slate-200 rounded-xl px-3.5 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Alamat Penjemputan (Rumah / Kos)</label>
                    <textarea id="pickupAddress" required rows="2" placeholder="Alamat lengkap penjemputan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition"></textarea>
                </div>
                <div>
                    <label class="block text-[11px] font-bold text-slate-700 mb-1">Alamat Pengantaran (Tujuan)</label>
                    <textarea id="dropoffAddress" required rows="2" placeholder="Alamat lengkap tujuan..." class="w-full bg-slate-50 border border-slate-200 rounded-xl p-3 text-xs text-slate-900 font-medium focus:ring-2 focus:ring-slate-900 focus:bg-white focus:outline-none transition"></textarea>
                </div>
            </div>

            <!-- Summary Bar -->
            <div class="bg-slate-100 rounded-xl p-3.5 flex items-center justify-between">
                <div>
                    <p class="text-[10px] text-slate-500 font-medium">Nomor Kursi</p>
                    <p class="font-bold text-xs text-slate-900 mt-0.5">
                        <span id="selectedSeatBadge" class="text-amber-800 bg-amber-100 px-2 py-0.5 rounded font-bold text-xs">Belum Dipilih</span>
                    </p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] text-slate-500 font-medium uppercase">Tarif All-In</p>
                    <p id="modalTotalPrice" class="font-bold text-base text-slate-900">Rp 0</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-2.5 pt-2">
                <button type="button" onclick="closeSeatModal()" class="px-4 py-2.5 rounded-xl border border-slate-200 text-slate-700 hover:bg-slate-100 text-xs font-bold transition">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition-all flex items-center gap-2">
                    <i class="fab fa-whatsapp text-sm"></i>
                    <span>Konfirmasi Reservasi WhatsApp</span>
                </button>
            </div>
        </form>

    </div>
</div>
