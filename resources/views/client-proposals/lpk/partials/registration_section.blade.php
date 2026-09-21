<!-- Online Trainee Registration Section (Clean & Minimal) -->
<section id="pendaftaran-peserta" class="py-20 bg-slate-50 relative">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="bg-white rounded-2xl p-6 sm:p-10 border border-slate-200/80 shadow-sm">

            <div class="text-center max-w-lg mx-auto mb-8">
                <h2 class="font-heading text-2xl font-extrabold text-slate-900 tracking-tight">
                    Pendaftaran Calon Pekerja
                </h2>
                <p class="mt-1.5 text-slate-600 text-xs sm:text-sm">
                    Isi formulir singkat untuk konsultasi program, jadwal kelas, dan informasi dana talangan.
                </p>
            </div>

            <form id="formRegistration" onsubmit="handleRegistrationSubmit(event)" class="space-y-4 text-xs">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Nama Lengkap *</label>
                        <input type="text" id="regName" required placeholder="Nama sesuai KTP" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Nomor WhatsApp *</label>
                        <input type="tel" id="regWa" required placeholder="081234567890" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Program Pelatihan *</label>
                        <select id="regProgram" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none">
                            <option value="">-- Pilih Program --</option>
                            @foreach($lpkDatabase['programs'] ?? [] as $prg)
                            <option value="{{ $prg['title'] }}">{{ $prg['title'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Pendidikan Terakhir *</label>
                        <select id="regEducation" required class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none">
                            <option value="SMA / SMK Sederajat">SMA / SMK Sederajat</option>
                            <option value="Diploma (D3)">Diploma (D3)</option>
                            <option value="Sarjana (S1 / D4)">Sarjana (S1 / D4)</option>
                            <option value="SMP">SMP</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Usia *</label>
                        <input type="number" id="regAge" min="17" max="45" required placeholder="Tahun" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none">
                    </div>
                    <div>
                        <label class="block font-semibold text-slate-700 mb-1">Kota Asal / Domisili *</label>
                        <input type="text" id="regCity" required placeholder="Kota domisili saat ini" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-semibold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                    <textarea id="regNotes" rows="2" placeholder="Pertanyaan seputar program atau pengalaman kerja sebelumnya..." class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-1 focus:ring-slate-800 outline-none"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3 px-6 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition">
                        Kirim Pendaftaran via WhatsApp
                    </button>
                </div>

            </form>

        </div>

    </div>
</section>
