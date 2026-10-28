<div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-3 sm:px-4 pt-3 sm:pt-4 pb-28 text-white">

    <!-- Global Floating Feedback / Alert -->
    @if ($feedbackMessage)
    <div class="fixed top-4 left-1/2 -translate-x-1/2 w-[92%] max-w-sm z-50 animate-bounce">
        <div class="p-3 rounded-2xl glass-card border {{ $feedbackType === 'error' ? 'border-red-500/50 bg-red-950/80 text-red-200' : 'border-emerald-500/50 bg-emerald-950/80 text-emerald-200' }} shadow-2xl flex items-center justify-between text-xs font-bold">
            <div class="flex items-center gap-2">
                <i class="fas {{ $feedbackType === 'error' ? 'fa-circle-exclamation text-red-400' : 'fa-circle-check text-emerald-400' }} text-sm"></i>
                <span>{{ $feedbackMessage }}</span>
            </div>
            <button type="button" wire:click="clearFeedback" class="text-white/60 hover:text-white text-base leading-none ml-2">&times;</button>
        </div>
    </div>
    @endif

    <!-- ================================================================================== -->
    <!-- PERMANENT APP HEADER & PROFILE BAR (Matching Scalify Partner)                      -->
    <!-- ================================================================================== -->
    <header class="flex justify-between items-center pb-3 border-b border-white/10 mb-3.5">
        <button type="button" wire:click="switchView('profile')" class="flex items-center gap-3 hover:opacity-85 transition-opacity text-left cursor-pointer group">
            <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 p-0.5 shadow-lg shadow-blue-500/25 flex items-center justify-center shrink-0 border border-white/15 group-hover:scale-105 transition-transform">
                @if ($isLoggedIn && !empty($customerName))
                <span class="text-sm font-black text-white font-mono">{{ strtoupper(substr(trim($customerName), 0, 1)) }}</span>
                @else
                <img src="{{ asset('images/travel/rivian_logo.jpg') }}" alt="Rivian Travel" class="w-full h-full object-cover rounded-[14px]">
                @endif
            </div>
            <div>
                <div class="flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full {{ $isLoggedIn ? 'bg-emerald-400 animate-pulse' : 'bg-blue-400' }}"></span>
                    <span class="text-[9px] text-blue-300 font-bold uppercase tracking-wider">
                        {{ $isLoggedIn ? 'Pelanggan Eksekutif' : 'Rivian Travel' }}
                    </span>
                </div>
                <h1 class="text-sm font-black text-white tracking-tight leading-tight truncate max-w-[170px]">
                    {{ $isLoggedIn ? $customerName : 'Masuk / Daftar Akun' }}
                </h1>
            </div>
        </button>

        <div class="flex items-center gap-2">
            @if ($isLoggedIn)
            <button type="button" wire:click="switchView('profile')" class="px-2.5 py-1 rounded-full text-[10px] font-black text-blue-300 bg-blue-500/15 border border-blue-400/30 shadow-xs flex items-center gap-1.5 hover:bg-blue-500/25 transition cursor-pointer">
                <i class="fas fa-gift text-blue-400 text-[10px]"></i>
                <span>{{ $customerPoints }} Poin</span>
            </button>
            @else
            <button type="button" wire:click="openCustomerAuthModal" class="px-3 py-1 rounded-full text-[10px] font-extrabold text-blue-300 bg-blue-500/15 border border-blue-400/30 flex items-center gap-1.5 hover:bg-blue-500/25 transition cursor-pointer">
                <i class="fas fa-user-plus text-[10px] text-blue-400"></i>
                <span>Masuk</span>
            </button>
            @endif
            <button type="button" onclick="window.shareTravelLink()" title="Bagikan Link Travel" class="w-9 h-9 rounded-2xl glass-panel flex items-center justify-center text-blue-400 hover:text-white transition-colors cursor-pointer border border-white/10 shrink-0">
                <i class="fas fa-share-nodes text-xs"></i>
            </button>
            <a href="https://wa.me/6281234567890" target="_blank" class="w-9 h-9 rounded-2xl glass-panel flex items-center justify-center text-emerald-400 hover:text-white transition-colors cursor-pointer border border-white/10 shrink-0">
                <i class="fab fa-whatsapp text-sm"></i>
            </a>
        </div>
    </header>

    <!-- Sub-Header Navigation Row (Displayed when NOT on Home) -->
    @if ($currentView !== 'home')
    <div class="flex items-center justify-between pb-3">
        <button type="button" wire:click="switchView('home')" class="glass-panel text-blue-400 hover:text-blue-300 px-3 py-1.5 rounded-xl text-xs font-bold flex items-center gap-1.5 cursor-pointer active:scale-95 transition">
            <i class="fas fa-arrow-left text-[11px]"></i>
            <span>Kembali</span>
        </button>
        <h2 class="text-xs font-black text-white uppercase tracking-wider">
            @if ($currentView === 'charter')
            Sewa Mobil (Charter)
            @elseif ($currentView === 'package')
            Titip Paket Kilat
            @elseif ($currentView === 'schedules')
            Jadwal Keberangkatan
            @elseif ($currentView === 'history')
            Tiket Saya
            @elseif ($currentView === 'ticket')
            E-Boarding Pass
            @elseif ($currentView === 'profile')
            Profil Pelanggan
            @endif
        </h2>
        <div class="w-14"></div>
    </div>
    @endif

    <!-- ================================================================================== -->
    <!-- VIEW 1: HOME (DIRECT SHUTTLE BOOKING)                                              -->
    <!-- ================================================================================== -->
    @if ($currentView === 'home')
    <div class="space-y-4">
        <!-- Route Hero Banner -->
        <div class="glass-card rounded-2xl p-4 relative overflow-hidden border border-white/15 shadow-xl">
            <div class="relative z-10 flex items-center justify-between">
                <div class="space-y-1">
                    <span class="inline-block bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[9px] font-black uppercase px-2 py-0.5 rounded-full tracking-wider">
                        Door to Door Eksekutif
                    </span>
                    <h2 class="text-base font-black text-white tracking-tight">Ciamis ➔ Bandung PP</h2>
                    <p class="text-[11px] text-slate-300 leading-snug">Daihatsu All New Xenia AC Dingin, jemput depan pintu & antar sampai tujuan.</p>
                </div>
                <div class="w-14 h-14 rounded-2xl overflow-hidden border border-white/20 shadow-lg shadow-blue-500/20 shrink-0 ml-3 bg-slate-800 p-0.5">
                    <img src="{{ asset('images/travel/minibus_hero.jpg') }}" alt="Daihatsu Xenia" class="w-full h-full object-cover rounded-[14px]">
                </div>
            </div>
            <div class="absolute -right-8 -bottom-8 w-32 h-32 bg-blue-500/15 rounded-full blur-2xl pointer-events-none"></div>
        </div>

        <!-- Quick Service Pills -->
        <div class="grid grid-cols-3 gap-2">
            <button type="button" wire:click="switchView('home')" class="p-2.5 rounded-2xl glass-card border border-blue-500/50 bg-blue-600/20 text-center transition cursor-pointer">
                <svg class="w-5 h-5 mx-auto mb-1 text-blue-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 17h2c.6 0 1-.4 1-1v-3c0-.9-.7-1.7-1.5-1.9C18.7 10.6 16 10 16 10s-1.3-1.4-2.2-2.3c-.5-.4-1.1-.7-1.8-.7H5c-1.1 0-2 .9-2 2v7c0 .6.4 1 1 1h2" />
                    <circle cx="7" cy="17" r="2" />
                    <path d="M9 17h6" />
                    <circle cx="17" cy="17" r="2" />
                </svg>
                <span class="text-[10px] font-extrabold text-white block">Shuttle Reguler</span>
            </button>
            <button type="button" wire:click="switchView('charter')" class="p-2.5 rounded-2xl glass-panel text-center hover:bg-white/10 transition cursor-pointer group">
                <svg class="w-5 h-5 mx-auto mb-1 text-slate-400 group-hover:text-blue-300 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 16H9m10 0h3v-3.15a1 1 0 0 0-.84-.99L16 11l-2.7-3.6a1 1 0 0 0-.8-.4H8.5a1 1 0 0 0-.8.4L5 11l-5.16.86a1 1 0 0 0-.84.99V16h3" />
                    <circle cx="6.5" cy="16.5" r="2.5" />
                    <circle cx="16.5" cy="16.5" r="2.5" />
                </svg>
                <span class="text-[10px] font-semibold text-slate-300 block">Sewa Mobil</span>
            </button>
            <button type="button" wire:click="switchView('package')" class="p-2.5 rounded-2xl glass-panel text-center hover:bg-white/10 transition cursor-pointer group">
                <svg class="w-5 h-5 mx-auto mb-1 text-slate-400 group-hover:text-blue-300 transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z" />
                    <path d="m3.3 7 8.7 5 8.7-5" />
                    <path d="M12 22V12" />
                </svg>
                <span class="text-[10px] font-semibold text-slate-300 block">Titip Paket</span>
            </button>
        </div>

        <!-- Form Booking Shuttle -->
        <form wire:submit.prevent="handleDirectBookingSubmit" class="space-y-4">

            <!-- Account Status Card -->
            @if ($isLoggedIn)
            <div class="glass-panel rounded-2xl p-3 border border-blue-500/30 bg-blue-950/20 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-8 h-8 rounded-xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center text-xs">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <div>
                        <div class="text-xs font-extrabold text-white">{{ $customerName }}</div>
                        <div class="text-[10px] text-blue-300 font-mono">{{ $customerPhone }} • {{ $customerPoints }} Poin</div>
                    </div>
                </div>
                <button type="button" wire:click="switchView('profile')" class="text-[10px] text-blue-400 hover:text-blue-300 font-bold underline cursor-pointer">Detail Profil</button>
            </div>
            @else
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Pemesan *</label>
                    <div class="relative flex items-center">
                        <i class="far fa-user absolute left-3.5 text-slate-500 text-xs"></i>
                        <input type="text" wire:model.defer="customerName" required placeholder="Contoh: Budi Santoso" class="w-full h-11 bg-white/5 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition font-medium">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">WhatsApp Pemesan *</label>
                    <div class="relative flex items-center">
                        <i class="fab fa-whatsapp absolute left-3.5 text-emerald-400 text-xs"></i>
                        <input type="tel" wire:model.defer="customerPhone" required placeholder="081234567890" class="w-full h-11 bg-white/5 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition font-mono font-medium">
                    </div>
                </div>
            </div>
            @endif

            <!-- 1. Titik Jemput (Asal) -->
            <div class="space-y-1.5">
                <div class="flex items-center justify-between">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-blue-400"></span>
                        <span>1. Titik Jemput (Asal) *</span>
                    </label>
                    <button type="button" onclick="detectUserLocation('pickup')" class="px-2.5 py-1 rounded-full bg-blue-500/15 border border-blue-500/30 text-blue-300 text-[10px] font-bold flex items-center gap-1 active:scale-95 transition cursor-pointer">
                        <i class="fas fa-crosshairs text-[9px]"></i>
                        <span>GPS Lokasi Saya</span>
                    </button>
                </div>

                <!-- Quick Chips Lokasi Jemput -->
                <div class="flex gap-1.5 overflow-x-auto hide-scrollbar py-0.5">
                    <button type="button" wire:click="applyQuickPickup('Pool Ciamis (Kantor Pusat) - Jl. Jenderal Sudirman No. 88, Ciamis')" class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0">
                        <i class="fas fa-building text-blue-400 text-[10px]"></i> Pool Ciamis
                    </button>
                    <button type="button" wire:click="applyQuickPickup('Pool Pasteur Bandung - Jl. Dr. Djunjunan No. 135')" class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0">
                        <i class="fas fa-building text-blue-400 text-[10px]"></i> Pool Pasteur
                    </button>
                    <button type="button" wire:click="applyQuickPickup('Pool Dipatiukur Bandung - Jl. Dipatiukur No. 42 (Dekat Kampus Unpad)')" class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0">
                        <i class="fas fa-university text-blue-400 text-[10px]"></i> Pool Dipatiukur
                    </button>
                </div>

                <div class="relative">
                    <textarea wire:model.defer="pickupAddress" required rows="2" placeholder="Ketik alamat penjemputan lengkap atau patokan lokasi..." class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition font-medium resize-none leading-relaxed"></textarea>
                </div>
            </div>

            <!-- 2. Titik Tujuan (Pengantaran) -->
            <div class="space-y-1.5">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                    <span>2. Titik Tujuan (Pengantaran) *</span>
                </label>

                <!-- Quick Chips Lokasi Tujuan -->
                <div class="flex gap-1.5 overflow-x-auto hide-scrollbar py-0.5">
                    <button type="button" wire:click="applyQuickDropoff('Pool Pasteur Bandung - Jl. Dr. Djunjunan No. 135')" class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0">
                        <i class="fas fa-location-dot text-emerald-400 text-[10px]"></i> Pool Pasteur
                    </button>
                    <button type="button" wire:click="applyQuickDropoff('Pool Dipatiukur Bandung - Jl. Dipatiukur No. 42 (Dekat Kampus Unpad)')" class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0">
                        <i class="fas fa-location-dot text-emerald-400 text-[10px]"></i> Pool Dipatiukur
                    </button>
                    <button type="button" wire:click="applyQuickDropoff('Pool Ciamis (Kantor Pusat) - Jl. Jenderal Sudirman No. 88, Ciamis')" class="glass-panel text-slate-300 hover:text-white px-3 py-1.5 rounded-xl text-[10px] font-semibold border-white/10 cursor-pointer whitespace-nowrap transition active:scale-95 flex items-center gap-1.5 shrink-0">
                        <i class="fas fa-location-dot text-emerald-400 text-[10px]"></i> Pool Ciamis
                    </button>
                </div>

                <div class="relative">
                    <textarea wire:model.defer="dropoffAddress" required rows="2" placeholder="Ketik alamat pengantaran lengkap tujuan Anda..." class="w-full bg-white/5 border border-white/10 rounded-xl p-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:bg-white/10 transition font-medium resize-none leading-relaxed"></textarea>
                </div>
            </div>

            <!-- 3. Jadwal & Jam Keberangkatan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-1">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tanggal Berangkat *</label>
                    <div class="relative flex items-center">
                        <i class="far fa-calendar-alt absolute left-3.5 text-blue-400 text-xs"></i>
                        <input type="date" wire:model="departureDate" min="{{ date('Y-m-d') }}" required class="w-full h-11 bg-white/5 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white focus:outline-none focus:border-blue-500 font-semibold cursor-pointer">
                    </div>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilihan Jam Keberangkatan</label>
                    <div class="grid grid-cols-5 gap-1.5">
                        @foreach ($timeSlots as $time)
                        <button type="button" wire:click="selectTime('{{ $time }}')" class="py-2 text-center rounded-xl text-xs font-black transition cursor-pointer border {{ $selectedTime === $time ? 'bg-blue-600 text-white border-blue-400 shadow-md shadow-blue-500/30' : 'glass-panel text-slate-300 border-white/10 hover:text-white hover:bg-white/10' }}">
                            {{ $time }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- 4. Stepper Jumlah Kursi (Minimal 4 Kursi) -->
            <div class="glass-card rounded-2xl p-4 border border-blue-500/25 bg-blue-950/20">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-black text-white flex items-center gap-1.5">
                            <span>Jumlah Kursi</span>
                            <span class="bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[9px] font-black px-1.5 py-0.5 rounded-md">Min. 4 Kursi</span>
                        </div>
                        <div class="text-[10px] text-blue-300 mt-0.5">Rp 190.000 / kursi via Tol Cipularang</div>
                    </div>

                    <!-- Stepper Controls -->
                    <div class="flex items-center gap-2 bg-white/10 p-1 rounded-xl border border-white/15">
                        <button type="button" wire:click="decrementSeats" class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 active:scale-95 text-white flex items-center justify-center font-black text-base cursor-pointer transition">
                            <i class="fas fa-minus text-xs"></i>
                        </button>
                        <span class="w-8 text-center text-sm font-black text-white font-mono">{{ $seatQuantity }}</span>
                        <button type="button" wire:click="incrementSeats" class="w-8 h-8 rounded-lg bg-blue-600 hover:bg-blue-500 active:scale-95 text-white flex items-center justify-center font-black text-base cursor-pointer transition shadow-md shadow-blue-600/30">
                            <i class="fas fa-plus text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Ringkasan Live Total -->
                <div class="mt-3 pt-3 border-t border-white/10 flex items-center justify-between">
                    <span class="text-[11px] text-slate-400 font-bold">Total Pembayaran:</span>
                    <div class="text-right">
                        <span class="text-lg font-black text-blue-400 font-mono tracking-tight">Rp {{ number_format($totalAmount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- Submit CTA Button -->
            <button type="submit" class="w-full h-12 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-black text-sm rounded-2xl shadow-xl shadow-blue-500/25 flex items-center justify-center gap-2.5 active:scale-[0.99] transition cursor-pointer">
                <span>Booking Sekarang</span>
                <i class="fas fa-arrow-right text-xs"></i>
            </button>
        </form>

        <!-- Jadwal Keberangkatan Preview -->
        <div class="pt-2">
            <div class="flex items-center justify-between mb-2.5">
                <strong class="text-xs font-black text-white flex items-center gap-1.5">
                    <i class="fas fa-clock text-blue-400"></i>
                    <span>Jadwal Armada ({{ \Carbon\Carbon::parse($departureDate ?: now())->locale('id')->isoFormat('D MMMM Y') }})</span>
                </strong>
                <button type="button" wire:click="switchView('schedules')" class="text-[10px] text-blue-400 hover:text-blue-300 font-bold">Lihat Semua &rarr;</button>
            </div>

            <div class="space-y-2">
                @foreach (array_slice($this->schedules, 0, 4) as $sched)
                @php
                $bookedCount = count($sched['booked_seats']);
                $remainingSeats = max(0, 5 - $bookedCount);
                $cleanTime = explode(' ', $sched['departure_time'])[0];
                @endphp
                <div wire:click="selectTime('{{ $cleanTime }}')" class="glass-card rounded-2xl p-3 border border-white/10 hover:border-blue-400/40 transition active:scale-[0.99] cursor-pointer space-y-2">
                    <!-- Top Row: Time + Route + Price -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-2 min-w-0">
                            <span class="px-2 py-0.5 rounded-xl bg-blue-500/15 border border-blue-400/30 text-blue-300 font-mono text-xs font-black shrink-0">
                                {{ $cleanTime }} <span class="text-[8px] font-normal text-blue-300/80">WIB</span>
                            </span>
                            <div class="font-extrabold text-xs text-white truncate flex items-center gap-1.5">
                                <span>{{ $sched['origin'] }}</span>
                                <i class="fas fa-arrow-right text-[9px] text-blue-400 shrink-0"></i>
                                <span class="truncate">{{ $sched['destination'] }}</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <span class="text-xs font-black text-blue-400 font-mono tracking-tight whitespace-nowrap">{{ $sched['price_formatted'] }}</span>
                        </div>
                    </div>

                    <!-- Bottom Row: Fleet + Status Badge -->
                    <div class="flex items-center justify-between pt-1.5 border-t border-white/5 text-[10px]">
                        <div class="flex items-center gap-1.5 text-slate-400 font-medium">
                            <i class="fas fa-car text-blue-400/70 text-[10px]"></i>
                            <span>All New Xenia (AC)</span>
                        </div>
                        <div>
                            @if ($bookedCount > 0)
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-amber-500/15 text-amber-300 border border-amber-500/30 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                <span>Sisa {{ $remainingSeats }}/5 Kursi ({{ $bookedCount }} Terisi)</span>
                            </span>
                            @else
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                <span>5 Kursi Kosong</span>
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- ================================================================================== -->
    <!-- VIEW 2: SCHEDULES (FULL SCHEDULE LIST)                                             -->
    <!-- ================================================================================== -->
    @elseif ($currentView === 'schedules')
    <div class="space-y-3">
        <div class="space-y-2.5">
            @foreach ($this->schedules as $sched)
            @php
            $bookedCount = count($sched['booked_seats']);
            $remainingSeats = max(0, 5 - $bookedCount);
            $cleanTime = explode(' ', $sched['departure_time'])[0];
            @endphp
            <div class="glass-card rounded-2xl p-3.5 border border-white/15 space-y-2.5">
                <!-- Top Row: Time + Route + Price -->
                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <span class="px-2.5 py-1 rounded-xl bg-blue-500/20 border border-blue-400/40 text-blue-300 font-mono text-xs font-black shrink-0">
                            {{ $cleanTime }} <span class="text-[8px] font-normal text-blue-300/80">WIB</span>
                        </span>
                        <div class="font-extrabold text-xs text-white truncate flex items-center gap-1.5">
                            <span>{{ $sched['origin'] }}</span>
                            <i class="fas fa-arrow-right text-[9px] text-blue-400 shrink-0"></i>
                            <span class="truncate">{{ $sched['destination'] }}</span>
                        </div>
                    </div>
                    <div class="text-right shrink-0">
                        <span class="text-xs font-black text-blue-400 font-mono tracking-tight whitespace-nowrap">{{ $sched['price_formatted'] }}</span>
                    </div>
                </div>

                <!-- Bottom Row: Fleet + Status Badge + Action Button -->
                <div class="flex items-center justify-between pt-2 border-t border-white/10 text-[10px]">
                    <div class="flex items-center gap-1.5 text-slate-400 font-medium">
                        <i class="fas fa-car text-blue-400 text-[10px]"></i>
                        <span>{{ $sched['fleet_name'] }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        @if ($bookedCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-amber-500/15 text-amber-300 border border-amber-500/30 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                            <span>Sisa {{ $remainingSeats }}/5</span>
                        </span>
                        @else
                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-500/15 text-emerald-300 border border-emerald-500/30 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                            <span>5 Kursi Kosong</span>
                        </span>
                        @endif
                        <button type="button" wire:click="selectTime('{{ $cleanTime }}'); switchView('home')" class="px-3 py-1 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-[10px] font-black cursor-pointer transition shadow-xs active:scale-95">
                            Pilih
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- ================================================================================== -->
    <!-- VIEW 3: CHARTER (SEWA MOBIL KONDANGAN / LIBURAN)                                   -->
    <!-- ================================================================================== -->
    @elseif ($currentView === 'charter')
    <div class="space-y-4">
        <div class="glass-card rounded-2xl p-4 border border-white/15 space-y-4">
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tujuan Sewa</label>
                <div class="grid grid-cols-3 gap-2">
                    <button type="button" wire:click="$set('charterPurpose', 'kondangan')" class="p-2.5 rounded-xl text-center text-xs font-bold border transition cursor-pointer {{ $charterPurpose === 'kondangan' ? 'bg-blue-600 text-white border-blue-400' : 'glass-panel text-slate-300 border-white/10' }}">
                        Kondangan
                    </button>
                    <button type="button" wire:click="$set('charterPurpose', 'liburan')" class="p-2.5 rounded-xl text-center text-xs font-bold border transition cursor-pointer {{ $charterPurpose === 'liburan' ? 'bg-blue-600 text-white border-blue-400' : 'glass-panel text-slate-300 border-white/10' }}">
                        Liburan
                    </button>
                    <button type="button" wire:click="$set('charterPurpose', 'dinas')" class="p-2.5 rounded-xl text-center text-xs font-bold border transition cursor-pointer {{ $charterPurpose === 'dinas' ? 'bg-blue-600 text-white border-blue-400' : 'glass-panel text-slate-300 border-white/10' }}">
                        Dinas / Kerja
                    </button>
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Pilihan Armada</label>
                <select wire:model.live="charterFleet" class="w-full h-11 bg-white/5 border border-white/10 rounded-xl px-3 text-xs text-white focus:outline-none focus:border-blue-500 font-semibold cursor-pointer">
                    <option value="xenia_all_new" class="bg-slate-900 text-white">Daihatsu All New Xenia (7 Kursi)</option>
                    <option value="avanza_veloz" class="bg-slate-900 text-white">Toyota Avanza / Veloz (7 Kursi)</option>
                    <option value="innova_zenix" class="bg-slate-900 text-white">Toyota Innova Zenix (7-8 Kursi)</option>
                    <option value="hiace_premio" class="bg-slate-900 text-white">Toyota Hiace Premio (14 Kursi)</option>
                    <option value="elf_long" class="bg-slate-900 text-white">Isuzu Elf Long (19 Kursi)</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Tanggal Sewa</label>
                    <input type="date" wire:model="charterDate" min="{{ date('Y-m-d') }}" class="w-full h-11 bg-white/5 border border-white/10 rounded-xl px-3 text-xs text-white focus:outline-none focus:border-blue-500 font-semibold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Durasi (Hari)</label>
                    <input type="number" wire:model.live="charterDays" min="1" max="30" class="w-full h-11 bg-white/5 border border-white/10 rounded-xl px-3 text-xs text-white focus:outline-none focus:border-blue-500 font-semibold font-mono">
                </div>
            </div>

            <div class="p-3 rounded-xl bg-blue-500/10 border border-blue-500/20 flex items-center justify-between">
                <div>
                    <span class="text-[10px] text-slate-400 block font-bold">Estimasi Biaya Sewa:</span>
                    <strong class="text-base text-blue-400 font-mono">Rp {{ number_format($charterTotalAmount, 0, ',', '.') }}</strong>
                </div>
                <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20ingin%20sewa%20mobil%20{{ $charterFleet }}%20untuk%20{{ $charterPurpose }}%20selama%20{{ $charterDays }}%20hari" target="_blank" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black flex items-center gap-1.5 transition">
                    <i class="fab fa-whatsapp"></i> Hubungi CS
                </a>
            </div>
        </div>
    </div>

    <!-- ================================================================================== -->
    <!-- VIEW 4: PACKAGE (TITIP PAKET KILAT)                                                -->
    <!-- ================================================================================== -->
    @elseif ($currentView === 'package')
    <div class="space-y-4">
        <div class="glass-card rounded-2xl p-5 border border-white/15 space-y-4 text-center">
            <div class="w-14 h-14 rounded-2xl bg-blue-500/15 border border-blue-500/30 text-blue-400 text-2xl flex items-center justify-center mx-auto">
                <i class="fas fa-box-open"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-white">Kirim Paket Ciamis ➔ Bandung PP</h3>
                <p class="text-[11px] text-slate-300 mt-1 leading-relaxed">Paket tiba di hari yang sama (Same Day Delivery). Dokumen penting, makanan khas, pakaian, dan barang dagangan diantar aman langsung ke tujuan.</p>
            </div>
            <div class="glass-panel p-3 rounded-xl border border-white/10 text-left text-[11px] space-y-1.5">
                <div class="flex items-center gap-2 text-slate-300">
                    <i class="fas fa-check-circle text-emerald-400 text-xs"></i>
                    <span>Tarif mulai dari <strong>Rp 40.000 / paket</strong></span>
                </div>
                <div class="flex items-center gap-2 text-slate-300">
                    <i class="fas fa-check-circle text-emerald-400 text-xs"></i>
                    <span>Berangkat sesuai jam operasional shuttle reguler</span>
                </div>
                <div class="flex items-center gap-2 text-slate-300">
                    <i class="fas fa-check-circle text-emerald-400 text-xs"></i>
                    <span>Bisa dijemput & diantar door-to-door</span>
                </div>
            </div>
            <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20mau%20titip%20paket%20kilat%20Ciamis%20-%20Bandung" target="_blank" class="w-full h-11 bg-emerald-600 hover:bg-emerald-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-emerald-600/30 flex items-center justify-center gap-2 transition">
                <i class="fab fa-whatsapp text-sm"></i>
                <span>Kirim Pesan Titip Paket via WA</span>
            </a>
        </div>
    </div>

    <!-- ================================================================================== -->
    <!-- VIEW 5: BOARDING PASS / OFFICIAL E-TICKET                                           -->
    <!-- ================================================================================== -->
    @elseif ($currentView === 'ticket' && $activeBooking)
    <div class="space-y-4">
        <!-- Verification Banner -->
        <div class="p-3.5 rounded-2xl border {{ $activeBooking['payment_status'] === 'paid' ? 'bg-emerald-950/40 border-emerald-500/40 text-emerald-200' : 'bg-amber-950/40 border-amber-500/40 text-amber-200' }} flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl {{ $activeBooking['payment_status'] === 'paid' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-amber-500/20 text-amber-400' }} flex items-center justify-center text-sm shrink-0">
                <i class="fas {{ $activeBooking['payment_status'] === 'paid' ? 'fa-check-circle' : 'fa-clock' }}"></i>
            </div>
            <div class="text-xs leading-snug">
                <strong class="block font-black">{{ $activeBooking['status_label'] }}</strong>
                <span class="text-[10px] opacity-80">{{ $activeBooking['payment_status'] === 'paid' ? 'Tiket Anda sudah terverifikasi dan siap digunakan.' : 'Menunggu verifikasi admin atau konfirmasi pembayaran.' }}</span>
            </div>
        </div>

        <!-- E-Ticket Card -->
        <div class="glass-card rounded-3xl border border-white/20 p-5 space-y-4 shadow-2xl relative overflow-hidden">
            <!-- Header Card -->
            <div class="flex items-center justify-between pb-3 border-b border-white/10">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-white/10 p-1 border border-white/15">
                        <img src="{{ asset('images/travel/rivian_logo.jpg') }}" alt="Rivian Travel" class="w-full h-full object-cover rounded-lg">
                    </div>
                    <div>
                        <strong class="text-xs font-black text-white block">Rivian Travel</strong>
                        <span class="text-[9px] text-blue-300 font-bold uppercase tracking-wider">Executive Shuttle</span>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-black text-blue-400 bg-blue-500/15 border border-blue-400/30">
                    {{ $activeBooking['booking_code'] }}
                </span>
            </div>

            <!-- Flight Route Row -->
            <div class="flex items-center justify-between py-2">
                <div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">BERANGKAT</span>
                    <div class="text-base font-black text-white font-mono mt-0.5">{{ $activeBooking['departure_time'] }}</div>
                    <span class="text-xs font-extrabold text-slate-200 block">{{ $activeBooking['origin'] }}</span>
                </div>
                <div class="flex flex-col items-center px-3">
                    <i class="fas fa-van-shuttle text-blue-400 text-sm"></i>
                    <div class="w-12 h-0.5 bg-blue-500/30 my-1"></div>
                    <span class="text-[8px] text-blue-300 font-bold">Via Tol</span>
                </div>
                <div class="text-right">
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">TUJUAN</span>
                    <div class="text-base font-black text-white font-mono mt-0.5">EST 3.5 Jam</div>
                    <span class="text-xs font-extrabold text-slate-200 block">{{ $activeBooking['destination'] }}</span>
                </div>
            </div>

            <!-- Detail Grid -->
            <div class="grid grid-cols-2 gap-3 py-2 border-y border-white/10 text-xs">
                <div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Penumpang</span>
                    <strong class="text-white block mt-0.5">{{ $activeBooking['customer_name'] }}</strong>
                    <span class="text-[10px] text-slate-400 font-mono">{{ $activeBooking['customer_phone'] }}</span>
                </div>
                <div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Berangkat</span>
                    <strong class="text-white block mt-0.5">{{ $activeBooking['departure_date_formatted'] }}</strong>
                    <span class="text-[10px] text-blue-300 font-bold">{{ $activeBooking['seat_numbers'] }}</span>
                </div>
            </div>

            <!-- Addresses -->
            <div class="space-y-2 text-[11px]">
                <div>
                    <span class="text-[9px] font-bold text-blue-400 uppercase tracking-wider block">Jemput (Asal):</span>
                    <p class="text-slate-300">{{ $activeBooking['pickup_address'] }}</p>
                </div>
                <div>
                    <span class="text-[9px] font-bold text-emerald-400 uppercase tracking-wider block">Antar (Tujuan):</span>
                    <p class="text-slate-300">{{ $activeBooking['dropoff_address'] }}</p>
                </div>
            </div>

            <!-- Total & Action -->
            <div class="pt-3 border-t border-white/10 flex items-center justify-between">
                <div>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Total Biaya:</span>
                    <strong class="text-base font-black text-blue-400 font-mono">{{ $activeBooking['total_amount_formatted'] }}</strong>
                </div>
                <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20sudah%20memesan%20tiket%20shuttle%20dengan%20Kode%20Booking:%20{{ $activeBooking['booking_code'] }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-black flex items-center gap-1.5 transition">
                    <i class="fab fa-whatsapp"></i> Konfirmasi Driver
                </a>
            </div>
        </div>
    </div>

    <!-- ================================================================================== -->
    <!-- VIEW 6: ORDER HISTORY (TIKET SAYA)                                                 -->
    <!-- ================================================================================== -->
    @elseif ($currentView === 'history')
    <div class="space-y-4">
        <!-- Phone Search Card -->
        <div class="glass-card rounded-2xl p-4 border border-white/15 space-y-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-xs">
                    <i class="fas fa-search"></i>
                </div>
                <div>
                    <strong class="text-xs font-black text-white block">Cek Riwayat Pemesanan</strong>
                    <span class="text-[10px] text-slate-400">Masukkan nomor WhatsApp yang digunakan saat memesan</span>
                </div>
            </div>

            <form wire:submit.prevent="loadMyTickets" class="flex gap-2">
                <div class="relative flex-1">
                    <i class="fab fa-whatsapp absolute left-3.5 top-3 text-emerald-400 text-xs"></i>
                    <input type="tel" wire:model.defer="historyPhone" placeholder="081234567890" class="w-full h-10 bg-white/5 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 font-mono font-medium">
                </div>
                <button type="submit" class="h-10 px-4 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-black flex items-center gap-1.5 transition cursor-pointer shrink-0">
                    <span>Cari</span>
                    <i class="fas fa-search text-[10px]"></i>
                </button>
            </form>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-2">
            <button type="button" wire:click="setHistoryFilter('all')" class="px-3 py-1.5 rounded-xl text-xs font-bold border transition cursor-pointer {{ $historyFilter === 'all' ? 'bg-blue-600 text-white border-blue-400' : 'glass-panel text-slate-300 border-white/10' }}">
                Semua
            </button>
            <button type="button" wire:click="setHistoryFilter('paid')" class="px-3 py-1.5 rounded-xl text-xs font-bold border transition cursor-pointer {{ $historyFilter === 'paid' ? 'bg-blue-600 text-white border-blue-400' : 'glass-panel text-slate-300 border-white/10' }}">
                Lunas
            </button>
            <button type="button" wire:click="setHistoryFilter('unpaid')" class="px-3 py-1.5 rounded-xl text-xs font-bold border transition cursor-pointer {{ $historyFilter === 'unpaid' ? 'bg-blue-600 text-white border-blue-400' : 'glass-panel text-slate-300 border-white/10' }}">
                Menunggu Verifikasi
            </button>
        </div>

        <!-- Ticket List -->
        <div class="space-y-3">
            @forelse ($myTickets as $ticket)
            <div class="glass-card rounded-2xl p-4 border border-white/15 space-y-3 hover:border-blue-400/30 transition">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-black text-blue-400 font-mono tracking-wider">{{ $ticket['booking_code'] }}</span>
                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider border {{ $ticket['payment_status'] === 'paid' ? 'bg-emerald-500/15 text-emerald-300 border-emerald-500/30' : 'bg-amber-500/15 text-amber-300 border-amber-500/30' }}">
                        {{ $ticket['payment_status'] === 'paid' ? 'LUNAS' : 'MENUNGGU' }}
                    </span>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <div>
                        <span class="font-extrabold text-white block">{{ $ticket['origin'] }} ➔ {{ $ticket['destination'] }}</span>
                        <span class="text-[10px] text-slate-400">{{ $ticket['departure_date_formatted'] }} • {{ $ticket['departure_time'] }}</span>
                    </div>
                    <span class="text-xs font-black text-blue-400 font-mono">{{ $ticket['total_amount_formatted'] }}</span>
                </div>

                <div class="pt-2 border-t border-white/10 flex items-center justify-between">
                    <span class="text-[10px] text-blue-300 font-bold">{{ $ticket['seat_numbers'] }}</span>
                    <button type="button" wire:click="openTicketByCode('{{ $ticket['booking_code'] }}')" class="px-3 py-1.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-[11px] font-black flex items-center gap-1.5 transition cursor-pointer">
                        <span>Buka Tiket</span>
                        <i class="fas fa-chevron-right text-[9px]"></i>
                    </button>
                </div>
            </div>
            @empty
            @if ($hasSearchedHistory)
            <div class="glass-panel rounded-2xl p-6 text-center border border-white/10 text-slate-400 space-y-2">
                <i class="fas fa-receipt text-3xl opacity-40"></i>
                <div class="text-xs font-bold text-white">Tidak Ada Riwayat Tiket</div>
                <p class="text-[11px]">Belum ada pemesanan untuk nomor WhatsApp ini.</p>
            </div>
            @endif
            @endforelse
        </div>
    </div>

    <!-- ================================================================================== -->
    <!-- VIEW 7: DEDICATED PROFILE VIEW (PROFIL & POIN PELANGGAN)                            -->
    <!-- ================================================================================== -->
    @elseif ($currentView === 'profile')
    <div class="space-y-4">
        @if ($isLoggedIn)
        <!-- Logged In Profile Card -->
        <div class="glass-card rounded-3xl p-5 border border-white/20 shadow-2xl relative overflow-hidden space-y-4">
            <div class="flex items-center gap-3.5">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center text-white shadow-xl shadow-blue-500/30 text-xl font-black font-mono border border-white/20">
                    {{ strtoupper(substr(trim($customerName), 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="text-[9px] text-blue-300 font-extrabold uppercase tracking-wider">Member Eksekutif</span>
                    </div>
                    <h3 class="text-base font-black text-white truncate leading-snug">{{ $customerName }}</h3>
                    <span class="text-xs text-slate-400 font-mono">{{ $customerPhone }}</span>
                </div>
            </div>

            <!-- Points Box -->
            <div class="p-3.5 rounded-2xl bg-gradient-to-r from-blue-600/20 to-indigo-600/20 border border-blue-500/30 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-base">
                        <i class="fas fa-coins"></i>
                    </div>
                    <div>
                        <span class="text-[10px] text-blue-200/80 font-bold uppercase tracking-wider block">Poin Loyalti Anda</span>
                        <strong class="text-lg font-black text-white font-mono">{{ $customerPoints }} Poin</strong>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[9px] font-bold text-emerald-300 bg-emerald-500/15 border border-emerald-400/30">
                    Aktif
                </span>
            </div>

            <div class="text-[10px] text-slate-300 bg-white/5 p-3 rounded-xl border border-white/10 flex items-center gap-2">
                <i class="fas fa-gift text-blue-400 text-xs shrink-0"></i>
                <span>Dapatkan <strong>+25 Poin</strong> setiap perjalanan berhasil. Kumpulkan 100 Poin untuk potongan langsung Rp 20.000!</span>
            </div>

            <!-- Edit Profile Form -->
            <div class="pt-2 border-t border-white/10 space-y-2">
                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider">Ubah Nama Lengkap</label>
                <div class="flex gap-2">
                    <input type="text" wire:model.defer="customerName" class="flex-1 h-10 bg-white/5 border border-white/10 rounded-xl px-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 font-medium">
                    <button type="button" wire:click="updateProfileName" class="h-10 px-3.5 rounded-xl bg-blue-600 hover:bg-blue-500 text-white text-xs font-black transition cursor-pointer">
                        Simpan
                    </button>
                </div>
            </div>
        </div>

        <!-- Account Actions Navigation List -->
        <div class="glass-panel rounded-2xl p-2 border border-white/10 divide-y divide-white/5 space-y-1">
            <button type="button" wire:click="switchView('history')" class="w-full p-3 rounded-xl hover:bg-white/5 flex items-center justify-between text-left transition cursor-pointer">
                <div class="flex items-center gap-3">
                    <i class="fas fa-receipt text-blue-400 text-sm w-5 text-center"></i>
                    <span class="text-xs font-bold text-white">Tiket & Riwayat Perjalanan Saya</span>
                </div>
                <i class="fas fa-chevron-right text-slate-500 text-xs"></i>
            </button>

            <button type="button" wire:click="switchView('home')" class="w-full p-3 rounded-xl hover:bg-white/5 flex items-center justify-between text-left transition cursor-pointer">
                <div class="flex items-center gap-3">
                    <i class="fas fa-van-shuttle text-blue-400 text-sm w-5 text-center"></i>
                    <span class="text-xs font-bold text-white">Pesan Shuttle Ciamis - Bandung</span>
                </div>
                <i class="fas fa-chevron-right text-slate-500 text-xs"></i>
            </button>

            <button type="button" wire:click="switchView('charter')" class="w-full p-3 rounded-xl hover:bg-white/5 flex items-center justify-between text-left transition cursor-pointer">
                <div class="flex items-center gap-3">
                    <i class="fas fa-car text-blue-400 text-sm w-5 text-center"></i>
                    <span class="text-xs font-bold text-white">Sewa Mobil Eksekutif (Charter)</span>
                </div>
                <i class="fas fa-chevron-right text-slate-500 text-xs"></i>
            </button>

            <a href="https://wa.me/6281234567890" target="_blank" class="w-full p-3 rounded-xl hover:bg-white/5 flex items-center justify-between text-left transition cursor-pointer">
                <div class="flex items-center gap-3">
                    <i class="fab fa-whatsapp text-emerald-400 text-sm w-5 text-center"></i>
                    <span class="text-xs font-bold text-white">Bantuan CS Rivian Travel</span>
                </div>
                <i class="fas fa-external-link-alt text-slate-500 text-xs"></i>
            </a>

            <button type="button" wire:click="logoutCustomer" class="w-full p-3 rounded-xl hover:bg-red-500/10 flex items-center justify-between text-left transition cursor-pointer group">
                <div class="flex items-center gap-3">
                    <i class="fas fa-sign-out-alt text-red-400 text-sm w-5 text-center"></i>
                    <span class="text-xs font-bold text-red-300 group-hover:text-red-200">Keluar Akun</span>
                </div>
                <i class="fas fa-chevron-right text-red-400/50 text-xs"></i>
            </button>
        </div>
        @else
        <!-- Guest State: Prompt to Login / Register -->
        <div class="glass-card rounded-3xl p-5 border border-white/20 shadow-2xl space-y-4 text-center">
            <div class="w-16 h-16 rounded-2xl bg-blue-500/20 text-blue-400 border border-blue-500/30 flex items-center justify-center text-2xl mx-auto shadow-xl shadow-blue-500/20">
                <i class="fas fa-user-shield"></i>
            </div>
            <div>
                <h3 class="text-sm font-black text-white">Masuk / Daftar Akun Pelanggan</h3>
                <p class="text-[11px] text-slate-300 mt-1 leading-relaxed">Cukup gunakan nomor WhatsApp untuk melihat riwayat tiket, kumpulkan poin loyalitas, dan pemesanan otomatis lebih cepat.</p>
            </div>

            <form wire:submit.prevent="handleCustomerAuthSubmit" class="space-y-3 text-left">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nomor WhatsApp *</label>
                    <div class="relative flex items-center">
                        <i class="fab fa-whatsapp absolute left-3.5 text-emerald-400 text-xs"></i>
                        <input type="tel" wire:model.defer="authPhone" required placeholder="081234567890" class="w-full h-11 bg-white/5 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 font-mono">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                    <div class="relative flex items-center">
                        <i class="far fa-user absolute left-3.5 text-slate-500 text-xs"></i>
                        <input type="text" wire:model.defer="authName" required placeholder="Contoh: Budi Santoso" class="w-full h-11 bg-white/5 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 font-medium">
                    </div>
                </div>

                <div class="glass-panel rounded-xl p-2.5 border border-blue-500/30 bg-blue-500/10 text-[10px] text-blue-300 flex items-center gap-2">
                    <i class="fas fa-gift text-blue-400 text-xs shrink-0"></i>
                    <span>Pelanggan baru otomatis mendapatkan <strong class="text-white">+50 Poin Loyalti</strong>!</span>
                </div>

                <button type="submit" class="w-full h-11 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 active:scale-[0.99] transition cursor-pointer">
                    <span>Masuk / Daftar Sekarang</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </button>
            </form>
        </div>
        @endif
    </div>
    @endif

    <!-- ================================================================================== -->
    <!-- MODAL 1: QRIS INSTANT POPUP MODAL                                                  -->
    <!-- ================================================================================== -->
    @if ($isQrisModalOpen && $qrisData)
    <div class="fixed inset-0 bg-black/85 backdrop-blur-md z-50 flex items-center justify-center p-4">
        <div class="w-full max-w-sm glass-card rounded-3xl border border-white/20 p-5 space-y-4 shadow-2xl relative text-center">
            <!-- Header -->
            <div class="flex items-center justify-between pb-2 border-b border-white/10">
                <span class="px-2.5 py-0.5 rounded-full text-[9px] font-black uppercase text-emerald-300 bg-emerald-500/15 border border-emerald-400/30">
                    QRIS Dynamic
                </span>
                <button type="button" wire:click="closeQrisModal" class="w-7 h-7 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white text-sm transition cursor-pointer">&times;</button>
            </div>

            <div>
                <h3 class="text-sm font-black text-white">Scan & Bayar via QRIS</h3>
                <p class="text-[10px] text-slate-400 mt-0.5">Dukung BCA, Mandiri, BRI, BNI, Dana, GoPay, OVO, ShopeePay</p>
            </div>

            <!-- QR Box -->
            <div class="w-48 h-48 mx-auto bg-white p-3 rounded-2xl shadow-xl flex items-center justify-center">
                @if (!empty($qrisData['qris_image_url']))
                <img src="{{ $qrisData['qris_image_url'] }}" alt="QRIS Code" class="w-full h-full object-contain">
                @elseif (!empty($qrisData['qris_payload']))
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode($qrisData['qris_payload']) }}" alt="QRIS Code" class="w-full h-full object-contain">
                @else
                <div class="text-slate-500 text-xs font-bold">QRIS Siap Discan</div>
                @endif
            </div>

            <!-- Total Amount -->
            <div class="p-2.5 rounded-xl bg-blue-500/10 border border-blue-500/20">
                <span class="text-[10px] text-slate-400 block font-bold">Total Pembayaran:</span>
                <strong class="text-lg font-black text-blue-400 font-mono">{{ $qrisData['formatted_amount'] }}</strong>
            </div>

            <!-- Action Button -->
            <button type="button" wire:click="confirmPayment" class="w-full h-11 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-emerald-500/25 flex items-center justify-center gap-2 active:scale-[0.99] transition cursor-pointer">
                <i class="fas fa-check-circle"></i>
                <span>Saya Sudah Bayar</span>
            </button>
        </div>
    </div>
    @endif

    <!-- ================================================================================== -->
    <!-- MODAL 2: CUSTOMER AUTH MODAL                                                       -->
    <!-- ================================================================================== -->
    @if ($isAuthModalOpen)
    <div class="fixed inset-0 bg-black/85 backdrop-blur-md z-50 flex items-end sm:items-center justify-center p-0 sm:p-4">
        <div class="w-full sm:max-w-sm glass-card rounded-t-3xl sm:rounded-3xl border border-white/20 p-5 space-y-3.5 shadow-2xl relative text-left">
            <div class="flex items-center justify-between pb-2 border-b border-white/10">
                <strong class="text-xs font-black text-white">Akun & Poin Pelanggan</strong>
                <button type="button" wire:click="closeCustomerAuthModal" class="w-7 h-7 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white text-sm transition cursor-pointer">&times;</button>
            </div>

            @if ($authError)
            <div class="p-2 rounded-xl bg-red-500/20 border border-red-500/30 text-[10px] text-red-200 font-bold">
                {{ $authError }}
            </div>
            @endif

            <form wire:submit.prevent="handleCustomerAuthSubmit" class="space-y-3">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nomor WhatsApp Aktif *</label>
                    <div class="relative flex items-center">
                        <i class="fab fa-whatsapp absolute left-3.5 text-emerald-400 text-xs"></i>
                        <input type="tel" wire:model.defer="authPhone" required placeholder="081234567890" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 font-mono">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1.5">Nama Lengkap *</label>
                    <div class="relative flex items-center">
                        <i class="far fa-user absolute left-3.5 text-slate-500 text-xs"></i>
                        <input type="text" wire:model.defer="authName" required placeholder="Contoh: Budi Santoso" class="w-full h-10 bg-black/30 border border-white/10 rounded-xl pl-9 pr-3 text-xs text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 font-medium">
                    </div>
                </div>

                <div class="glass-panel rounded-xl p-2.5 border border-blue-500/30 bg-blue-500/10 text-[10px] text-blue-300 flex items-center gap-2">
                    <i class="fas fa-gift text-blue-400 text-xs shrink-0"></i>
                    <span>Pelanggan baru otomatis mendapatkan <strong class="text-white">+50 Poin Loyalti</strong>!</span>
                </div>

                <button type="submit" class="w-full h-11 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-extrabold text-xs rounded-xl shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 active:scale-[0.99] transition cursor-pointer">
                    <span>Masuk Akun</span>
                    <i class="fas fa-arrow-right text-[10px]"></i>
                </button>
            </form>
        </div>
    </div>
    @endif

    <!-- ================================================================================== -->
    <!-- 4. DOCKED MOBILE BOTTOM NAVIGATION BAR                                             -->
    <!-- ================================================================================== -->
    <nav class="fixed bottom-0 left-0 w-full glass-panel border-t border-white/10 z-40 shadow-[0_-8px_32px_rgba(0,0,0,0.5)]">
        <div class="max-w-md mx-auto flex justify-around items-center px-4 py-2.5">
            <button type="button" wire:click="switchView('home')" class="flex flex-col items-center gap-1 transition-colors cursor-pointer py-1 {{ $currentView === 'home' ? 'text-blue-400 font-bold' : 'text-slate-400 hover:text-blue-300' }}">
                <i class="fas fa-house text-lg"></i>
                <span class="text-[10px]">Home</span>
            </button>
            <button type="button" wire:click="switchView('history')" class="flex flex-col items-center gap-1 transition-colors cursor-pointer py-1 {{ $currentView === 'history' ? 'text-blue-400 font-bold' : 'text-slate-400 hover:text-blue-300' }}">
                <i class="fas fa-receipt text-lg"></i>
                <span class="text-[10px]">Tiket Saya</span>
            </button>
            <a href="https://wa.me/6281234567890" target="_blank" class="flex flex-col items-center gap-1 text-slate-400 hover:text-emerald-400 transition-colors cursor-pointer py-1">
                <i class="fab fa-whatsapp text-lg text-emerald-400"></i>
                <span class="text-[10px]">WhatsApp</span>
            </a>
            <button type="button" wire:click="switchView('profile')" class="flex flex-col items-center gap-1 transition-colors cursor-pointer py-1 {{ $currentView === 'profile' ? 'text-blue-400 font-bold' : 'text-slate-400 hover:text-blue-300' }}">
                <i class="fas fa-user text-lg"></i>
                <span class="text-[10px]">{{ $isLoggedIn ? 'Profil' : 'Akun' }}</span>
            </button>
        </div>
    </nav>

    <!-- Browser Geolocation Helper Script -->
    <script>
        function detectUserLocation(target) {
            if (!navigator.geolocation) {
                alert('Fitur GPS tidak didukung di browser ini.');
                return;
            }

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        try {
                            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                            const data = await res.json();
                            const address = data.display_name || `Lokasi GPS: ${lat.toFixed(5)}, ${lng.toFixed(5)}`;
                            @this.set('pickupAddress', address);
                        } catch (e) {
                            @this.set('pickupAddress', `Lokasi GPS: ${lat.toFixed(5)}, ${lng.toFixed(5)}`);
                        }
                    }
                    , (err) => {
                        alert('Tidak dapat mendeteksi lokasi GPS: ' + err.message);
                    }, {
                        enableHighAccuracy: true
                        , timeout: 10000
                    }
            );
        }

    </script>

</div>
