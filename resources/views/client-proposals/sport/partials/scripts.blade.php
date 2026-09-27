<script>
    // Global State for Landing Page
    let landingState = {
        selectedSport: 'all'
        , selectedDate: document.getElementById('heroBookingDate')?.value || new Date().toISOString().split('T')[0]
        , activeModalCourt: null
        , modalSelectedSlots: []
        , currentOrder: null
    };

    document.addEventListener('DOMContentLoaded', () => {
        renderCourtsGrid();
        setDefaultWebSampleIfEmpty();
    });

    function toggleMobileNav() {
        const menu = document.getElementById('mobileMenu');
        const icon = document.getElementById('navIcon');
        if (menu) {
            menu.classList.toggle('hidden');
            if (icon) {
                icon.className = menu.classList.contains('hidden') ? 'fas fa-bars' : 'fas fa-times';
            }
        }
    }

    function selectSportCategory(sportId) {
        landingState.selectedSport = sportId;
        const courtSection = document.getElementById('lapangan');
        if (courtSection) {
            courtSection.scrollIntoView({
                behavior: 'smooth'
            });
        }
        filterCourtSport(sportId);
    }

    function executeHeroSearch() {
        const sportSelect = document.getElementById('heroSportSelect');
        const dateInput = document.getElementById('heroBookingDate');

        if (sportSelect) landingState.selectedSport = sportSelect.value;
        if (dateInput) {
            landingState.selectedDate = dateInput.value;
            const liveDate = document.getElementById('courtsLiveDate');
            if (liveDate) liveDate.value = dateInput.value;
        }

        const courtSection = document.getElementById('lapangan');
        if (courtSection) {
            courtSection.scrollIntoView({
                behavior: 'smooth'
            });
        }
        filterCourtSport(landingState.selectedSport);
    }

    function handleLiveDateChange(val) {
        landingState.selectedDate = val;
        renderCourtsGrid();
    }

    function filterCourtSport(sportId) {
        landingState.selectedSport = sportId;

        // Update Buttons Styling
        const buttons = document.querySelectorAll('.court-tab-btn');
        buttons.forEach(btn => {
            if (btn.dataset.sport === sportId) {
                btn.className = 'court-tab-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-emerald-500 text-slate-950 whitespace-nowrap transition cursor-pointer';
            } else {
                btn.className = 'court-tab-btn px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-slate-900 text-slate-300 hover:text-white border border-slate-800 whitespace-nowrap transition cursor-pointer';
            }
        });

        renderCourtsGrid();
    }

    function renderCourtsGrid() {
        const container = document.getElementById('courtsDisplayGrid');
        if (!container || !SPORT_DATABASE || !SPORT_DATABASE.sports) return;
        container.innerHTML = '';

        let courtsList = [];

        SPORT_DATABASE.sports.forEach(sport => {
            if (landingState.selectedSport === 'all' || landingState.selectedSport === sport.id) {
                sport.courts.forEach(court => {
                    courtsList.push({
                        ...court
                        , sport_id: sport.id
                        , sport_name: sport.name
                    });
                });
            }
        });

        courtsList.forEach(court => {
            const card = document.createElement('div');
            card.className = 'bg-slate-900/80 border border-slate-800 rounded-2xl p-4 hover:border-slate-700 transition flex flex-col justify-between';

            card.innerHTML = `
                <div>
                    <div class="flex items-center justify-between pb-2 mb-2 border-b border-slate-800">
                        <div>
                            <span class="text-[9px] font-semibold uppercase text-emerald-400 block">${court.sport_name}</span>
                            <h4 class="text-xs font-bold text-white">${court.name}</h4>
                        </div>
                        <span class="text-[10px] text-slate-400 bg-slate-950 px-2 py-0.5 rounded border border-slate-800 font-mono">
                            ${court.id}
                        </span>
                    </div>

                    <p class="text-[11px] text-slate-400 mb-3">
                        ${court.type}
                    </p>

                    <div class="bg-slate-950 p-2.5 rounded-xl border border-slate-800/80 mb-3 space-y-1 text-xs">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[10px]">Non-Peak (06-15 WIB)</span>
                            <span class="font-medium text-slate-200 text-[11px]">Rp ${court.price_regular.toLocaleString('id-ID')}/jam</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400 text-[10px]">Prime Time (16-24 WIB)</span>
                            <span class="font-bold text-emerald-400 text-[11px]">Rp ${court.price_peak.toLocaleString('id-ID')}/jam</span>
                        </div>
                    </div>
                </div>

                <div class="pt-1">
                    <button type="button" onclick="openBookingModal('${court.id}')" class="w-full py-2 rounded-lg bg-slate-800 hover:bg-emerald-500 hover:text-slate-950 text-slate-200 font-semibold text-xs transition flex items-center justify-center gap-1.5 cursor-pointer">
                        <span>Pilih Jam & Booking</span>
                        <i class="fas fa-arrow-right text-[9px]"></i>
                    </button>
                </div>
            `;
            container.appendChild(card);
        });
    }

    // ================= MULTI-STEP MODAL ENGINE =================
    function showModalStep(stepId) {
        ['modalStepForm', 'modalStepPayment', 'modalStepTicket', 'modalStepHistory'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                if (id === stepId) {
                    el.classList.remove('hidden');
                } else {
                    el.classList.add('hidden');
                }
            }
        });
    }

    function openBookingModal(courtId) {
        let foundCourt = null;
        let foundSport = null;

        SPORT_DATABASE.sports.forEach(sport => {
            sport.courts.forEach(c => {
                if (c.id === courtId) {
                    foundCourt = c;
                    foundSport = sport;
                }
            });
        });

        if (!foundCourt) return;

        landingState.activeModalCourt = {
            ...foundCourt
            , sport_name: foundSport.name
        };
        landingState.modalSelectedSlots = [];

        document.getElementById('modalSportTag').textContent = foundSport.name.toUpperCase();
        document.getElementById('modalCourtTitle').textContent = foundCourt.name;
        document.getElementById('modalCourtType').textContent = `${foundCourt.type} • Standar Kompetisi`;

        const modalDateInput = document.getElementById('modalBookingDate');
        if (modalDateInput) modalDateInput.value = landingState.selectedDate;

        updateModalSlots();
        showModalStep('modalStepForm');

        const modal = document.getElementById('bookingModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function closeBookingModal() {
        const modal = document.getElementById('bookingModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    function updateModalSlots() {
        const container = document.getElementById('modalSlotsContainer');
        if (!container || !SPORT_DATABASE || !SPORT_DATABASE.time_slots) return;
        container.innerHTML = '';

        landingState.modalSelectedSlots = [];

        SPORT_DATABASE.time_slots.forEach((slot, idx) => {
            const isBooked = [3, 7, 13].includes(idx);

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.dataset.time = slot.time;
            btn.dataset.peak = slot.is_peak ? '1' : '0';

            if (isBooked) {
                btn.className = 'p-1.5 rounded-lg bg-slate-950 text-slate-600 text-[9px] font-medium border border-slate-900 cursor-not-allowed text-center';
                btn.disabled = true;
                btn.innerHTML = `<span class="block">${slot.time}</span><span class="text-[8px] text-rose-500">Terisi</span>`;
            } else {
                btn.className = 'slot-choice-btn p-1.5 rounded-lg bg-slate-950 text-slate-300 hover:border-slate-700 text-[9px] font-medium border border-slate-800 text-center transition cursor-pointer';
                btn.innerHTML = `<span class="block">${slot.time}</span><span class="text-[8px] ${slot.is_peak ? 'text-amber-400' : 'text-emerald-400'}">${slot.is_peak ? 'Peak' : 'Reguler'}</span>`;
                btn.onclick = () => toggleModalSlot(btn, slot);
            }
            container.appendChild(btn);
        });

        calculateModalTotal();
    }

    function toggleModalSlot(btn, slot) {
        const index = landingState.modalSelectedSlots.findIndex(s => s.time === slot.time);
        if (index > -1) {
            landingState.modalSelectedSlots.splice(index, 1);
            btn.className = 'slot-choice-btn p-1.5 rounded-lg bg-slate-950 text-slate-300 hover:border-slate-700 text-[9px] font-medium border border-slate-800 text-center transition cursor-pointer';
        } else {
            if (landingState.modalSelectedSlots.length >= 3) {
                alert('Maksimal booking 3 jam per transaksi demo.');
                return;
            }
            landingState.modalSelectedSlots.push(slot);
            btn.className = 'slot-choice-btn p-1.5 rounded-lg bg-emerald-500 text-slate-950 text-[9px] font-bold border-2 border-emerald-400 text-center transition cursor-pointer';
        }

        const countLabel = document.getElementById('modalSelectedSlotCount');
        if (countLabel) countLabel.textContent = `${landingState.modalSelectedSlots.length} slot dipilih`;

        calculateModalTotal();
    }

    function calculateModalTotal() {
        const court = landingState.activeModalCourt;
        if (!court) return;

        let courtTotal = 0;
        landingState.modalSelectedSlots.forEach(slot => {
            courtTotal += slot.is_peak ? court.price_peak : court.price_regular;
        });

        let addonTotal = 0;
        const wasitChecked = document.getElementById('addonWasit')?.checked;
        const rompiChecked = document.getElementById('addonRompi')?.checked;
        const airChecked = document.getElementById('addonAir')?.checked;

        if (wasitChecked) addonTotal += 50000 * (landingState.modalSelectedSlots.length || 1);
        if (rompiChecked) addonTotal += 25000;
        if (airChecked) addonTotal += 35000;

        const grandTotal = courtTotal + addonTotal;

        const totalDisplay = document.getElementById('modalTotalPriceDisplay');
        const submitBtn = document.getElementById('btnSubmitModalBooking');

        if (totalDisplay) totalDisplay.textContent = `Rp ${grandTotal.toLocaleString('id-ID')}`;

        if (submitBtn) {
            if (landingState.modalSelectedSlots.length === 0) {
                submitBtn.disabled = true;
                submitBtn.className = 'px-4 py-2 rounded-lg bg-slate-800 text-slate-500 font-bold text-xs transition cursor-not-allowed flex items-center gap-1.5 shadow-sm';
            } else {
                submitBtn.disabled = false;
                submitBtn.className = 'px-4 py-2 rounded-lg bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-bold text-xs transition active:scale-95 flex items-center gap-1.5 cursor-pointer shadow-sm';
            }
        }
    }

    // Step 1 to Step 2 (QRIS)
    function proceedModalToPayment(e) {
        e.preventDefault();
        if (landingState.modalSelectedSlots.length === 0) return;

        const court = landingState.activeModalCourt;
        const dateVal = document.getElementById('modalBookingDate')?.value || landingState.selectedDate;
        const nameVal = document.getElementById('modalCustomerName')?.value.trim() || 'Andi Pratama';
        const teamVal = document.getElementById('modalCustomerTeam')?.value.trim() || 'Garuda FC';
        const phoneVal = document.getElementById('modalCustomerPhone')?.value.trim() || '081234567890';

        let courtTotal = 0;
        landingState.modalSelectedSlots.forEach(slot => {
            courtTotal += slot.is_peak ? court.price_peak : court.price_regular;
        });

        let addonTotal = 0;
        let addonsArr = [];
        if (document.getElementById('addonWasit')?.checked) {
            addonTotal += 50000 * landingState.modalSelectedSlots.length;
            addonsArr.push('Wasit');
        }
        if (document.getElementById('addonRompi')?.checked) {
            addonTotal += 25000;
            addonsArr.push('Rompi');
        }
        if (document.getElementById('addonAir')?.checked) {
            addonTotal += 35000;
            addonsArr.push('Air Mineral');
        }

        const grandTotal = courtTotal + addonTotal;
        const slotsText = landingState.modalSelectedSlots.map(s => s.time).join(', ');
        const bookingCode = 'SPT-' + Math.floor(100000 + Math.random() * 900000);

        landingState.currentOrder = {
            id: 'ORD-WEB-' + Date.now()
            , bookingCode: bookingCode
            , sportName: court.sport_name
            , courtName: court.name
            , courtType: court.type
            , leadName: nameVal
            , teamName: teamVal
            , phone: phoneVal
            , playDate: dateVal
            , slotsText: slotsText
            , slotCount: landingState.modalSelectedSlots.length
            , addons: addonsArr.join(', ') || 'Tanpa Add-on'
            , totalAmount: grandTotal
            , totalFormatted: `Rp ${grandTotal.toLocaleString('id-ID')}`
            , createdAt: new Date().toLocaleDateString('id-ID')
        };

        document.getElementById('modalQRISTotalAmount').textContent = landingState.currentOrder.totalFormatted;
        document.getElementById('modalQRISSubtitle').textContent = `${court.name} • ${landingState.currentOrder.slotCount} Jam • ${dateVal}`;

        showModalStep('modalStepPayment');
    }

    function returnModalToForm() {
        showModalStep('modalStepForm');
    }

    // Step 2 to Step 3 (Ticket Success)
    function simulateModalPaymentSuccess() {
        if (!landingState.currentOrder) return;

        // Save order to localStorage (shared with customer-demo mobile)
        saveWebOrderToHistory(landingState.currentOrder);
        const order = landingState.currentOrder;

        document.getElementById('modalTicketCode').textContent = order.bookingCode;
        document.getElementById('modalTicketSportBadge').textContent = order.sportName.toUpperCase() + ' ARENA';
        document.getElementById('modalTicketCourtName').textContent = order.courtName;
        document.getElementById('modalTicketDate').textContent = order.playDate;
        document.getElementById('modalTicketSlots').textContent = order.slotsText;
        document.getElementById('modalTicketLead').textContent = order.leadName;
        document.getElementById('modalTicketTeam').textContent = order.teamName;
        document.getElementById('modalTicketPrice').textContent = order.totalFormatted;

        showModalStep('modalStepTicket');
    }

    // Step 4 (History Viewer)
    function openHistoryModal() {
        loadWebHistoryList();
        showModalStep('modalStepHistory');

        const modal = document.getElementById('bookingModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function loadWebHistoryList() {
        const container = document.getElementById('modalHistoryList');
        const emptyBox = document.getElementById('modalEmptyHistory');
        if (!container) return;

        let history = JSON.parse(localStorage.getItem('apex_sport_orders') || '[]');
        container.innerHTML = '';

        if (history.length === 0) {
            if (emptyBox) emptyBox.classList.remove('hidden');
            return;
        } else {
            if (emptyBox) emptyBox.classList.add('hidden');
        }

        history.forEach(order => {
            const card = document.createElement('div');
            card.className = 'bg-slate-950 p-2.5 rounded-xl border border-slate-800 text-xs';
            card.innerHTML = `
                <div class="flex items-center justify-between pb-1 mb-1 border-b border-slate-900">
                    <span class="font-bold text-white">${order.bookingCode}</span>
                    <span class="text-[9px] font-bold text-emerald-400 bg-emerald-500/10 px-1.5 py-0.2 rounded">LUNAS</span>
                </div>
                <div class="flex items-center justify-between font-semibold text-slate-200">
                    <span class="truncate">${order.courtName}</span>
                    <span class="text-emerald-400 font-bold">${order.totalFormatted}</span>
                </div>
                <p class="text-[10px] text-slate-400 mt-0.5">
                    ${order.playDate} • ${order.slotsText}
                </p>
                <div class="flex items-center justify-between pt-1.5 mt-1.5 border-t border-slate-900 text-[10px]">
                    <span class="text-slate-500">${order.createdAt}</span>
                    <button type="button" onclick="viewSpecificTicketInModal('${order.bookingCode}')" class="font-semibold text-emerald-400 hover:underline cursor-pointer">
                        Lihat E-Ticket ➔
                    </button>
                </div>
            `;
            container.appendChild(card);
        });
    }

    function viewSpecificTicketInModal(code) {
        let history = JSON.parse(localStorage.getItem('apex_sport_orders') || '[]');
        const order = history.find(o => o.bookingCode === code);
        if (!order) return;

        landingState.currentOrder = order;
        document.getElementById('modalTicketCode').textContent = order.bookingCode;
        document.getElementById('modalTicketSportBadge').textContent = order.sportName.toUpperCase() + ' ARENA';
        document.getElementById('modalTicketCourtName').textContent = order.courtName;
        document.getElementById('modalTicketDate').textContent = order.playDate;
        document.getElementById('modalTicketSlots').textContent = order.slotsText;
        document.getElementById('modalTicketLead').textContent = order.leadName;
        document.getElementById('modalTicketTeam').textContent = order.teamName;
        document.getElementById('modalTicketPrice').textContent = order.totalFormatted;

        showModalStep('modalStepTicket');
    }

    function saveWebOrderToHistory(order) {
        let history = JSON.parse(localStorage.getItem('apex_sport_orders') || '[]');
        history.unshift(order);
        localStorage.setItem('apex_sport_orders', JSON.stringify(history));
    }

    function setDefaultWebSampleIfEmpty() {
        let history = JSON.parse(localStorage.getItem('apex_sport_orders') || '[]');
        if (history.length === 0) {
            const sample = {
                id: 'ORD-SAMPLE-1'
                , bookingCode: 'SPT-882190'
                , sportName: 'Futsal'
                , courtName: 'Lapangan 1 (Vinyl Pro)'
                , courtType: 'Vinyl 8mm'
                , leadName: 'Andi Pratama'
                , teamName: 'Garuda Futsal Squad'
                , phone: '081234567890'
                , playDate: 'Hari Ini'
                , slotsText: '19:00 - 20:00 WIB'
                , slotCount: 1
                , addons: '1 Set Rompi'
                , totalAmount: 130600
                , totalFormatted: 'Rp 130.600'
                , createdAt: 'Hari ini'
            };
            saveWebOrderToHistory(sample);
        }
    }

    function resetWebSportOrders() {
        if (confirm('Reset semua riwayat transaksi demo?')) {
            localStorage.removeItem('apex_sport_orders');
            loadWebHistoryList();
        }
    }

    function shareModalTicketToWhatsApp() {
        if (!landingState.currentOrder) return;
        const o = landingState.currentOrder;
        const msg = `*E-TICKET RESMI BOOKING LAPANGAN - ${BRAND_NAME.toUpperCase()}*
----------------------------------------
*Kode Booking:* ${o.bookingCode}
*Status:* LUNAS (Siap Main)

*Detail Reservasi:*
• *Cabor:* ${o.sportName}
• *Lapangan:* ${o.courtName}
• *Tanggal:* ${o.playDate}
• *Jam:* ${o.slotsText}
• *Pemesan:* ${o.leadName} (${o.phone})
• *Tim:* ${o.teamName}
• *Add-on:* ${o.addons}
• *Total Biaya:* ${o.totalFormatted}

*Lokasi Arena:*
Jl. Boulevard Sport Arena No. 88 (Fasilitas Shower Air Panas & Parkir Luas).
----------------------------------------
_Tunjukkan pesan ini di meja resepsionis saat check-in._`;

        const url = `https://wa.me/${WA_NUMBER}?text=${encodeURIComponent(msg)}`;
        window.open(url, '_blank');
    }

</script>
