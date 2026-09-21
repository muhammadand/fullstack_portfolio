<!-- Quick Registration Modal (Clean & Minimal) -->
<div id="modalRegisterQuick" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-md w-full overflow-hidden shadow-xl border border-slate-200 transform transition-all my-8">

        <div class="p-5 border-b border-slate-100 relative">
            <button onclick="closeModal('modalRegisterQuick')" class="absolute top-4 right-4 w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                <i class="fas fa-times text-xs"></i>
            </button>
            <h3 class="font-heading text-base font-bold text-slate-900">Pendaftaran Program</h3>
            <p id="quickModalProgramName" class="text-xs text-blue-600 mt-0.5 font-semibold"></p>
        </div>

        <form id="formQuickRegister" onsubmit="handleQuickRegisterSubmit(event)" class="p-5 space-y-3.5 text-slate-800 text-xs">
            <div>
                <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                <input type="text" id="quickRegName" required placeholder="Nama sesuai KTP" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none">
            </div>

            <div class="grid grid-cols-2 gap-2.5">
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">No. WhatsApp *</label>
                    <input type="tel" id="quickRegWa" required placeholder="08123xxx" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none">
                </div>
                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Usia *</label>
                    <input type="number" id="quickRegAge" min="17" max="45" required placeholder="Thn" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none">
                </div>
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Domisili Asal *</label>
                <input type="text" id="quickRegCity" required placeholder="Kota tempat tinggal" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none">
            </div>

            <div class="pt-2">
                <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition">
                    Lanjutkan ke WhatsApp
                </button>
            </div>
        </form>

    </div>
</div>

<!-- Modal Login Portal Siswa (Clean & Minimal) -->
<div id="modal-login-demo" class="fixed inset-0 z-50 hidden bg-slate-900/50 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-2xl max-w-sm w-full overflow-hidden shadow-xl border border-slate-200 my-8">

        <div class="p-5 border-b border-slate-100 relative">
            <button onclick="closeModal('modal-login-demo')" class="absolute top-4 right-4 w-7 h-7 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-500 flex items-center justify-center transition">
                <i class="fas fa-times text-xs"></i>
            </button>
            <h3 class="font-heading text-base font-bold text-slate-900">Portal Siswa & LMS</h3>
            <p class="text-xs text-slate-500 mt-0.5">{{ $brandName }}</p>
        </div>

        <div class="p-5 space-y-3.5 text-slate-800 text-xs">
            <div>
                <label class="block font-semibold text-slate-700 mb-1">NIS / Username</label>
                <input type="text" value="LPK-2026-JP091" readonly class="w-full px-3 py-2 bg-slate-100 border border-slate-200 rounded-xl font-mono text-xs text-slate-700">
            </div>

            <div>
                <label class="block font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" value="••••••••••••" readonly class="w-full px-3 py-2 bg-slate-100 border border-slate-200 rounded-xl font-mono text-xs text-slate-700">
            </div>

            <div class="pt-2">
                <a href="#hero" onclick="closeModal('modal-login-demo')" class="w-full py-2.5 px-4 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-center block transition">
                    Buka Dashboard Siswa (Demo)
                </a>
            </div>
        </div>

    </div>
</div>
