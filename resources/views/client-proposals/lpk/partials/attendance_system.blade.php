<!-- Attendance & Presensi Digital Section (Clean & Minimal) -->
<section id="sistem-absensi" class="py-20 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">

            <!-- Left Column: Copywriting -->
            <div class="lg:col-span-5 space-y-5">
                <div>
                    <h2 class="font-heading text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                        Presensi Siswa Digital
                    </h2>
                    <p class="mt-2 text-slate-600 text-xs sm:text-sm leading-relaxed">
                        Pencatatan kehadiran harian berbasis QR Code dan validasi GPS untuk memastikan kedisiplinan calon tenaga kerja.
                    </p>
                </div>

                <div class="space-y-3 text-xs text-slate-600 pt-1">
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <strong class="text-slate-900 block font-semibold">Scan QR Code Cepat</strong>
                        <span class="text-slate-500">Siswa check-in mandiri di kelas secara realtime.</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <strong class="text-slate-900 block font-semibold">Validasi Radius Lokasi (GPS)</strong>
                        <span class="text-slate-500">Memastikan presensi hanya bisa dilakukan di area pelatihan.</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <strong class="text-slate-900 block font-semibold">Rekap Laporan Disnaker</strong>
                        <span class="text-slate-500">Export rekapitulasi kehadiran bulanan ke Excel secara otomatis.</span>
                    </div>
                </div>

                <div>
                    <button onclick="simulateScanAttendance()" class="px-4 py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-semibold text-xs transition">
                        Simulasi Scan Absen QR
                    </button>
                </div>
            </div>

            <!-- Right Column: Attendance Log Table Preview -->
            <div class="lg:col-span-7">
                <div class="bg-slate-900 rounded-2xl p-5 sm:p-6 border border-slate-800 text-white shadow-xl text-xs">

                    <!-- Table Header -->
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3 mb-4">
                        <div>
                            <h4 class="font-bold text-white text-sm">Log Kehadiran Siswa</h4>
                            <span class="text-slate-400 text-[11px]">Sesi Pelatihan Hari Ini</span>
                        </div>
                        <span class="px-2 py-0.5 rounded bg-emerald-500/20 text-emerald-400 text-[10px] font-mono">
                            Live Sinkronisasi
                        </span>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-slate-300">
                            <thead class="text-slate-400 font-semibold border-b border-slate-800 text-[11px]">
                                <tr>
                                    <th class="pb-2">Nama Siswa</th>
                                    <th class="pb-2">Jam</th>
                                    <th class="pb-2">Status</th>
                                </tr>
                            </thead>
                            <tbody id="attendanceLogBody" class="divide-y divide-slate-800/60 font-medium">
                                @foreach($lpkDatabase['attendance_demo'] ?? [] as $att)
                                <tr>
                                    <td class="py-2.5">
                                        <div class="font-semibold text-white">{{ $att['student'] }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $att['session'] }}</div>
                                    </td>
                                    <td class="py-2.5 font-mono text-slate-400 text-[11px]">{{ $att['time'] }}</td>
                                    <td class="py-2.5">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $att['badge'] }}">
                                            {{ $att['status'] }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Simulated Notice -->
                    <div id="scanSuccessAlert" class="hidden mt-3 p-2.5 rounded-lg bg-emerald-950 border border-emerald-800 text-emerald-300 text-[11px] flex items-center justify-between">
                        <span>Presensi baru berhasil dicatat: <strong>Andi Saputra (JP-01)</strong></span>
                        <span class="font-mono text-[9px] bg-emerald-900 px-1.5 py-0.5 rounded">GPS OK</span>
                    </div>

                </div>
            </div>

        </div>

    </div>
</section>
