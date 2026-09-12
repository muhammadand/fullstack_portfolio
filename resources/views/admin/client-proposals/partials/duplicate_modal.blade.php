<!-- Modal Deteksi Duplikat -->
<div x-show="showDuplicateModal" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
    <div @click.away="showDuplicateModal = false" class="bg-white rounded-2xl shadow-2xl max-w-lg w-full overflow-hidden border border-slate-200 transform transition-all flex flex-col max-h-[90vh]">

        <!-- Modal Header -->
        <div class="px-6 py-5 bg-gradient-to-r from-rose-500 to-rose-600 text-white flex items-center justify-between shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-full bg-white/20 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-broom"></i>
                </div>
                <div>
                    <h3 class="font-bold text-lg leading-tight">Deteksi & Bersihkan Duplikat</h3>
                    <p class="text-rose-100 text-xs">Temukan nomor WA yang sama</p>
                </div>
            </div>
            <button @click="showDuplicateModal = false" type="button" class="text-white/80 hover:text-white transition">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto">
            <div x-show="isLoadingDuplicates" class="text-center py-8">
                <i class="fa-solid fa-circle-notch fa-spin text-rose-500 text-3xl mb-3"></i>
                <p class="text-sm text-slate-500 font-medium">Mendeteksi data...</p>
            </div>

            <div x-show="!isLoadingDuplicates && duplicateData.length === 0" style="display: none;" class="text-center py-8">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                    <i class="fa-solid fa-check-double"></i>
                </div>
                <h4 class="text-base font-bold text-slate-800 mb-1">Aman dari Duplikat!</h4>
                <p class="text-sm text-slate-500">Tidak ada nomor WhatsApp yang ganda.</p>
            </div>

            <div x-show="!isLoadingDuplicates && duplicateData.length > 0" style="display: none;">
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-4">
                    <div class="flex items-start gap-3">
                        <i class="fa-solid fa-triangle-exclamation text-amber-500 text-lg mt-0.5"></i>
                        <div>
                            <h5 class="text-sm font-bold text-amber-800">Ditemukan <span x-text="duplicateData.length"></span> Nomor Duplikat</h5>
                            <p class="text-xs text-amber-700 mt-1">Hanya akan disimpan 1 data pertama (paling lama) untuk setiap nomor yang duplikat, dan sisanya akan dihapus.</p>
                        </div>
                    </div>
                </div>

                <div class="border border-slate-200 rounded-lg overflow-hidden mb-2">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 text-xs uppercase">
                            <tr>
                                <th class="px-4 py-2 font-semibold">Nomor WhatsApp</th>
                                <th class="px-4 py-2 font-semibold text-center">Jumlah Data</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-for="item in duplicateData" :key="item.wa_number">
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-2 font-medium text-slate-700 font-mono" x-text="item.wa_number"></td>
                                    <td class="px-4 py-2 text-center text-rose-600 font-bold" x-text="item.count + ' data'"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="p-4 border-t border-slate-200 flex justify-end gap-3 shrink-0 bg-slate-50" x-show="!isLoadingDuplicates && duplicateData.length > 0" style="display: none;">
            <button @click="showDuplicateModal = false" type="button" class="px-4 py-2 bg-white hover:bg-slate-100 border border-slate-300 text-slate-700 text-sm font-medium rounded-lg transition">
                Batal
            </button>
            <form action="{{ route('admin.client_proposals.clean_duplicates') }}" method="POST">
                @csrf
                <button type="submit" onclick="return confirm('Yakin ingin membersihkan semua nomor duplikat? Data selain entri pertama akan dihapus permanen.')" class="px-5 py-2 bg-rose-500 hover:bg-rose-600 text-white text-sm font-bold rounded-lg transition shadow-md flex items-center gap-2">
                    <i class="fa-solid fa-trash-can"></i> Bersihkan Sekarang
                </button>
            </form>
        </div>
        <div class="p-4 border-t border-slate-200 flex justify-center bg-slate-50" x-show="!isLoadingDuplicates && duplicateData.length === 0" style="display: none;">
            <button @click="showDuplicateModal = false" type="button" class="px-5 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-lg transition shadow-md">
                Tutup
            </button>
        </div>
    </div>
</div>
