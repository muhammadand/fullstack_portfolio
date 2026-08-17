<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Data Mahasiswa - Mobile</title>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <x-affiliate.pwa-meta />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative">

    <x-affiliate.page-loader />

    <!-- Background Decoration -->
    <div class="fixed top-0 right-0 w-full h-64 bg-cyan-600/10 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6 z-20 relative">
            <div class="flex items-center">
                <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <div class="ml-4">
                    <p class="text-xs text-cyan-400 font-medium tracking-wider uppercase">CRM</p>
                    <h1 class="text-xl font-bold text-white">Data Mahasiswa</h1>
                </div>
            </div>

            <div class="relative">
                <button onclick="openAddLeadModal(); dismissCoachMark()" class="w-10 h-10 rounded-full bg-cyan-500 text-white shadow-lg shadow-cyan-500/30 flex items-center justify-center hover:bg-cyan-600 transition-colors shrink-0 relative z-10">
                    <i class="fa-solid fa-plus"></i>
                </button>

                <!-- Coach Mark -->
                <div id="coach-mark" class="absolute top-14 right-0 w-56 bg-cyan-600 text-white p-3.5 rounded-2xl shadow-2xl hidden z-50 transform origin-top-right transition-all duration-500 scale-0 opacity-0 border border-cyan-400/30">
                    <div class="absolute -top-2 right-3 w-4 h-4 bg-cyan-600 border-t border-l border-cyan-400/30 rotate-45 rounded-sm"></div>
                    <div class="relative z-10">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-white/20 flex items-center justify-center shrink-0 shadow-inner">
                                <i class="fa-solid fa-lightbulb text-yellow-300"></i>
                            </div>
                            <div>
                                <p class="text-[11px] font-medium leading-relaxed mb-3">Klik tombol ini untuk simpan nomor prospek mahasiswa secara manual & cepat!</p>
                                <button onclick="dismissCoachMark()" class="bg-black/20 hover:bg-black/30 border border-black/10 px-3 py-1.5 rounded-lg text-[10px] font-bold text-white transition-colors w-full text-center active:scale-95">
                                    Oke, Mengerti
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="text-xs text-slate-400 mb-6 leading-relaxed">
            Kelola prospek mahasiswa yang butuh bantuan Tugas Akhir/Skripsi. Anda bisa klaim data global untuk menjadi prospek Anda.
        </p>

        {{-- Tabs --}}
        <div class="flex p-1 bg-white/5 rounded-xl mb-6 relative z-10 border border-white/5">
            <a href="{{ route('affiliate.student_leads.index', ['tab' => 'global']) }}" class="flex-1 py-2 text-center text-xs font-semibold rounded-lg transition-all {{ $tab == 'global' ? 'bg-cyan-500 text-white shadow-lg' : 'text-slate-400 hover:text-white' }}">
                Data Global
            </a>
            <a href="{{ route('affiliate.student_leads.index', ['tab' => 'my_leads']) }}" class="flex-1 py-2 text-center text-xs font-semibold rounded-lg transition-all {{ $tab == 'my_leads' ? 'bg-cyan-500 text-white shadow-lg' : 'text-slate-400 hover:text-white' }}">
                Mahasiswaku
            </a>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-400 p-3 rounded-xl mb-6 text-xs font-semibold">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/50 text-red-400 p-3 rounded-xl mb-6 text-xs font-semibold">
            {{ session('error') }}
        </div>
        @endif

        {{-- List --}}
        @if($leads->isEmpty())
        <div class="flex flex-col items-center justify-center py-12 text-center">
            <div class="w-16 h-16 rounded-full bg-white/5 flex items-center justify-center text-slate-500 text-2xl mb-4">
                <i class="fa-solid fa-users-slash"></i>
            </div>
            <p class="text-slate-400 text-sm font-medium">Belum ada data prospek mahasiswa.</p>
        </div>
        @else
        <div class="flex flex-col gap-4">
            @foreach($leads as $lead)
            <div class="glass-panel p-4 rounded-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-cyan-500/10 rounded-bl-full blur-xl pointer-events-none"></div>

                <div class="flex justify-between items-start mb-3">
                    <div>
                        <h3 class="font-bold text-sm text-white mb-1">{{ $lead->name ?? 'Anonim' }}</h3>
                        <p class="text-[11px] text-slate-400"><i class="fa-solid fa-graduation-cap mr-1 text-cyan-400"></i> {{ $lead->university ?? 'Universitas Belum Diisi' }}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($tab === 'my_leads')
                        <button onclick="openEditLeadModal('{{ $lead->id }}', '{{ addslashes($lead->name) }}', '{{ $lead->wa_number }}', '{{ addslashes($lead->needs) }}')" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/20 text-slate-300 flex items-center justify-center transition-colors">
                            <i class="fa-solid fa-pen text-[10px]"></i>
                        </button>
                        @endif
                        @if($lead->status === 'new')
                        <span class="px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded-md text-[10px] font-bold">Baru</span>
                        @elseif($lead->status === 'contacted')
                        <span class="px-2 py-1 bg-blue-500/20 text-blue-400 rounded-md text-[10px] font-bold">Dihubungi</span>
                        @elseif($lead->status === 'deal')
                        <span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 rounded-md text-[10px] font-bold">Deal</span>
                        @endif
                    </div>
                </div>

                <div class="bg-white/5 rounded-xl p-3 mb-4">
                    <p class="text-[11px] text-slate-300 font-medium mb-1"><i class="fa-solid fa-clipboard-list mr-1"></i> Kebutuhan:</p>
                    <p class="text-xs text-white font-bold">{{ $lead->needs }}</p>
                </div>

                @if($tab === 'global')
                <form action="{{ route('affiliate.student_leads.claim', $lead->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full py-2 bg-cyan-600 hover:bg-cyan-500 text-white text-xs font-bold rounded-xl transition-colors">
                        Klaim Prospek Ini
                    </button>
                </form>
                @else
                <div class="flex gap-2">
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->wa_number) }}" target="_blank" class="flex-1 py-2 bg-green-500 hover:bg-green-600 text-white text-center text-xs font-bold rounded-xl transition-colors">
                        <i class="fa-brands fa-whatsapp mr-1"></i> Hubungi WA
                    </a>
                    @if($lead->clientProposal)
                    <a href="{{ route('landing.dynamic', $lead->clientProposal->slug) }}" target="_blank" class="flex-1 py-2 bg-white/10 hover:bg-white/20 text-white text-center text-xs font-bold rounded-xl transition-colors">
                        <i class="fa-solid fa-globe mr-1"></i> Lihat Proposal
                    </a>
                    @endif
                </div>
                @endif
            </div>
            @endforeach
        </div>

        <div class="mt-6 mb-8">
            {{ $leads->links() }}
        </div>
        @endif
    </div>

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

    <x-affiliate.bottom-nav />
    <x-affiliate.scripts />

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const hasSeenCoachMark = localStorage.getItem('hasSeenStudentLeadCoachMark');
            if (!hasSeenCoachMark) {
                const coachMark = document.getElementById('coach-mark');
                coachMark.classList.remove('hidden');
                setTimeout(() => {
                    coachMark.classList.remove('scale-0', 'opacity-0');
                    coachMark.classList.add('scale-100', 'opacity-100');
                }, 100);
            }
        });

        function dismissCoachMark() {
            const coachMark = document.getElementById('coach-mark');
            if (coachMark && !coachMark.classList.contains('hidden')) {
                coachMark.classList.remove('scale-100', 'opacity-100');
                coachMark.classList.add('scale-0', 'opacity-0');
                setTimeout(() => {
                    coachMark.classList.add('hidden');
                }, 500);
                localStorage.setItem('hasSeenStudentLeadCoachMark', 'true');
            }
        }

        function openAddLeadModal() {
            const modal = document.getElementById('addLeadModal');
            const content = document.getElementById('addLeadModalContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('translate-y-full');
            }, 10);
        }

        function closeAddLeadModal() {
            const content = document.getElementById('addLeadModalContent');
            content.classList.add('translate-y-full');

            setTimeout(() => {
                document.getElementById('addLeadModal').classList.add('hidden');
            }, 300);
        }

        function openEditLeadModal(id, name, waNumber, needs) {
            const modal = document.getElementById('editLeadModal');
            const content = document.getElementById('editLeadModalContent');
            const form = document.getElementById('editLeadForm');

            // Set form values
            document.getElementById('editName').value = name === 'Anonim' ? '' : name;
            document.getElementById('editWaNumber').value = waNumber;
            document.getElementById('editNeeds').value = needs === 'Belum Diketahui' ? '' : needs;

            // Set form action route
            form.action = `/partner/student-leads/${id}`;

            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('translate-y-full');
            }, 10);
        }

        function closeEditLeadModal() {
            const content = document.getElementById('editLeadModalContent');
            content.classList.add('translate-y-full');

            setTimeout(() => {
                document.getElementById('editLeadModal').classList.add('hidden');
            }, 300);
        }

    </script>
</body>
</html>
