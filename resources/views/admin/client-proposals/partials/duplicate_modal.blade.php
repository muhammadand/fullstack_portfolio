<!-- Modal Deteksi Duplikat (Midnight Blue Glass) -->
<div x-show="showDuplicateModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm">
    <!-- Modal Card - Glassmorphism -->
    <div @click.away="showDuplicateModal = false" class="bg-slate-900/70 backdrop-blur-xl rounded-2xl shadow-2xl shadow-blue-900/20 max-w-lg w-full overflow-hidden border border-slate-700/50 transform transition-all flex flex-col max-h-[90vh]">

        <!-- Modal Header -->
        <div class="px-6 py-5 bg-slate-800/50 border-b border-slate-700/50 flex items-center justify-between shrink-0">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-500/30 flex items-center justify-center text-lg text-blue-400 shadow-inner">
                    <i class="fa-solid fa-broom"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg text-white leading-tight">Deteksi & Bersihkan Duplikat</h3>
                    <p class="text-slate-400 text-xs mt-0.5">Temukan nomor WA yang sama</p>
                </div>
            </div>
            <button @click="showDuplicateModal = false" type="button" class="text-slate-400 hover:text-white transition bg-slate-800/50 hover:bg-slate-700 w-8 h-8 rounded-full flex items-center justify-center">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto">
            <div x-show="isLoadingDuplicates" class="text-center py-8">
                <i class="fa-solid fa-circle-notch fa-spin text-blue-500 text-3xl mb-3"></i>
                <p class="text-sm text-slate-400 font-medium">Mendeteksi data...</p>
            </div>

            <div x-show="!isLoadingDuplicates && duplicateData.length === 0" style="display: none;" class="text-center py-8">
                <div class="w-16 h-16 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4 shadow-[0_0_15px_rgba(16,185,129,0.15)]">
                    <i class="fa-solid fa-check-double"></i>
                </div>
                <h4 class="text-base font-bold text-white mb-1">Aman dari Duplikat!</h4>
                <p class="text-sm text-slate-400">Tidak ada nomor WhatsApp yang ganda.</p>
            </div>

            <div x-show="!isLoadingDuplicates && duplicateData.length > 0" style="display: none;">
                <div class="bg-amber-500/10 border border-amber-500/20 rounded-xl p-4 mb-5">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-amber-400 text-lg mt-0.5"></i>
                        <div>
                            <h5 class="text-sm font-bold text-amber-400">Ditemukan <span x-text="duplicateData.length"></span> Nomor Duplikat</h5>
                            <p class="text-xs text-amber-200/70 mt-1">Hanya 1 data (paling lama) yang dipertahankan untuk tiap nomor duplikat, sisanya akan dihapus.</p>
                        </div>
                    </div>
                </div>

                <div class="border border-slate-700/50 rounded-xl overflow-hidden mb-2 bg-slate-800/30">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead class="bg-slate-800/50 border-b border-slate-700/50 text-slate-400 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-3 font-semibold">Nomor WhatsApp</th>
                                <th class="px-4 py-3 font-semibold text-center">Jumlah Data</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700/50">
                            <template x-for="item in duplicateData" :key="item.wa_number">
                                <tr class="hover:bg-slate-700/30 transition-colors">
                                    <td class="px-4 py-3 font-medium text-slate-300 font-mono" x-text="item.wa_number"></td>
                                    <td class="px-4 py-3 text-center text-rose-400 font-bold" x-text="item.count + ' data'"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-5 border-t border-slate-700/50 flex justify-end gap-3 shrink-0 bg-slate-800/40" x-show="!isLoadingDuplicates && duplicateData.length > 0" style="display: none;">
            <button @click="showDuplicateModal = false" type="button" class="px-5 py-2.5 bg-transparent hover:bg-slate-800 border border-slate-600 text-slate-300 text-sm font-medium rounded-xl transition-colors">
                Batal
            </button>
            <form action="{{ route('admin.client_proposals.clean_duplicates') }}" method="POST">
                @csrf
                <button type="submit" onclick="return confirm('Yakin ingin membersihkan semua nomor duplikat? Data selain entri pertama akan dihapus permanen.')" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-500 text-white text-sm font-bold rounded-xl transition shadow-[0_0_15px_rgba(225,29,72,0.3)] flex items-center gap-2">
                    <i class="fa-solid fa-trash-can"></i> Bersihkan Sekarang
                </button>
            </form>
        </div>
        <div class="p-5 border-t border-slate-700/50 flex justify-center bg-slate-800/40" x-show="!isLoadingDuplicates && duplicateData.length === 0" style="display: none;">
            <button @click="showDuplicateModal = false" type="button" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-sm font-bold rounded-xl transition shadow-[0_0_15px_rgba(37,99,235,0.3)]">
                Tutup
            </button>
        </div>
    </div>
</div>
