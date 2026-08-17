<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Katalog Jasa Mahasiswa - Sobat Scalify</title>
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

        .glass-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(30, 58, 138, 0.1));
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative">

    <x-affiliate.page-loader />

    <!-- Background Decoration -->
    <div class="fixed top-0 left-0 w-full h-64 bg-blue-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('affiliate.dashboard') }}" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="text-xl font-bold ml-4 text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400">Jasa Mahasiswa</h1>
            </div>
            <button type="button" onclick="openInfoModal()" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-blue-400 hover:text-blue-300 hover:bg-white/10 transition-colors shadow-[0_0_15px_rgba(59,130,246,0.3)]">
                <i class="fa-solid fa-circle-info text-lg"></i>
            </button>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-400 p-3 rounded-xl mb-4 text-xs font-semibold">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-500/20 border border-red-500/50 text-red-400 p-3 rounded-xl mb-4 text-xs font-semibold">
            {{ session('error') }}
        </div>
        @endif

        <div class="glass-panel p-4 rounded-2xl mb-6">
            <h2 class="font-bold text-white mb-2"><i class="fa-solid fa-graduation-cap text-blue-400 mr-2"></i>Tawarkan Ke Teman</h2>
            <p class="text-xs text-slate-300 leading-relaxed mb-4">
                Pilih layanan di bawah ini, pilih prospek, dan langsung kirimkan penawaran instan via WhatsApp!
            </p>
            <button type="button" onclick="openAddLeadModal()" class="w-full py-2 bg-blue-600/20 hover:bg-blue-600/40 text-blue-400 border border-blue-500/30 rounded-xl text-xs font-bold transition-colors flex items-center justify-center gap-2">
                <i class="fa-solid fa-user-plus"></i> Tambah Nomor Teman (Target)
            </button>
        </div>

        <!-- Services List -->
        <div class="flex flex-col gap-4">
            @foreach($servicesByCategory as $categoryName => $services)
            <div class="glass-panel rounded-2xl overflow-hidden">
                <button type="button" class="w-full flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 transition-colors" onclick="toggleAccordion('cat-{{ $loop->index }}')">
                    <h3 class="text-md font-bold text-white flex items-center gap-2">
                        <i class="fa-solid fa-layer-group text-blue-400"></i>{{ $categoryName }}
                    </h3>
                    <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300" id="icon-cat-{{ $loop->index }}"></i>
                </button>
                <div id="content-cat-{{ $loop->index }}" class="hidden px-4 pb-4 pt-2">
                    <div class="flex flex-col gap-4">
                        @foreach($services as $service)
                        <div class="glass-panel rounded-2xl p-4 relative overflow-hidden group">
                            <!-- Decoration -->
                            <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-blue-500/10 rounded-full blur-xl group-hover:bg-blue-500/20 transition-all"></div>

                            <div class="flex justify-end items-start mb-2">
                                <span class="text-xs font-bold text-green-400">
                                    Estimasi: Rp {{ number_format($service->min_price, 0, ',', '.') }} - Rp {{ number_format($service->max_price, 0, ',', '.') }}
                                </span>
                            </div>

                            <h4 class="text-sm font-bold text-white mb-2">{{ $service->name }}</h4>
                            <p class="text-[11px] text-slate-400 leading-relaxed mb-4">
                                {{ $service->description }}
                            </p>

                            <button type="button" onclick="openOfferModal('{{ addslashes($service->name) }}')" class="w-full py-2 bg-white/10 hover:bg-white/20 text-white rounded-xl text-xs font-semibold transition-colors flex justify-center items-center gap-2">
                                <i class="fa-brands fa-whatsapp text-green-400"></i> Buat Penawaran WA
                            </button>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal Form WhatsApp -->
    <div id="offerModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeOfferModal()"></div>
        <div class="absolute bottom-0 left-0 w-full bg-[#0B1120] border-t border-white/10 rounded-t-[2rem] p-6 transform transition-transform translate-y-full min-h-[70vh] max-h-[90vh] overflow-y-auto" id="offerModalContent">

            <div class="w-12 h-1.5 bg-white/20 rounded-full mx-auto mb-6 shrink-0"></div>

            <h3 class="text-lg font-bold text-white mb-2" id="modalServiceName">Kirim Penawaran</h3>
            <p class="text-xs text-slate-400 mb-6">Masukkan nomor WhatsApp target dan sesuaikan pesan penawarannya jika perlu.</p>

            <form action="{{ route('affiliate.student_services.generate') }}" method="POST" id="offerForm">
                @csrf
                <div class="mb-4">
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Pilih Prospek (Mahasiswa)</label>
                    <div class="relative">
                        <select id="leadSelect" name="student_lead_id" onchange="toggleManualInput()" class="w-full bg-white/5 border border-white/10 rounded-xl py-3.5 px-4 text-sm text-white focus:outline-none focus:border-blue-500 transition-colors appearance-none">
                            <option value="" class="bg-[#0B1120] font-bold text-blue-400">-- Input Nomor WA Baru Manual --</option>

                            @if($myLeads->count() > 0)
                            <optgroup label="Mahasiswaku (CRM)" class="bg-[#0B1120] text-slate-400">
                                @foreach($myLeads as $lead)
                                <option value="{{ $lead->id }}" class="bg-[#0B1120] text-white">
                                    {{ $lead->name ? $lead->name . ' (' . $lead->wa_number . ')' : $lead->wa_number }}
                                    {{ $lead->needs && $lead->needs != 'Belum Diketahui' ? ' - Bth: ' . $lead->needs : '' }}
                                </option>
                                @endforeach
                            </optgroup>
                            @endif

                            @if($globalLeads->count() > 0)
                            <optgroup label="Data Global (Terbuka)" class="bg-[#0B1120] text-slate-400">
                                @foreach($globalLeads as $lead)
                                <option value="{{ $lead->id }}" class="bg-[#0B1120] text-white">
                                    {{ $lead->name ? $lead->name . ' (' . $lead->wa_number . ')' : $lead->wa_number }}
                                    {{ $lead->needs && $lead->needs != 'Belum Diketahui' ? ' - Bth: ' . $lead->needs : '' }}
                                </option>
                                @endforeach
                            </optgroup>
                            @endif
                        </select>
                        <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>

                <div class="mb-4" id="manualInputContainer">
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Nomor WhatsApp Target <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-brands fa-whatsapp"></i></span>
                        <input type="tel" name="wa_number" id="targetPhone" required placeholder="Contoh: 08123456789" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                </div>

                <!-- Toggle untuk Pesan -->
                <button type="button" onclick="toggleMessageSettings()" class="w-full flex items-center justify-between py-3 px-4 bg-white/5 rounded-xl mb-4 hover:bg-white/10 transition-colors">
                    <span class="text-xs font-semibold text-slate-300"><i class="fa-solid fa-pen-to-square mr-2"></i>Sesuaikan Pesan (Opsional)</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 text-xs transition-transform" id="msgToggleIcon"></i>
                </button>

                <!-- Container Pesan (Hidden by default) -->
                <div id="messageSettingsContainer" class="hidden">
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Pilih Template Pesan</label>
                        <div class="relative">
                            <select id="chatTemplateSelect" onchange="changeTemplate()" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-sm text-white focus:outline-none focus:border-blue-500 transition-colors appearance-none">
                                <option value="default" class="bg-[#0B1120]">Default (Bawaan)</option>
                                @foreach($chatTemplates as $template)
                                <option value="{{ $template->id }}" class="bg-[#0B1120]">{{ $template->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-xs font-semibold text-slate-300 mb-2">Pesan Penawaran</label>
                        <textarea name="chat_message" id="offerMessage" required rows="5" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 px-4 text-xs text-white focus:outline-none focus:border-blue-500 transition-colors leading-relaxed"></textarea>
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/30 transition-all flex justify-center items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Penawaran & Buat Link
                </button>

                <!-- Hidden inputs -->
                <input type="hidden" name="service_name" id="serviceNameHidden">
                <input type="hidden" id="affiliateCode" value="{{ $affiliate->affiliate_code }}">
            </form>
        </div>
    </div>

    <!-- Modal Informasi Komisi -->
    <div id="infoModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeInfoModal()"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-sm px-4">
            <div class="bg-[#0B1120] border border-white/10 rounded-[2rem] p-6 shadow-2xl transform transition-all scale-95 opacity-0" id="infoModalContent">
                <div class="w-14 h-14 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center text-2xl mx-auto mb-4">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>

                <h3 class="text-lg font-bold text-white text-center mb-6">Sistem Komisi Jasa Mahasiswa</h3>

                <div class="space-y-4">
                    <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-graduation-cap text-green-400"></i>
                            <h4 class="font-bold text-white text-sm">Project Skripsi</h4>
                        </div>
                        <ul class="text-xs text-slate-300 space-y-2 ml-7 list-disc">
                            <li>Komisi Fix: <span class="text-green-400 font-bold">Rp 200.000</span> per closing.</li>
                            <li>Harga tertera adalah estimasi. Anda bisa nego dengan teman Anda, lalu konsultasikan harga fix-nya ke Owner.</li>
                        </ul>
                    </div>

                    <div class="bg-white/5 p-4 rounded-xl border border-white/5">
                        <div class="flex items-center gap-3 mb-2">
                            <i class="fa-solid fa-book-open text-blue-400"></i>
                            <h4 class="font-bold text-white text-sm">Tugas Kuliah & Lainnya</h4>
                        </div>
                        <ul class="text-xs text-slate-300 space-y-2 ml-7 list-disc">
                            <li>Komisi Persentase: <span class="text-blue-400 font-bold">10%</span> dari total harga project.</li>
                            <li>Berlaku untuk tugas akhir, presentasi, makalah, atau project non-skripsi lainnya.</li>
                        </ul>
                    </div>
                </div>

                <button type="button" onclick="closeInfoModal()" class="w-full mt-6 py-3 bg-white/10 hover:bg-white/20 text-white rounded-xl text-sm font-bold transition-colors">
                    Mengerti
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Prospek Manual -->
    <div id="addLeadModal" class="fixed inset-0 z-[60] hidden">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="closeAddLeadModal()"></div>
        <div class="absolute bottom-0 left-0 w-full bg-[#0B1120] border-t border-white/10 rounded-t-[2rem] p-6 transform transition-transform translate-y-full" id="addLeadModalContent">

            <div class="w-12 h-1.5 bg-white/20 rounded-full mx-auto mb-6"></div>

            <h3 class="text-lg font-bold text-white mb-2">Simpan Nomor Baru</h3>
            <p class="text-xs text-slate-400 mb-6">Simpan nomor teman kamu ke dalam daftar sebelum membuat penawaran.</p>

            <form action="{{ route('affiliate.student_leads.store') }}" method="POST">
                @csrf
                <input type="hidden" name="redirect_to" value="student_services">

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Nomor WhatsApp <span class="text-red-400">*</span></label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-brands fa-whatsapp"></i></span>
                        <input type="tel" name="wa_number" required placeholder="Contoh: 08123456789" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Nama (Opsional)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-user"></i></span>
                        <input type="text" name="name" placeholder="Nama Mahasiswa" class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-semibold text-slate-300 mb-2">Kebutuhan / Project (Opsional)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fa-solid fa-briefcase"></i></span>
                        <input type="text" name="needs" placeholder="Contoh: Skripsi E-Commerce, Tugas Akhir..." class="w-full bg-white/5 border border-white/10 rounded-xl py-3 pl-10 pr-4 text-sm text-white focus:outline-none focus:border-blue-500 transition-colors">
                    </div>
                </div>

                <button type="submit" class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-500/30 transition-all flex justify-center items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan & Lanjutkan
                </button>
            </form>
        </div>
    </div>

    <x-affiliate.scripts />

    <script>
        const chatTemplates = @json($chatTemplates);

        function openOfferModal(serviceName) {
            const modal = document.getElementById('offerModal');
            const content = document.getElementById('offerModalContent');
            const titleEl = document.getElementById('modalServiceName');
            const hiddenName = document.getElementById('serviceNameHidden');
            const select = document.getElementById('chatTemplateSelect');

            modal.classList.remove('hidden');
            // Allow display to update before animating
            setTimeout(() => {
                content.classList.remove('translate-y-full');
            }, 10);

            titleEl.textContent = `Penawaran: ${serviceName}`;
            hiddenName.value = serviceName;

            // Reset inputs
            document.getElementById('leadSelect').value = "";
            toggleManualInput();

            // Reset toggle pesan
            const msgContainer = document.getElementById('messageSettingsContainer');
            const msgIcon = document.getElementById('msgToggleIcon');
            msgContainer.classList.add('hidden');
            msgIcon.classList.remove('rotate-180');

            // Set default template
            select.value = 'default';
            changeTemplate();
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

        function toggleMessageSettings() {
            const container = document.getElementById('messageSettingsContainer');
            const icon = document.getElementById('msgToggleIcon');

            if (container.classList.contains('hidden')) {
                container.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                container.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        function toggleManualInput() {
            const select = document.getElementById('leadSelect');
            const manualContainer = document.getElementById('manualInputContainer');
            const phoneInput = document.getElementById('targetPhone');

            if (select.value === "") {
                manualContainer.classList.remove('hidden');
                phoneInput.setAttribute('required', 'required');
            } else {
                manualContainer.classList.add('hidden');
                phoneInput.removeAttribute('required');
                phoneInput.value = ''; // clear
            }
        }

        function changeTemplate() {
            const select = document.getElementById('chatTemplateSelect');
            const messageEl = document.getElementById('offerMessage');
            const serviceName = document.getElementById('serviceNameHidden').value;
            const refCode = document.getElementById('affiliateCode').value;
            const refLink = `{{ url('/sobat-scalify') }}?ref=${refCode}`;

            if (select.value === 'default') {
                messageEl.value = `Halo bro, lagi sibuk ngerjain project atau skripsi?\n\nKalo butuh bantuan buat bikin *${serviceName}*, aku bisa bantu nih sama tim dari Scalify.\n\nBiar kamu ngga pusing mikirin kodenya, serahin ke ahlinya aja. Proses cepat, rapi, dan bisa direvisi!\n\nKalo minat atau mau tanya-tanya dulu, bisa cek di link ini ya bro: ${refLink}`;
                return;
            }

            const template = chatTemplates.find(t => t.id == select.value);
            if (template) {
                let content = template.content;
                // Replace variables commonly used in templates
                content = content.replace(/\[Nama Prospek\]/g, 'Bro/Sis');
                content = content.replace(/\[Nama Bisnis\]/g, serviceName);
                content = content.replace(/\[Link Proposal\]/g, refLink);
                content = content.replace(/\[Link Affiliate\]/g, refLink);
                messageEl.value = content;
            }
        }

        function closeOfferModal() {
            const content = document.getElementById('offerModalContent');
            content.classList.add('translate-y-full');

            setTimeout(() => {
                document.getElementById('offerModal').classList.add('hidden');
            }, 300);
        }

        function openInfoModal() {
            const modal = document.getElementById('infoModal');
            const content = document.getElementById('infoModalContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeInfoModal() {
            const modal = document.getElementById('infoModal');
            const content = document.getElementById('infoModalContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        function toggleAccordion(id) {
            const content = document.getElementById('content-' + id);
            const icon = document.getElementById('icon-' + id);

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        // Auto-show info modal on first visit
        document.addEventListener('DOMContentLoaded', () => {
            const hasSeenInfo = localStorage.getItem('hasSeenStudentCommissionInfo');
            if (!hasSeenInfo) {
                openInfoModal();
                localStorage.setItem('hasSeenStudentCommissionInfo', 'true');
            }
        });

    </script>
</body>
</html>
