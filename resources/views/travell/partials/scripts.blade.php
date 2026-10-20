<script id="dbSchedulesData" type="application/json">{!! json_encode($dbSchedulesList ?? []) !!}</script>

<script>
    var BRAND_NAME = "{{ $brandName ?? 'Rivian Travel' }}";
    var WA_PHONE = "{{ $waNumber ?? '6281234567890' }}";
    var CSRF_TOKEN = "{{ csrf_token() }}";
    var BOOKING_ROUTE = "{{ route('travell.book') }}";

    // Safe DOM Helpers (Prevents Formatter Syntax Errors)
    function getVal(id, fallback) {
        var el = document.getElementById(id);
        return (el && el.value !== undefined) ? el.value : (fallback || '');
    }

    function getText(id, fallback) {
        var el = document.getElementById(id);
        return (el && el.textContent) ? el.textContent : (fallback || '');
    }

    function setText(id, content) {
        var el = document.getElementById(id);
        if (el) el.textContent = content;
    }

    function getRadioVal(name, fallback) {
        var el = document.querySelector('input[name="' + name + '"]:checked');
        return (el && el.value) ? el.value : (fallback || '');
    }

    // Load schedules safely from JSON
    var dataEl = document.getElementById('dbSchedulesData');
    var DB_SCHEDULES = [];
    try {
        DB_SCHEDULES = JSON.parse(dataEl ? dataEl.textContent : '[]');
    } catch (e) {
        DB_SCHEDULES = [];
    }

    // App State
    var state = {
        activeView: 'viewHome',
        searchShift: 'all',
        selectedSchedule: null,
        selectedSeats: [],
        currentOrder: null,
        qrisTimer: null
    };

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Clock
        function updateClock() {
            var d = new Date();
            var h = String(d.getHours()).padStart(2, '0');
            var m = String(d.getMinutes()).padStart(2, '0');
            setText('statusBarClock', h + ':' + m);
        }
        updateClock();
        setInterval(updateClock, 30000);

        // Date input default to today
        var today = new Date().toISOString().split('T')[0];
        var dateInput = document.getElementById('homeDate');
        if (dateInput) {
            dateInput.min = today;
            if (!dateInput.value) dateInput.value = today;
        }

        // Render initial schedules, order history, and charter rates
        executeScheduleSearch();
        loadOrderHistory();
        updateCharterTotal();
    });

    // 1. View Navigation
    function switchView(viewId) {
        var views = ['viewHome', 'viewSchedules', 'viewSeatPicker', 'viewPassengerForm', 'viewPayment', 'viewSuccessTicket', 'viewHistory', 'viewCharter', 'viewPackage'];
        views.forEach(function(id) {
            var el = document.getElementById(id);
            if (!el) return;
            if (id === viewId) {
                el.classList.remove('hidden');
                el.classList.add('flex');
            } else {
                el.classList.add('hidden');
                el.classList.remove('flex');
            }
        });

        // Bottom nav styling
        var tabHome = document.getElementById('tabNavHome');
        var tabSchedules = document.getElementById('tabNavSchedules');
        var tabHistory = document.getElementById('tabNavHistory');
        if (tabHome && tabSchedules && tabHistory) {
            tabHome.className = 'nav-tab-btn flex flex-col items-center gap-0.5 cursor-pointer ' + (viewId === 'viewHome' ? 'text-sky-500 font-bold' : 'text-slate-400');
            tabSchedules.className = 'nav-tab-btn flex flex-col items-center gap-0.5 cursor-pointer ' + (viewId === 'viewSchedules' || viewId === 'viewSeatPicker' ? 'text-sky-500 font-bold' : 'text-slate-400');
            tabHistory.className = 'nav-tab-btn flex flex-col items-center gap-0.5 cursor-pointer ' + (viewId === 'viewHistory' || viewId === 'viewSuccessTicket' ? 'text-sky-500 font-bold' : 'text-slate-400');
        }

        state.activeView = viewId;
        var viewport = document.getElementById('appViewport');
        if (viewport) viewport.scrollTop = 0;
    }

    // 2. Route Search & Swap
    function swapOriginDestination() {
        var orig = document.getElementById('homeOrigin');
        var dest = document.getElementById('homeDestination');
        if (orig && dest) {
            var temp = orig.value;
            orig.value = dest.value;
            dest.value = temp;
        }
    }

    function quickSearchRoute(orig, dest) {
        var origSelect = document.getElementById('homeOrigin');
        var destSelect = document.getElementById('homeDestination');
        if (origSelect) origSelect.value = orig;
        if (destSelect) destSelect.value = dest;
        executeScheduleSearch();
    }

    function handleDateChange(val) {}

    // 3. Schedule Search & Filtering
    function executeScheduleSearch() {
        var orig = (getVal('homeOrigin', 'ciamis')).toLowerCase();
        var dest = (getVal('homeDestination', 'bandung')).toLowerCase();

        setText('schedulesRouteTitle', orig.toUpperCase() + ' ➔ ' + dest.toUpperCase());

        renderSchedulesList(orig, dest);
        if (state.activeView === 'viewHome') {
            switchView('viewSchedules');
        }
    }

    function filterScheduleShift(shift) {
        state.searchShift = shift;
        document.querySelectorAll('.shift-btn').forEach(function(btn) {
            if (btn.getAttribute('data-shift') === shift) {
                btn.className = 'shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-sky-500 text-white shadow-xs whitespace-nowrap shrink-0 transition cursor-pointer';
            } else {
                btn.className = 'shift-btn px-3 py-1.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-700 hover:bg-sky-50 hover:text-sky-700 whitespace-nowrap shrink-0 transition cursor-pointer';
            }
        });
        var orig = (getVal('homeOrigin', 'ciamis')).toLowerCase();
        var dest = (getVal('homeDestination', 'bandung')).toLowerCase();
        renderSchedulesList(orig, dest);
    }

    function renderSchedulesList(orig, dest) {
        var container = document.getElementById('schedulesListContainer');
        if (!container) return;

        var filtered = DB_SCHEDULES.filter(function(s) {
            var matchOrig = s.origin && s.origin.toLowerCase().indexOf(orig) !== -1;
            var matchDest = s.destination && s.destination.toLowerCase().indexOf(dest) !== -1;
            var matchShift = (state.searchShift === 'all' || s.shift === state.searchShift);
            return matchOrig && matchDest && matchShift;
        });

        if (filtered.length === 0) {
            filtered = DB_SCHEDULES.filter(function(s) {
                return state.searchShift === 'all' || s.shift === state.searchShift;
            });
        }

        if (filtered.length === 0) {
            container.innerHTML = '<div class="text-center py-10 bg-white rounded-2xl border border-dashed border-slate-200 p-6">' +
                '<i class="fa-solid fa-calendar-xmark text-3xl text-slate-300 mb-2"></i>' +
                '<p class="text-xs font-bold text-slate-700">Jadwal Tidak Ditemukan</p>' +
                '<p class="text-[11px] text-slate-500 mt-1">Silakan pilih waktu shift lain atau ubah rute kota tujuan.</p>' +
                '</div>';
            return;
        }

        container.innerHTML = filtered.map(function(s) {
            var bookedCount = (s.booked_seats && s.booked_seats.length) ? s.booked_seats.length : 0;
            var remaining = Math.max(0, 5 - bookedCount);
            return '<div class="bg-white rounded-2xl p-3.5 border border-slate-200/90 shadow-xs hover:border-sky-300 transition">' +
                '<div class="flex items-center justify-between pb-2 border-b border-slate-100 mb-2">' +
                '<div class="flex items-center gap-1.5">' +
                '<span class="w-2 h-2 rounded-full bg-emerald-500"></span>' +
                '<span class="text-xs font-black text-slate-900">' + (s.fleet_name || 'Daihatsu All New Xenia') + '</span>' +
                '</div>' +
                '<span class="text-[10px] font-bold text-sky-700 bg-sky-50 px-2 py-0.5 rounded-full border border-sky-100">Min. 4 Kursi Rombongan</span>' +
                '</div>' +
                '<div class="flex items-center justify-between my-2">' +
                '<div>' +
                '<p class="text-sm font-black text-slate-900">' + s.departure_time + '</p>' +
                '<p class="text-[10px] text-slate-500 font-medium">' + s.origin + '</p>' +
                '</div>' +
                '<div class="flex flex-col items-center px-3">' +
                '<span class="text-[9px] text-slate-400 font-semibold">3.5 jam</span>' +
                '<div class="w-16 h-0.5 bg-slate-200 relative my-1">' +
                '<i class="fa-solid fa-car text-[9px] text-sky-500 absolute -top-1.5 left-1/2 -translate-x-1/2"></i>' +
                '</div>' +
                '<span class="text-[9px] text-emerald-600 font-bold">Via Tol Door-to-Door</span>' +
                '</div>' +
                '<div class="text-right">' +
                '<p class="text-sm font-black text-slate-900">' + s.arrival_est + '</p>' +
                '<p class="text-[10px] text-slate-500 font-medium truncate max-w-[100px]">' + s.destination + '</p>' +
                '</div>' +
                '</div>' +
                '<div class="flex items-center justify-between pt-2.5 border-t border-slate-100">' +
                '<div>' +
                '<p class="text-[10px] text-slate-400">Harga per kursi</p>' +
                '<p class="text-sm font-black text-sky-600">' + (s.price_formatted || 'Rp 190.000') + '</p>' +
                '</div>' +
                '<button type="button" onclick="selectSchedule(' + s.id + ')" class="bg-sky-500 hover:bg-sky-600 active:scale-95 text-white px-3.5 py-1.5 rounded-xl font-bold text-xs shadow-xs transition flex items-center gap-1.5 cursor-pointer">' +
                '<span>Pilih Kursi</span>' +
                '<span class="text-[10px] bg-white/20 px-1.5 py-0.2 rounded-full">Sisa ' + remaining + '</span>' +
                '</button>' +
                '</div>' +
                '</div>';
        }).join('');
    }

    // 4. Seat Picker (Enforce Minimal 4 Kursi)
    function selectSchedule(scheduleId) {
        var schedule = null;
        for (var i = 0; i < DB_SCHEDULES.length; i++) {
            if (DB_SCHEDULES[i].id == scheduleId) {
                schedule = DB_SCHEDULES[i];
                break;
            }
        }
        if (!schedule) schedule = DB_SCHEDULES[0];

        state.selectedSchedule = schedule;
        state.selectedSeats = [];

        setText('seatPickerSubtitle', schedule.origin + ' ➔ ' + schedule.destination + ' • ' + schedule.departure_time);

        renderSeats(schedule);
        updateSeatSummary();
        switchView('viewSeatPicker');
    }

    function renderSeats(schedule) {
        var container = document.getElementById('interactiveSeatsGrid');
        if (!container) return;

        var booked = schedule.booked_seats || [];

        container.innerHTML = '<!-- Baris 1: Sopir + K-01 (Depan) -->' +
            '<div class="grid grid-cols-2 gap-3 mb-2.5">' +
            '<div class="p-3 rounded-xl border border-slate-200 bg-slate-100 flex flex-col items-center justify-center text-slate-400">' +
            '<i class="fa-solid fa-id-badge text-lg mb-1"></i>' +
            '<span class="text-[10px] font-bold">SOPIR</span>' +
            '</div>' +
            renderSingleSeat(1, booked.indexOf(1) !== -1, 'K-01 (Depan)') +
            '</div>' +
            '<!-- Baris 2: Kursi Tengah K-02 & K-03 -->' +
            '<div class="grid grid-cols-2 gap-3 mb-2.5">' +
            renderSingleSeat(2, booked.indexOf(2) !== -1, 'K-02 (Tengah)') +
            renderSingleSeat(3, booked.indexOf(3) !== -1, 'K-03 (Tengah)') +
            '</div>' +
            '<!-- Baris 3: Kursi Belakang K-04 & K-05 -->' +
            '<div class="grid grid-cols-2 gap-3">' +
            renderSingleSeat(4, booked.indexOf(4) !== -1, 'K-04 (Belakang)') +
            renderSingleSeat(5, booked.indexOf(5) !== -1, 'K-05 (Belakang)') +
            '</div>';
    }

    function renderSingleSeat(num, isBooked, label) {
        var isSelected = state.selectedSeats.indexOf(num) !== -1;
        if (isBooked) {
            return '<div class="p-3 rounded-xl border border-rose-200 bg-rose-50 flex flex-col items-center justify-center text-rose-300 cursor-not-allowed">' +
                '<i class="fa-solid fa-couch text-lg mb-1"></i>' +
                '<span class="text-[10px] font-bold">K-0' + num + ' (Terisi)</span>' +
                '</div>';
        }

        var borderBg = isSelected
            ? 'border-2 border-sky-500 bg-sky-500 text-white shadow-sm'
            : 'border border-slate-200 bg-white text-slate-700 hover:border-sky-300';

        var iconColor = isSelected ? 'text-white' : 'text-sky-500';

        return '<button type="button" onclick="toggleSeat(' + num + ')" class="p-3 rounded-xl ' + borderBg + ' flex flex-col items-center justify-center transition active:scale-95 cursor-pointer">' +
            '<i class="fa-solid fa-couch text-lg mb-1 ' + iconColor + '"></i>' +
            '<span class="text-[10px] font-bold">K-0' + num + '</span>' +
            '</button>';
    }

    function toggleSeat(seatNum) {
        var index = state.selectedSeats.indexOf(seatNum);
        if (index > -1) {
            state.selectedSeats.splice(index, 1);
        } else {
            state.selectedSeats.push(seatNum);
        }
        renderSeats(state.selectedSchedule);
        updateSeatSummary();
    }

    function updateSeatSummary() {
        var sched = state.selectedSchedule;
        var pricePerSeat = (sched && sched.price) ? sched.price : 190000;
        var count = state.selectedSeats.length;
        var total = count * pricePerSeat;
        var minRequired = (sched && sched.min_quota) ? sched.min_quota : 4;

        var countText = count > 0
            ? count + ' Kursi (K-0' + state.selectedSeats.slice().sort().join(', K-0') + ')'
            : 'Belum Ada Kursi';

        setText('selectedSeatsLabel', countText);
        setText('selectedSeatsTotalPrice', 'Rp ' + total.toLocaleString('id-ID'));

        var nextBtn = document.getElementById('btnContinueToPassenger');
        var btnLabel = document.getElementById('btnContinueLabel');

        if (nextBtn && btnLabel) {
            if (count < minRequired) {
                var missing = minRequired - count;
                nextBtn.disabled = true;
                nextBtn.className = 'w-full py-3 rounded-xl bg-slate-200 text-slate-400 font-bold text-xs transition flex items-center justify-center gap-2 whitespace-nowrap cursor-not-allowed';
                btnLabel.textContent = 'Pilih minimal ' + minRequired + ' kursi (Kurang ' + missing + ' lagi)';
            } else {
                nextBtn.disabled = false;
                nextBtn.className = 'w-full py-3 rounded-xl bg-gradient-to-r from-sky-500 to-sky-600 hover:from-sky-600 hover:to-sky-700 text-white font-bold text-xs shadow-md shadow-sky-500/20 transition flex items-center justify-center gap-2 whitespace-nowrap cursor-pointer active:scale-95';
                btnLabel.textContent = 'Lanjut Isi Data Penumpang (' + count + ' Kursi)';
            }
        }
    }

    // 5. Passenger Form & Booking Submission
    function proceedToPassengerForm() {
        var sched = state.selectedSchedule;
        var minRequired = (sched && sched.min_quota) ? sched.min_quota : 4;
        if (state.selectedSeats.length < minRequired) {
            alert('Pemberangkatan shuttle reguler minimal memesan ' + minRequired + ' kursi.');
            return;
        }

        var total = state.selectedSeats.length * ((sched && sched.price) ? sched.price : 190000);

        setText('formSummaryRoute', sched.origin + ' ➔ ' + sched.destination);
        setText('formSummarySeatsBadge', state.selectedSeats.length + ' Kursi (K-0' + state.selectedSeats.slice().sort().join(', K-0') + ')');
        setText('formSummaryFleet', (sched.fleet_name || 'Daihatsu All New Xenia') + ' (' + sched.departure_time + ')');

        setText('passengerSummaryRoute', sched.origin + ' ➔ ' + sched.destination + ' (' + sched.departure_time + ')');
        setText('passengerSummarySeats', 'Kursi Terpilih: K-0' + state.selectedSeats.slice().sort().join(', K-0'));
        setText('passengerSummaryTotal', 'Rp ' + total.toLocaleString('id-ID'));

        switchView('viewPassengerForm');
    }

    async function proceedToPayment(e) {
        e.preventDefault();

        var name = (getVal('custName') || getVal('passengerName')).trim();
        var phone = (getVal('custPhone') || getVal('passengerPhone')).trim();
        var pickup = (getVal('custPickup') || getVal('passengerPickup')).trim();
        var dropoff = (getVal('custDropoff') || getVal('passengerDropoff')).trim();

        if (!name || !phone || !pickup || !dropoff) {
            alert('Lengkapi seluruh data penumpang dan alamat penjemputan.');
            return;
        }

        var sched = state.selectedSchedule;
        var minRequired = (sched && sched.min_quota) ? sched.min_quota : 4;
        if (state.selectedSeats.length < minRequired) {
            alert('Pemesanan shuttle reguler minimal ' + minRequired + ' kursi.');
            return;
        }

        var total = state.selectedSeats.length * ((sched && sched.price) ? sched.price : 190000);
        var bookingCode = 'RVN-' + Math.floor(100000 + Math.random() * 900000);
        var qrisPayload = null;
        var qrisImageUrl = null;
        var finalTotalFormatted = 'Rp ' + total.toLocaleString('id-ID');

        // Show loading state
        var submitBtn = document.getElementById('btnSubmitMobileBooking') || document.getElementById('btnSubmitPassengerForm');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-sm mr-2"></i> Menyiapkan QRIS Dinamis...';
        }

        try {
            var formData = new FormData();
            formData.append('_token', CSRF_TOKEN);
            formData.append('booking_type', 'reguler');
            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('schedule_id', (sched && sched.id) ? sched.id : '');
            formData.append('total_passengers', state.selectedSeats.length);
            formData.append('pickup_address', pickup);
            formData.append('dropoff_address', dropoff);
            formData.append('notes', 'Kursi: K-0' + state.selectedSeats.slice().sort().join(', K-0'));

            // Append seat numbers array
            state.selectedSeats.forEach(function(s) {
                formData.append('seats[]', s);
            });

            var res = await fetch(BOOKING_ROUTE, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: formData
            });
            var data = await res.json();
            if (data && data.success && data.data) {
                bookingCode = data.data.booking_code || bookingCode;
                qrisPayload = data.data.qris_payload || null;
                qrisImageUrl = data.data.qris_image_url || null;
                if (data.data.formatted_amount) {
                    finalTotalFormatted = data.data.formatted_amount;
                }
            } else if (data && !data.success && data.message) {
                alert(data.message);
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span>Lanjut ke Pembayaran QRIS</span> <i class="fas fa-arrow-right text-[10px]"></i>';
                }
                return;
            }
        } catch (err) {
            console.log('Error creating booking:', err);
        }

        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Lanjut ke Pembayaran QRIS</span> <i class="fas fa-arrow-right text-[10px]"></i>';
        }

        state.currentOrder = {
            id: 'ORD-' + Date.now(),
            bookingCode: bookingCode,
            orderType: 'REGULER',
            passengerName: name,
            phone: phone,
            origin: sched.origin,
            destination: sched.destination,
            departureTime: sched.departure_time,
            departureDate: (sched && sched.date) ? sched.date : new Date().toISOString().split('T')[0],
            seats: state.selectedSeats.slice().sort().map(function(s) { return 'K-0' + s; }).join(', '),
            pickupAddress: pickup,
            dropoffAddress: dropoff,
            fleetName: (sched && sched.fleet_name) ? sched.fleet_name : 'Daihatsu All New Xenia',
            totalPrice: total,
            totalFormatted: finalTotalFormatted,
            qrisPayload: qrisPayload,
            qrisImageUrl: qrisImageUrl,
            paymentStatus: 'MENUNGGU PEMBAYARAN',
            createdAt: new Date().toISOString()
        };

        saveOrderToHistory(state.currentOrder);
        renderPaymentScreen(state.currentOrder);
        switchView('viewPayment');
    }

    // 6. QRIS Display & Simulation
    function renderPaymentScreen(order) {
        setText('paymentBookingCode', order.bookingCode);
        setText('qrisTotalAmount', order.totalFormatted);
        setText('qrisDetailText', (order.seats || '1 Unit') + ' • ' + order.origin + ' ➔ ' + order.destination);

        var qrImg = document.getElementById('qrisQrImage');
        if (qrImg) {
            if (order.qrisImageUrl) {
                qrImg.src = order.qrisImageUrl;
            } else if (order.qrisPayload) {
                qrImg.src = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=8&data=' + encodeURIComponent(order.qrisPayload);
            } else {
                qrImg.src = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&margin=8&data=' + encodeURIComponent('00020101021226570011ID.DANA.WWW' + order.bookingCode);
            }
        }

        startQrisCountdown(30 * 60);
    }

    function startQrisCountdown(durationSeconds) {
        if (state.qrisTimer) clearInterval(state.qrisTimer);
        var timer = durationSeconds;
        function tick() {
            var m = Math.floor(timer / 60);
            var s = timer % 60;
            setText('qrisCountdown', String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0'));
            if (--timer < 0) {
                clearInterval(state.qrisTimer);
                setText('qrisCountdown', 'EXPIRED');
            }
        }
        tick();
        state.qrisTimer = setInterval(tick, 1000);
    }

    function simulateQrisPayment() {
        if (!state.currentOrder) return;
        state.currentOrder.paymentStatus = 'LUNAS';
        saveOrderToHistory(state.currentOrder);
        renderTicket(state.currentOrder);
        switchView('viewSuccessTicket');
    }

    // 7. Render Success E-Ticket
    function renderTicket(order) {
        if (!order) return;
        setText('ticketBookingCode', order.bookingCode);
        setText('ticketPaymentStatus', order.paymentStatus || 'LUNAS');
        setText('ticketPassengerName', order.passengerName);
        setText('ticketPassengerPhone', order.phone);
        setText('ticketRoute', order.origin + ' ➔ ' + order.destination);
        setText('ticketDepartureTime', order.departureTime);
        setText('ticketDepTime', order.departureTime);
        setText('ticketOrigin', order.origin);
        setText('ticketArrTime', 'Est. 3.5 jam');
        setText('ticketDestination', order.destination);
        setText('ticketSeats', order.seats || '1 Unit');
        setText('ticketSeatsList', order.seats || '1 Unit');
        setText('ticketTravelDate', order.departureDate || 'Hari Ini');
        setText('ticketFleet', order.fleetName);
        setText('ticketFleetName', order.fleetName);
        setText('ticketPickupAddress', order.pickupAddress);
        setText('ticketDropoffAddress', order.dropoffAddress);
        setText('ticketTotalPrice', order.totalFormatted);
    }

    function shareTicketWhatsApp() {
        if (!state.currentOrder) return;
        var ord = state.currentOrder;
        var msg = '*TIKET RESMI RIVIAN TRAVEL*\n\n' +
            'Kode Booking: *' + ord.bookingCode + '*\n' +
            'Nama: ' + ord.passengerName + '\n' +
            'Rute: ' + ord.origin + ' ➔ ' + ord.destination + '\n' +
            'Jadwal: ' + ord.departureTime + '\n' +
            'Kursi / Unit: ' + ord.seats + '\n' +
            'Alamat Jemput: ' + ord.pickupAddress + '\n' +
            'Tujuan: ' + ord.dropoffAddress + '\n' +
            'Total: ' + ord.totalFormatted + ' (' + ord.paymentStatus + ')\n\n' +
            'Terima kasih telah memilih Rivian Travel!';
        window.open('https://wa.me/' + WA_PHONE + '?text=' + encodeURIComponent(msg), '_blank');
    }

    function shareTicketToWhatsApp() {
        shareTicketWhatsApp();
    }

    // 8. Order History (localStorage)
    function saveOrderToHistory(order) {
        try {
            var history = JSON.parse(localStorage.getItem('rivian_orders') || '[]');
            var found = false;
            for (var i = 0; i < history.length; i++) {
                if (history[i].bookingCode === order.bookingCode) {
                    history[i] = order;
                    found = true;
                    break;
                }
            }
            if (!found) history.unshift(order);
            localStorage.setItem('rivian_orders', JSON.stringify(history.slice(0, 10)));
            loadOrderHistory();
        } catch (e) {}
    }

    function loadOrderHistory() {
        var container = document.getElementById('orderHistoryContainer');
        if (!container) return;
        try {
            var history = JSON.parse(localStorage.getItem('rivian_orders') || '[]');
            if (history.length === 0) {
                container.innerHTML = '<div class="text-center py-10 bg-white rounded-2xl border border-dashed border-slate-200 p-6">' +
                    '<i class="fa-solid fa-ticket text-3xl text-slate-300 mb-2"></i>' +
                    '<p class="text-xs font-bold text-slate-700">Belum Ada Riwayat Pesanan</p>' +
                    '<p class="text-[11px] text-slate-500 mt-1">Pesan shuttle atau sewa mobil untuk melihat tiket Anda di sini.</p>' +
                    '</div>';
                return;
            }

            container.innerHTML = history.map(function(item) {
                var badgeClass = item.paymentStatus === 'LUNAS' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-600';
                return '<div class="bg-white rounded-2xl p-3 border border-slate-200 shadow-xs flex items-center justify-between">' +
                    '<div>' +
                    '<div class="flex items-center gap-2 mb-1">' +
                    '<span class="text-xs font-black text-slate-900">' + item.bookingCode + '</span>' +
                    '<span class="text-[9px] font-bold ' + badgeClass + ' px-2 py-0.5 rounded-full">' + item.paymentStatus + '</span>' +
                    '</div>' +
                    '<p class="text-[11px] font-bold text-slate-700">' + item.origin + ' ➔ ' + item.destination + '</p>' +
                    '<p class="text-[10px] text-slate-500">' + item.departureTime + ' • ' + (item.seats || '1 Unit') + '</p>' +
                    '</div>' +
                    '<button type="button" onclick="viewHistoryDetail(\'' + item.bookingCode + '\')" class="text-xs font-bold text-sky-600 hover:text-sky-700 bg-sky-50 px-3 py-1.5 rounded-xl cursor-pointer">' +
                    'Lihat E-Ticket' +
                    '</button>' +
                    '</div>';
            }).join('');
        } catch (e) {}
    }

    function viewHistoryDetail(bookingCode) {
        try {
            var history = JSON.parse(localStorage.getItem('rivian_orders') || '[]');
            for (var i = 0; i < history.length; i++) {
                if (history[i].bookingCode === bookingCode) {
                    state.currentOrder = history[i];
                    renderTicket(history[i]);
                    switchView('viewSuccessTicket');
                    break;
                }
            }
        } catch (e) {}
    }

    // 9. Charter Mobil (Kondangan vs Liburan Rates)
    var CHARTER_PRICING = {
        'kondangan': {
            'xenia_all_new': { name: 'Daihatsu All New Xenia', price: 750000 },
            'avanza_veloz': { name: 'Toyota Avanza / Veloz', price: 700000 },
            'innova_zenix': { name: 'Toyota Innova Zenix VIP', price: 1000000 },
            'hiace_premio': { name: 'Toyota HiAce Premio Luxury', price: 1350000 }
        },
        'liburan': {
            'xenia_all_new': { name: 'Daihatsu All New Xenia', price: 950000 },
            'avanza_veloz': { name: 'Toyota Avanza / Veloz', price: 850000 },
            'innova_zenix': { name: 'Toyota Innova Zenix VIP', price: 1250000 },
            'hiace_premio': { name: 'Toyota HiAce Premio Luxury', price: 1650000 }
        }
    };

    function updateCharterTotal() {
        var purpose = getRadioVal('charterPurpose', 'kondangan');
        var fleet = getRadioVal('charterFleet', 'xenia_all_new');
        var days = parseInt(getVal('charterDuration', '1'), 10);

        // Highlight selected purpose card
        document.querySelectorAll('.charter-purpose-card').forEach(function(card) {
            var radio = card.querySelector('input[name="charterPurpose"]');
            if (radio && radio.checked) {
                card.className = 'charter-purpose-card p-2.5 rounded-xl border-2 border-sky-500 bg-sky-50/60 cursor-pointer flex flex-col justify-between transition';
            } else {
                card.className = 'charter-purpose-card p-2.5 rounded-xl border border-slate-200 bg-white cursor-pointer hover:border-sky-300 flex flex-col justify-between transition';
            }
        });

        // Update rate badges on fleet cards
        var purposeRates = CHARTER_PRICING[purpose] || CHARTER_PRICING['kondangan'];
        setText('rateDisplay_xenia', 'Rp ' + purposeRates['xenia_all_new'].price.toLocaleString('id-ID') + '/hari');
        setText('rateDisplay_avanza', 'Rp ' + purposeRates['avanza_veloz'].price.toLocaleString('id-ID') + '/hari');
        setText('rateDisplay_zenix', 'Rp ' + purposeRates['innova_zenix'].price.toLocaleString('id-ID') + '/hari');
        setText('rateDisplay_hiace', 'Rp ' + purposeRates['hiace_premio'].price.toLocaleString('id-ID') + '/hari');

        var rate = (purposeRates[fleet] && purposeRates[fleet].price) ? purposeRates[fleet].price : 750000;
        var total = rate * days;
        setText('charterTotalPriceDisplay', 'Rp ' + total.toLocaleString('id-ID'));
    }

    async function proceedCharterBooking(e) {
        e.preventDefault();
        var purpose = getRadioVal('charterPurpose', 'kondangan');
        var fleet = getRadioVal('charterFleet', 'xenia_all_new');
        var purposeRates = CHARTER_PRICING[purpose] || CHARTER_PRICING['kondangan'];
        var fleetInfo = purposeRates[fleet] || purposeRates['xenia_all_new'];
        var days = parseInt(getVal('charterDuration', '1'), 10);
        var orig = getVal('charterOrigin', 'Ciamis');
        var dest = getVal('charterDestination', 'Bandung');
        var date = getVal('charterDate', '');
        var name = getVal('charterName', 'Pelanggan').trim();
        var phone = getVal('charterPhone', '').trim();
        var pickup = getVal('charterPickup', '').trim();

        if (!name || !phone || !pickup) {
            alert('Lengkapi seluruh data kontak dan alamat penjemputan.');
            return;
        }

        var total = fleetInfo.price * days;
        var bookingCode = 'CHR-' + Math.floor(100000 + Math.random() * 900000);
        var qrisPayload = null;
        var qrisImageUrl = null;
        var finalTotalFormatted = 'Rp ' + total.toLocaleString('id-ID');

        var submitBtn = document.getElementById('btnSubmitCharter');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-sm mr-2"></i> Menyiapkan QRIS Charter...';
        }

        try {
            var formData = new FormData();
            formData.append('_token', CSRF_TOKEN);
            formData.append('booking_type', 'charter');
            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('total_passengers', 6);
            formData.append('charter_date', date);
            formData.append('duration_days', days);
            formData.append('charter_purpose', purpose);
            formData.append('charter_fleet', fleet);
            formData.append('pickup_address', pickup);
            formData.append('dropoff_address', dest);
            formData.append('destination_note', 'Charter ' + (purpose === 'kondangan' ? 'Kondangan' : 'Liburan') + ' ke ' + dest);

            var res = await fetch(BOOKING_ROUTE, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' },
                body: formData
            });
            var data = await res.json();
            if (data && data.success && data.data) {
                bookingCode = data.data.booking_code || bookingCode;
                qrisPayload = data.data.qris_payload || null;
                qrisImageUrl = data.data.qris_image_url || null;
                if (data.data.formatted_amount) {
                    finalTotalFormatted = data.data.formatted_amount;
                }
            }
        } catch (err) {
            console.log('Error charter booking:', err);
        }

        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Booking Charter & Lanjut Bayar QRIS</span> <i class="fas fa-arrow-right text-[10px]"></i>';
        }

        state.currentOrder = {
            id: 'ORD-CHR-' + Date.now(),
            bookingCode: bookingCode,
            orderType: 'CHARTER',
            passengerName: name,
            phone: phone,
            origin: orig,
            destination: dest,
            departureTime: (purpose === 'kondangan' ? 'Kondangan (12 Jam)' : 'Liburan (24 Jam)'),
            departureDate: date,
            seats: fleetInfo.name + ' (' + days + ' Hari)',
            pickupAddress: pickup,
            dropoffAddress: dest,
            fleetName: fleetInfo.name,
            totalPrice: total,
            totalFormatted: finalTotalFormatted,
            qrisPayload: qrisPayload,
            qrisImageUrl: qrisImageUrl,
            paymentStatus: 'MENUNGGU PEMBAYARAN',
            createdAt: new Date().toISOString()
        };

        saveOrderToHistory(state.currentOrder);
        renderPaymentScreen(state.currentOrder);
        switchView('viewPayment');
    }

    // 10. Paket Kilat
    var PACKAGE_RATES = {
        'dokumen': { name: 'Dokumen / Surat Penting', price: 50000 },
        'barang_kecil': { name: 'Barang Kecil (< 5 kg)', price: 75000 },
        'barang_sedang': { name: 'Kardus Sedang (< 15 kg)', price: 120000 },
        'frozen_food': { name: 'Makanan / Frozen Kilat', price: 90000 }
    };

    function updatePackageTotal() {
        var cat = getRadioVal('packageCategory', 'dokumen');
        var price = (PACKAGE_RATES[cat] && PACKAGE_RATES[cat].price) ? PACKAGE_RATES[cat].price : 50000;
        setText('pkgTotalPriceDisplay', 'Rp ' + price.toLocaleString('id-ID'));
    }

    function proceedPackageBooking(e) {
        e.preventDefault();
        var cat = getRadioVal('packageCategory', 'dokumen');
        var catName = (PACKAGE_RATES[cat] && PACKAGE_RATES[cat].name) ? PACKAGE_RATES[cat].name : 'Dokumen';
        var sender = getVal('pkgSenderName', 'Pengirim');
        var senderPhone = getVal('pkgSenderPhone', '');
        var recipient = getVal('pkgRecipientName', 'Penerima');
        var recipientPhone = getVal('pkgRecipientPhone', '');
        var orig = getVal('pkgOrigin', 'Ciamis');
        var dest = getVal('pkgDestination', 'Bandung');
        var pickup = getVal('pkgPickupAddress', '');
        var dropoff = getVal('pkgDropoffAddress', '');
        var price = (PACKAGE_RATES[cat] && PACKAGE_RATES[cat].price) ? PACKAGE_RATES[cat].price : 50000;

        var msg = '*KIRIM PAKET KILAT SAME DAY*\n\n' +
            'Kategori: ' + catName + '\n' +
            'Pengirim: ' + sender + ' (' + senderPhone + ')\n' +
            'Penerima: ' + recipient + ' (' + recipientPhone + ')\n' +
            'Rute: ' + orig + ' ➔ ' + dest + '\n' +
            'Alamat Ambil: ' + pickup + '\n' +
            'Alamat Antar: ' + dropoff + '\n' +
            'Tarif: Rp ' + price.toLocaleString('id-ID') + '\n\n' +
            'Mohon jemput paket saya untuk jadwal shuttle berikutnya.';
        window.open('https://wa.me/' + WA_PHONE + '?text=' + encodeURIComponent(msg), '_blank');
    }
</script>
