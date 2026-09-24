<script>
    let currentBooking = {
        scheduleId: null,
        fleetName: '',
        origin: '',
        destination: '',
        time: '',
        priceFormatted: '',
        totalSeats: 16,
        bookedSeats: [],
        selectedSeat: null,
        inclusionsText: ''
    };

    // Initialize Page Data from JSON Database
    document.addEventListener('DOMContentLoaded', () => {
        initRouteFilters();
        renderSchedules('all');
        renderFleets();
        renderMembershipTiers();
    });

    // Toggle Mobile Nav
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }

    // 1. Render Route Filter Buttons
    function initRouteFilters() {
        const container = document.getElementById('dynamicRouteFilters');
        if (!container || !TRAVEL_DATABASE.routes) return;
        container.innerHTML = '';

        TRAVEL_DATABASE.routes.forEach((route, index) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.dataset.routeId = route.id;
            btn.className = `route-tab-btn px-4 py-2 rounded-full text-xs font-bold transition-all flex items-center gap-2 ${
                index === 0 
                ? 'bg-slate-900 text-white shadow-sm' 
                : 'bg-white text-slate-700 border border-slate-200/80 hover:bg-slate-100'
            }`;
            btn.innerHTML = `<i class="fas ${route.icon} text-[11px]"></i> <span>${route.name}</span>`;
            btn.onclick = () => filterByRoute(route.id);
            container.appendChild(btn);
        });
    }

    // Filter Action
    function filterByRoute(routeId) {
        const buttons = document.querySelectorAll('.route-tab-btn');
        buttons.forEach(btn => {
            if (btn.dataset.routeId === routeId) {
                btn.className = 'route-tab-btn px-4 py-2 rounded-full text-xs font-bold transition-all bg-slate-900 text-white shadow-sm flex items-center gap-2';
            } else {
                btn.className = 'route-tab-btn px-4 py-2 rounded-full text-xs font-bold transition-all bg-white text-slate-700 border border-slate-200/80 hover:bg-slate-100 flex items-center gap-2';
            }
        });

        renderSchedules(routeId);
    }

    // 2. Render Schedules dynamically from JSON with Seat Progress Tracker
    function renderSchedules(routeFilter = 'all', originFilter = 'all', destFilter = 'all', timeFilter = 'all') {
        const container = document.getElementById('dynamicScheduleContainer');
        if (!container || !TRAVEL_DATABASE.schedules) return;
        container.innerHTML = '';

        let filtered = TRAVEL_DATABASE.schedules.filter(item => {
            const matchRoute = (routeFilter === 'all' || item.route_id === routeFilter);
            const matchOrigin = (originFilter === 'all' || item.origin.toLowerCase().includes(originFilter));
            const matchDest = (destFilter === 'all' || item.destination.toLowerCase().includes(destFilter));
            const matchTime = (timeFilter === 'all' || item.shift === timeFilter);
            return matchRoute && matchOrigin && matchDest && matchTime;
        });

        const alertBox = document.getElementById('noScheduleAlert');
        if (filtered.length === 0) {
            if (alertBox) alertBox.classList.remove('hidden');
            return;
        } else {
            if (alertBox) alertBox.classList.add('hidden');
        }

        filtered.forEach(item => {
            const bookedCount = item.booked_seats.length;
            const remainingSeats = item.total_seats - bookedCount;
            const percentage = Math.round((bookedCount / item.total_seats) * 100);

            let seatStatusBadge = '';
            if (remainingSeats <= 1) {
                seatStatusBadge = `<span class="text-[11px] font-bold text-rose-700 bg-rose-50 px-2.5 py-0.5 rounded-full border border-rose-200"><i class="fas fa-fire text-rose-500 mr-1"></i> Sisa 1 Kursi</span>`;
            } else if (remainingSeats <= 3) {
                seatStatusBadge = `<span class="text-[11px] font-bold text-amber-800 bg-amber-50 px-2.5 py-0.5 rounded-full border border-amber-200"><i class="fas fa-clock text-amber-600 mr-1"></i> Tersisa ${remainingSeats} Kursi</span>`;
            } else {
                seatStatusBadge = `<span class="text-[11px] font-bold text-emerald-800 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200"><i class="fas fa-chair text-emerald-600 mr-1"></i> Tersisa ${remainingSeats} Kursi</span>`;
            }

            // Inclusions chips
            const inclusionsChips = item.inclusions.slice(0, 3).map(inc =>
                `<span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 text-[10px] font-semibold"><i class="fas fa-check text-emerald-600 mr-1"></i>${inc}</span>`
            ).join(' ');

            const card = document.createElement('div');
            card.className = 'bg-white rounded-2xl p-5 sm:p-6 border border-slate-200/80 shadow-xs hover:border-slate-300 hover:shadow-md transition-all duration-200';
            card.innerHTML = `
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 lg:gap-6 items-center">
                    
                    <!-- Route & Departure Time -->
                    <div class="lg:col-span-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="px-2.5 py-0.5 rounded-md ${item.shift_badge || 'bg-slate-100 text-slate-700'} text-[10px] font-bold uppercase tracking-wider">
                                ${item.shift_label}
                            </span>
                            <span class="text-xs text-slate-400">•</span>
                            <span class="text-xs font-semibold text-slate-500">${item.fleet_name}</span>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="text-left">
                                <p class="text-xl sm:text-2xl font-bold text-slate-900">${item.departure_time.split(' ')[0]}</p>
                                <p class="text-xs font-semibold text-slate-600 mt-0.5">${item.origin}</p>
                            </div>
                            <div class="flex-1 flex items-center justify-center px-2">
                                <div class="w-full flex items-center">
                                    <div class="w-2 h-2 rounded-full bg-slate-400"></div>
                                    <div class="flex-1 h-[1.5px] bg-slate-200 relative">
                                        <i class="fas fa-arrow-right absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-slate-400 text-[9px] bg-white px-1"></i>
                                    </div>
                                    <div class="w-2 h-2 rounded-full bg-travel-700"></div>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-xl sm:text-2xl font-bold text-slate-900">${item.arrival_est.split(' ')[0]}</p>
                                <p class="text-xs font-semibold text-slate-600 mt-0.5">${item.destination.split(' ')[0]}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Fleet Specs & Inclusions -->
                    <div class="lg:col-span-3 border-t lg:border-t-0 lg:border-l border-slate-100 pt-3 lg:pt-0 lg:pl-6">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Fasilitas Termasuk</p>
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            ${inclusionsChips}
                        </div>
                        <p class="text-[11px] text-slate-500 mt-2">
                            <i class="fas fa-home text-slate-400 mr-1"></i> Antar jemput sampai alamat
                        </p>
                    </div>

                    <!-- Seat Quota Progress -->
                    <div class="lg:col-span-3 border-t lg:border-t-0 lg:border-l border-slate-100 pt-3 lg:pt-0 lg:pl-6">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="text-xs font-semibold text-slate-700">Ketersediaan</span>
                            ${seatStatusBadge}
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="h-full bg-slate-800 rounded-full transition-all duration-300" style="width: ${percentage}%"></div>
                        </div>
                        <p class="text-[11px] text-slate-500 mt-1.5 flex items-center justify-between">
                            <span>Total: ${item.total_seats} Kursi</span>
                            <span class="font-bold text-slate-700">${bookedCount} Terisi (${percentage}%)</span>
                        </p>
                    </div>

                    <!-- Price & CTA -->
                    <div class="lg:col-span-2 border-t lg:border-t-0 lg:border-l border-slate-100 pt-3 lg:pt-0 lg:pl-6 text-left lg:text-right flex flex-row lg:flex-col justify-between items-center lg:items-end gap-2.5">
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase font-bold">Tarif All-In</p>
                            <p class="text-lg sm:text-xl font-bold text-slate-900">${item.price_formatted}</p>
                        </div>
                        <button type="button" onclick="openSeatModalById(${item.id})" class="w-auto sm:w-full px-4 py-2.5 rounded-xl bg-travel-700 hover:bg-travel-800 text-white text-xs font-bold shadow-sm transition-all active:scale-95 flex items-center justify-center gap-1.5">
                            <i class="fas fa-chair text-xs"></i> <span>Pilih Kursi</span>
                        </button>
                    </div>

                </div>
            `;
            container.appendChild(card);
        });
    }

    // 3. Render Fleets dynamically from JSON
    function renderFleets() {
        const grid = document.getElementById('dynamicFleetGrid');
        if (!grid || !TRAVEL_DATABASE.fleets) return;
        grid.innerHTML = '';

        TRAVEL_DATABASE.fleets.forEach(fleet => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-2xl overflow-hidden border border-slate-200/80 shadow-xs hover:shadow-md transition-all duration-200 flex flex-col justify-between group';
            card.innerHTML = `
                <div>
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img src="${fleet.photo}" alt="${fleet.name}" class="w-full h-full object-cover transform group-hover:scale-103 transition-transform duration-500">
                        <span class="absolute top-3 left-3 bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-md">
                            ${fleet.badge}
                        </span>
                        <span class="absolute bottom-3 right-3 bg-white/90 backdrop-blur-md text-slate-900 text-xs font-bold px-2.5 py-1 rounded-md shadow-xs">
                            ${fleet.capacity}
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-bold text-base text-slate-900 mb-1">${fleet.name}</h3>
                        <p class="text-xs text-travel-700 font-semibold mb-2.5 flex items-center gap-1.5">
                            <i class="fas fa-route text-slate-400"></i> ${fleet.main_routes}
                        </p>
                        <p class="text-xs text-slate-500 mb-3.5 leading-relaxed">${fleet.specs}</p>
                        
                        <ul class="space-y-1.5 text-xs text-slate-600 border-t border-slate-100 pt-3">
                            ${fleet.benefits.map(b => `<li class="flex items-center gap-2"><i class="fas fa-check text-emerald-600 text-xs"></i> ${b}</li>`).join('')}
                        </ul>
                    </div>
                </div>
                <div class="p-5 pt-0">
                    <a href="#jadwal" class="block text-center w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-900 hover:text-white text-slate-700 text-xs font-bold transition">
                        Cek Jadwal Armada Ini
                    </a>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    // 4. Render Membership Tiers dynamically from JSON
    function renderMembershipTiers() {
        const grid = document.getElementById('dynamicMembershipGrid');
        if (!grid || !TRAVEL_DATABASE.membership_tiers) return;
        grid.innerHTML = '';

        TRAVEL_DATABASE.membership_tiers.forEach(tier => {
            const card = document.createElement('div');
            const isPop = tier.is_popular;

            card.className = `rounded-2xl p-6 flex flex-col justify-between transition-all duration-200 relative ${
                isPop 
                ? 'border-2 border-amber-400 bg-amber-50/20 shadow-md' 
                : 'border border-slate-200/80 bg-white hover:border-slate-300 shadow-xs'
            }`;

            card.innerHTML = `
                <div>
                    ${isPop ? '<span class="absolute -top-3 left-1/2 -translate-x-1/2 bg-amber-500 text-slate-950 text-[9px] font-extrabold uppercase tracking-wider px-3 py-0.5 rounded-full shadow-xs">PALING FAVORIT</span>' : ''}
                    
                    <div class="flex items-center justify-between gap-2 mb-3 mt-1">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-bold uppercase tracking-wider border ${tier.badge_color}">
                            <i class="fas ${tier.icon || 'fa-award'} text-[10px]"></i> ${tier.tier}
                        </span>
                    </div>

                    <h3 class="font-bold text-xl text-slate-900 mb-0.5 tracking-tight">${tier.points_needed}</h3>
                    <p class="text-xs text-slate-500 mb-4">${tier.criteria}</p>
                    
                    <div class="space-y-2 text-xs text-slate-600 border-t border-slate-100 pt-3.5">
                        ${tier.benefits.map(b => `
                            <div class="flex items-start gap-2">
                                <span class="w-3.5 h-3.5 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0 text-[8px] mt-0.5 font-bold">
                                    <i class="fas fa-check"></i>
                                </span>
                                <span class="leading-relaxed font-medium">${b}</span>
                            </div>
                        `).join('')}
                    </div>
                </div>
                
                <div class="pt-5 mt-5 border-t border-slate-100">
                    <a href="https://wa.me/${WA_NUMBER}?text=${encodeURIComponent('Halo ' + BRAND_NAME + ', saya ingin info membership ' + tier.tier + '.')}" target="_blank" class="block w-full py-2.5 text-center rounded-xl font-bold text-xs transition-all ${tier.btn_theme || 'bg-slate-100 hover:bg-slate-200 text-slate-800'}">
                        Pilih Tier Ini
                    </a>
                </div>
            `;
            grid.appendChild(card);
        });
    }

    // Handle Schedule Search Form (From Hero Widget)
    function handleScheduleSearch(e) {
        e.preventDefault();
        const origin = document.getElementById('searchOrigin').value.toLowerCase();
        const destination = document.getElementById('searchDestination').value.toLowerCase();
        const time = document.getElementById('searchTime').value.toLowerCase();

        renderSchedules('all', origin, destination, time);

        const target = document.getElementById('jadwal');
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    }

    // Open Seat Selection Modal from JSON ID
    function openSeatModalById(scheduleId) {
        const schedule = TRAVEL_DATABASE.schedules.find(s => s.id === scheduleId);
        if (!schedule) return;

        currentBooking.scheduleId = schedule.id;
        currentBooking.fleetName = schedule.fleet_name;
        currentBooking.origin = schedule.origin;
        currentBooking.destination = schedule.destination;
        currentBooking.time = schedule.departure_time;
        currentBooking.priceFormatted = schedule.price_formatted;
        currentBooking.totalSeats = schedule.total_seats;
        currentBooking.bookedSeats = schedule.booked_seats;
        currentBooking.selectedSeat = null;
        currentBooking.inclusionsText = schedule.inclusions.join(', ');

        document.getElementById('modalSubInfo').textContent = `${schedule.fleet_name} (${schedule.fleet_code}) • ${schedule.origin} ➔ ${schedule.destination} (${schedule.departure_time})`;
        document.getElementById('modalInclusionText').textContent = `Gratis Snack Box, Air Mineral Botol & Paket Makan di Rest Area Tol`;
        document.getElementById('modalTotalPrice').textContent = schedule.price_formatted;
        document.getElementById('selectedSeatBadge').textContent = 'Belum Dipilih';
        document.getElementById('selectedSeatBadge').className = 'text-amber-800 bg-amber-100 px-2.5 py-0.5 rounded-md font-bold text-xs';

        renderElfSeatGrid();

        const modal = document.getElementById('seatPickerModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeSeatModal() {
        const modal = document.getElementById('seatPickerModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    // Render Realistic Elf Long / Minibus Layout (Driver + Passenger 1 front, rows of seats)
    function renderElfSeatGrid() {
        const grid = document.getElementById('seatLayoutGrid');
        if (!grid) return;
        grid.innerHTML = '';

        // Row 1: Driver + Seat 1
        const driverDiv = document.createElement('div');
        driverDiv.className = 'col-span-2 p-2.5 rounded-xl bg-slate-100 text-slate-500 font-bold text-center text-xs flex items-center justify-center gap-1.5 border border-slate-200';
        driverDiv.innerHTML = '<i class="fas fa-steering-wheel"></i> <span>Supir</span>';
        grid.appendChild(driverDiv);

        const seat1Booked = currentBooking.bookedSeats.includes(1);
        const seat1 = document.createElement('button');
        seat1.type = 'button';
        seat1.className = `col-span-2 p-2.5 rounded-xl font-bold text-xs flex items-center justify-center gap-1 transition ${
            seat1Booked 
            ? 'bg-slate-200 text-slate-400 cursor-not-allowed border border-slate-300' 
            : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-300'
        }`;
        seat1.innerHTML = seat1Booked ? 'K-01 (Terisi)' : '<i class="fas fa-chair"></i> K-01 (Depan)';
        if (!seat1Booked) {
            seat1.onclick = () => selectSeat(1, seat1);
        }
        grid.appendChild(seat1);

        // Remaining Seats (2 to totalSeats)
        for (let i = 2; i <= currentBooking.totalSeats; i++) {
            const isBooked = currentBooking.bookedSeats.includes(i);
            const seatBtn = document.createElement('button');
            seatBtn.type = 'button';
            seatBtn.dataset.seatNum = i;
            seatBtn.className = `p-2.5 rounded-xl font-bold text-xs flex items-center justify-center gap-1 transition ${
                isBooked 
                ? 'bg-slate-200 text-slate-400 cursor-not-allowed border border-slate-300' 
                : 'bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-300'
            }`;
            seatBtn.innerHTML = isBooked ? `K-${i < 10 ? '0'+i : i}` : `<i class="fas fa-chair"></i> K-${i < 10 ? '0'+i : i}`;

            if (!isBooked) {
                seatBtn.onclick = () => selectSeat(i, seatBtn);
            }
            grid.appendChild(seatBtn);
        }
    }

    // Select Seat
    function selectSeat(seatNumber, buttonElement) {
        currentBooking.selectedSeat = seatNumber;

        const allButtons = document.querySelectorAll('#seatLayoutGrid button');
        allButtons.forEach(btn => {
            if (!btn.classList.contains('cursor-not-allowed')) {
                btn.className = 'p-2.5 rounded-xl font-bold text-xs flex items-center justify-center gap-1 bg-emerald-50 text-emerald-800 hover:bg-emerald-100 border border-emerald-300 transition';
            }
        });

        buttonElement.className = 'p-2.5 rounded-xl font-bold text-xs flex items-center justify-center gap-1 bg-slate-900 text-white border-2 border-slate-950 shadow-sm transition';

        const badge = document.getElementById('selectedSeatBadge');
        badge.textContent = `Kursi K-${seatNumber < 10 ? '0' + seatNumber : seatNumber}`;
        badge.className = 'text-white bg-slate-900 px-2.5 py-0.5 rounded-md font-bold text-xs';
    }

    // Handle Confirmation Booking with WhatsApp
    function handleConfirmBooking(e) {
        e.preventDefault();

        if (!currentBooking.selectedSeat) {
            alert('Silakan pilih salah satu nomor kursi yang tersedia terlebih dahulu!');
            return;
        }

        const passengerName = document.getElementById('passengerName').value.trim();
        const passengerPhone = document.getElementById('passengerPhone').value.trim();
        const pickupAddress = document.getElementById('pickupAddress').value.trim();
        const dropoffAddress = document.getElementById('dropoffAddress').value.trim();

        const message = `*RESERVASI TIKET TRAVEL SHUTTLE - ${BRAND_NAME.toUpperCase()}*
----------------------------------------
*Nama Penumpang:* ${passengerName}
*No. WhatsApp:* ${passengerPhone}

*Detail Perjalanan:*
• *Rute:* ${currentBooking.origin} ➔ ${currentBooking.destination}
• *Waktu Berangkat:* ${currentBooking.time}
• *Armada:* ${currentBooking.fleetName}
• *Nomor Kursi:* Kursi K-${currentBooking.selectedSeat < 10 ? '0' + currentBooking.selectedSeat : currentBooking.selectedSeat}
• *Tarif Tiket:* ${currentBooking.priceFormatted}

*Fasilitas Termasuk:*
✓ Gratis Paket Makan di Rest Area Tol
✓ Gratis Snack Box & Air Mineral Botol
✓ Door to Door Penjemputan ke Rumah
✓ Port USB Charger per Kursi + AC Dingin

*Poin Membership:* +100 Poin (Program 10x Naik Free 1 Tiket)

*Alamat Penjemputan (Door to Door):*
${pickupAddress}

*Alamat Tujuan:*
${dropoffAddress}
----------------------------------------
_Mohon konfirmasi ketersediaan kursi & detail pembayaran. Terima kasih._`;

        const waUrl = `https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(message)}`;
        window.open(waUrl, '_blank');
        closeSeatModal();
    }

    // Backdrop click
    window.onclick = function(event) {
        const modal = document.getElementById('seatPickerModal');
        if (event.target === modal) {
            closeSeatModal();
        }
    };
</script>
