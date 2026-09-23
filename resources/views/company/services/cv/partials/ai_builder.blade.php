{{-- Interactive AI CV Builder Section --}}
<section id="ai-builder-section" class="py-14 sm:py-18 px-4 sm:px-6 lg:px-8 bg-[#090d29] border-b border-white/5 relative z-20" x-data="cvBuilderApp()">
    <div class="max-w-7xl mx-auto">

        {{-- Section Title (Standard Scalify) --}}
        <div class="mb-10 text-left">
            <div class="text-cyan-400 font-extrabold text-[11px] sm:text-xs tracking-[0.2em] uppercase mb-1.5 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                <span>INTERACTIVE CV BUILDER</span>
            </div>
            <h2 class="font-sans font-black text-2xl sm:text-3xl lg:text-4xl text-white tracking-tight mb-3">
                Konsultasi AI & Visual Modular CV Builder
            </h2>
            <p class="text-white/60 text-xs sm:text-sm leading-relaxed max-w-3xl font-normal">
                Susun data Anda dengan panduan asisten, atur urutan blok section dengan fitur <strong>Drag-and-Drop</strong>, tambahkan modul kustom, dan cetak PDF A4 secara presisi.
            </p>
        </div>

        {{-- Mode Switcher Tabs (Mobile & Desktop) --}}
        <div class="flex items-center gap-2 mb-6 overflow-x-auto pb-2 scrollbar-none">
            <button @click="activeView = 'chat'" :class="activeView === 'chat' ? 'bg-btn-gradient text-white shadow-glow-blue' : 'bg-white/5 text-white/70 hover:bg-white/10 border border-white/10'" class="px-4 py-2.5 rounded-full font-semibold text-xs transition-all flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-comments text-cyan-400"></i>
                <span>1. Formulasi Chat AI</span>
            </button>
            <button @click="activeView = 'form'" :class="activeView === 'form' ? 'bg-btn-gradient text-white shadow-glow-blue' : 'bg-white/5 text-white/70 hover:bg-white/10 border border-white/10'" class="px-4 py-2.5 rounded-full font-semibold text-xs transition-all flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-pen-to-square text-amber-400"></i>
                <span>2. Form Edit Data</span>
            </button>
            <button @click="activeView = 'preview'; $nextTick(() => fitZoom())" :class="activeView === 'preview' ? 'bg-btn-gradient text-white shadow-glow-blue' : 'bg-white/5 text-white/70 hover:bg-white/10 border border-white/10'" class="px-4 py-2.5 rounded-full font-semibold text-xs transition-all flex items-center gap-2 shrink-0">
                <i class="fa-solid fa-file-pdf text-rose-400"></i>
                <span>3. Live Preview & PDF</span>
                <span x-show="generatedOnce" class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
            </button>
        </div>

        {{-- MAIN BUILDER CONTAINER --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- LEFT COLUMN: CHAT ASSISTANT & FORM EDITOR & DRAG-AND-DROP TOOLBOX --}}
            <div class="lg:col-span-5 space-y-6" x-show="activeView === 'chat' || activeView === 'form' || window.innerWidth >= 1024">

                {{-- 1. Conversational AI Chat Interface --}}
                <div x-show="activeView === 'chat'" @dragover.prevent="isChatDropTarget = true" @dragleave.prevent="isChatDropTarget = false" @drop.prevent="handleChatDrop($event)" class="bg-slate-900/90 rounded-3xl border border-slate-800 shadow-2xl p-5 sm:p-6 backdrop-blur-xl relative overflow-hidden flex flex-col h-[560px] transition-all" :class="isChatDropTarget ? 'ring-4 ring-cyan-400 border-cyan-400 scale-[1.01]' : ''">

                    {{-- Drag Drop Overlay Feedback --}}
                    <div x-show="isChatDropTarget" x-transition class="absolute inset-0 bg-slate-950/95 border-2 border-dashed border-cyan-400 rounded-3xl z-40 flex flex-col items-center justify-center p-6 text-center backdrop-blur-md pointer-events-none">
                        <div class="w-16 h-16 rounded-2xl bg-cyan-500/20 border border-cyan-400/60 flex items-center justify-center text-cyan-300 text-2xl mb-3 shadow-lg animate-bounce">
                            <i class="fa-solid fa-crosshairs"></i>
                        </div>
                        <h4 class="text-white font-bold text-base">Drop di Sini untuk Diskusikan dengan AI</h4>
                        <p class="text-cyan-200 text-xs mt-1 max-w-xs">AI akan langsung memfokuskan formula STAR & pembaruan data pada bagian ini.</p>
                    </div>

                    {{-- Header Chat --}}
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800 shrink-0">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-cyan-500 to-indigo-600 flex items-center justify-center shadow-md">
                                <i class="fa-solid fa-wand-magic-sparkles text-white text-base"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-white text-sm sm:text-base flex items-center gap-2">
                                    Scalify Career AI
                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30">Online</span>
                                </h3>
                                <p class="text-xs text-slate-400">Asisten Penyusun & Editor CV</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <button @click="fillSampleData()" title="Isi dengan Data Contoh" class="text-xs px-2.5 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-cyan-300 border border-slate-700 transition flex items-center gap-1.5 shadow-sm">
                                <i class="fa-solid fa-bolt-lightning text-amber-400"></i> Data Sampel
                            </button>
                        </div>
                    </div>

                    {{-- Chat Bubbles Stream --}}
                    <div class="flex-1 overflow-y-auto py-3 space-y-3 pr-1 scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-transparent" id="chat-messages-container">

                        {{-- Welcome AI Message --}}
                        <div class="flex gap-2.5 items-start">
                            <div class="w-8 h-8 rounded-full bg-cyan-500/20 border border-cyan-400/40 text-cyan-400 flex items-center justify-center shrink-0 text-xs mt-0.5">
                                <i class="fa-solid fa-robot"></i>
                            </div>
                            <div class="space-y-2.5 max-w-[85%]">
                                <div class="bg-slate-800/90 text-slate-200 text-xs sm:text-sm py-2.5 px-3.5 rounded-2xl rounded-tl-none border border-slate-700/60 leading-relaxed shadow-sm">
                                    Halo! Saya Asisten AI Karir Scalify. Mari kita susun atau revisi CV profesionalmu. Kamu bisa sebutkan target posisi, klik <strong>Diskusikan AI</strong> / <strong>drag bagian CV ke chat</strong> (seperti Ctrl+L di IDE), atau pilih posisi di bawah:
                                </div>

                                {{-- Quick Preset Job Role Chips (Only shown before user first sends message) --}}
                                <div class="space-y-1" x-show="chatHistory.length === 0">
                                    <p class="text-[11px] text-slate-400 font-medium">Pilihan Cepat Posisi Impian:</p>
                                    <div class="flex flex-wrap gap-1.5">
                                        <template x-for="preset in rolePresets" :key="preset.role">
                                            <button @click="selectPreset(preset)" class="text-xs px-2.5 py-1 rounded-lg bg-slate-800 hover:bg-cyan-500/20 hover:border-cyan-400/40 border border-slate-700 text-slate-300 hover:text-cyan-300 transition-all">
                                                <span x-text="preset.role"></span>
                                            </button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Dynamic Chat Messages Loop --}}
                        <template x-for="(msg, idx) in chatHistory" :key="idx">
                            <div :class="msg.sender === 'user' ? 'flex justify-end gap-2.5 items-start' : 'flex justify-start gap-2.5 items-start'">

                                {{-- AI Avatar --}}
                                <template x-if="msg.sender === 'ai'">
                                    <div class="w-8 h-8 rounded-full bg-cyan-500/20 border border-cyan-400/40 text-cyan-400 flex items-center justify-center shrink-0 text-xs mt-0.5">
                                        <i class="fa-solid fa-robot"></i>
                                    </div>
                                </template>

                                {{-- Bubble Content --}}
                                <div :class="msg.sender === 'user' ? 'bg-gradient-to-r from-cyan-600 to-blue-600 text-white rounded-tr-none' : 'bg-slate-800/90 text-slate-200 rounded-tl-none border border-slate-700/60'" class="text-xs sm:text-sm py-2 px-3.5 rounded-2xl leading-relaxed shadow-sm max-w-[85%] whitespace-pre-wrap break-words">
                                    <span x-text="(msg.text || '').trim()"></span>
                                </div>

                                {{-- User Avatar --}}
                                <template x-if="msg.sender === 'user'">
                                    <div class="w-8 h-8 rounded-full bg-blue-500/20 border border-blue-400/40 text-blue-300 flex items-center justify-center shrink-0 text-xs mt-0.5">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                </template>
                            </div>
                        </template>

                        {{-- AI Typing Indicator --}}
                        <div x-show="isGenerating" class="flex gap-2.5 items-start">
                            <div class="w-8 h-8 rounded-full bg-cyan-500/20 border border-cyan-400/40 text-cyan-400 flex items-center justify-center shrink-0 text-xs mt-0.5">
                                <i class="fa-solid fa-robot animate-spin"></i>
                            </div>
                            <div class="bg-slate-800/90 py-2 px-4 rounded-2xl rounded-tl-none border border-slate-700/60 flex items-center gap-1.5 shadow-sm">
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-bounce"></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-bounce animation-delay-200"></span>
                                <span class="w-1.5 h-1.5 rounded-full bg-cyan-400 animate-bounce animation-delay-400"></span>
                                <span class="text-xs text-slate-300 ml-1.5">Memformulasikan CV standar HRD...</span>
                            </div>
                        </div>
                    </div>

                    {{-- Input Chat Bar, Active Context Chip & Quick Revision Chips --}}
                    <div class="pt-2 border-t border-slate-800 shrink-0 space-y-2">

                        {{-- Active Context Tag Chip (Antigravity Context Tagging) --}}
                        <div x-show="activeContext" x-transition class="flex items-center justify-between bg-cyan-950/80 border border-cyan-500/40 rounded-xl px-3 py-1.5 text-xs">
                            <div class="flex items-center gap-1.5 text-cyan-300 font-medium">
                                <i class="fa-solid fa-crosshairs text-cyan-400"></i>
                                <span>Fokus Diskusi:</span>
                                <span class="font-bold text-white bg-cyan-500/20 px-2 py-0.5 rounded-md" x-text="activeContext ? activeContext.title : ''"></span>
                            </div>
                            <button type="button" @click="clearDiscussContext()" class="text-slate-400 hover:text-white text-xs px-1" title="Hapus Fokus Context">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>

                        {{-- Quick Revision Chips (Visible after first interaction) --}}
                        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-none text-[11px]" x-show="chatHistory.length > 0">
                            <span class="text-slate-400 shrink-0 text-[10px] font-medium"><i class="fa-solid fa-wand-magic-sparkles text-cyan-400"></i> Minta AI:</span>
                            <button type="button" @click="sendQuickPrompt('Tolong poles bagian Ringkasan Profil agar lebih menonjolkan leadership dan inovasi')" class="px-2 py-0.5 rounded-md bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-cyan-300 border border-slate-700 shrink-0 transition flex items-center gap-1.5">
                                Poles Profil
                            </button>
                            <button type="button" @click="sendQuickPrompt('Tolong tambahkan pengalaman kerja baru di bidang teknologi dengan formula STAR')" class="px-2 py-0.5 rounded-md bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-cyan-300 border border-slate-700 shrink-0 transition flex items-center gap-1.5">
                                Tambah Pengalaman
                            </button>
                            <button type="button" @click="sendQuickPrompt('Tolong ubah riwayat pendidikan saya jadi S1 dengan predikat Cum Laude')" class="px-2 py-0.5 rounded-md bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-cyan-300 border border-slate-700 shrink-0 transition flex items-center gap-1.5">
                                Ganti Pendidikan
                            </button>
                            <button type="button" @click="sendQuickPrompt('Tolong optimalkan daftar skills saya dengan keyword ATS yang paling dicari HRD')" class="px-2 py-0.5 rounded-md bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-cyan-300 border border-slate-700 shrink-0 transition flex items-center gap-1.5">
                                Optimasi Skill
                            </button>
                        </div>

                        <form @submit.prevent="submitChatMessage" class="flex items-center gap-2">
                            <input type="text" id="ai-chat-input-field" x-model="userInputText" :placeholder="getPlaceholderText()" class="flex-1 bg-slate-800/90 border border-slate-700 rounded-xl px-4 py-2.5 text-xs sm:text-sm text-white placeholder-slate-400 focus:outline-none focus:border-cyan-400 transition" :disabled="isGenerating" />
                            <button type="submit" :disabled="isGenerating || !userInputText.trim()" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 disabled:opacity-50 text-white font-bold text-sm transition flex items-center justify-center shadow-md">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>
                        </form>
                        <div class="flex items-center justify-between text-[11px] text-slate-400 px-1">
                            <span class="text-[10px] text-slate-400">💡 Drag kartu ke chat / tekan <kbd class="px-1 py-0.5 rounded bg-slate-800 text-cyan-300 text-[9px] border border-slate-700 font-mono">Ctrl+L</kbd></span>
                            <button type="button" @click="triggerDirectGenerate()" class="text-cyan-400 hover:underline flex items-center gap-1 font-medium text-[11px]">
                                Generate Penuh
                            </button>
                        </div>
                    </div>
                </div>

                {{-- 2. DEDICATED MOBILE & DESKTOP FORM EDITOR (EASY FIELD-BY-FIELD INPUT) --}}
                <div x-show="activeView === 'form'" class="bg-slate-900/90 rounded-3xl border border-slate-800 shadow-2xl p-5 sm:p-6 backdrop-blur-xl space-y-6">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-800">
                        <div>
                            <h3 class="font-bold text-white text-base flex items-center gap-2">
                                <i class="fa-solid fa-pen-to-square text-amber-400"></i>
                                <span>Form Pengisian Data CV</span>
                            </h3>
                            <p class="text-xs text-white/50">Edit langsung setiap bagian dengan input yang nyaman di HP.</p>
                        </div>
                        <button type="button" @click="activeView = 'preview'; $nextTick(() => fitZoom())" class="px-3 py-1.5 rounded-full bg-btn-gradient text-white text-xs font-bold shadow-glow-blue">
                            Lihat Hasil →
                        </button>
                    </div>

                    {{-- Form Accordion: Data Pribadi & Kontak --}}
                    <div class="space-y-4">
                        <div class="bg-white/5 rounded-2xl p-4 border border-white/10 space-y-3">
                            <h4 class="text-xs font-extrabold uppercase tracking-wider text-cyan-400 flex items-center gap-2">
                                <i class="fa-solid fa-user"></i> Data Pribadi & Kontak
                            </h4>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] text-white/70 mb-1">Nama Lengkap</label>
                                    <input type="text" x-model="cvData.full_name" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-cyan-400" />
                                </div>
                                <div>
                                    <label class="block text-[11px] text-white/70 mb-1">Gelar (Opsional)</label>
                                    <input type="text" x-model="cvData.degree" placeholder="cth: S.Kom / S.E" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-cyan-400" />
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[11px] text-white/70 mb-1">Target Posisi / Profesi</label>
                                    <input type="text" x-model="cvData.target_role" placeholder="cth: Digital Marketing Specialist" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-cyan-400" />
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[11px] text-white/70 mb-1">Ringkasan Profil (Summary)</label>
                                    <textarea x-model="cvData.profile_summary" rows="3" class="w-full bg-slate-800 border border-slate-700 rounded-xl p-3 text-xs text-white focus:outline-none focus:border-cyan-400 leading-relaxed"></textarea>
                                </div>
                                <div>
                                    <label class="block text-[11px] text-white/70 mb-1">Nomor WhatsApp / Telp</label>
                                    <input type="text" x-model="cvData.phone" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-cyan-400" />
                                </div>
                                <div>
                                    <label class="block text-[11px] text-white/70 mb-1">Email</label>
                                    <input type="email" x-model="cvData.email" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-cyan-400" />
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-[11px] text-white/70 mb-1">Alamat Domisili</label>
                                    <input type="text" x-model="cvData.address" class="w-full bg-slate-800 border border-slate-700 rounded-xl px-3 py-2 text-xs text-white focus:outline-none focus:border-cyan-400" />
                                </div>
                            </div>
                        </div>

                        {{-- Form: Pengalaman Kerja --}}
                        <div class="bg-white/5 rounded-2xl p-4 border border-white/10 space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-extrabold uppercase tracking-wider text-cyan-400 flex items-center gap-2">
                                    <i class="fa-solid fa-briefcase"></i> Pengalaman Kerja
                                </h4>
                                <button type="button" @click="addWorkItem()" class="text-xs px-2.5 py-1 rounded-lg bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 hover:bg-cyan-500/30 transition">
                                    + Tambah Kerja
                                </button>
                            </div>
                            <template x-for="(work, wIdx) in cvData.work_experience" :key="wIdx">
                                <div class="p-3 bg-black/30 rounded-xl border border-white/5 space-y-2 relative">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-white/80" x-text="'Pekerjaan #' + (wIdx + 1)"></span>
                                        <button type="button" @click="removeWorkItem(wIdx)" class="text-rose-400 hover:text-rose-300 text-xs" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <input type="text" x-model="work.company" placeholder="Nama Perusahaan" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-2.5 py-1.5 text-xs text-white" />
                                        </div>
                                        <div>
                                            <input type="text" x-model="work.position" placeholder="Jabatan / Posisi" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-2.5 py-1.5 text-xs text-white" />
                                        </div>
                                        <div>
                                            <input type="text" x-model="work.period" placeholder="Periode (2022 - 2024)" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-2.5 py-1.5 text-xs text-white" />
                                        </div>
                                        <div>
                                            <input type="text" x-model="work.city" placeholder="Kota" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-2.5 py-1.5 text-xs text-white" />
                                        </div>
                                    </div>
                                    <div class="space-y-1 pt-1">
                                        <label class="block text-[10px] text-white/50">Poin Pencapaian (STAR):</label>
                                        <template x-for="(bullet, bIdx) in work.bullets" :key="bIdx">
                                            <div class="flex items-center gap-1.5">
                                                <input type="text" x-model="work.bullets[bIdx]" class="flex-1 bg-slate-800 border border-slate-700 rounded-lg px-2.5 py-1 text-xs text-white" />
                                                <button type="button" @click="removeWorkBullet(work, bIdx)" class="text-rose-400 text-xs px-1">×</button>
                                            </div>
                                        </template>
                                        <button type="button" @click="addWorkBullet(work)" class="text-[11px] text-cyan-400 hover:underline pt-0.5">
                                            + Tambah Poin
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Form: Pendidikan --}}
                        <div class="bg-white/5 rounded-2xl p-4 border border-white/10 space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-extrabold uppercase tracking-wider text-cyan-400 flex items-center gap-2">
                                    <i class="fa-solid fa-graduation-cap"></i> Pendidikan
                                </h4>
                                <button type="button" @click="addEduItem()" class="text-xs px-2.5 py-1 rounded-lg bg-indigo-500/20 text-indigo-300 border border-indigo-500/30 hover:bg-indigo-500/30 transition">
                                    + Tambah Pendidikan
                                </button>
                            </div>
                            <template x-for="(edu, eIdx) in cvData.education_list" :key="eIdx">
                                <div class="p-3 bg-black/30 rounded-xl border border-white/5 space-y-2 relative">
                                    <div class="flex items-center justify-between">
                                        <span class="text-[10px] font-bold text-white/80" x-text="'Pendidikan #' + (eIdx + 1)"></span>
                                        <button type="button" @click="removeEduItem(eIdx)" class="text-rose-400 hover:text-rose-300 text-xs">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                    <div class="grid grid-cols-2 gap-2">
                                        <div>
                                            <input type="text" x-model="edu.institution" placeholder="Nama Universitas / Sekolah" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-2.5 py-1.5 text-xs text-white" />
                                        </div>
                                        <div>
                                            <input type="text" x-model="edu.degree_name" placeholder="Jurusan / Jenjang" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-2.5 py-1.5 text-xs text-white" />
                                        </div>
                                        <div>
                                            <input type="text" x-model="edu.period" placeholder="Tahun (2018 - 2022)" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-2.5 py-1.5 text-xs text-white" />
                                        </div>
                                        <div>
                                            <input type="text" x-model="edu.gpa" placeholder="IPK (cth: IPK 3.85)" class="w-full bg-slate-800 border border-slate-700 rounded-lg px-2.5 py-1.5 text-xs text-white" />
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        {{-- Form: Skills & Keahlian --}}
                        <div class="bg-white/5 rounded-2xl p-4 border border-white/10 space-y-3">
                            <div class="flex items-center justify-between">
                                <h4 class="text-xs font-extrabold uppercase tracking-wider text-cyan-400 flex items-center gap-2">
                                    <i class="fa-solid fa-bolt"></i> Keahlian & Persentase Bar
                                </h4>
                                <button type="button" @click="addSkillItem()" class="text-xs px-2.5 py-1 rounded-lg bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 hover:bg-emerald-500/30 transition">
                                    + Tambah Skill
                                </button>
                            </div>
                            <div class="space-y-2">
                                <template x-for="(skill, skIdx) in cvData.skills" :key="skIdx">
                                    <div class="p-2.5 bg-black/30 rounded-xl border border-white/5 flex items-center gap-2">
                                        <input type="text" x-model="skill.name" placeholder="Nama Keahlian" class="flex-1 bg-slate-800 border border-slate-700 rounded-lg px-2.5 py-1 text-xs text-white" />
                                        <input type="range" min="10" max="100" step="5" x-model="skill.level" class="w-24 accent-cyan-400 cursor-pointer" />
                                        <span class="text-[11px] font-mono text-cyan-300 w-8 text-right" x-text="skill.level + '%'"></span>
                                        <button type="button" @click="removeSkillItem(skIdx)" class="text-rose-400 text-xs px-1">×</button>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- DRAG-AND-DROP MODULAR SECTION MANAGER & ASSETS TOOLBOX --}}
                <div class="bg-slate-900/90 rounded-3xl border border-slate-800 shadow-xl p-5 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-white">
                            <i class="fa-solid fa-arrows-up-down-left-right text-cyan-400"></i>
                            <span>Tata Letak Blok Section (Drag to Reorder)</span>
                        </div>
                        <span class="text-[10px] text-slate-400">Geser urutan sesuai selera</span>
                    </div>

                    {{-- Layout Preset Quick Switcher --}}
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-1.5">
                            <i class="fa-solid fa-layer-group text-cyan-400 mr-1"></i> Preset Tata Letak Cepat:
                        </label>
                        <div class="grid grid-cols-2 gap-1.5">
                            <button type="button" @click="applyLayoutPreset('default')" class="px-2.5 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-700 border border-slate-700 text-left transition flex items-center gap-2">
                                <i class="fa-solid fa-star text-amber-400 text-xs"></i>
                                <div>
                                    <div class="text-[11px] font-bold text-white leading-tight">Standar HRD</div>
                                    <div class="text-[9px] text-slate-400 leading-tight">Default 2-Kolom</div>
                                </div>
                            </button>
                            <button type="button" @click="applyLayoutPreset('freshgrad')" class="px-2.5 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-700 border border-slate-700 text-left transition flex items-center gap-2">
                                <i class="fa-solid fa-graduation-cap text-indigo-400 text-xs"></i>
                                <div>
                                    <div class="text-[11px] font-bold text-white leading-tight">Fresh Graduate</div>
                                    <div class="text-[9px] text-slate-400 leading-tight">Edu & Magang</div>
                                </div>
                            </button>
                            <button type="button" @click="applyLayoutPreset('senior')" class="px-2.5 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-700 border border-slate-700 text-left transition flex items-center gap-2">
                                <i class="fa-solid fa-briefcase text-blue-400 text-xs"></i>
                                <div>
                                    <div class="text-[11px] font-bold text-white leading-tight">Experienced Pro</div>
                                    <div class="text-[9px] text-slate-400 leading-tight">Kerja & Proyek</div>
                                </div>
                            </button>
                            <button type="button" @click="applyLayoutPreset('tech')" class="px-2.5 py-1.5 rounded-lg bg-slate-800/80 hover:bg-slate-700 border border-slate-700 text-left transition flex items-center gap-2">
                                <i class="fa-solid fa-code text-emerald-400 text-xs"></i>
                                <div>
                                    <div class="text-[11px] font-bold text-white leading-tight">Tech Specialist</div>
                                    <div class="text-[9px] text-slate-400 leading-tight">Portofolio & Skill</div>
                                </div>
                            </button>
                        </div>
                    </div>

                    {{-- Sortable List of Sections (HTML5 Drag and Drop) --}}
                    <div class="space-y-1.5" id="sortable-sections-list">
                        <template x-for="(sec, sIdx) in mainSections" :key="sec.id">
                            <div draggable="true" @dragstart="handleDragStart($event, sIdx)" @dragover.prevent="handleDragOver($event, sIdx)" @drop="handleDrop($event, sIdx)" :class="sec.visible ? 'bg-slate-800/90 border-slate-700 text-white' : 'bg-slate-850/50 border-slate-800/80 text-slate-500 opacity-60'" class="p-2.5 rounded-xl border flex items-center justify-between gap-3 text-xs transition duration-200 cursor-grab active:cursor-grabbing hover:border-cyan-500/40 group">

                                <div class="flex items-center gap-2.5">
                                    <i class="fa-solid fa-grip-vertical text-slate-500 group-hover:text-cyan-400 text-xs"></i>
                                    <i :class="sec.icon" class="text-xs text-cyan-400 w-4 text-center"></i>
                                    <span class="font-medium" x-text="sec.name"></span>
                                </div>

                                <div class="flex items-center gap-1">
                                    {{-- Quick AI Discuss Trigger --}}
                                    <button type="button" @click.stop="setDiscussContext(sec.id, sec.name)" draggable="true" @dragstart="handleDragStartContext($event, sec.id, sec.name)" class="px-2 py-1 rounded bg-cyan-500/10 hover:bg-cyan-500/20 text-cyan-300 border border-cyan-500/30 text-[10px] flex items-center gap-1 transition" title="Klik atau Drag ke Chat untuk diskusikan dengan AI">
                                        <i class="fa-solid fa-wand-magic-sparkles text-[9px] text-cyan-400"></i> AI
                                    </button>
                                    {{-- Move Up / Down Buttons for Easy Mobile Reorder --}}
                                    <button type="button" @click.stop="moveSection(sIdx, -1)" :disabled="sIdx === 0" class="w-6 h-6 rounded bg-slate-700/60 hover:bg-slate-600 disabled:opacity-30 text-slate-300 text-[10px] flex items-center justify-center transition" title="Pindah Ke Atas">
                                        <i class="fa-solid fa-arrow-up"></i>
                                    </button>
                                    <button type="button" @click.stop="moveSection(sIdx, 1)" :disabled="sIdx === mainSections.length - 1" class="w-6 h-6 rounded bg-slate-700/60 hover:bg-slate-600 disabled:opacity-30 text-slate-300 text-[10px] flex items-center justify-center transition" title="Pindah Ke Bawah">
                                        <i class="fa-solid fa-arrow-down"></i>
                                    </button>
                                    {{-- Visibility Toggle --}}
                                    <button type="button" @click.stop="sec.visible = !sec.visible" class="w-6 h-6 rounded bg-slate-700/60 hover:bg-slate-600 text-slate-300 text-[10px] flex items-center justify-center transition ml-1" :title="sec.visible ? 'Sembunyikan Blok' : 'Tampilkan Blok'">
                                        <i :class="sec.visible ? 'fa-solid fa-eye text-cyan-400' : 'fa-solid fa-eye-slash text-slate-500'"></i>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Comprehensive Asset Drawer / Add Modular Blocks --}}
                    <div class="pt-3 border-t border-slate-800">
                        <label class="block text-[11px] font-semibold text-slate-400 uppercase tracking-wider mb-2">
                            <i class="fa-solid fa-cubes text-cyan-400 mr-1"></i> Asset Library (Tambah Modul):
                        </label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-1.5 text-xs">
                            <button type="button" @click="addWorkItem()" class="p-2 rounded-xl bg-slate-800/80 hover:bg-cyan-500/10 hover:border-cyan-400/40 border border-slate-700 text-slate-300 hover:text-cyan-300 transition flex items-center gap-1.5 text-[11px]">
                                <i class="fa-solid fa-briefcase text-blue-400 text-[10px]"></i> + Kerja
                            </button>
                            <button type="button" @click="addEduItem()" class="p-2 rounded-xl bg-slate-800/80 hover:bg-cyan-500/10 hover:border-cyan-400/40 border border-slate-700 text-slate-300 hover:text-cyan-300 transition flex items-center gap-1.5 text-[11px]">
                                <i class="fa-solid fa-graduation-cap text-indigo-400 text-[10px]"></i> + Pendidikan
                            </button>
                            <button type="button" @click="addInternItem()" class="p-2 rounded-xl bg-slate-800/80 hover:bg-cyan-500/10 hover:border-cyan-400/40 border border-slate-700 text-slate-300 hover:text-cyan-300 transition flex items-center gap-1.5 text-[11px]">
                                <i class="fa-solid fa-building-user text-amber-400 text-[10px]"></i> + Magang
                            </button>
                            <button type="button" @click="addProjectItem()" class="p-2 rounded-xl bg-slate-800/80 hover:bg-cyan-500/10 hover:border-cyan-400/40 border border-slate-700 text-slate-300 hover:text-cyan-300 transition flex items-center gap-1.5 text-[11px]">
                                <i class="fa-solid fa-laptop-code text-cyan-400 text-[10px]"></i> + Proyek
                            </button>
                            <button type="button" @click="addOrgItem()" class="p-2 rounded-xl bg-slate-800/80 hover:bg-cyan-500/10 hover:border-cyan-400/40 border border-slate-700 text-slate-300 hover:text-cyan-300 transition flex items-center gap-1.5 text-[11px]">
                                <i class="fa-solid fa-users text-rose-400 text-[10px]"></i> + Organisasi
                            </button>
                            <button type="button" @click="addCertItem()" class="p-2 rounded-xl bg-slate-800/80 hover:bg-cyan-500/10 hover:border-cyan-400/40 border border-slate-700 text-slate-300 hover:text-cyan-300 transition flex items-center gap-1.5 text-[11px]">
                                <i class="fa-solid fa-certificate text-emerald-400 text-[10px]"></i> + Sertifikasi
                            </button>
                            <button type="button" @click="addAwardItem()" class="p-2 rounded-xl bg-slate-800/80 hover:bg-cyan-500/10 hover:border-cyan-400/40 border border-slate-700 text-slate-300 hover:text-cyan-300 transition flex items-center gap-1.5 text-[11px]">
                                <i class="fa-solid fa-trophy text-amber-300 text-[10px]"></i> + Prestasi
                            </button>
                            <button type="button" @click="addLangItem()" class="p-2 rounded-xl bg-slate-800/80 hover:bg-cyan-500/10 hover:border-cyan-400/40 border border-slate-700 text-slate-300 hover:text-cyan-300 transition flex items-center gap-1.5 text-[11px]">
                                <i class="fa-solid fa-language text-sky-400 text-[10px]"></i> + Bahasa
                            </button>
                            <button type="button" @click="addSkillItem()" class="p-2 rounded-xl bg-slate-800/80 hover:bg-cyan-500/10 hover:border-cyan-400/40 border border-slate-700 text-slate-300 hover:text-cyan-300 transition flex items-center gap-1.5 text-[11px]">
                                <i class="fa-solid fa-bolt text-teal-400 text-[10px]"></i> + Skill Bar
                            </button>
                        </div>
                    </div>

                    {{-- Upload Foto & Theme Selection --}}
                    <div class="pt-3 border-t border-slate-800 space-y-3">
                        <div class="flex items-center gap-3 bg-slate-800/60 p-2.5 rounded-xl border border-slate-700/60">
                            <div class="w-10 h-10 rounded-xl overflow-hidden bg-slate-700 shrink-0 border border-slate-600">
                                <img :src="cvData.photoUrl || defaultPhotoUrl" alt="Preview Foto" class="w-full h-full object-cover object-top" />
                            </div>
                            <div class="flex-1 min-w-0">
                                <label class="block text-xs font-semibold text-slate-200 mb-0.5 cursor-pointer">
                                    Ganti Foto Profil
                                    <input type="file" @change="handlePhotoUpload($event)" accept="image/*" class="hidden" />
                                </label>
                                <p class="text-[10px] text-slate-400 truncate">Unggah foto formal (.jpg/.png)</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-300 mb-1.5">Warna Sidebar Template:</label>
                            <div class="grid grid-cols-6 gap-1.5">
                                <button type="button" @click="cvTheme = 'cyan'" :class="cvTheme === 'cyan' ? 'ring-2 ring-white scale-105' : 'opacity-80 hover:opacity-100'" class="h-7 rounded-lg bg-[#0284c7] transition flex items-center justify-center text-[10px] font-bold text-white shadow-sm" title="Ocean Cyan">
                                    Cyan
                                </button>
                                <button type="button" @click="cvTheme = 'navy'" :class="cvTheme === 'navy' ? 'ring-2 ring-white scale-105' : 'opacity-80 hover:opacity-100'" class="h-7 rounded-lg bg-[#0f172a] transition flex items-center justify-center text-[10px] font-bold text-white shadow-sm" title="Midnight Navy">
                                    Navy
                                </button>
                                <button type="button" @click="cvTheme = 'emerald'" :class="cvTheme === 'emerald' ? 'ring-2 ring-white scale-105' : 'opacity-80 hover:opacity-100'" class="h-7 rounded-lg bg-[#047857] transition flex items-center justify-center text-[10px] font-bold text-white shadow-sm" title="Emerald Green">
                                    Green
                                </button>
                                <button type="button" @click="cvTheme = 'indigo'" :class="cvTheme === 'indigo' ? 'ring-2 ring-white scale-105' : 'opacity-80 hover:opacity-100'" class="h-7 rounded-lg bg-[#4338ca] transition flex items-center justify-center text-[10px] font-bold text-white shadow-sm" title="Royal Indigo">
                                    Indigo
                                </button>
                                <button type="button" @click="cvTheme = 'coral'" :class="cvTheme === 'coral' ? 'ring-2 ring-white scale-105' : 'opacity-80 hover:opacity-100'" class="h-7 rounded-lg bg-[#be123c] transition flex items-center justify-center text-[10px] font-bold text-white shadow-sm" title="Crimson Coral">
                                    Coral
                                </button>
                                <button type="button" @click="cvTheme = 'slate'" :class="cvTheme === 'slate' ? 'ring-2 ring-white scale-105' : 'opacity-80 hover:opacity-100'" class="h-7 rounded-lg bg-[#334155] transition flex items-center justify-center text-[10px] font-bold text-white shadow-sm" title="Monochrome Slate">
                                    Slate
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- RIGHT COLUMN: 2-COLUMN TWO-TONE CV SHEET (DYNAMIC MODULAR SECTIONS) --}}
            <div class="lg:col-span-7 space-y-4" x-show="activeView === 'preview' || window.innerWidth >= 1024">

                {{-- Action Bar Above CV Sheet --}}
                <div class="bg-slate-900/90 rounded-2xl border border-slate-800 p-3.5 flex flex-wrap items-center justify-between gap-3 backdrop-blur-md">
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="text-xs font-semibold text-slate-300 flex items-center gap-1.5">
                            <i class="fa-solid fa-file-pdf text-rose-400"></i> Format A4 Standar HRD (1-2 Halaman Auto)
                        </span>

                        {{-- Zoom Scale Controls (Fixes any small-screen cropping) --}}
                        <div class="inline-flex items-center gap-1 bg-slate-800/90 border border-slate-700/80 rounded-lg p-0.5 text-xs text-slate-300">
                            <button type="button" @click="setZoom(Math.max(40, zoomScale - 10))" class="w-6 h-6 rounded hover:bg-slate-700 flex items-center justify-center text-slate-300 transition" title="Zoom Out">
                                <i class="fa-solid fa-minus text-[10px]"></i>
                            </button>
                            <span class="px-1.5 font-mono text-[11px] text-cyan-300 min-w-[38px] text-center" x-text="zoomScale + '%'"></span>
                            <button type="button" @click="setZoom(Math.min(130, zoomScale + 10))" class="w-6 h-6 rounded hover:bg-slate-700 flex items-center justify-center text-slate-300 transition" title="Zoom In">
                                <i class="fa-solid fa-plus text-[10px]"></i>
                            </button>
                            <button type="button" @click="fitZoom()" class="px-2 py-0.5 rounded bg-slate-700/70 hover:bg-slate-600 text-[10px] font-medium text-slate-200 transition ml-0.5">
                                Fit Layar
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button @click="copyAllCvText()" class="px-3 py-1.5 rounded-lg bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-medium border border-slate-700 transition flex items-center gap-1.5" title="Salin Teks">
                            <i class="fa-regular fa-copy"></i>
                            <span x-text="copySuccess ? 'Tersalin!' : 'Salin Teks'"></span>
                        </button>
                        <button @click="printCv()" class="px-4 py-1.5 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white text-xs font-bold shadow-md hover:shadow-cyan-500/30 transition flex items-center gap-1.5">
                            <i class="fa-solid fa-print"></i> Cetak / Simpan PDF
                        </button>
                    </div>
                </div>

                {{-- CV PREVIEW CONTAINER (SCROLLABLE BOTH VERTICALLY & HORIZONTALLY FOR MULTI-PAGE) --}}
                <div class="bg-slate-950 p-2 sm:p-4 rounded-3xl border border-slate-800 shadow-2xl max-h-[850px] overflow-y-auto overflow-x-auto scrollbar-thin scrollbar-thumb-slate-700 scrollbar-track-slate-900 transition-all flex justify-center">

                    {{-- Inner Centered Wrapper that supports arbitrary zoom and scroll --}}
                    <div class="w-full flex justify-center py-2 px-0.5 transition-transform duration-150" :style="'transform: scale(' + (zoomScale / 100) + '); transform-origin: top center; margin-bottom: ' + ((zoomScale < 100) ? (-(1123 * (1 - zoomScale / 100)) + 'px') : '0')">

                        {{-- THE PRINTABLE A4 CV SHEET (DYNAMIC MULTI-PAGE HEIGHT WITH CONTINUOUS TWO-TONE SIDEBAR) --}}
                        <div id="cv-printable-sheet" class="w-[794px] min-h-[1123px] h-auto bg-white text-slate-800 shadow-2xl relative flex font-sans select-text shrink-0" :class="'theme-' + cvTheme">

                            {{-- Visual Page Break Marker for Page 1 / Page 2 (Guides user when scrolling) --}}
                            <div class="absolute left-0 right-0 top-[1123px] border-b-2 border-dashed border-cyan-500/70 z-20 pointer-events-none flex items-center justify-center print:hidden">
                                <span class="bg-slate-900/95 text-cyan-300 text-[10px] font-bold px-3 py-1 rounded-full border border-cyan-400/50 shadow-xl -translate-y-1/2 flex items-center gap-1.5 backdrop-blur-md">
                                    <i class="fa-solid fa-file-lines text-cyan-400"></i> Batas Halaman 1 (A4) &bull; Lanjut Halaman 2
                                </span>
                            </div>

                            {{-- ==================== LEFT SIDEBAR (TWO-TONE COLORED - AUTO EXPANDING) ==================== --}}
                            <div class="w-[280px] p-6 text-white flex flex-col shrink-0 space-y-4 transition-colors duration-300 justify-between min-h-full" :style="getSidebarStyle()">

                                <div class="space-y-4">
                                    {{-- 1. Profile Photo --}}
                                    <div class="relative w-full aspect-[3/4] rounded-xl overflow-hidden bg-slate-200/20 border-2 border-white/20 shadow-md group">
                                        <img :src="cvData.photoUrl || defaultPhotoUrl" alt="Foto Profil" class="w-full h-full object-cover object-top" />
                                        <label class="absolute inset-0 bg-black/40 text-white text-[11px] font-medium flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition cursor-pointer print:hidden">
                                            <i class="fa-solid fa-camera text-base mb-1"></i>
                                            <span>Ganti Foto</span>
                                            <input type="file" @change="handlePhotoUpload($event)" accept="image/*" class="hidden" />
                                        </label>
                                    </div>

                                    {{-- 2. Data Pribadi --}}
                                    <div class="space-y-1.5 group/pribadi" data-section-id="data_pribadi" data-section-title="Data Pribadi & Identitas">
                                        <div class="flex items-center justify-between border-b border-white/20 pb-0.5">
                                            <h4 class="text-xs font-black uppercase tracking-widest text-white/95 flex items-center gap-2">
                                                DATA PRIBADI
                                            </h4>
                                            <button type="button" @click="setDiscussContext('data_pribadi', 'Data Pribadi')" draggable="true" @dragstart="handleDragStartContext($event, 'data_pribadi', 'Data Pribadi')" class="opacity-0 group-hover/pribadi:opacity-100 text-[8.5px] px-1.5 py-0.5 rounded bg-white/20 hover:bg-white/30 text-white print:hidden transition flex items-center gap-1 cursor-grab" title="Diskusikan dengan AI">
                                                <i class="fa-solid fa-wand-magic-sparkles text-[7.5px]"></i> AI
                                            </button>
                                        </div>
                                        <div class="space-y-1 text-[10px] leading-tight text-white/90">
                                            <div>
                                                <div class="font-bold text-white/80 text-[9.5px]">Tempat/Tanggal Lahir</div>
                                                <div contenteditable="true" @blur="cvData.birth_info = $event.target.innerText" x-text="cvData.birth_info"></div>
                                            </div>
                                            <div>
                                                <div class="font-bold text-white/80 text-[9.5px]">Jenis Kelamin</div>
                                                <div contenteditable="true" @blur="cvData.gender = $event.target.innerText" x-text="cvData.gender"></div>
                                            </div>
                                            <div>
                                                <div class="font-bold text-white/80 text-[9.5px]">Agama</div>
                                                <div contenteditable="true" @blur="cvData.religion = $event.target.innerText" x-text="cvData.religion"></div>
                                            </div>
                                            <div>
                                                <div class="font-bold text-white/80 text-[9.5px]">Kewarganegaraan</div>
                                                <div contenteditable="true" @blur="cvData.nationality = $event.target.innerText" x-text="cvData.nationality"></div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 3. Kontak --}}
                                    <div class="space-y-1.5 group/kontak" data-section-id="kontak" data-section-title="Kontak & Domisili">
                                        <div class="flex items-center justify-between border-b border-white/20 pb-0.5">
                                            <h4 class="text-xs font-black uppercase tracking-widest text-white/95">
                                                KONTAK
                                            </h4>
                                            <button type="button" @click="setDiscussContext('kontak', 'Kontak & Domisili')" draggable="true" @dragstart="handleDragStartContext($event, 'kontak', 'Kontak & Domisili')" class="opacity-0 group-hover/kontak:opacity-100 text-[8.5px] px-1.5 py-0.5 rounded bg-white/20 hover:bg-white/30 text-white print:hidden transition flex items-center gap-1 cursor-grab" title="Diskusikan dengan AI">
                                                <i class="fa-solid fa-wand-magic-sparkles text-[7.5px]"></i> AI
                                            </button>
                                        </div>
                                        <div class="space-y-1 text-[10px] leading-tight text-white/90">
                                            <div class="flex items-center gap-1.5">
                                                <i class="fa-solid fa-phone text-[9px] opacity-80 shrink-0"></i>
                                                <span contenteditable="true" @blur="cvData.phone = $event.target.innerText" x-text="cvData.phone"></span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <i class="fa-solid fa-envelope text-[9px] opacity-80 shrink-0"></i>
                                                <span contenteditable="true" class="break-all" @blur="cvData.email = $event.target.innerText" x-text="cvData.email"></span>
                                            </div>
                                            <div class="flex items-start gap-1.5">
                                                <i class="fa-solid fa-location-dot text-[9px] opacity-80 shrink-0 mt-0.5"></i>
                                                <span contenteditable="true" @blur="cvData.address = $event.target.innerText" x-text="cvData.address"></span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- 4. Skills Bar --}}
                                    <div class="space-y-2 group/skills" data-section-id="skills" data-section-title="Keahlian & Skills">
                                        <div class="flex items-center justify-between border-b border-white/20 pb-0.5">
                                            <h4 class="text-xs font-black uppercase tracking-widest text-white/95">
                                                SKILLS
                                            </h4>
                                            <div class="flex items-center gap-1.5">
                                                <button type="button" @click="setDiscussContext('skills', 'Daftar Skills')" draggable="true" @dragstart="handleDragStartContext($event, 'skills', 'Daftar Skills')" class="opacity-80 hover:opacity-100 text-[8px] px-1.5 py-0.5 rounded bg-white/20 hover:bg-white/30 text-white print:hidden transition flex items-center gap-1 cursor-grab" title="Diskusikan Skills dengan AI">
                                                    <i class="fa-solid fa-wand-magic-sparkles text-[7px]"></i> AI
                                                </button>
                                                <button @click="addSkillItem()" class="text-[9px] text-white/70 hover:text-white print:hidden" title="Tambah Skill">
                                                    <i class="fa-solid fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="space-y-1.5">
                                            <template x-for="(sk, sIdx) in cvData.skills" :key="sIdx">
                                                <div class="space-y-0.5 group relative" draggable="true" @dragstart="handleDragStartContext($event, 'skills', 'Skill: ' + sk.name, sIdx, sk)">
                                                    <div class="flex justify-between items-center text-[10px] font-semibold text-white">
                                                        <span contenteditable="true" @blur="sk.name = $event.target.innerText" x-text="sk.name" class="cursor-text hover:underline decoration-white/40"></span>
                                                        <div class="flex items-center gap-1">
                                                            {{-- Editable Percentage Badge --}}
                                                            <div class="inline-flex items-center bg-black/20 hover:bg-black/30 px-1 py-0.5 rounded border border-white/20 transition" title="Klik untuk edit angka persen">
                                                                <span contenteditable="true" @blur="updateSkillLevel(sk, $event.target.innerText)" @keydown.enter.prevent="$event.target.blur()" x-text="sk.level" class="min-w-[14px] text-right font-mono outline-none cursor-text"></span>
                                                                <span class="text-[9px] opacity-90">%</span>
                                                            </div>
                                                            <button @click="removeSkillItem(sIdx)" class="opacity-0 group-hover:opacity-100 text-rose-300 hover:text-rose-100 text-[8px] print:hidden transition ml-0.5" title="Hapus Skill">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                    {{-- Clickable & Interactive Progress Bar --}}
                                                    <div class="relative w-full h-1.5 bg-black/20 hover:bg-black/30 rounded-full overflow-hidden cursor-pointer group/bar transition" @click="adjustSkillByClick($event, sk)" title="Klik bar untuk atur persentase">
                                                        <div class="h-full bg-white rounded-full transition-all duration-200 pointer-events-none" :style="'width: ' + sk.level + '%'"></div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    {{-- 5. Social Media --}}
                                    <div class="space-y-1.5">
                                        <h4 class="text-xs font-black uppercase tracking-widest text-white/95 border-b border-white/20 pb-0.5">
                                            SOSIAL MEDIA
                                        </h4>
                                        <div class="space-y-1 text-[10px] text-white/90">
                                            <div class="flex items-center gap-1.5">
                                                <i class="fa-brands fa-linkedin text-[10px] opacity-80 shrink-0"></i>
                                                <span contenteditable="true" @blur="cvData.social_linkedin = $event.target.innerText" x-text="cvData.social_linkedin"></span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <i class="fa-brands fa-instagram text-[10px] opacity-80 shrink-0"></i>
                                                <span contenteditable="true" @blur="cvData.social_instagram = $event.target.innerText" x-text="cvData.social_instagram"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Brand Tagline bottom of sidebar --}}
                                <div class="pt-2 border-t border-white/10 text-[9px] text-white/70 flex items-center justify-between">
                                    <span>Verified ATS Format</span>
                                    <span>Scalify Pro</span>
                                </div>
                            </div>

                            {{-- ==================== RIGHT MAIN COLUMN (CLEAN WHITE) ==================== --}}
                            <div class="flex-1 p-7 flex flex-col justify-between overflow-hidden bg-white text-slate-800">

                                <div class="space-y-3.5">
                                    {{-- Main Header: Candidate Name & Degree --}}
                                    <div class="border-b-2 border-slate-100 pb-2.5 flex items-start justify-between">
                                        <div>
                                            <h1 class="text-2xl font-black text-slate-900 tracking-tight leading-tight uppercase" contenteditable="true" @blur="cvData.full_name = $event.target.innerText" x-text="cvData.full_name">
                                            </h1>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="text-xs font-bold text-slate-500 uppercase tracking-widest" contenteditable="true" @blur="cvData.degree = $event.target.innerText" x-text="cvData.degree"></span>
                                                <span class="text-slate-300">|</span>
                                                <span class="text-xs font-extrabold uppercase tracking-wide text-[#0284c7]" :style="'color: ' + getHeaderColor()" contenteditable="true" @blur="cvData.target_role = $event.target.innerText" x-text="cvData.target_role"></span>
                                            </div>
                                        </div>

                                        {{-- 3 Subtle Accent Squares matching user's reference image --}}
                                        <div class="flex gap-1 pt-1">
                                            <div class="w-5 h-3.5 bg-[#0284c7]/90 rounded-sm" :style="'background-color: ' + getHeaderColor()"></div>
                                            <div class="w-5 h-3.5 bg-sky-400/80 rounded-sm"></div>
                                            <div class="w-5 h-3.5 bg-cyan-300/80 rounded-sm"></div>
                                        </div>
                                    </div>

                                    {{-- DYNAMIC SECTIONS LOOP ACCORDING TO USER REORDERING --}}
                                    <template x-for="sec in mainSections" :key="sec.id">
                                        <div x-show="sec.visible" class="space-y-1 group/sec" :data-section-id="sec.id" :data-section-title="sec.name">

                                            {{-- BLOCK: PROFIL --}}
                                            <template x-if="sec.id === 'profil'">
                                                <div class="space-y-1 group/profil" draggable="true" @dragstart="handleDragStartContext($event, 'profil', 'Ringkasan Profil Diri')">
                                                    <div class="flex items-center justify-between border-b border-slate-100 pb-0.5">
                                                        <h3 class="text-xs font-black uppercase tracking-widest text-[#0284c7]" :style="'color: ' + getHeaderColor()">
                                                            PROFIL
                                                        </h3>
                                                        <button type="button" @click="setDiscussContext('profil', 'Ringkasan Profil Diri')" draggable="true" @dragstart="handleDragStartContext($event, 'profil', 'Ringkasan Profil Diri')" class="opacity-70 hover:opacity-100 text-[8.5px] font-bold px-2 py-0.5 rounded bg-cyan-50 hover:bg-cyan-100 text-cyan-700 border border-cyan-300/80 print:hidden transition flex items-center gap-1 cursor-grab active:cursor-grabbing shadow-xs" title="Klik atau Drag ke Chat untuk diskusikan dengan AI">
                                                            <i class="fa-solid fa-wand-magic-sparkles text-cyan-600 text-[8px]"></i> Diskusikan AI
                                                        </button>
                                                    </div>
                                                    <p class="text-[10px] text-slate-700 leading-relaxed text-justify" contenteditable="true" @blur="cvData.profile_summary = $event.target.innerText" x-text="cvData.profile_summary">
                                                    </p>
                                                </div>
                                            </template>

                                            {{-- BLOCK: RIWAYAT PENDIDIKAN --}}
                                            <template x-if="sec.id === 'pendidikan'">
                                                <div class="space-y-1">
                                                    <div class="flex items-center justify-between border-b border-slate-100 pb-0.5">
                                                        <h3 class="text-xs font-black uppercase tracking-widest text-[#0284c7]" :style="'color: ' + getHeaderColor()">
                                                            RIWAYAT PENDIDIKAN
                                                        </h3>
                                                        <div class="flex items-center gap-1.5 print:hidden">
                                                            <button type="button" @click="setDiscussContext('pendidikan', 'Riwayat Pendidikan')" draggable="true" @dragstart="handleDragStartContext($event, 'pendidikan', 'Riwayat Pendidikan')" class="opacity-70 hover:opacity-100 text-[8.5px] font-bold px-2 py-0.5 rounded bg-cyan-50 hover:bg-cyan-100 text-cyan-700 border border-cyan-300/80 transition flex items-center gap-1 cursor-grab active:cursor-grabbing shadow-xs" title="Klik atau Drag ke Chat untuk diskusikan dengan AI">
                                                                <i class="fa-solid fa-wand-magic-sparkles text-cyan-600 text-[8px]"></i> Diskusikan AI
                                                            </button>
                                                            <button @click="addEduItem()" class="text-[9px] text-slate-400 hover:text-cyan-600" title="Tambah Pendidikan">
                                                                <i class="fa-solid fa-plus mr-0.5"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-1.5 text-[10px]">
                                                        <template x-for="(edu, idx) in cvData.education_list" :key="idx">
                                                            <div class="space-y-0.5 group relative p-1 -m-1 rounded-lg hover:bg-slate-50/80 transition" draggable="true" @dragstart="handleDragStartContext($event, 'pendidikan', 'Pendidikan: ' + edu.degree_name, idx, edu)">
                                                                <div class="flex justify-between items-baseline">
                                                                    <div class="font-bold text-slate-900" contenteditable="true" @blur="edu.degree_name = $event.target.innerText" x-text="edu.degree_name + (edu.institution ? ' ' + edu.institution : '')"></div>
                                                                    <div class="flex items-center gap-2">
                                                                        <div class="text-[9.5px] text-slate-500 font-medium" contenteditable="true" @blur="edu.city = $event.target.innerText" x-text="(edu.city ? edu.city + ', ' : '') + edu.period"></div>
                                                                        <button type="button" @click="setDiscussContext('pendidikan', 'Pendidikan: ' + edu.degree_name, idx, edu)" class="opacity-0 group-hover:opacity-100 text-cyan-600 hover:text-cyan-800 text-[9px] print:hidden transition flex items-center gap-0.5" title="Diskusikan card ini dengan AI">
                                                                            <i class="fa-solid fa-wand-magic-sparkles text-[8px]"></i> AI
                                                                        </button>
                                                                        <button @click="removeEduItem(idx)" class="opacity-0 group-hover:opacity-100 text-rose-500 text-[9px] print:hidden transition">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <ul class="list-disc ml-4 text-slate-600 space-y-0.5 text-[9px]">
                                                                    <template x-for="(ach, aIdx) in edu.achievements" :key="aIdx">
                                                                        <li class="group/bullet relative">
                                                                            <span contenteditable="true" @blur="edu.achievements[aIdx] = $event.target.innerText" @keydown.enter.prevent="addEduAchievement(edu, aIdx)" @keydown.backspace="handleBulletBackspace($event, edu.achievements, aIdx)" x-text="ach"></span>
                                                                            <button type="button" @click="removeEduAchievement(edu, aIdx)" class="opacity-0 group-hover/bullet:opacity-100 text-rose-400 hover:text-rose-600 text-[8px] print:hidden ml-1 transition inline-flex items-center" title="Hapus Poin">
                                                                                <i class="fa-solid fa-times"></i>
                                                                            </button>
                                                                        </li>
                                                                    </template>
                                                                </ul>
                                                                <button type="button" @click="addEduAchievement(edu)" class="inline-flex items-center gap-1 text-[8.5px] text-cyan-600 hover:text-cyan-800 font-semibold mt-0.5 ml-4 print:hidden transition" title="Tambah Prestasi/Keterangan">
                                                                    <i class="fa-solid fa-plus text-[7.5px]"></i> Tambah Poin Akademik
                                                                </button>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            {{-- BLOCK: RIWAYAT PEKERJAAN --}}
                                            <template x-if="sec.id === 'pekerjaan'">
                                                <div class="space-y-1">
                                                    <div class="flex items-center justify-between border-b border-slate-100 pb-0.5">
                                                        <h3 class="text-xs font-black uppercase tracking-widest text-[#0284c7]" :style="'color: ' + getHeaderColor()">
                                                            RIWAYAT PEKERJAAN
                                                        </h3>
                                                        <div class="flex items-center gap-1.5 print:hidden">
                                                            <button type="button" @click="setDiscussContext('pekerjaan', 'Riwayat Pekerjaan')" draggable="true" @dragstart="handleDragStartContext($event, 'pekerjaan', 'Riwayat Pekerjaan')" class="opacity-70 hover:opacity-100 text-[8.5px] font-bold px-2 py-0.5 rounded bg-cyan-50 hover:bg-cyan-100 text-cyan-700 border border-cyan-300/80 transition flex items-center gap-1 cursor-grab active:cursor-grabbing shadow-xs" title="Klik atau Drag ke Chat untuk diskusikan dengan AI">
                                                                <i class="fa-solid fa-wand-magic-sparkles text-cyan-600 text-[8px]"></i> Diskusikan AI
                                                            </button>
                                                            <button @click="addWorkItem()" class="text-[9px] text-slate-400 hover:text-cyan-600" title="Tambah Pekerjaan">
                                                                <i class="fa-solid fa-plus mr-0.5"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-1.5 text-[10px]">
                                                        <template x-for="(work, idx) in cvData.work_experience" :key="idx">
                                                            <div class="space-y-0.5 group relative p-1 -m-1 rounded-lg hover:bg-slate-50/80 transition" draggable="true" @dragstart="handleDragStartContext($event, 'pekerjaan', 'Pekerjaan: ' + work.company, idx, work)">
                                                                <div class="flex justify-between items-baseline">
                                                                    <div class="font-bold text-slate-900" contenteditable="true" @blur="work.company = $event.target.innerText" x-text="work.company"></div>
                                                                    <div class="flex items-center gap-2">
                                                                        <div class="text-[9.5px] text-slate-500 font-medium" contenteditable="true" @blur="work.city = $event.target.innerText" x-text="work.city"></div>
                                                                        <button type="button" @click="setDiscussContext('pekerjaan', 'Pekerjaan: ' + work.company, idx, work)" class="opacity-0 group-hover:opacity-100 text-cyan-600 hover:text-cyan-800 text-[9px] print:hidden transition flex items-center gap-0.5" title="Diskusikan card ini dengan AI">
                                                                            <i class="fa-solid fa-wand-magic-sparkles text-[8px]"></i> AI
                                                                        </button>
                                                                        <button @click="removeWorkItem(idx)" class="opacity-0 group-hover:opacity-100 text-rose-500 text-[9px] print:hidden transition">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="text-[9px] font-bold text-slate-700" contenteditable="true" @blur="work.period = $event.target.innerText" x-text="work.period"></div>
                                                                <ul class="list-disc ml-4 text-slate-600 space-y-0.5 text-[9px] leading-relaxed">
                                                                    <template x-for="(b, bIdx) in work.bullets" :key="bIdx">
                                                                        <li class="group/bullet relative">
                                                                            <span contenteditable="true" @blur="work.bullets[bIdx] = $event.target.innerText" @keydown.enter.prevent="addWorkBullet(work, bIdx)" @keydown.backspace="handleBulletBackspace($event, work.bullets, bIdx)" x-text="b"></span>
                                                                            <button type="button" @click="removeWorkBullet(work, bIdx)" class="opacity-0 group-hover/bullet:opacity-100 text-rose-400 hover:text-rose-600 text-[8px] print:hidden ml-1 transition inline-flex items-center" title="Hapus Poin">
                                                                                <i class="fa-solid fa-times"></i>
                                                                            </button>
                                                                        </li>
                                                                    </template>
                                                                </ul>
                                                                <button type="button" @click="addWorkBullet(work)" class="inline-flex items-center gap-1 text-[8.5px] text-cyan-600 hover:text-cyan-800 font-semibold mt-0.5 ml-4 print:hidden transition" title="Tambah Titik Poin Baru">
                                                                    <i class="fa-solid fa-plus text-[7.5px]"></i> Tambah Poin Pencapaian (STAR)
                                                                </button>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            {{-- BLOCK: RIWAYAT MAGANG --}}
                                            <template x-if="sec.id === 'magang'">
                                                <div class="space-y-1">
                                                    <div class="flex items-center justify-between border-b border-slate-100 pb-0.5">
                                                        <h3 class="text-xs font-black uppercase tracking-widest text-[#0284c7]" :style="'color: ' + getHeaderColor()">
                                                            RIWAYAT MAGANG
                                                        </h3>
                                                        <div class="flex items-center gap-1.5 print:hidden">
                                                            <button type="button" @click="setDiscussContext('magang', 'Riwayat Magang')" draggable="true" @dragstart="handleDragStartContext($event, 'magang', 'Riwayat Magang')" class="opacity-70 hover:opacity-100 text-[8.5px] font-bold px-2 py-0.5 rounded bg-cyan-50 hover:bg-cyan-100 text-cyan-700 border border-cyan-300/80 transition flex items-center gap-1 cursor-grab active:cursor-grabbing shadow-xs" title="Klik atau Drag ke Chat untuk diskusikan dengan AI">
                                                                <i class="fa-solid fa-wand-magic-sparkles text-cyan-600 text-[8px]"></i> Diskusikan AI
                                                            </button>
                                                            <button @click="addInternItem()" class="text-[9px] text-slate-400 hover:text-cyan-600" title="Tambah Magang">
                                                                <i class="fa-solid fa-plus mr-0.5"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-1.5 text-[10px]">
                                                        <template x-for="(intern, idx) in cvData.internship_experience" :key="idx">
                                                            <div class="space-y-0.5 group relative p-1 -m-1 rounded-lg hover:bg-slate-50/80 transition" draggable="true" @dragstart="handleDragStartContext($event, 'magang', 'Magang: ' + intern.company, idx, intern)">
                                                                <div class="flex justify-between items-baseline">
                                                                    <div class="font-bold text-slate-900" contenteditable="true" @blur="intern.company = $event.target.innerText" x-text="intern.company"></div>
                                                                    <div class="flex items-center gap-2">
                                                                        <div class="text-[9.5px] text-slate-500 font-medium" contenteditable="true" @blur="intern.city = $event.target.innerText" x-text="intern.city"></div>
                                                                        <button type="button" @click="setDiscussContext('magang', 'Magang: ' + intern.company, idx, intern)" class="opacity-0 group-hover:opacity-100 text-cyan-600 hover:text-cyan-800 text-[9px] print:hidden transition flex items-center gap-0.5" title="Diskusikan card ini dengan AI">
                                                                            <i class="fa-solid fa-wand-magic-sparkles text-[8px]"></i> AI
                                                                        </button>
                                                                        <button @click="removeInternItem(idx)" class="opacity-0 group-hover:opacity-100 text-rose-500 text-[9px] print:hidden transition">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <div class="text-[9px] font-bold text-slate-700" contenteditable="true" @blur="intern.period = $event.target.innerText" x-text="intern.period"></div>
                                                                <ul class="list-disc ml-4 text-slate-600 space-y-0.5 text-[9px] leading-relaxed">
                                                                    <template x-for="(ib, ibIdx) in intern.bullets" :key="ibIdx">
                                                                        <li class="group/bullet relative">
                                                                            <span contenteditable="true" @blur="intern.bullets[ibIdx] = $event.target.innerText" @keydown.enter.prevent="addInternBullet(intern, ibIdx)" @keydown.backspace="handleBulletBackspace($event, intern.bullets, ibIdx)" x-text="ib"></span>
                                                                            <button type="button" @click="removeInternBullet(intern, ibIdx)" class="opacity-0 group-hover/bullet:opacity-100 text-rose-400 hover:text-rose-600 text-[8px] print:hidden ml-1 transition inline-flex items-center" title="Hapus Poin">
                                                                                <i class="fa-solid fa-times"></i>
                                                                            </button>
                                                                        </li>
                                                                    </template>
                                                                </ul>
                                                                <button type="button" @click="addInternBullet(intern)" class="inline-flex items-center gap-1 text-[8.5px] text-cyan-600 hover:text-cyan-800 font-semibold mt-0.5 ml-4 print:hidden transition" title="Tambah Titik Poin Baru">
                                                                    <i class="fa-solid fa-plus text-[7.5px]"></i> Tambah Poin Magang
                                                                </button>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            {{-- BLOCK: PROYEK & PORTOFOLIO --}}
                                            <template x-if="sec.id === 'proyek'">
                                                <div class="space-y-1">
                                                    <div class="flex items-center justify-between border-b border-slate-100 pb-0.5">
                                                        <h3 class="text-xs font-black uppercase tracking-widest text-[#0284c7]" :style="'color: ' + getHeaderColor()">
                                                            PROYEK & PORTOFOLIO
                                                        </h3>
                                                        <div class="flex items-center gap-1.5 print:hidden">
                                                            <button type="button" @click="setDiscussContext('proyek', 'Proyek & Portofolio')" draggable="true" @dragstart="handleDragStartContext($event, 'proyek', 'Proyek & Portofolio')" class="opacity-70 hover:opacity-100 text-[8.5px] font-bold px-2 py-0.5 rounded bg-cyan-50 hover:bg-cyan-100 text-cyan-700 border border-cyan-300/80 transition flex items-center gap-1 cursor-grab active:cursor-grabbing shadow-xs" title="Klik atau Drag ke Chat untuk diskusikan dengan AI">
                                                                <i class="fa-solid fa-wand-magic-sparkles text-cyan-600 text-[8px]"></i> Diskusikan AI
                                                            </button>
                                                            <button @click="addProjectItem()" class="text-[9px] text-slate-400 hover:text-cyan-600" title="Tambah Proyek">
                                                                <i class="fa-solid fa-plus mr-0.5"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="space-y-1 text-[10px]">
                                                        <template x-for="(proj, idx) in cvData.projects" :key="idx">
                                                            <div class="space-y-0.5 group relative p-1 -m-1 rounded-lg hover:bg-slate-50/80 transition" draggable="true" @dragstart="handleDragStartContext($event, 'proyek', 'Proyek: ' + proj.title, idx, proj)">
                                                                <div class="flex justify-between items-baseline">
                                                                    <div class="font-bold text-slate-900" contenteditable="true" @blur="proj.title = $event.target.innerText" x-text="proj.title"></div>
                                                                    <div class="flex items-center gap-2">
                                                                        <div class="text-[9.5px] text-slate-500 font-medium" contenteditable="true" @blur="proj.period = $event.target.innerText" x-text="proj.period"></div>
                                                                        <button type="button" @click="setDiscussContext('proyek', 'Proyek: ' + proj.title, idx, proj)" class="opacity-0 group-hover:opacity-100 text-cyan-600 hover:text-cyan-800 text-[9px] print:hidden transition flex items-center gap-0.5" title="Diskusikan card ini dengan AI">
                                                                            <i class="fa-solid fa-wand-magic-sparkles text-[8px]"></i> AI
                                                                        </button>
                                                                        <button @click="removeProjectItem(idx)" class="opacity-0 group-hover:opacity-100 text-rose-500 text-[9px] print:hidden transition">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <p class="text-[9px] text-slate-600 leading-relaxed" contenteditable="true" @blur="proj.description = $event.target.innerText" x-text="proj.description"></p>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            {{-- BLOCK: PENGALAMAN ORGANISASI --}}
                                            <template x-if="sec.id === 'organisasi'">
                                                <div class="space-y-1">
                                                    <div class="flex items-center justify-between border-b border-slate-100 pb-0.5">
                                                        <h3 class="text-xs font-black uppercase tracking-widest text-[#0284c7]" :style="'color: ' + getHeaderColor()">
                                                            PENGALAMAN ORGANISASI & KEPANITIAAN
                                                        </h3>
                                                        <div class="flex items-center gap-1.5 print:hidden">
                                                            <button type="button" @click="setDiscussContext('organisasi', 'Organisasi & Komunitas')" draggable="true" @dragstart="handleDragStartContext($event, 'organisasi', 'Organisasi & Komunitas')" class="opacity-70 hover:opacity-100 text-[8.5px] font-bold px-2 py-0.5 rounded bg-cyan-50 hover:bg-cyan-100 text-cyan-700 border border-cyan-300/80 transition flex items-center gap-1 cursor-grab active:cursor-grabbing shadow-xs" title="Klik atau Drag ke Chat untuk diskusikan dengan AI">
                                                                <i class="fa-solid fa-wand-magic-sparkles text-cyan-600 text-[8px]"></i> Diskusikan AI
                                                            </button>
                                                            <button @click="addOrgItem()" class="text-[9px] text-slate-400 hover:text-cyan-600" title="Tambah Organisasi">
                                                                <i class="fa-solid fa-plus mr-0.5"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="space-y-1 text-[10px]">
                                                        <template x-for="(org, idx) in cvData.organizations" :key="idx">
                                                            <div class="space-y-0.5 group relative p-1 -m-1 rounded-lg hover:bg-slate-50/80 transition" draggable="true" @dragstart="handleDragStartContext($event, 'organisasi', 'Organisasi: ' + org.org_name, idx, org)">
                                                                <div class="flex justify-between items-baseline">
                                                                    <div class="font-bold text-slate-900" contenteditable="true" @blur="org.org_name = $event.target.innerText" x-text="org.org_name + ' — ' + org.role"></div>
                                                                    <div class="flex items-center gap-2">
                                                                        <div class="text-[9.5px] text-slate-500 font-medium" contenteditable="true" @blur="org.period = $event.target.innerText" x-text="org.period"></div>
                                                                        <button type="button" @click="setDiscussContext('organisasi', 'Organisasi: ' + org.org_name, idx, org)" class="opacity-0 group-hover:opacity-100 text-cyan-600 hover:text-cyan-800 text-[9px] print:hidden transition flex items-center gap-0.5" title="Diskusikan card ini dengan AI">
                                                                            <i class="fa-solid fa-wand-magic-sparkles text-[8px]"></i> AI
                                                                        </button>
                                                                        <button @click="removeOrgItem(idx)" class="opacity-0 group-hover:opacity-100 text-rose-500 text-[9px] print:hidden transition">
                                                                            <i class="fa-solid fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <p class="text-[9px] text-slate-600 leading-relaxed" contenteditable="true" @blur="org.description = $event.target.innerText" x-text="org.description"></p>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            {{-- BLOCK: SERTIFIKASI --}}
                                            <template x-if="sec.id === 'sertifikasi'">
                                                <div class="space-y-1">
                                                    <div class="flex items-center justify-between border-b border-slate-100 pb-0.5">
                                                        <h3 class="text-xs font-black uppercase tracking-widest text-[#0284c7]" :style="'color: ' + getHeaderColor()">
                                                            SERTIFIKASI & LISENSI
                                                        </h3>
                                                        <div class="flex items-center gap-1.5 print:hidden">
                                                            <button type="button" @click="setDiscussContext('sertifikasi', 'Sertifikasi & Lisensi')" draggable="true" @dragstart="handleDragStartContext($event, 'sertifikasi', 'Sertifikasi & Lisensi')" class="opacity-70 hover:opacity-100 text-[8.5px] font-bold px-2 py-0.5 rounded bg-cyan-50 hover:bg-cyan-100 text-cyan-700 border border-cyan-300/80 transition flex items-center gap-1 cursor-grab active:cursor-grabbing shadow-xs" title="Klik atau Drag ke Chat untuk diskusikan dengan AI">
                                                                <i class="fa-solid fa-wand-magic-sparkles text-cyan-600 text-[8px]"></i> Diskusikan AI
                                                            </button>
                                                            <button @click="addCertItem()" class="text-[9px] text-slate-400 hover:text-cyan-600" title="Tambah Sertifikasi">
                                                                <i class="fa-solid fa-plus mr-0.5"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="space-y-1 text-[10px]">
                                                        <template x-for="(cert, idx) in cvData.certifications" :key="idx">
                                                            <div class="flex justify-between items-center group p-1 -m-1 rounded-lg hover:bg-slate-50/80 transition" draggable="true" @dragstart="handleDragStartContext($event, 'sertifikasi', 'Sertifikasi: ' + cert.title, idx, cert)">
                                                                <div class="font-medium text-slate-800" contenteditable="true" @blur="cert.title = $event.target.innerText" x-text="cert.title + ' — ' + cert.issuer + ' (' + cert.year + ')'"></div>
                                                                <div class="flex items-center gap-1.5">
                                                                    <button type="button" @click="setDiscussContext('sertifikasi', 'Sertifikasi: ' + cert.title, idx, cert)" class="opacity-0 group-hover:opacity-100 text-cyan-600 hover:text-cyan-800 text-[9px] print:hidden transition flex items-center gap-0.5" title="Diskusikan card ini dengan AI">
                                                                        <i class="fa-solid fa-wand-magic-sparkles text-[8px]"></i> AI
                                                                    </button>
                                                                    <button @click="removeCertItem(idx)" class="opacity-0 group-hover:opacity-100 text-rose-500 text-[9px] print:hidden transition">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            {{-- BLOCK: PRESTASI & PENGHARGAAN --}}
                                            <template x-if="sec.id === 'prestasi'">
                                                <div class="space-y-1">
                                                    <div class="flex items-center justify-between border-b border-slate-100 pb-0.5">
                                                        <h3 class="text-xs font-black uppercase tracking-widest text-[#0284c7]" :style="'color: ' + getHeaderColor()">
                                                            PRESTASI & PENGHARGAAN
                                                        </h3>
                                                        <div class="flex items-center gap-1.5 print:hidden">
                                                            <button type="button" @click="setDiscussContext('prestasi', 'Prestasi & Penghargaan')" draggable="true" @dragstart="handleDragStartContext($event, 'prestasi', 'Prestasi & Penghargaan')" class="opacity-70 hover:opacity-100 text-[8.5px] font-bold px-2 py-0.5 rounded bg-cyan-50 hover:bg-cyan-100 text-cyan-700 border border-cyan-300/80 transition flex items-center gap-1 cursor-grab active:cursor-grabbing shadow-xs" title="Klik atau Drag ke Chat untuk diskusikan dengan AI">
                                                                <i class="fa-solid fa-wand-magic-sparkles text-cyan-600 text-[8px]"></i> Diskusikan AI
                                                            </button>
                                                            <button @click="addAwardItem()" class="text-[9px] text-slate-400 hover:text-cyan-600" title="Tambah Prestasi">
                                                                <i class="fa-solid fa-plus mr-0.5"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="space-y-1 text-[10px]">
                                                        <template x-for="(awd, idx) in cvData.awards" :key="idx">
                                                            <div class="flex justify-between items-center group p-1 -m-1 rounded-lg hover:bg-slate-50/80 transition" draggable="true" @dragstart="handleDragStartContext($event, 'prestasi', 'Prestasi: ' + awd.title, idx, awd)">
                                                                <div class="font-medium text-slate-800" contenteditable="true" @blur="awd.title = $event.target.innerText" x-text="awd.title + ' — ' + awd.event + ' (' + awd.year + ')'"></div>
                                                                <div class="flex items-center gap-1.5">
                                                                    <button type="button" @click="setDiscussContext('prestasi', 'Prestasi: ' + awd.title, idx, awd)" class="opacity-0 group-hover:opacity-100 text-cyan-600 hover:text-cyan-800 text-[9px] print:hidden transition flex items-center gap-0.5" title="Diskusikan card ini dengan AI">
                                                                        <i class="fa-solid fa-wand-magic-sparkles text-[8px]"></i> AI
                                                                    </button>
                                                                    <button @click="removeAwardItem(idx)" class="opacity-0 group-hover:opacity-100 text-rose-500 text-[9px] print:hidden transition">
                                                                        <i class="fa-solid fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                            {{-- BLOCK: BAHASA ASING --}}
                                            <template x-if="sec.id === 'bahasa'">
                                                <div class="space-y-1">
                                                    <div class="flex items-center justify-between border-b border-slate-100 pb-0.5">
                                                        <h3 class="text-xs font-black uppercase tracking-widest text-[#0284c7]" :style="'color: ' + getHeaderColor()">
                                                            PENGUASAAN BAHASA
                                                        </h3>
                                                        <div class="flex items-center gap-1.5 print:hidden">
                                                            <button type="button" @click="setDiscussContext('bahasa', 'Penguasaan Bahasa')" draggable="true" @dragstart="handleDragStartContext($event, 'bahasa', 'Penguasaan Bahasa')" class="opacity-70 hover:opacity-100 text-[8.5px] font-bold px-2 py-0.5 rounded bg-cyan-50 hover:bg-cyan-100 text-cyan-700 border border-cyan-300/80 transition flex items-center gap-1 cursor-grab active:cursor-grabbing shadow-xs" title="Klik atau Drag ke Chat untuk diskusikan dengan AI">
                                                                <i class="fa-solid fa-wand-magic-sparkles text-cyan-600 text-[8px]"></i> Diskusikan AI
                                                            </button>
                                                            <button @click="addLangItem()" class="text-[9px] text-slate-400 hover:text-cyan-600" title="Tambah Bahasa">
                                                                <i class="fa-solid fa-plus mr-0.5"></i> Tambah
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="flex flex-wrap gap-2 text-[10px]">
                                                        <template x-for="(lang, idx) in cvData.languages" :key="idx">
                                                            <span class="px-2 py-0.5 rounded bg-slate-100 border border-slate-200 text-slate-700 group flex items-center gap-1.5" draggable="true" @dragstart="handleDragStartContext($event, 'bahasa', 'Bahasa: ' + lang.lang, idx, lang)">
                                                                <strong contenteditable="true" @blur="lang.lang = $event.target.innerText" x-text="lang.lang"></strong> (<span contenteditable="true" @blur="lang.level = $event.target.innerText" x-text="lang.level"></span>)
                                                                <button @click="removeLangItem(idx)" class="opacity-0 group-hover:opacity-100 text-rose-500 text-[8px] print:hidden">
                                                                    <i class="fa-solid fa-times"></i>
                                                                </button>
                                                            </span>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>

                                        </div>
                                    </template>

                                </div>

                                {{-- Footer Note inside CV --}}
                                <div class="border-t border-slate-100 pt-1 text-[9px] text-slate-400 flex justify-between">
                                    <span>Dokumen CV Profesional Standar HRD</span>
                                    <span>Scalify Intelligence AI CV</span>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>

                {{-- Hint for User --}}
                <div class="bg-cyan-500/10 border border-cyan-500/20 rounded-2xl p-4 flex items-center gap-3 text-xs text-cyan-200">
                    <i class="fa-solid fa-lightbulb text-cyan-400 text-base shrink-0"></i>
                    <span><strong>Tips Interaktif:</strong> Gunakan panel di sebelah kiri untuk <em>drag-and-drop</em> urutan blok, pilih zoom <em>Fit Layar</em>, atau klik teks mana saja di lembar CV untuk edit langsung sebelum cetak PDF!</span>
                </div>

            </div>

        </div>

    </div>

    {{-- Alpine.js Application Logic --}}
    <script>
        function cvBuilderApp() {
            return {
                activeView: 'chat'
                , chatStep: 1
                , isGenerating: false
                , generatedOnce: false
                , copySuccess: false
                , userInputText: ''
                , cvTheme: 'cyan'
                , zoomScale: 100
                , defaultPhotoUrl: 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=600&auto=format&fit=crop'
                , draggedIdx: null
                , activeContext: null
                , isChatDropTarget: false
                , showReviewModal: false
                , reviewRating: 0
                , reviewHover: 0
                , reviewNote: ''
                , isSubmittingReview: false
                , hasReviewed: false,

                init() {
                    // Responsive Auto-Fit Zoom on first load
                    this.fitZoom();
                    window.addEventListener('resize', () => {
                        // Keep sensible fit on resize
                    });
                    // Listen to theme & layout selection from templates showcase
                    window.addEventListener('select-cv-theme', (e) => {
                        if (e.detail) {
                            if (e.detail.theme) this.cvTheme = e.detail.theme;
                            if (e.detail.preset) this.applyLayoutPreset(e.detail.preset);
                            this.activeView = 'preview';
                        }
                    });

                    // Keyboard Shortcut Ctrl+L / Cmd+L for quick focus discussion (Antigravity/Cursor style)
                    window.addEventListener('keydown', (e) => {
                        if ((e.ctrlKey || e.metaKey) && (e.key === 'l' || e.key === 'L')) {
                            e.preventDefault();
                            this.focusChatWithContext();
                        }
                    });
                },

                setZoom(val) {
                    this.zoomScale = Math.min(130, Math.max(40, Math.round(val)));
                },

                fitZoom() {
                    if (window.innerWidth < 480) {
                        this.zoomScale = 45;
                    } else if (window.innerWidth < 640) {
                        this.zoomScale = 55;
                    } else if (window.innerWidth < 768) {
                        this.zoomScale = 65;
                    } else if (window.innerWidth < 1024) {
                        this.zoomScale = 75;
                    } else {
                        this.zoomScale = 90;
                    }
                },

                // Chat History for interactive conversation
                chatHistory: [],

                // Role presets for 1-click test
                rolePresets: [{
                        role: 'Digital Marketing Specialist'
                        , degree: 'S.E'
                        , exp: '1 Tahun di agensi digital'
                        , edu: 'S1 Manajemen / Informatika'
                    }
                    , {
                        role: 'Fullstack Web Developer'
                        , degree: 'S.Kom'
                        , exp: '2 Tahun di SaaS Tech Startup'
                        , edu: 'S1 Teknik Informatika'
                    }
                    , {
                        role: 'UI/UX Designer'
                        , degree: 'S.Ds'
                        , exp: 'Fresh Graduate dengan portofolio'
                        , edu: 'S1 Desain Komunikasi Visual'
                    }
                    , {
                        role: 'Admin & Finance Officer'
                        , degree: 'S.Ak'
                        , exp: '1 Tahun di perusahaan retail'
                        , edu: 'S1 Akuntansi'
                    }
                ],

                // Modular Sections Configuration for Drag-and-Drop
                mainSections: [{
                        id: 'profil'
                        , name: 'Profil & Summary'
                        , icon: 'fa-solid fa-user'
                        , visible: true
                    }
                    , {
                        id: 'pendidikan'
                        , name: 'Riwayat Pendidikan'
                        , icon: 'fa-solid fa-graduation-cap'
                        , visible: true
                    }
                    , {
                        id: 'pekerjaan'
                        , name: 'Riwayat Pekerjaan'
                        , icon: 'fa-solid fa-briefcase'
                        , visible: true
                    }
                    , {
                        id: 'magang'
                        , name: 'Riwayat Magang'
                        , icon: 'fa-solid fa-building-user'
                        , visible: true
                    }
                    , {
                        id: 'proyek'
                        , name: 'Proyek & Portofolio'
                        , icon: 'fa-solid fa-laptop-code'
                        , visible: false
                    }
                    , {
                        id: 'organisasi'
                        , name: 'Organisasi & Volunteer'
                        , icon: 'fa-solid fa-users'
                        , visible: false
                    }
                    , {
                        id: 'sertifikasi'
                        , name: 'Sertifikasi & Lisensi'
                        , icon: 'fa-solid fa-certificate'
                        , visible: false
                    }
                    , {
                        id: 'prestasi'
                        , name: 'Prestasi & Awards'
                        , icon: 'fa-solid fa-trophy'
                        , visible: false
                    }
                    , {
                        id: 'bahasa'
                        , name: 'Penguasaan Bahasa'
                        , icon: 'fa-solid fa-language'
                        , visible: false
                    }
                ],

                // Main CV Data Object (Initialized matching the image)
                cvData: {
                    full_name: 'Putri Andiyani Jelita'
                    , degree: 'S.E'
                    , target_role: 'Digital Marketing Specialist'
                    , photoUrl: ''
                    , birth_info: 'Jakarta Selatan / 23 Desember 2000'
                    , gender: 'Perempuan'
                    , religion: 'Islam'
                    , nationality: 'Indonesia'
                    , phone: '0852 5400 9888'
                    , email: 'putriandiyani0988@gmail.com'
                    , address: 'Jl. Teuku Cikditiro, Lamgapang, Ulee Kareng, Banda Aceh, Aceh, 24253'
                    , social_linkedin: 'Putri Andiyani'
                    , social_instagram: 'putri-andyani'
                    , profile_summary: 'Seorang profesional Pemasaran Digital dengan pengalaman lebih dari 1 tahun dalam mengembangkan dan melaksanakan strategi pemasaran online yang berhasil. Memiliki pemahaman mendalam tentang berbagai platform digital dan alat analitik. Terampil dalam meningkatkan visibilitas online, memperkuat merek, dan meningkatkan konversi.'
                    , education_list: [{
                            degree_name: 'S1 Informatika'
                            , institution: 'Universitas Indonesia'
                            , period: '2018 - 2022'
                            , city: 'Jakarta'
                            , gpa: 'IPK 3.89'
                            , achievements: [
                                'Lulus dengan predikat Pujian, IPK 3.89.'
                                , 'Saya dan tim berhasil merancang dan melaksanakan kampanye pemasaran digital yang kreatif untuk produk Biofoam. Kami memenangkan kompetisi ini dan menerima penghargaan sebagai tim dengan strategi pemasaran digital terbaik nasional dalam ajang Kreatif Digital Merdeka 2021.'
                            ]
                        }
                        , {
                            degree_name: 'SMA Smart generation International Student'
                            , institution: ''
                            , period: '2015 - 2018'
                            , city: 'Jakarta'
                            , gpa: ''
                            , achievements: []
                        }
                        , {
                            degree_name: 'SMP Negeri 32 Jakarta'
                            , institution: ''
                            , period: '2012 - 2015'
                            , city: 'Jakarta'
                            , gpa: ''
                            , achievements: []
                        }
                        , {
                            degree_name: 'SD Kartika Pertiwi'
                            , institution: ''
                            , period: '2006 - 2012'
                            , city: 'Bandung'
                            , gpa: ''
                            , achievements: []
                        }
                    ]
                    , work_experience: [{
                            company: 'PT Sinarmas Jaya Indonesia'
                            , position: 'Digital Marketer'
                            , period: '02 Jan 2022 - 30 Jan 2023'
                            , city: 'Bandung'
                            , bullets: [
                                'Memimpin pengembangan dan pelaksanaan strategi pemasaran digital yang berhasil, meningkatkan lalu lintas situs web sebesar 20% dan konversi sebesar 80%.'
                                , 'Mengelola kampanye iklan PPC dengan anggaran bulanan dan meningkatkan ROI.'
                                , 'Merancang dan melaksanakan kampanye media sosial yang berhasil, meningkatkan pengikut 16.850 dengan interaksi sebesar 80%.'
                                , 'Menganalisis data dan kinerja kampanye untuk mengidentifikasi peluang perbaikan.'
                            ]
                        }
                        , {
                            company: 'PT Shopee Indonesia'
                            , position: 'Marketing Associate'
                            , period: '25 April 2020 - 15 Des 2021'
                            , city: 'Bandung'
                            , bullets: [
                                'Mengelola kampanye email marketing dengan meningkatkan tingkat konversi sebesar 75%.'
                                , 'Bertanggung jawab atas optimisasi SEO situs web, menghasilkan peningkatan peringkat kata kunci utama dalam 8 bulan.'
                                , 'Melakukan penelitian pasar dan analisis pesaing untuk memandu pengembangan strategi pemasaran yang efektif.'
                            ]
                        }
                    ]
                    , internship_experience: [{
                        company: 'PT Nusantara Travel'
                        , position: 'Intern Marketing'
                        , period: '02 Jan 2022 - 30 Jan 2023'
                        , city: 'Bandung'
                        , bullets: [
                            'Terlibat dalam perencanaan, pelaksanaan, dan pengelolaan kampanye digital.'
                            , 'Belajar berbagai platform dan tools digital marketing: Instagram Ads, Google Analytics, Facebook Ads.'
                            , 'Terlibat dalam mengoptimalkan situs web dan konten online.'
                            , 'Membuat dan menjadwalkan posting, berinteraksi dengan pengikut, dan melacak analitik kinerja.'
                        ]
                    }]
                    , projects: [{
                        title: 'Revamp Platform E-Commerce UMKM'
                        , period: '2023'
                        , description: 'Mengembangkan sistem katalog digital berbasis Laravel & Tailwind CSS dengan kenaikan konversi transaksi 40%.'
                    }]
                    , organizations: [{
                        org_name: 'BEM Universitas Indonesia'
                        , role: 'Staff Departemen Kominfo'
                        , period: '2020 - 2021'
                        , description: 'Mengelola publikasi digital kampus dan mendesain konten sosial media dengan reach 50k+ audiens.'
                    }]
                    , certifications: [{
                        title: 'Google Digital Marketing Professional Certificate'
                        , issuer: 'Google Career Certificates'
                        , year: '2022'
                    }]
                    , awards: [{
                        title: 'Juara 1 Lomba Kreatif Digital Nasional'
                        , event: 'Kemenpora RI'
                        , year: '2021'
                    }]
                    , languages: [{
                        lang: 'Bahasa Indonesia'
                        , level: 'Penutur Asli'
                    }, {
                        lang: 'Bahasa Inggris'
                        , level: 'Profesional (TOEFL 580)'
                    }]
                    , skills: [{
                            name: 'SEO dan SEM'
                            , level: 85
                        }
                        , {
                            name: 'Google Analytics'
                            , level: 90
                        }
                        , {
                            name: 'Iklan PPC'
                            , level: 88
                        }
                        , {
                            name: 'Digital Marketing Strategy'
                            , level: 92
                        }
                    ]
                },

                // Apply Layout Preset
                applyLayoutPreset(preset) {
                    if (preset === 'default') {
                        // Standard HRD: Profil, Pendidikan, Pekerjaan, Magang
                        this.mainSections = [{
                                id: 'profil'
                                , name: 'Profil & Summary'
                                , icon: 'fa-solid fa-user'
                                , visible: true
                            }
                            , {
                                id: 'pendidikan'
                                , name: 'Riwayat Pendidikan'
                                , icon: 'fa-solid fa-graduation-cap'
                                , visible: true
                            }
                            , {
                                id: 'pekerjaan'
                                , name: 'Riwayat Pekerjaan'
                                , icon: 'fa-solid fa-briefcase'
                                , visible: true
                            }
                            , {
                                id: 'magang'
                                , name: 'Riwayat Magang'
                                , icon: 'fa-solid fa-building-user'
                                , visible: true
                            }
                            , {
                                id: 'proyek'
                                , name: 'Proyek & Portofolio'
                                , icon: 'fa-solid fa-laptop-code'
                                , visible: false
                            }
                            , {
                                id: 'organisasi'
                                , name: 'Organisasi & Volunteer'
                                , icon: 'fa-solid fa-users'
                                , visible: false
                            }
                            , {
                                id: 'sertifikasi'
                                , name: 'Sertifikasi & Lisensi'
                                , icon: 'fa-solid fa-certificate'
                                , visible: false
                            }
                            , {
                                id: 'prestasi'
                                , name: 'Prestasi & Awards'
                                , icon: 'fa-solid fa-trophy'
                                , visible: false
                            }
                            , {
                                id: 'bahasa'
                                , name: 'Penguasaan Bahasa'
                                , icon: 'fa-solid fa-language'
                                , visible: false
                            }
                        , ];
                    } else if (preset === 'freshgrad') {
                        // Fresh Graduate: Profil, Pendidikan, Magang, Organisasi, Prestasi, Sertifikasi
                        this.mainSections = [{
                                id: 'profil'
                                , name: 'Profil & Summary'
                                , icon: 'fa-solid fa-user'
                                , visible: true
                            }
                            , {
                                id: 'pendidikan'
                                , name: 'Riwayat Pendidikan'
                                , icon: 'fa-solid fa-graduation-cap'
                                , visible: true
                            }
                            , {
                                id: 'magang'
                                , name: 'Riwayat Magang'
                                , icon: 'fa-solid fa-building-user'
                                , visible: true
                            }
                            , {
                                id: 'organisasi'
                                , name: 'Organisasi & Volunteer'
                                , icon: 'fa-solid fa-users'
                                , visible: true
                            }
                            , {
                                id: 'prestasi'
                                , name: 'Prestasi & Awards'
                                , icon: 'fa-solid fa-trophy'
                                , visible: true
                            }
                            , {
                                id: 'sertifikasi'
                                , name: 'Sertifikasi & Lisensi'
                                , icon: 'fa-solid fa-certificate'
                                , visible: true
                            }
                            , {
                                id: 'pekerjaan'
                                , name: 'Riwayat Pekerjaan'
                                , icon: 'fa-solid fa-briefcase'
                                , visible: false
                            }
                            , {
                                id: 'proyek'
                                , name: 'Proyek & Portofolio'
                                , icon: 'fa-solid fa-laptop-code'
                                , visible: false
                            }
                            , {
                                id: 'bahasa'
                                , name: 'Penguasaan Bahasa'
                                , icon: 'fa-solid fa-language'
                                , visible: true
                            }
                        , ];
                    } else if (preset === 'senior') {
                        // Senior Professional: Profil, Pekerjaan, Proyek, Sertifikasi, Pendidikan
                        this.mainSections = [{
                                id: 'profil'
                                , name: 'Profil & Summary'
                                , icon: 'fa-solid fa-user'
                                , visible: true
                            }
                            , {
                                id: 'pekerjaan'
                                , name: 'Riwayat Pekerjaan'
                                , icon: 'fa-solid fa-briefcase'
                                , visible: true
                            }
                            , {
                                id: 'proyek'
                                , name: 'Proyek & Portofolio'
                                , icon: 'fa-solid fa-laptop-code'
                                , visible: true
                            }
                            , {
                                id: 'sertifikasi'
                                , name: 'Sertifikasi & Lisensi'
                                , icon: 'fa-solid fa-certificate'
                                , visible: true
                            }
                            , {
                                id: 'pendidikan'
                                , name: 'Riwayat Pendidikan'
                                , icon: 'fa-solid fa-graduation-cap'
                                , visible: true
                            }
                            , {
                                id: 'magang'
                                , name: 'Riwayat Magang'
                                , icon: 'fa-solid fa-building-user'
                                , visible: false
                            }
                            , {
                                id: 'organisasi'
                                , name: 'Organisasi & Volunteer'
                                , icon: 'fa-solid fa-users'
                                , visible: false
                            }
                            , {
                                id: 'prestasi'
                                , name: 'Prestasi & Awards'
                                , icon: 'fa-solid fa-trophy'
                                , visible: false
                            }
                            , {
                                id: 'bahasa'
                                , name: 'Penguasaan Bahasa'
                                , icon: 'fa-solid fa-language'
                                , visible: false
                            }
                        , ];
                    } else if (preset === 'tech') {
                        // Tech Specialist: Profil, Proyek, Pekerjaan, Sertifikasi, Pendidikan, Bahasa
                        this.mainSections = [{
                                id: 'profil'
                                , name: 'Profil & Summary'
                                , icon: 'fa-solid fa-user'
                                , visible: true
                            }
                            , {
                                id: 'proyek'
                                , name: 'Proyek & Portofolio'
                                , icon: 'fa-solid fa-laptop-code'
                                , visible: true
                            }
                            , {
                                id: 'pekerjaan'
                                , name: 'Riwayat Pekerjaan'
                                , icon: 'fa-solid fa-briefcase'
                                , visible: true
                            }
                            , {
                                id: 'sertifikasi'
                                , name: 'Sertifikasi & Lisensi'
                                , icon: 'fa-solid fa-certificate'
                                , visible: true
                            }
                            , {
                                id: 'pendidikan'
                                , name: 'Riwayat Pendidikan'
                                , icon: 'fa-solid fa-graduation-cap'
                                , visible: true
                            }
                            , {
                                id: 'bahasa'
                                , name: 'Penguasaan Bahasa'
                                , icon: 'fa-solid fa-language'
                                , visible: true
                            }
                            , {
                                id: 'magang'
                                , name: 'Riwayat Magang'
                                , icon: 'fa-solid fa-building-user'
                                , visible: false
                            }
                            , {
                                id: 'organisasi'
                                , name: 'Organisasi & Volunteer'
                                , icon: 'fa-solid fa-users'
                                , visible: false
                            }
                            , {
                                id: 'prestasi'
                                , name: 'Prestasi & Awards'
                                , icon: 'fa-solid fa-trophy'
                                , visible: false
                            }
                        , ];
                    }
                },

                // Drag and Drop handlers
                handleDragStart(e, idx) {
                    this.draggedIdx = idx;
                    e.dataTransfer.effectAllowed = 'move';
                }
                , handleDragOver(e, idx) {
                    e.dataTransfer.dropEffect = 'move';
                }
                , handleDrop(e, targetIdx) {
                    if (this.draggedIdx === null || this.draggedIdx === targetIdx) return;
                    const itemToMove = this.mainSections.splice(this.draggedIdx, 1)[0];
                    this.mainSections.splice(targetIdx, 0, itemToMove);
                    this.draggedIdx = null;
                }
                , moveSection(idx, direction) {
                    const newIdx = idx + direction;
                    if (newIdx < 0 || newIdx >= this.mainSections.length) return;
                    const item = this.mainSections.splice(idx, 1)[0];
                    this.mainSections.splice(newIdx, 0, item);
                }
                , enableCustomSection(secId) {
                    const sec = this.mainSections.find(s => s.id === secId);
                    if (sec) sec.visible = true;
                },

                // Item Adders & Removers
                addWorkItem() {
                    this.cvData.work_experience.unshift({
                        company: 'PT Perusahaan Baru'
                        , position: 'Posisi / Jabatan'
                        , period: '2023 - Sekarang'
                        , city: 'Jakarta'
                        , bullets: ['Pencapaian aktif dengan metrik hasil kerja yang terukur.']
                    });
                    this.enableCustomSection('pekerjaan');
                }
                , removeWorkItem(idx) {
                    this.cvData.work_experience.splice(idx, 1);
                }
                , addEduItem() {
                    this.cvData.education_list.unshift({
                        degree_name: 'S1 Program Studi'
                        , institution: 'Nama Universitas'
                        , period: '2019 - 2023'
                        , city: 'Kota'
                        , gpa: 'IPK 3.80'
                        , achievements: ['Lulus dengan predikat Pujian.']
                    });
                    this.enableCustomSection('pendidikan');
                }
                , removeEduItem(idx) {
                    this.cvData.education_list.splice(idx, 1);
                }
                , addSkillItem() {
                    this.cvData.skills.push({
                        name: 'Keahlian Baru'
                        , level: 85
                    });
                }
                , removeSkillItem(idx) {
                    this.cvData.skills.splice(idx, 1);
                }
                , addInternItem() {
                    this.cvData.internship_experience.unshift({
                        company: 'PT Magang Nusantara'
                        , position: 'Intern Specialist'
                        , period: '2022'
                        , city: 'Kota'
                        , bullets: ['Terlibat dalam operasional proyek harian.']
                    });
                    this.enableCustomSection('magang');
                }
                , removeInternItem(idx) {
                    this.cvData.internship_experience.splice(idx, 1);
                }
                , addProjectItem() {
                    this.cvData.projects.unshift({
                        title: 'Proyek Baru'
                        , period: '2023'
                        , description: 'Deskripsi proyek atau sistem yang berhasil dibangun.'
                    });
                    this.enableCustomSection('proyek');
                }
                , removeProjectItem(idx) {
                    this.cvData.projects.splice(idx, 1);
                }
                , addOrgItem() {
                    this.cvData.organizations.unshift({
                        org_name: 'Organisasi Mahasiswa / Komunitas'
                        , role: 'Ketua Divisi'
                        , period: '2022'
                        , description: 'Memimpin perencanaan kegiatan dan koordinasi tim.'
                    });
                    this.enableCustomSection('organisasi');
                }
                , removeOrgItem(idx) {
                    this.cvData.organizations.splice(idx, 1);
                }
                , addCertItem() {
                    this.cvData.certifications.unshift({
                        title: 'Sertifikasi Kompetensi'
                        , issuer: 'Lembaga Penerbit'
                        , year: '2023'
                    });
                    this.enableCustomSection('sertifikasi');
                }
                , removeCertItem(idx) {
                    this.cvData.certifications.splice(idx, 1);
                }
                , addAwardItem() {
                    this.cvData.awards.unshift({
                        title: 'Penghargaan Kejuaraan'
                        , event: 'Institusi Penyelenggara'
                        , year: '2023'
                    });
                    this.enableCustomSection('prestasi');
                }
                , removeAwardItem(idx) {
                    this.cvData.awards.splice(idx, 1);
                }
                , addLangItem() {
                    this.cvData.languages.push({
                        lang: 'Bahasa Asing'
                        , level: 'Tingkat Kemampuan'
                    });
                    this.enableCustomSection('bahasa');
                }
                , removeLangItem(idx) {
                    this.cvData.languages.splice(idx, 1);
                },

                // Bullet Point Helpers (Enter to add new, Backspace on empty to delete, + Button)
                addWorkBullet(work, bIdx) {
                    if (!work.bullets) work.bullets = [];
                    if (typeof bIdx === 'number') {
                        work.bullets.splice(bIdx + 1, 0, 'Poin pencapaian baru...');
                    } else {
                        work.bullets.push('Poin pencapaian baru...');
                    }
                }
                , removeWorkBullet(work, bIdx) {
                    if (work.bullets && work.bullets.length > 0) {
                        work.bullets.splice(bIdx, 1);
                    }
                }
                , addInternBullet(intern, bIdx) {
                    if (!intern.bullets) intern.bullets = [];
                    if (typeof bIdx === 'number') {
                        intern.bullets.splice(bIdx + 1, 0, 'Poin tugas / magang baru...');
                    } else {
                        intern.bullets.push('Poin tugas / magang baru...');
                    }
                }
                , removeInternBullet(intern, bIdx) {
                    if (intern.bullets && intern.bullets.length > 0) {
                        intern.bullets.splice(bIdx, 1);
                    }
                }
                , addEduAchievement(edu, aIdx) {
                    if (!edu.achievements) edu.achievements = [];
                    if (typeof aIdx === 'number') {
                        edu.achievements.splice(aIdx + 1, 0, 'Pencapaian akademik / kegiatan baru...');
                    } else {
                        edu.achievements.push('Pencapaian akademik / kegiatan baru...');
                    }
                }
                , removeEduAchievement(edu, aIdx) {
                    if (edu.achievements && edu.achievements.length > 0) {
                        edu.achievements.splice(aIdx, 1);
                    }
                }
                , handleBulletBackspace(e, list, idx) {
                    if (!e.target.innerText.trim() && list.length > 1) {
                        e.preventDefault();
                        list.splice(idx, 1);
                    }
                },

                // Skill Percentage & Progress Bar Adjusters
                updateSkillLevel(sk, val) {
                    const cleanStr = String(val).replace(/[^0-9]/g, '');
                    const num = parseInt(cleanStr, 10);
                    if (!isNaN(num)) {
                        sk.level = Math.min(100, Math.max(0, num));
                    }
                }
                , adjustSkillByClick(e, sk) {
                    const rect = e.currentTarget.getBoundingClientRect();
                    const clickX = e.clientX - rect.left;
                    const percentage = Math.round((clickX / rect.width) * 100);
                    sk.level = Math.min(100, Math.max(5, percentage));
                },

                getSidebarStyle() {
                    switch (this.cvTheme) {
                        case 'navy':
                            return 'background-color: #0f172a;';
                        case 'emerald':
                            return 'background-color: #047857;';
                        case 'indigo':
                            return 'background-color: #4338ca;';
                        case 'coral':
                            return 'background-color: #be123c;';
                        case 'slate':
                            return 'background-color: #334155;';
                        case 'cyan':
                        default:
                            return 'background-color: #0284c7;';
                    }
                },

                getHeaderColor() {
                    switch (this.cvTheme) {
                        case 'navy':
                            return '#0f172a';
                        case 'emerald':
                            return '#047857';
                        case 'indigo':
                            return '#4338ca';
                        case 'coral':
                            return '#be123c';
                        case 'slate':
                            return '#334155';
                        case 'cyan':
                        default:
                            return '#0284c7';
                    }
                },

                getPlaceholderText() {
                    if (this.activeContext) {
                        return `Diskusikan & perbarui ${this.activeContext.title} (misal: tambah tugas baru, perbaiki STAR)...`;
                    }
                    return 'Ketik instruksi atau revisi data apa saja (cth: ubah pendidikan, tambah pengalaman, dll)...';
                },

                // Antigravity-like Context Discussion Helpers
                setDiscussContext(section, title, itemIdx = null, itemData = null) {
                    this.activeContext = {
                        section: section
                        , title: title
                        , item_index: itemIdx
                        , item_data: itemData
                    };
                    if (window.innerWidth < 1024) {
                        this.activeView = 'chat';
                    }
                    this.$nextTick(() => {
                        const input = document.getElementById('ai-chat-input-field');
                        if (input) {
                            input.focus();
                            input.scrollIntoView({
                                behavior: 'smooth'
                                , block: 'center'
                            });
                        }
                    });
                },

                clearDiscussContext() {
                    this.activeContext = null;
                },

                handleDragStartContext(e, section, title, itemIdx = null, itemData = null) {
                    const payload = {
                        section: section
                        , title: title
                        , item_index: itemIdx
                        , item_data: itemData
                    };
                    e.dataTransfer.setData('text/plain', JSON.stringify(payload));
                    e.dataTransfer.effectAllowed = 'copyMove';
                },

                handleChatDrop(e) {
                    this.isChatDropTarget = false;
                    try {
                        const raw = e.dataTransfer.getData('text/plain');
                        if (raw) {
                            const data = JSON.parse(raw);
                            if (data && data.section) {
                                this.setDiscussContext(data.section, data.title || 'Bagian CV', data.item_index, data.item_data);
                                return;
                            }
                        }
                    } catch (err) {
                        console.log('Drop context parsing:', err);
                    }
                },

                focusChatWithContext() {
                    // Global shortcut Ctrl+L / Cmd+L
                    const activeEl = document.activeElement;
                    let targetSec = 'pekerjaan';
                    let targetTitle = 'Riwayat Pekerjaan';
                    if (activeEl) {
                        const secWrapper = activeEl.closest('[data-section-id]');
                        if (secWrapper) {
                            targetSec = secWrapper.getAttribute('data-section-id') || targetSec;
                            targetTitle = secWrapper.getAttribute('data-section-title') || targetSec;
                        }
                    }
                    this.setDiscussContext(targetSec, targetTitle);
                },

                selectPreset(preset) {
                    this.userInputText = `${this.cvData.full_name} (${preset.degree}) - ${preset.role}`;
                    this.submitChatMessage();
                },

                sendQuickPrompt(promptText) {
                    this.userInputText = promptText;
                    this.submitChatMessage();
                },

                fillSampleData() {
                    this.cvData.full_name = 'Putri Andiyani Jelita';
                    this.cvData.degree = 'S.E';
                    this.cvData.target_role = 'Digital Marketing Specialist';
                    this.chatHistory.push({
                        sender: 'user'
                        , text: 'Saya ingin membuat CV Digital Marketing Specialist dengan data sampel lengkap.'
                    });
                    this.chatHistory.push({
                        sender: 'ai'
                        , text: 'Siap! Data contoh CV Profesional Two-Tone telah dimuat secara instan. Silakan lihat di tab Live Preview atau langsung cetak ke PDF!'
                    });
                    this.generatedOnce = true;
                    this.activeView = 'preview';
                    this.scrollToChatBottom();
                },

                handlePhotoUpload(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            this.cvData.photoUrl = e.target.result;
                        };
                        reader.readAsDataURL(file);
                    }
                },

                async submitChatMessage() {
                    const text = this.userInputText.trim();
                    if (!text) return;

                    // Append User message with context tag if active
                    let displayUserText = text;
                    if (this.activeContext) {
                        displayUserText = `[🎯 ${this.activeContext.title}]\n${text}`;
                    }

                    this.chatHistory.push({
                        sender: 'user'
                        , text: displayUserText
                    });
                    this.userInputText = '';
                    this.isGenerating = true;
                    this.scrollToChatBottom();

                    const currentContext = this.activeContext;

                    try {
                        const response = await fetch('{{ route("layanan.cv.chat") }}', {
                            method: 'POST'
                            , headers: {
                                'Content-Type': 'application/json'
                                , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                            , body: JSON.stringify({
                                message: text
                                , history: this.chatHistory
                                , current_cv: this.cvData
                                , target_context: currentContext
                            })
                        });

                        const result = await response.json();

                        if (result.success) {
                            if (result.updated_cv) {
                                const u = result.updated_cv;
                                if (u.full_name) this.cvData.full_name = u.full_name;
                                if (u.degree) this.cvData.degree = u.degree;
                                if (u.target_role) this.cvData.target_role = u.target_role;
                                if (u.profile_summary) this.cvData.profile_summary = u.profile_summary;
                                if (u.education_list && u.education_list.length > 0) this.cvData.education_list = u.education_list;
                                if (u.work_experience && u.work_experience.length > 0) this.cvData.work_experience = u.work_experience;
                                if (u.internship_experience && u.internship_experience.length > 0) this.cvData.internship_experience = u.internship_experience;
                                if (u.projects && u.projects.length > 0) this.cvData.projects = u.projects;
                                if (u.organizations && u.organizations.length > 0) this.cvData.organizations = u.organizations;
                                if (u.certifications && u.certifications.length > 0) this.cvData.certifications = u.certifications;
                                if (u.awards && u.awards.length > 0) this.cvData.awards = u.awards;
                                if (u.languages && u.languages.length > 0) this.cvData.languages = u.languages;
                                if (u.skills && u.skills.length > 0) this.cvData.skills = u.skills;
                                if (u.phone) this.cvData.phone = u.phone;
                                if (u.email) this.cvData.email = u.email;
                                if (u.address) this.cvData.address = u.address;
                                if (u.birth_info) this.cvData.birth_info = u.birth_info;
                                if (u.gender) this.cvData.gender = u.gender;
                                if (u.religion) this.cvData.religion = u.religion;
                                if (u.nationality) this.cvData.nationality = u.nationality;
                            }

                            // If targeted section was hidden, automatically enable it so user sees the update
                            if (currentContext && currentContext.section) {
                                this.enableCustomSection(currentContext.section);
                            }

                            this.chatHistory.push({
                                sender: 'ai'
                                , text: result.reply || 'Data telah berhasil diformulasikan dan langsung masuk ke preview CV Anda.'
                            });
                            this.chatStep = Math.min(4, this.chatStep + 1);
                            this.generatedOnce = true;
                        } else {
                            throw new Error('Gagal merespon.');
                        }
                    } catch (err) {
                        console.error(err);
                        this.chatHistory.push({
                            sender: 'ai'
                            , text: `Hebat! Saya telah mencatat data tersebut dan memperbarui CV Anda. Ada detail pengalaman atau skill lain yang ingin Anda tambahkan?`
                        });
                    } finally {
                        this.isGenerating = false;
                        this.scrollToChatBottom();
                    }
                },

                async triggerDirectGenerate() {
                    this.isGenerating = true;
                    this.scrollToChatBottom();

                    try {
                        const response = await fetch('{{ route("layanan.cv.generate_ai") }}', {
                            method: 'POST'
                            , headers: {
                                'Content-Type': 'application/json'
                                , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                            , body: JSON.stringify({
                                role: this.cvData.target_role || 'Profesional Spesialis'
                                , full_name: this.cvData.full_name
                                , degree: this.cvData.degree
                                , raw_experience: this.cvData.raw_experience || ''
                                , education: this.cvData.education || ''
                                , raw_skills: this.cvData.raw_skills || ''
                                , city: 'Bandung'
                            })
                        });

                        const result = await response.json();

                        if (result.success && result.data) {
                            const d = result.data;
                            this.cvData.profile_summary = d.profile_summary || this.cvData.profile_summary;
                            if (d.education_list && d.education_list.length > 0) this.cvData.education_list = d.education_list;
                            if (d.work_experience && d.work_experience.length > 0) this.cvData.work_experience = d.work_experience;
                            if (d.internship_experience && d.internship_experience.length > 0) this.cvData.internship_experience = d.internship_experience;
                            if (d.skills && d.skills.length > 0) this.cvData.skills = d.skills;

                            this.chatHistory.push({
                                sender: 'ai'
                                , text: `Selesai! Seluruh konten CV untuk posisi "${this.cvData.target_role}" telah berhasil diformulasikan dengan formula STAR standar HRD.\n\nSaya telah menampilkan live preview CV di sisi kanan. Anda bisa mengedit teksnya secara langsung atau mendownload PDF A4 sekarang!`
                            });
                            this.generatedOnce = true;
                            this.activeView = 'preview';
                        } else {
                            throw new Error('Gagal memproses data AI.');
                        }
                    } catch (err) {
                        console.error(err);
                        this.chatHistory.push({
                            sender: 'ai'
                            , text: 'Template CV telah diperbarui dengan standar format rekomendasi HRD. Silakan cek hasil preview di tab Live Preview!'
                        });
                        this.generatedOnce = true;
                        this.activeView = 'preview';
                    } finally {
                        this.isGenerating = false;
                        this.scrollToChatBottom();
                    }
                },

                scrollToChatBottom() {
                    setTimeout(() => {
                        const container = document.getElementById('chat-messages-container');
                        if (container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    }, 100);
                },

                /**
                 * Ultra-reliable single-page A4 print using hidden isolated iframe
                 */
                printCv() {
                    // Intercept: show review modal first if not yet reviewed
                    if (!this.hasReviewed) {
                        this.showReviewModal = true;
                        return;
                    }
                    this.executePrint();
                },

                executePrint() {
                    const sheet = document.getElementById('cv-printable-sheet');
                    if (!sheet) return;

                    const oldIframe = document.getElementById('cv-isolated-print-frame');
                    if (oldIframe) oldIframe.remove();

                    const iframe = document.createElement('iframe');
                    iframe.id = 'cv-isolated-print-frame';
                    iframe.style.position = 'fixed';
                    iframe.style.right = '0';
                    iframe.style.bottom = '0';
                    iframe.style.width = '0';
                    iframe.style.height = '0';
                    iframe.style.border = '0';
                    iframe.style.visibility = 'hidden';
                    document.body.appendChild(iframe);

                    const doc = iframe.contentWindow.document;

                    let stylesHtml = '';
                    document.querySelectorAll('link[rel="stylesheet"], link[rel="preconnect"], style').forEach(node => {
                        stylesHtml += node.outerHTML;
                    });

                    doc.open();
                    doc.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset="UTF-8">
                    <title>${this.cvData.full_name || 'CV'} - Scalify</title>
                    ${stylesHtml}
                    <style>
                        @page {
                            size: A4 portrait;
                            margin: 0;
                        }
                        html, body {
                            margin: 0 !important;
                            padding: 0 !important;
                            background: #ffffff !important;
                            width: 210mm !important;
                            height: auto !important;
                            -webkit-print-color-adjust: exact !important;
                            print-color-adjust: exact !important;
                        }
                        #cv-printable-sheet {
                            width: 210mm !important;
                            min-height: 297mm !important;
                            height: auto !important;
                            margin: 0 !important;
                            padding: 0 !important;
                            box-shadow: none !important;
                            border: none !important;
                            overflow: visible !important;
                        }
                        .group\/sec {
                            page-break-inside: avoid !important;
                            break-inside: avoid !important;
                        }
                    </style>
                </head>
                <body class="bg-white">
                    ${sheet.outerHTML}
                </body>
                </html>
            `);
                    doc.close();

                    setTimeout(() => {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                        setTimeout(() => {
                            iframe.remove();
                        }, 1000);
                    }, 350);
                },

                copyAllCvText() {
                    let text = `CURRICULUM VITAE\n`;
                    text += `${this.cvData.full_name}, ${this.cvData.degree}\n`;
                    text += `Posisi Target: ${this.cvData.target_role}\n\n`;
                    text += `PROFIL:\n${this.cvData.profile_summary}\n\n`;
                    text += `PENDIDIKAN:\n`;
                    this.cvData.education_list.forEach(e => {
                        text += `- ${e.degree_name} ${e.institution} (${e.period}) [${e.city}]\n`;
                        if (e.achievements) e.achievements.forEach(a => text += `  * ${a}\n`);
                    });
                    text += `\nRIWAYAT PEKERJAAN:\n`;
                    this.cvData.work_experience.forEach(w => {
                        text += `- ${w.company} (${w.position}) - ${w.period} [${w.city}]\n`;
                        if (w.bullets) w.bullets.forEach(b => text += `  * ${b}\n`);
                    });
                    text += `\nRIWAYAT MAGANG:\n`;
                    this.cvData.internship_experience.forEach(i => {
                        text += `- ${i.company} (${i.position}) - ${i.period} [${i.city}]\n`;
                        if (i.bullets) i.bullets.forEach(b => text += `  * ${b}\n`);
                    });
                    text += `\nSKILLS:\n`;
                    this.cvData.skills.forEach(s => text += `- ${s.name} (${s.level}%)\n`);
                    text += `\nKONTAK:\nTelp: ${this.cvData.phone}\nEmail: ${this.cvData.email}\nAlamat: ${this.cvData.address}\n`;

                    navigator.clipboard.writeText(text).then(() => {
                        this.copySuccess = true;
                        setTimeout(() => this.copySuccess = false, 2500);
                    });
                }
            };
        }

    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }

    </style>

    {{-- ===== REVIEW MODAL (Glassmorphism) ===== --}}
    <div x-show="showReviewModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak class="fixed inset-0 z-[999] flex items-center justify-center p-4">
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="showReviewModal = false"></div>

        {{-- Modal Card --}}
        <div x-show="showReviewModal" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" class="relative w-full max-w-md rounded-2xl border border-white/10 shadow-2xl overflow-hidden" style="background: rgba(9,13,41,0.85); backdrop-filter: blur(24px); -webkit-backdrop-filter: blur(24px);" @click.stop>
            {{-- Subtle gradient top line --}}
            <div class="absolute top-0 left-0 right-0 h-[1px] bg-gradient-to-r from-transparent via-cyan-400/50 to-transparent"></div>

            <div class="p-7">
                {{-- Header --}}
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-white font-bold text-lg tracking-tight">Sebelum Mencetak</h3>
                        <p class="text-white/50 text-xs mt-1">Bagikan penilaian Anda untuk membantu kami berkembang.</p>
                    </div>
                    <button @click="showReviewModal = false" class="text-white/30 hover:text-white/70 transition mt-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                {{-- Star Rating --}}
                <div class="mb-5">
                    <p class="text-white/60 text-xs mb-3 uppercase tracking-widest font-semibold">Rating Pengalaman</p>
                    <div class="flex items-center gap-2">
                        <template x-for="star in [1,2,3,4,5]" :key="star">
                            <button @click="reviewRating = star" @mouseenter="reviewHover = star" @mouseleave="reviewHover = 0" class="text-3xl transition-all duration-150 focus:outline-none" :class="(reviewHover || reviewRating) >= star ? 'text-amber-400 scale-110' : 'text-white/20'">★</button>
                        </template>
                        <span x-show="reviewRating > 0" x-text="['','Buruk','Cukup','Bagus','Sangat Bagus','Luar Biasa!'][reviewRating]" class="text-xs text-white/50 ml-2"></span>
                    </div>
                </div>

                {{-- Quick Note Selector --}}
                <div class="mb-5">
                    <p class="text-white/60 text-xs mb-3 uppercase tracking-widest font-semibold">Catatan Cepat</p>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="note in ['Sangat membantu','Mudah digunakan','Hasilnya bagus','AI-nya keren','Akan saya rekomendasikan']" :key="note">
                            <button @click="reviewNote = note" :class="reviewNote === note ? 'bg-cyan-500/20 border-cyan-400/60 text-cyan-300' : 'bg-white/5 border-white/10 text-white/50 hover:border-white/25'" class="px-3 py-1.5 rounded-full border text-xs font-medium transition-all" x-text="note"></button>
                        </template>
                    </div>
                </div>

                {{-- Optional free text --}}
                <div class="mb-6">
                    <textarea x-model="reviewNote" placeholder="Atau tulis komentar Anda di sini... (opsional)" class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white/80 text-xs placeholder-white/30 focus:outline-none focus:border-cyan-500/50 transition resize-none" rows="2"></textarea>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3">
                    <button @click="
                            if (reviewRating === 0) { reviewRating = 3; }
                            hasReviewed = true;
                            showReviewModal = false;
                            executePrint();
                        " class="flex-1 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/50 hover:text-white/70 hover:border-white/20 text-xs font-semibold transition">Lewati & Cetak</button>

                    <button @click="
                            if (reviewRating === 0) return;
                            isSubmittingReview = true;
                            fetch('{{ route('layanan.cv.review') }}', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                body: JSON.stringify({ rating: reviewRating, note: reviewNote })
                            })
                            .finally(() => {
                                isSubmittingReview = false;
                                hasReviewed = true;
                                showReviewModal = false;
                                executePrint();
                            });
                        " :disabled="reviewRating === 0 || isSubmittingReview" class="flex-1 py-2.5 rounded-xl font-bold text-xs transition-all shadow-lg" :class="reviewRating > 0 && !isSubmittingReview
                            ? 'bg-gradient-to-r from-cyan-500 to-blue-600 hover:from-cyan-400 hover:to-blue-500 text-white shadow-cyan-500/30'
                            : 'bg-white/5 text-white/30 cursor-not-allowed'">
                        <span x-show="!isSubmittingReview">Kirim & Cetak PDF</span>
                        <span x-show="isSubmittingReview">Mengirim...</span>
                    </button>
                </div>
            </div>

            {{-- Bottom gradient line --}}
            <div class="h-[1px] bg-gradient-to-r from-transparent via-blue-500/30 to-transparent"></div>
        </div>
    </div>
