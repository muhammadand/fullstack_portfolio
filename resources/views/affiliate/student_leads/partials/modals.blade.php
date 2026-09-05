<!-- Modal Tambah Prospek Manual -->
<div id="addLeadModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeAddLeadModal()"></div>
    <div class="absolute bottom-0 left-0 w-full bg-[#0B1120] border-t border-white/10 rounded-t-[2rem] p-6 transform transition-transform translate-y-full" id="addLeadModalContent">

        <div class="w-12 h-1.5 bg-white/20 rounded-full mx-auto mb-6"></div>

        <h3 class="text-lg font-bold text-white mb-2">Simpan Nomor Baru</h3>
        <p class="text-xs text-slate-400 mb-6">Simpan nomor prospek mahasiswa ke dalam daftar Anda dengan cepat.</p>

        <form action="{{ route('affiliate.student_leads.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-300 mb-2">Nomor WhatsApp <span class="text-red-400">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-brands fa-whatsapp"></i></span>
                    <input type="tel" name="wa_number" required placeholder="Contoh: 08123456789" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-cyan-500 transition-colors">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-300 mb-2">Nama (Opsional)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="name" placeholder="Nama Mahasiswa" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-cyan-500 transition-colors">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-semibold text-slate-300 mb-2">Kebutuhan / Project (Opsional)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-briefcase"></i></span>
                    <input type="text" name="needs" placeholder="Contoh: Skripsi E-Commerce, Tugas Akhir..." class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-cyan-500 transition-colors">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-cyan-500/30 transition-all flex justify-center items-center gap-2">
                <i class="fa-solid fa-save"></i> Simpan Prospek
            </button>
        </form>
    </div>
</div>

<!-- Modal Edit Prospek -->
<div id="editLeadModal" class="fixed inset-0 z-[60] hidden">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeEditLeadModal()"></div>
    <div class="absolute bottom-0 left-0 w-full bg-[#0B1120] border-t border-white/10 rounded-t-[2rem] p-6 transform transition-transform translate-y-full" id="editLeadModalContent">

        <div class="w-12 h-1.5 bg-white/20 rounded-full mx-auto mb-6"></div>

        <h3 class="text-lg font-bold text-white mb-2">Edit Data Mahasiswa</h3>
        <p class="text-xs text-slate-400 mb-6">Perbarui nama, nomor WA, atau kebutuhan prospek.</p>

        <form action="" method="POST" id="editLeadForm">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-300 mb-2">Nomor WhatsApp <span class="text-red-400">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-brands fa-whatsapp"></i></span>
                    <input type="tel" name="wa_number" id="editWaNumber" required placeholder="Contoh: 08123456789" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-cyan-500 transition-colors">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-semibold text-slate-300 mb-2">Nama (Opsional)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-user"></i></span>
                    <input type="text" name="name" id="editName" placeholder="Nama Mahasiswa" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-cyan-500 transition-colors">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-semibold text-slate-300 mb-2">Kebutuhan / Project (Opsional)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-briefcase"></i></span>
                    <input type="text" name="needs" id="editNeeds" placeholder="Contoh: Skripsi E-Commerce, Tugas Akhir..." class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-cyan-500 transition-colors">
                </div>
            </div>

            <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-cyan-600 to-blue-600 hover:from-cyan-500 hover:to-blue-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-cyan-500/30 transition-all flex justify-center items-center gap-2">
                <i class="fa-solid fa-save"></i> Perbarui Data
            </button>
        </form>
    </div>
</div>

<!-- Modal Penawaran AI & Produk Digital -->
<div id="aiOfferModal" class="fixed inset-0 z-[65] hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" onclick="closeAiOfferModal()"></div>
    <div class="absolute bottom-0 left-0 w-full bg-[#0B1120] border-t border-indigo-500/30 rounded-t-[2rem] p-6 transform transition-transform translate-y-full max-h-[90vh] overflow-y-auto" id="aiOfferModalContent">

        <div class="w-12 h-1.5 bg-white/20 rounded-full mx-auto mb-5"></div>

        <div class="flex items-center gap-3 mb-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white text-lg shadow-lg shadow-indigo-500/30">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </div>
            <div>
                <h3 class="text-base font-bold text-white">Rekomendasi AI (Soft-Selling)</h3>
                <p class="text-xs text-slate-400">Pesan WhatsApp pendek & persuasif</p>
            </div>
        </div>

        <!-- Target Student Info Pill -->
        <div class="bg-white/5 border border-white/10 rounded-xl p-3 mb-4 text-xs">
            <div class="flex items-center justify-between gap-2 mb-1">
                <span class="text-slate-400">Target Prospek:</span>
                <span class="font-bold text-cyan-300" id="aiTargetName">Anonim</span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-slate-400">Kebutuhan:</span>
                <span class="font-bold text-white truncate max-w-[200px]" id="aiTargetNeeds">Skripsi / Tugas Akhir</span>
            </div>
        </div>

        <!-- Pilih Produk Digital -->
        <div class="mb-4">
            <label class="block text-xs font-semibold text-slate-300 mb-1.5 flex items-center justify-between">
                <span>Pilih Produk yang Ingin Ditawarkan</span>
                <span class="text-[10px] text-amber-400 font-normal"><i class="fa-solid fa-cube mr-1"></i>Lynk.id</span>
            </label>
            <div class="relative">
                <select id="aiProductSelect" class="w-full bg-slate-900 border border-slate-700 text-white rounded-xl py-3 pl-3.5 pr-8 text-xs focus:outline-none focus:border-indigo-500 transition-colors appearance-none">
                    <option value="" class="text-cyan-400 font-semibold">✨ Jasa Pembuatan Website / Skripsi Custom</option>
                    @if(isset($digitalProducts) && $digitalProducts->count() > 0)
                    <optgroup label="Katalog Produk Digital Lynk.id" class="bg-slate-900 text-slate-300">
                        @foreach($digitalProducts as $dp)
                        <option value="{{ $dp->id }}" class="bg-slate-900 text-white">
                            📦 {{ $dp->name }} (Rp {{ number_format($dp->price, 0, ',', '.') }})
                        </option>
                        @endforeach
                    </optgroup>
                    @endif
                </select>
                <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none text-slate-400 text-xs">
                    <i class="fa-solid fa-chevron-down"></i>
                </div>
            </div>
        </div>

        <!-- Tombol Generate AI -->
        <button type="button" id="btnGenerateAi" onclick="executeAiGeneration()" class="w-full py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white rounded-xl text-xs font-bold transition-all shadow-md shadow-indigo-500/20 flex items-center justify-center gap-2 mb-4">
            <i class="fa-solid fa-robot"></i> Buat Pesan AI (Soft-Selling)
        </button>

        <!-- Preview Textarea (Editable) -->
        <div class="mb-5">
            <label class="block text-xs font-semibold text-slate-300 mb-1.5 flex items-center justify-between">
                <span>Preview Draft Pesan WhatsApp</span>
                <span class="text-[10px] text-slate-400">Dapat diedit langsung</span>
            </label>
            <textarea id="aiMessageResult" rows="5" placeholder="Klik tombol di atas untuk membuat pesan otomatis dengan AI..." class="w-full bg-slate-900/80 border border-slate-700 text-white text-xs rounded-xl p-3.5 focus:outline-none focus:border-indigo-500 leading-relaxed placeholder-slate-500"></textarea>
            <p class="text-[10px] text-slate-400 mt-1 flex items-center gap-1">
                <i class="fa-solid fa-circle-check text-green-400 text-[9px]"></i>
                Otomatis menyertakan info request custom jika judul mereka berbeda.
            </p>
        </div>

        <!-- Action Button Send WA -->
        <button type="button" id="btnSendWa" onclick="sendAiMessageToWa()" class="w-full py-3.5 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-500 hover:to-emerald-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-green-500/20 transition-all flex items-center justify-center gap-2">
            <i class="fa-brands fa-whatsapp text-base"></i> Buka & Kirim di WhatsApp
        </button>
    </div>
</div>

<!-- AI Loading Modal -->
<div id="aiLoadingModal" class="fixed inset-0 z-[70] hidden">
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-[#0B1120] border border-indigo-500/30 rounded-2xl p-6 text-center shadow-2xl shadow-indigo-500/20 max-w-xs w-full animate-pulse">
            <div class="w-16 h-16 bg-indigo-500/20 text-indigo-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fa-solid fa-robot text-3xl"></i>
            </div>
            <h3 class="text-white font-bold text-sm mb-2">AI Sedang Merangkai Pesan...</h3>
            <p class="text-xs text-slate-400">Menyesuaikan dengan produk & kebutuhan mahasiswa secara santai & persuasif.</p>
        </div>
    </div>
</div>
