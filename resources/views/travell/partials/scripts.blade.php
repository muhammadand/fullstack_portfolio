<script id="dbSchedulesData" type="application/json">
    {
        !!json_encode($dbSchedulesList ? ? []) !!
    }

</script>

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
        activeView: 'viewHome'
        , searchShift: 'all'
        , selectedSchedule: null
        , selectedSeats: []
        , currentOrder: null
        , qrisTimer: null
    };

    // Customer Auth & Points Management
    function getStoredCustomer() {
        try {
            var raw = localStorage.getItem('rivian_customer');
            return raw ? JSON.parse(raw) : null;
        } catch (e) {
            return null;
        }
    }

    function setStoredCustomer(cust) {
        if (!cust) {
            localStorage.removeItem('rivian_customer');
            localStorage.removeItem('rivian_customer_phone');
        } else {
            localStorage.setItem('rivian_customer', JSON.stringify(cust));
            if (cust.phone) {
                localStorage.setItem('rivian_customer_phone', cust.phone);
            }
        }
        updateCustomerUI();
    }

    function updateCustomerUI() {
        var cust = getStoredCustomer();
        var loggedInCard = document.getElementById('customerLoggedInCard');
        var guestFields = document.getElementById('customerGuestFields');
        var bName = document.getElementById('bookingCustName');
        var bPhone = document.getElementById('bookingCustPhone');

        if (cust && cust.phone) {
            if (loggedInCard) loggedInCard.style.display = 'block';
            if (guestFields) guestFields.style.display = 'none';
            setText('loggedInUserName', cust.name || 'Pelanggan');
            setText('loggedInUserPhone', cust.phone + ' • ' + (cust.points || 0) + ' Poin');

            if (bName) {
                bName.value = cust.name || '';
                bName.removeAttribute('required');
            }
            if (bPhone) {
                bPhone.value = cust.phone || '';
                bPhone.removeAttribute('required');
            }

            var lookupInput = document.getElementById('lookupPhoneInput');
            if (lookupInput && !lookupInput.value) lookupInput.value = cust.phone || '';
        } else {
            if (loggedInCard) loggedInCard.style.display = 'none';
            if (guestFields) guestFields.style.display = 'block';
            if (bName) {
                bName.setAttribute('required', 'required');
            }
            if (bPhone) {
                bPhone.setAttribute('required', 'required');
            }
        }
    }

    function switchCustomerAccount() {
        if (!confirm('Ganti ke akun pemesan lain?')) return;
        setStoredCustomer(null);
        var bName = document.getElementById('bookingCustName');
        var bPhone = document.getElementById('bookingCustPhone');
        if (bName) bName.value = '';
        if (bPhone) bPhone.value = '';
        updateCustomerUI();
        refreshHistory();
        openHistoryPhoneModal();
    }

    async function syncCustomerProfile(phone) {
        if (!phone) return;
        try {
            var res = await fetch('/travell/customer/profile?phone=' + encodeURIComponent(phone), {
                headers: {
                    'Accept': 'application/json'
                }
            });
            var json = await res.json();
            if (json && json.success && json.customer) {
                setStoredCustomer(json.customer);
            }
        } catch (e) {
            console.log('Error syncing customer profile:', e);
        }
    }

    function openCustomerAuthModal() {
        var modal = document.getElementById('customerAuthModal');
        if (modal) modal.classList.add('open');
        var cust = getStoredCustomer();
        var phoneIn = document.getElementById('authCustomerPhone');
        var nameIn = document.getElementById('authCustomerName');
        if (cust) {
            if (nameIn) nameIn.value = cust.name || '';
            if (phoneIn) phoneIn.value = cust.phone || '';
        } else {
            var savedPhone = localStorage.getItem('rivian_customer_phone');
            if (phoneIn && savedPhone) phoneIn.value = savedPhone;
        }
    }

    function closeCustomerAuthModal() {
        var modal = document.getElementById('customerAuthModal');
        if (modal) modal.classList.remove('open');
    }

    async function handleCustomerAuthSubmit(e) {
        if (e) e.preventDefault();
        var phone = getVal('authCustomerPhone').trim();
        var name = getVal('authCustomerName').trim();

        if (!phone || !name) {
            alert('Silakan masukkan nomor WhatsApp aktif dan Nama Lengkap Anda.');
            return;
        }

        var btn = document.getElementById('btnSubmitAuthCustomer');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> Memproses...';
        }

        try {
            var formData = new FormData();
            formData.append('phone', phone);
            formData.append('name', name);

            var res = await fetch('/travell/customer/login', {
                method: 'POST'
                , headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    , 'Accept': 'application/json'
                    , 'X-CSRF-TOKEN': CSRF_TOKEN
                }
                , body: formData
            });

            var json = await res.json();
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<span>Masuk / Daftarkan Saya</span> <i class="fas fa-arrow-right text-[10px]"></i>';
            }

            if (json && json.success && json.customer) {
                setStoredCustomer(json.customer);
                closeCustomerAuthModal();
                refreshHistory();
                alert('Selamat datang, ' + json.customer.name + '!\n' + (json.is_new ? 'Bonus Poin Sambutan: ' : 'Poin Loyalti Anda: ') + (json.customer.points || 0) + ' Poin.');
            } else {
                alert(json.message || 'Gagal masuk akun pelanggan.');
            }
        } catch (err) {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<span>Masuk / Daftarkan Saya</span> <i class="fas fa-arrow-right text-[10px]"></i>';
            }
            alert('Terjadi kendala jaringan saat menghubungkan akun pelanggan.');
        }
    }

    function logoutCustomer() {
        if (!confirm('Apakah Anda yakin ingin keluar dari akun pelanggan ini?')) {
            return;
        }
        setStoredCustomer(null);
        var cName = document.getElementById('custName');
        var cPhone = document.getElementById('custPhone');
        if (cName) cName.value = '';
        if (cPhone) cPhone.value = '';
        var charterName = document.getElementById('charterName');
        var charterPhone = document.getElementById('charterPhone');
        if (charterName) charterName.value = '';
        if (charterPhone) charterPhone.value = '';
        var lookupInput = document.getElementById('lookupPhoneInput');
        if (lookupInput) lookupInput.value = '';
        loadOrderHistory();
    }

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

        // Initialize customer auth state & update UI
        updateCustomerUI();

        var cust = getStoredCustomer();
        if (cust && cust.id) {
            fetchTicketsByCustomerId(cust.id);
            if (cust.phone) syncCustomerProfile(cust.phone);
        } else if (cust && cust.phone) {
            syncCustomerProfile(cust.phone);
            fetchTicketsByPhone(cust.phone);
        } else {
            var activePhone = localStorage.getItem('rivian_customer_phone');
            if (activePhone) {
                var phoneInput = document.getElementById('lookupPhoneInput');
                if (phoneInput) phoneInput.value = activePhone;
                fetchTicketsByPhone(activePhone);
            } else {
                loadOrderHistory();
            }
        }

        // Stay on home view by default
        updateCharterTotal();
        switchView('viewHome');
    });

    // 1. View Navigation
    function switchView(viewId) {
        var views = ['viewHome', 'viewSuccessTicket', 'viewHistory', 'viewSchedules', 'viewSeatPicker', 'viewPassengerForm', 'viewPayment', 'viewCharter', 'viewPackage'];
        views.forEach(function(id) {
            var el = document.getElementById(id);
            if (!el) return;
            if (id === viewId) {
                el.style.display = 'block';
                el.classList.remove('hidden');
            } else {
                el.style.display = 'none';
                el.classList.add('hidden');
            }
        });

        // Bottom nav styling
        var tabHome = document.getElementById('navTabHome');
        var tabTickets = document.getElementById('navTabTickets');
        var tabAccount = document.getElementById('navTabAccount');
        if (tabHome) {
            if (viewId === 'viewHome') tabHome.classList.add('active');
            else tabHome.classList.remove('active');
        }
        if (tabTickets) {
            if (viewId === 'viewHistory' || viewId === 'viewSuccessTicket') tabTickets.classList.add('active');
            else tabTickets.classList.remove('active');
        }

        state.activeView = viewId;
        if (viewId === 'viewHistory') {
            var cust = getStoredCustomer();
            if (!cust || (!cust.id && !cust.phone)) {
                openHistoryPhoneModal();
            }
            refreshHistory();
        }
        var viewport = document.getElementById('appViewport');
        if (viewport) viewport.scrollTop = 0;
    }

    // QRIS Modal Popup Controller
    function openQrisModal(order) {
        if (!order) return;
        renderPaymentScreen(order);
        var modal = document.getElementById('qrisModalBackdrop');
        if (modal) modal.classList.add('open');
    }

    function closeQrisModal() {
        var modal = document.getElementById('qrisModalBackdrop');
        if (modal) modal.classList.remove('open');
    }

    // 2. Route Search & Swap (Pool & Door-to-Door Aware)
    function swapOriginDestination() {
        var orig = document.getElementById('homeOrigin');
        var dest = document.getElementById('homeDestination');
        if (!orig || !dest) return;

        var curOrig = orig.value;
        var curDest = dest.value;

        // If currently origin is Ciamis and dest is Bandung, flip them to valid Bandung origin & Ciamis dest
        if (curOrig.indexOf('ciamis') !== -1) {
            orig.value = curDest.indexOf('dipatiukur') !== -1 ? 'pool_dipatiukur' : (curDest.indexOf('home') !== -1 ? 'home_bandung' : 'pool_pasteur');
            dest.value = curOrig.indexOf('home') !== -1 ? 'home_ciamis' : 'pool_ciamis';
        } else {
            orig.value = curDest.indexOf('home') !== -1 ? 'home_ciamis' : 'pool_ciamis';
            dest.value = curOrig.indexOf('dipatiukur') !== -1 ? 'pool_dipatiukur' : (curOrig.indexOf('home') !== -1 ? 'home_bandung' : 'pool_pasteur');
        }
    }

    function quickSearchRoute(origCity, destCity) {
        var origSelect = document.getElementById('homeOrigin');
        var destSelect = document.getElementById('homeDestination');
        if (origSelect) {
            origSelect.value = (origCity === 'bandung') ? 'pool_pasteur' : 'pool_ciamis';
        }
        if (destSelect) {
            destSelect.value = (destCity === 'ciamis') ? 'pool_ciamis' : 'pool_pasteur';
        }
        executeScheduleSearch();
    }

    // Direct Booking State & Logic (Min 4 Kursi @ 190.000)
    var directBookingState = {
        seatCount: 4
        , unitPrice: 190000
        , selectedTime: '06:00'
    };

    function changeSeatQuantity(delta) {
        directBookingState.seatCount = Math.max(4, Math.min(6, directBookingState.seatCount + delta));
        var count = directBookingState.seatCount;
        var total = count * directBookingState.unitPrice;

        setText('seatQuantityDisplay', count + ' Kursi');
        setText('directBookingTotalDisplay', 'Rp ' + total.toLocaleString('id-ID'));

        var submitBtn = document.getElementById('btnSubmitDirectBooking');
        if (submitBtn) {
            submitBtn.innerHTML = '<span>Lanjut Bayar QRIS (Rp ' + total.toLocaleString('id-ID') + ')</span> <i class="fas fa-qrcode text-sm"></i>';
        }

        var btnMinus = document.getElementById('btnMinusSeat');
        var btnPlus = document.getElementById('btnPlusSeat');
        if (btnMinus) btnMinus.disabled = (count <= 4);
        if (btnPlus) btnPlus.disabled = (count >= 6);
    }

    function selectBookingTime(time) {
        directBookingState.selectedTime = time;
        var hiddenInput = document.getElementById('bookingSelectedTime');
        if (hiddenInput) hiddenInput.value = time;

        document.querySelectorAll('.time-chip-btn').forEach(function(btn) {
            if (btn.getAttribute('data-time') === time) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });
    }

    function applyQuickPickup(val) {
        var input = document.getElementById('bookingCustPickup');
        if (!input || !val) return;

        if (val === 'current_gps') {
            detectCurrentLocation('bookingCustPickup');
            return;
        }

        if (val.indexOf('Pool ') !== -1) {
            input.value = val;
        } else if (val === 'custom_ciamis') {
            input.value = 'Jemput di Alamat Rumah Ciamis: ';
            input.focus();
        } else if (val === 'custom_bandung') {
            input.value = 'Jemput di Alamat Rumah/Hotel Bandung: ';
            input.focus();
        }
    }

    async function detectCurrentLocation(targetInputId) {
        var targetId = targetInputId || 'bookingCustPickup';
        var input = document.getElementById(targetId);
        var btn = document.getElementById('btnDetectCurrentLocation');
        var icon = document.getElementById('detectLocationIcon');
        var text = document.getElementById('detectLocationText');
        var statusBadge = document.getElementById('gpsStatusBadge');
        var statusText = document.getElementById('gpsStatusText');
        var accuracyText = document.getElementById('gpsAccuracyText');

        if (!navigator.geolocation) {
            alert('Fitur Geolocation (GPS) tidak didukung oleh browser ini.');
            return;
        }

        if (btn) btn.disabled = true;
        if (icon) icon.className = 'fas fa-spinner fa-spin text-sky-600';
        if (text) text.textContent = 'Mencari GPS...';

        navigator.geolocation.getCurrentPosition(
            async function(position) {
                    var lat = position.coords.latitude;
                    var lng = position.coords.longitude;
                    var accuracy = Math.round(position.coords.accuracy || 0);

                    if (text) text.textContent = 'Membaca Alamat...';

                    var addressResult = '';

                    try {
                        // Reverse geocode with OpenStreetMap Nominatim API
                        var nominatimUrl = 'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=' + lat + '&lon=' + lng + '&accept-language=id';
                        var controller = new AbortController();
                        var timeoutId = setTimeout(function() {
                            controller.abort();
                        }, 6000);

                        var response = await fetch(nominatimUrl, {
                            signal: controller.signal
                            , headers: {
                                'Accept': 'application/json'
                            }
                        });
                        clearTimeout(timeoutId);

                        if (response.ok) {
                            var data = await response.json();
                            var addr = data.address || {};
                            var road = addr.road || addr.pedestrian || addr.suburb || addr.neighbourhood || '';
                            var village = addr.village || addr.suburb || '';
                            var city = addr.city || addr.town || addr.county || addr.city_district || '';
                            var state = addr.state || '';

                            var components = [];
                            if (road) components.push(road);
                            if (village && village !== road) components.push(village);
                            if (city && city !== village) components.push(city);
                            if (state) components.push(state);

                            if (components.length > 0) {
                                addressResult = components.join(', ');
                            } else if (data.display_name) {
                                addressResult = data.display_name;
                            }
                        }
                    } catch (e) {
                        console.warn('Geocoding service note:', e);
                    }

                    // If geocoding failed or returned empty, use coordinates
                    if (!addressResult) {
                        addressResult = 'Lokasi GPS: Lat ' + lat.toFixed(5) + ', Lng ' + lng.toFixed(5);
                    }

                    if (input) {
                        input.value = addressResult;
                        input.focus();
                        input.classList.add('ring-2', 'ring-emerald-400');
                        setTimeout(function() {
                            input.classList.remove('ring-2', 'ring-emerald-400');
                        }, 2500);
                    }

                    if (icon) icon.className = 'fas fa-check text-emerald-600';
                    if (text) text.textContent = 'Lokasi Terdeteksi';

                    if (statusBadge && statusText) {
                        statusBadge.classList.remove('hidden');
                        statusText.textContent = 'GPS Terdeteksi';
                        if (accuracyText) accuracyText.textContent = 'Akurasi ±' + accuracy + 'm';
                    }

                    setTimeout(function() {
                        if (btn) btn.disabled = false;
                        if (icon) icon.className = 'fas fa-location-crosshairs text-sky-600';
                        if (text) text.textContent = 'Gunakan Lokasi Saat Ini';
                    }, 4000);
                }
                , function(err) {
                    console.error('Geolocation error:', err);
                    var errMessage = 'Gagal mendeteksi lokasi saat ini.';
                    if (err.code === 1) {
                        errMessage = 'Izin lokasi (GPS) ditolak oleh browser. Silakan izinkan akses lokasi atau ketik alamat penjemputan manual.';
                    } else if (err.code === 2) {
                        errMessage = 'Posisi lokasi tidak tersedia. Pastikan GPS perangkat aktif.';
                    } else if (err.code === 3) {
                        errMessage = 'Waktu pencarian lokasi habis (timeout). Silakan coba lagi.';
                    }
                    alert(errMessage);

                    if (btn) btn.disabled = false;
                    if (icon) icon.className = 'fas fa-location-crosshairs text-sky-600';
                    if (text) text.textContent = 'Gunakan Lokasi Saat Ini';
                }, {
                    enableHighAccuracy: true
                    , timeout: 10000
                    , maximumAge: 0
                }
        );
    }

    function applyQuickDropoff(val) {
        var input = document.getElementById('bookingCustDropoff');
        if (!input || !val) return;
        if (val.indexOf('Pool ') !== -1) {
            input.value = val;
        } else if (val === 'custom_bandung') {
            input.value = 'Diantar ke Alamat Rumah/Hotel Bandung: ';
            input.focus();
        } else if (val === 'custom_ciamis') {
            input.value = 'Diantar ke Alamat Rumah Ciamis: ';
            input.focus();
        }
    }

    async function handleDirectBookingSubmit(e) {
        if (e) e.preventDefault();

        var name = (getVal('bookingCustName') || getVal('custName')).trim();
        var phone = (getVal('bookingCustPhone') || getVal('custPhone')).trim();
        var pickup = (getVal('bookingCustPickup') || getVal('custPickup')).trim();
        var dropoff = (getVal('bookingCustDropoff') || getVal('custDropoff')).trim();
        var date = getVal('bookingDate', new Date().toISOString().split('T')[0]);
        var time = getVal('bookingSelectedTime', '06:00');
        var seatCount = directBookingState.seatCount;

        if (!name || !phone || !pickup || !dropoff) {
            alert('Mohon lengkapi Nama, WhatsApp, Alamat Jemput, dan Alamat Tujuan.');
            return;
        }

        var total = seatCount * directBookingState.unitPrice;
        var bookingCode = 'RVN-' + Math.floor(100000 + Math.random() * 900000);
        var qrisPayload = null;
        var qrisImageUrl = null;
        var finalTotalFormatted = 'Rp ' + total.toLocaleString('id-ID');

        var submitBtn = document.getElementById('btnSubmitDirectBooking');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-sm mr-2"></i> Menyiapkan Tagihan QRIS...';
        }

        try {
            var formData = new FormData();
            formData.append('_token', CSRF_TOKEN);
            formData.append('booking_type', 'reguler');
            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('total_passengers', seatCount);
            formData.append('pickup_address', pickup);
            formData.append('dropoff_address', dropoff);
            formData.append('departure_date', date);
            formData.append('departure_time', time);
            formData.append('notes', 'Direct Booking: ' + seatCount + ' Kursi Door to Door');

            for (var i = 1; i <= seatCount; i++) {
                formData.append('seats[]', i);
            }

            var res = await fetch(BOOKING_ROUTE, {
                method: 'POST'
                , headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    , 'Accept': 'application/json'
                }
                , body: formData
            });
            var data = await res.json();
            if (data && data.success && data.data) {
                bookingCode = data.data.booking_code || bookingCode;
                qrisPayload = data.data.qris_payload || null;
                qrisImageUrl = data.data.qris_image_url || null;
                if (data.data.formatted_amount) {
                    finalTotalFormatted = data.data.formatted_amount;
                }
                if (data.data.customer_phone) {
                    var cust = getStoredCustomer() || {};
                    if (data.data.customer_id) {
                        cust.id = data.data.customer_id;
                    }
                    cust.phone = data.data.customer_phone;
                    cust.name = data.data.customer_name || name;
                    if (data.data.customer_points !== undefined) {
                        cust.points = data.data.customer_points;
                    }
                    setStoredCustomer(cust);
                }
            } else if (data && !data.success && data.message) {
                alert(data.message);
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<span>Lanjut Bayar QRIS (' + finalTotalFormatted + ')</span> <i class="fas fa-qrcode text-sm"></i>';
                }
                return;
            }
        } catch (err) {
            console.log('Error direct booking:', err);
        }

        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<span>Lanjut Bayar QRIS (' + finalTotalFormatted + ')</span> <i class="fas fa-qrcode text-sm"></i>';
        }

        var originName = (pickup.toLowerCase().indexOf('bandung') !== -1) ? 'Bandung' : 'Ciamis';
        var destName = (dropoff.toLowerCase().indexOf('ciamis') !== -1) ? 'Ciamis' : 'Bandung';

        state.currentOrder = {
            id: 'ORD-' + Date.now()
            , bookingCode: bookingCode
            , orderType: 'REGULER'
            , passengerName: name
            , phone: phone
            , origin: originName
            , destination: destName
            , departureTime: time + ' WIB'
            , departureDate: date
            , seats: seatCount + ' Kursi Rombongan (K-01 s/d K-0' + seatCount + ')'
            , pickupAddress: pickup
            , dropoffAddress: dropoff
            , fleetName: 'Daihatsu All New Xenia'
            , totalPrice: total
            , totalFormatted: finalTotalFormatted
            , qrisPayload: qrisPayload
            , qrisImageUrl: qrisImageUrl
            , paymentStatus: 'MENUNGGU VERIFIKASI'
            , bookingStatus: 'pending'
            , statusLabel: 'Proses Verifikasi Pembayaran'
            , statusColor: 'amber'
            , createdAt: new Date().toISOString()
        };

        saveOrderToHistory(state.currentOrder);
        openQrisModal(state.currentOrder);
    }

    function handleDateChange(val) {}

    // Helpers to extract base city from pool / door-to-door value
    function extractCityFromPoint(pointVal, fallback) {
        if (!pointVal) return fallback;
        var lower = pointVal.toLowerCase();
        if (lower.indexOf('bandung') !== -1 || lower.indexOf('pasteur') !== -1 || lower.indexOf('dipatiukur') !== -1) {
            return 'bandung';
        }
        if (lower.indexOf('ciamis') !== -1) {
            return 'ciamis';
        }
        return fallback;
    }

    // 3. Schedule Search & Filtering
    function executeScheduleSearch() {
        var origVal = getVal('homeOrigin', 'pool_ciamis');
        var destVal = getVal('homeDestination', 'pool_pasteur');

        var origCity = extractCityFromPoint(origVal, 'ciamis');
        var destCity = extractCityFromPoint(destVal, 'bandung');

        setText('schedulesRouteTitle', origCity.toUpperCase() + ' ➔ ' + destCity.toUpperCase());

        renderSchedulesList(origCity, destCity);
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

        var borderBg = isSelected ?
            'border-2 border-sky-500 bg-sky-500 text-white shadow-sm' :
            'border border-slate-200 bg-white text-slate-700 hover:border-sky-300';

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

        var countText = count > 0 ?
            count + ' Kursi (K-0' + state.selectedSeats.slice().sort().join(', K-0') + ')' :
            'Belum Ada Kursi';

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

    // 5. Pool vs Door-to-Door Pickup & Dropoff Logic
    var currentPickupType = 'pool';
    var currentDropoffType = 'pool';

    function setPickupType(type) {
        currentPickupType = type;
        var btnPool = document.getElementById('btnPickupTypePool');
        var btnDoor = document.getElementById('btnPickupTypeDoor');
        var poolContainer = document.getElementById('pickupPoolSelectContainer');
        var customContainer = document.getElementById('pickupCustomAddressContainer');
        var custPickup = document.getElementById('custPickup');

        if (type === 'pool') {
            if (btnPool) {
                btnPool.className = 'py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 bg-white text-sky-700 shadow-xs cursor-pointer';
            }
            if (btnDoor) {
                btnDoor.className = 'py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900 cursor-pointer';
            }
            if (poolContainer) poolContainer.classList.remove('hidden');
            if (customContainer) customContainer.classList.add('hidden');
            syncPickupAddress();
        } else {
            if (btnPool) {
                btnPool.className = 'py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900 cursor-pointer';
            }
            if (btnDoor) {
                btnDoor.className = 'py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 bg-white text-sky-700 shadow-xs cursor-pointer';
            }
            if (poolContainer) poolContainer.classList.add('hidden');
            if (customContainer) customContainer.classList.remove('hidden');
            if (custPickup && custPickup.value.indexOf('Pool ') !== -1) {
                custPickup.value = '';
            }
            if (custPickup) custPickup.focus();
        }
    }

    function syncPickupAddress() {
        var poolSelect = document.getElementById('pickupPoolSelect');
        var custPickup = document.getElementById('custPickup');
        if (currentPickupType === 'pool' && poolSelect && custPickup) {
            custPickup.value = poolSelect.value;
        }
    }

    function setDropoffType(type) {
        currentDropoffType = type;
        var btnPool = document.getElementById('btnDropoffTypePool');
        var btnDoor = document.getElementById('btnDropoffTypeDoor');
        var poolContainer = document.getElementById('dropoffPoolSelectContainer');
        var customContainer = document.getElementById('dropoffCustomAddressContainer');
        var custDropoff = document.getElementById('custDropoff');

        if (type === 'pool') {
            if (btnPool) {
                btnPool.className = 'py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 bg-white text-rose-700 shadow-xs cursor-pointer';
            }
            if (btnDoor) {
                btnDoor.className = 'py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900 cursor-pointer';
            }
            if (poolContainer) poolContainer.classList.remove('hidden');
            if (customContainer) customContainer.classList.add('hidden');
            syncDropoffAddress();
        } else {
            if (btnPool) {
                btnPool.className = 'py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 text-slate-600 hover:text-slate-900 cursor-pointer';
            }
            if (btnDoor) {
                btnDoor.className = 'py-1.5 px-2 rounded-lg text-[10px] font-bold transition flex items-center justify-center gap-1.5 bg-white text-rose-700 shadow-xs cursor-pointer';
            }
            if (poolContainer) poolContainer.classList.add('hidden');
            if (customContainer) customContainer.classList.remove('hidden');
            if (custDropoff && custDropoff.value.indexOf('Pool ') !== -1) {
                custDropoff.value = '';
            }
            if (custDropoff) custDropoff.focus();
        }
    }

    function syncDropoffAddress() {
        var poolSelect = document.getElementById('dropoffPoolSelect');
        var custDropoff = document.getElementById('custDropoff');
        if (currentDropoffType === 'pool' && poolSelect && custDropoff) {
            custDropoff.value = poolSelect.value;
        }
    }

    // 6. Passenger Form & Booking Submission
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

        // Refresh/prefill customer fields if logged in
        updateCustomerUI();

        // Intelligently configure Pickup and Dropoff from Homepage selections
        var homeOriginVal = getVal('homeOrigin', 'pool_ciamis');
        var homeDestVal = getVal('homeDestination', 'pool_pasteur');

        // Sync Pickup
        var pickupPoolSelect = document.getElementById('pickupPoolSelect');
        if (homeOriginVal.indexOf('home_') !== -1) {
            setPickupType('door');
        } else {
            setPickupType('pool');
            if (pickupPoolSelect) {
                if (homeOriginVal === 'pool_pasteur') {
                    pickupPoolSelect.selectedIndex = 1;
                } else if (homeOriginVal === 'pool_dipatiukur') {
                    pickupPoolSelect.selectedIndex = 2;
                } else {
                    pickupPoolSelect.selectedIndex = 0;
                }
            }
            syncPickupAddress();
        }

        // Sync Dropoff
        var dropoffPoolSelect = document.getElementById('dropoffPoolSelect');
        if (homeDestVal.indexOf('home_') !== -1) {
            setDropoffType('door');
        } else {
            setDropoffType('pool');
            if (dropoffPoolSelect) {
                if (homeDestVal === 'pool_dipatiukur') {
                    dropoffPoolSelect.selectedIndex = 1;
                } else if (homeDestVal === 'pool_ciamis') {
                    dropoffPoolSelect.selectedIndex = 2;
                } else {
                    dropoffPoolSelect.selectedIndex = 0;
                }
            }
            syncDropoffAddress();
        }

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
                method: 'POST'
                , headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    , 'Accept': 'application/json'
                }
                , body: formData
            });
            var data = await res.json();
            if (data && data.success && data.data) {
                bookingCode = data.data.booking_code || bookingCode;
                qrisPayload = data.data.qris_payload || null;
                qrisImageUrl = data.data.qris_image_url || null;
                if (data.data.formatted_amount) {
                    finalTotalFormatted = data.data.formatted_amount;
                }
                if (data.data.customer_phone) {
                    var cust = getStoredCustomer() || {};
                    cust.phone = data.data.customer_phone;
                    cust.name = data.data.customer_name || name;
                    if (data.data.customer_points !== undefined) {
                        cust.points = data.data.customer_points;
                    }
                    setStoredCustomer(cust);
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
            id: 'ORD-' + Date.now()
            , bookingCode: bookingCode
            , orderType: 'REGULER'
            , passengerName: name
            , phone: phone
            , origin: sched.origin
            , destination: sched.destination
            , departureTime: sched.departure_time
            , departureDate: (sched && sched.date) ? sched.date : new Date().toISOString().split('T')[0]
            , seats: state.selectedSeats.slice().sort().map(function(s) {
                return 'K-0' + s;
            }).join(', ')
            , pickupAddress: pickup
            , dropoffAddress: dropoff
            , fleetName: (sched && sched.fleet_name) ? sched.fleet_name : 'Daihatsu All New Xenia'
            , totalPrice: total
            , totalFormatted: finalTotalFormatted
            , qrisPayload: qrisPayload
            , qrisImageUrl: qrisImageUrl
            , paymentStatus: 'MENUNGGU PEMBAYARAN'
            , createdAt: new Date().toISOString()
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

    async function confirmPaymentSuccess() {
        if (!state.currentOrder) return;

        // Immediately close QRIS modal ("langsung keluar dari itu")
        closeQrisModal();

        var btn = document.getElementById('btnConfirmPaid');
        var btnText = document.getElementById('btnConfirmPaidText');
        if (btn) {
            btn.disabled = true;
            if (btnText) btnText.innerHTML = '<i class="fas fa-circle-notch fa-spin text-sm mr-1"></i> Mengirim Bukti Bayar...';
        }

        state.currentOrder.paymentStatus = 'MENUNGGU VERIFIKASI';
        state.currentOrder.bookingStatus = 'pending';
        state.currentOrder.statusLabel = 'Proses Verifikasi Pembayaran';
        state.currentOrder.statusColor = 'amber';

        // Notify backend to mark payment status as pending verification by admin
        if (state.currentOrder.bookingCode) {
            try {
                var res = await fetch('/travell/pay/' + encodeURIComponent(state.currentOrder.bookingCode), {
                    method: 'POST'
                    , headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                        , 'Accept': 'application/json'
                        , 'X-CSRF-TOKEN': CSRF_TOKEN
                    }
                });
                var json = await res.json();
                if (json && json.success && json.data) {
                    if (json.data.status_label) {
                        state.currentOrder.statusLabel = json.data.status_label;
                    }
                    if (json.data.customer_points !== undefined) {
                        var cust = getStoredCustomer();
                        if (cust) {
                            cust.points = json.data.customer_points;
                            setStoredCustomer(cust);
                        }
                    }
                }
            } catch (e) {
                console.log('Payment notification error:', e);
            }
        }

        if (btn) {
            btn.disabled = false;
            if (btnText) btnText.textContent = 'Saya Sudah Bayar (Konfirmasi)';
        }

        saveOrderToHistory(state.currentOrder);
        renderTicket(state.currentOrder);
        switchView('viewSuccessTicket');
    }

    var simulateQrisPayment = confirmPaymentSuccess;

    // 7. Render Success E-Ticket
    function renderTicket(order) {
        if (!order) return;
        setText('ticketBookingCode', order.bookingCode);
        setText('ticketPaymentStatus', order.paymentStatus || 'MENUNGGU VERIFIKASI');
        setText('ticketPassengerName', order.passengerName);
        setText('ticketPassengerPhone', order.phone);
        setText('ticketRoute', order.origin + ' ➔ ' + order.destination);
        setText('ticketDepartureTime', order.departureTime);
        setText('ticketDepTime', order.departureTime);
        setText('ticketOrigin', order.origin);
        setText('ticketArrTime', 'Est. 3.5 jam');
        setText('ticketDestination', order.destination);
        setText('ticketSeats', order.seats || '4 Kursi');
        setText('ticketSeatsList', order.seats || '4 Kursi');
        setText('ticketTravelDate', order.departureDate || 'Hari Ini');
        setText('ticketFleet', order.fleetName || 'Daihatsu All New Xenia');
        setText('ticketFleetName', order.fleetName || 'Daihatsu All New Xenia');
        setText('ticketPickupAddress', order.pickupAddress);
        setText('ticketDropoffAddress', order.dropoffAddress);
        setText('ticketTotalPrice', order.totalFormatted);

        var qrImg = document.getElementById('ticketQrImage');
        if (qrImg && order.bookingCode) {
            qrImg.src = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&margin=4&data=' + encodeURIComponent(order.bookingCode);
        }

        // Update live status badge & verification header
        var statusBadge = document.getElementById('ticketStatusBadge');
        var banner = document.getElementById('ticketHeaderStatusBlock');
        var iconEl = document.getElementById('ticketHeaderIcon');
        var bStatus = (order.bookingStatus || 'pending').toLowerCase();
        var pStatus = (order.paymentStatus || '').toLowerCase();

        if (bStatus === 'confirmed' || pStatus.indexOf('lunas') !== -1 || pStatus.indexOf('paid') !== -1) {
            if (banner) banner.className = 'ticket-verify-banner paid';
            if (statusBadge) {
                statusBadge.className = 'status-badge paid';
                statusBadge.innerHTML = '<i class="fas fa-circle-check"></i> LUNAS (PAID)';
            }
            if (iconEl) {
                iconEl.innerHTML = '<i class="fas fa-check"></i>';
            }
            setText('ticketHeaderTitle', 'Pembayaran Terverifikasi (PAID)');
            setText('ticketHeaderSub', 'Tiket shuttle rombongan Anda telah aktif & terverifikasi. Siap berangkat!');
        } else if (bStatus === 'completed') {
            if (banner) banner.className = 'ticket-verify-banner paid';
            if (statusBadge) {
                statusBadge.className = 'status-badge completed';
                statusBadge.innerHTML = '<i class="fas fa-flag-checkered"></i> SELESAI';
            }
            if (iconEl) {
                iconEl.innerHTML = '<i class="fas fa-flag-checkered"></i>';
            }
            setText('ticketHeaderTitle', 'Perjalanan Selesai');
            setText('ticketHeaderSub', 'Terima kasih telah bepergian bersama Rivian Travel.');
        } else if (bStatus === 'cancelled') {
            if (banner) banner.className = 'ticket-verify-banner';
            if (statusBadge) {
                statusBadge.className = 'status-badge cancelled';
                statusBadge.innerHTML = '<i class="fas fa-ban"></i> DIBATALKAN';
            }
            if (iconEl) {
                iconEl.innerHTML = '<i class="fas fa-xmark"></i>';
            }
            setText('ticketHeaderTitle', 'Pesanan Dibatalkan');
            setText('ticketHeaderSub', 'Pesanan ini telah dibatalkan.');
        } else {
            // Default: PROSES VERIFIKASI PEMBAYARAN
            if (banner) banner.className = 'ticket-verify-banner';
            if (statusBadge) {
                statusBadge.className = 'status-badge pending';
                statusBadge.innerHTML = '<i class="fas fa-clock"></i> VERIFIKASI PEMBAYARAN';
            }
            if (iconEl) {
                iconEl.innerHTML = '<i class="fas fa-clock"></i>';
            }
            setText('ticketHeaderTitle', 'Proses Verifikasi Pembayaran');
            setText('ticketHeaderSub', 'Admin sedang memverifikasi bukti pembayaran Anda. Begitu diverifikasi, tiket otomatis aktif (PAID).');
        }
    }

    async function checkCurrentTicketStatus() {
        if (!state.currentOrder || !state.currentOrder.bookingCode) {
            alert('Tidak ada tiket yang sedang aktif.');
            return;
        }

        var btn = document.getElementById('btnRefreshTicketStatus');
        var btnText = document.getElementById('btnRefreshTicketStatusText');
        if (btn) {
            btn.disabled = true;
            if (btnText) btnText.innerHTML = '<i class="fas fa-circle-notch fa-spin text-xs"></i> Memeriksa Status...';
        }

        var phone = state.currentOrder.phone || localStorage.getItem('rivian_customer_phone');
        if (!phone) {
            if (btn) {
                btn.disabled = false;
                if (btnText) btnText.textContent = 'Cek / Perbarui Status Verifikasi';
            }
            return;
        }

        try {
            var formData = new FormData();
            formData.append('phone', phone);
            var res = await fetch('/travell/my-tickets', {
                method: 'POST'
                , headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    , 'Accept': 'application/json'
                    , 'X-CSRF-TOKEN': CSRF_TOKEN
                }
                , body: formData
            });
            var json = await res.json();
            if (btn) {
                btn.disabled = false;
                if (btnText) btnText.textContent = 'Cek / Perbarui Status Verifikasi';
            }

            if (json && json.success && Array.isArray(json.data)) {
                var found = json.data.find(function(t) {
                    return t.bookingCode === state.currentOrder.bookingCode;
                });
                if (found) {
                    state.currentOrder = Object.assign({}, state.currentOrder, found);
                    renderTicket(state.currentOrder);
                    saveOrderToHistory(state.currentOrder);

                    var bStatus = (found.bookingStatus || '').toLowerCase();
                    var pStatus = (found.paymentStatus || '').toLowerCase();
                    if (bStatus === 'confirmed' || pStatus.indexOf('lunas') !== -1 || pStatus.indexOf('paid') !== -1) {
                        alert('Selamat! Pembayaran pesanan #' + found.bookingCode + ' telah DIVERIFIKASI (PAID). Tiket Anda siap digunakan!');
                    } else {
                        alert('Status pesanan #' + found.bookingCode + ' saat ini masih: ' + (found.statusLabel || 'Proses Verifikasi Pembayaran'));
                    }
                } else {
                    alert('Status pesanan saat ini masih: Proses Verifikasi Pembayaran.');
                }
            }
        } catch (e) {
            if (btn) {
                btn.disabled = false;
                if (btnText) btnText.textContent = 'Cek / Perbarui Status Verifikasi';
            }
            console.log('Error checking ticket status:', e);
        }
    }

    function shareTicketWhatsApp() {
        if (!state.currentOrder) return;
        var ord = state.currentOrder;
        var msg = '*TIKET RESMI RIVIAN TRAVEL*\n\n' +
            'Kode Booking: *' + ord.bookingCode + '*\n' +
            'Status Pesanan: *' + (ord.statusLabel || 'Sedang Diproses') + '*\n' +
            'Nama: ' + ord.passengerName + '\n' +
            'Rute: ' + ord.origin + ' ➔ ' + ord.destination + '\n' +
            'Jadwal: ' + ord.departureTime + ' (' + (ord.departureDate || 'Hari Ini') + ')\n' +
            'Kursi / Unit: ' + ord.seats + '\n' +
            'Alamat Jemput: ' + ord.pickupAddress + '\n' +
            'Tujuan: ' + ord.dropoffAddress + '\n' +
            'Total: ' + ord.totalFormatted + ' (' + ord.paymentStatus + ')\n\n' +
            'Cek tiket Anda langsung dengan memasukkan Nomor HP di website Rivian Travel.';
        window.open('https://wa.me/' + WA_PHONE + '?text=' + encodeURIComponent(msg), '_blank');
    }

    function shareTicketToWhatsApp() {
        shareTicketWhatsApp();
    }

    // 8. Order History & Phone Lookup (Live Database + localStorage)
    var currentHistoryTab = 'all';
    var allHistoryOrders = [];

    function saveOrderToHistory(order) {
        try {
            var history = JSON.parse(localStorage.getItem('rivian_orders') || '[]');
            var found = false;
            for (var i = 0; i < history.length; i++) {
                if (history[i].bookingCode === order.bookingCode) {
                    history[i] = Object.assign({}, history[i], order);
                    found = true;
                    break;
                }
            }
            if (!found) history.unshift(order);
            localStorage.setItem('rivian_orders', JSON.stringify(history.slice(0, 15)));
            if (order.phone) {
                localStorage.setItem('rivian_customer_phone', order.phone);
            }
            loadOrderHistory();
        } catch (e) {}
    }

    function openHistoryPhoneModal() {
        var modal = document.getElementById('historyPhonePromptModal');
        if (modal) {
            modal.classList.add('open');
            var input = document.getElementById('historyModalPhoneInput');
            var savedPhone = localStorage.getItem('rivian_customer_phone');
            if (input) {
                if (savedPhone && !input.value) {
                    input.value = savedPhone;
                }
                setTimeout(function() {
                    input.focus();
                }, 150);
            }
        }
    }

    function closeHistoryPhoneModal() {
        var modal = document.getElementById('historyPhonePromptModal');
        if (modal) modal.classList.remove('open');
    }

    async function handleHistoryPhoneSubmit(e) {
        if (e) e.preventDefault();
        var input = document.getElementById('historyModalPhoneInput');
        var phone = input ? input.value.trim() : '';

        if (!phone) {
            alert('Silakan masukkan nomor WhatsApp / HP Anda.');
            return;
        }

        var cleanPhone = phone.replace(/[^0-9]/g, '');
        if (cleanPhone.length < 8) {
            alert('Nomor HP tidak valid (minimal 8 digit).');
            return;
        }

        var btn = document.getElementById('btnSubmitHistoryPhone');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-circle-notch fa-spin"></i> <span>Mencari Tiket...</span>';
        }

        try {
            // Coba login / daftarkan customer berdasarkan nomor HP
            var loginData = new FormData();
            loginData.append('phone', cleanPhone);

            var loginRes = await fetch('/travell/customer/login', {
                method: 'POST'
                , headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    , 'Accept': 'application/json'
                    , 'X-CSRF-TOKEN': CSRF_TOKEN
                }
                , body: loginData
            });

            var loginJson = await loginRes.json();
            if (loginJson && loginJson.success && loginJson.customer) {
                setStoredCustomer(loginJson.customer);
            } else {
                localStorage.setItem('rivian_customer_phone', cleanPhone);
                setStoredCustomer({
                    name: 'Pelanggan'
                    , phone: cleanPhone
                    , points: 0
                });
            }

            // Sinkronkan input lookup tiket di halaman history
            var lookupIn = document.getElementById('lookupPhoneInput');
            if (lookupIn) lookupIn.value = cleanPhone;

            closeHistoryPhoneModal();
            await fetchTicketsByPhone(cleanPhone);
            refreshHistory();
        } catch (err) {
            console.error('Error phone login/lookup:', err);
            localStorage.setItem('rivian_customer_phone', cleanPhone);
            closeHistoryPhoneModal();
            await fetchTicketsByPhone(cleanPhone);
            refreshHistory();
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerHTML = '<span>Lihat Tiket Saya</span> <i class="fas fa-arrow-right"></i>';
            }
        }
    }

    async function handleSearchPhoneTickets(e) {
        if (e) e.preventDefault();
        var input = document.getElementById('lookupPhoneInput');
        var phone = input ? input.value.trim() : '';
        if (!phone) {
            openHistoryPhoneModal();
            return;
        }
        var cleanPhone = phone.replace(/[^0-9]/g, '');
        if (cleanPhone.length < 8) {
            alert('Nomor HP tidak valid (minimal 8 digit).');
            return;
        }
        var modalInput = document.getElementById('historyModalPhoneInput');
        if (modalInput) modalInput.value = cleanPhone;
        await handleHistoryPhoneSubmit(null);
    }

    function refreshHistoryByPhone() {
        refreshHistory();
    }

    function refreshHistory() {
        var cust = getStoredCustomer();
        var loggedInBar = document.getElementById('historyCustomerLoggedInBar');
        var guestCard = document.getElementById('historyGuestSearchCard');
        var authReqCard = document.getElementById('historyAuthRequiredCard');
        var filterBar = document.querySelector('.history-filter-bar');
        var emptyAlert = document.getElementById('emptyHistoryAlert');

        if (cust && (cust.id || cust.phone)) {
            if (loggedInBar) loggedInBar.style.display = 'block';
            if (guestCard) guestCard.style.display = 'none';
            if (authReqCard) authReqCard.style.display = 'none';
            if (filterBar) filterBar.style.display = 'flex';

            setText('historyCustName', cust.name || 'Akun Pelanggan');
            setText('historyCustPhone', (cust.phone || '') + ' • ' + (cust.points || 0) + ' Poin');

            if (cust.id) {
                fetchTicketsByCustomerId(cust.id);
            } else {
                fetchTicketsByPhone(cust.phone);
            }
        } else {
            if (loggedInBar) loggedInBar.style.display = 'none';
            if (guestCard) guestCard.style.display = 'block';

            var savedPhone = localStorage.getItem('rivian_customer_phone');
            var input = document.getElementById('lookupPhoneInput');
            if (input && savedPhone && !input.value) {
                input.value = savedPhone;
            }

            if (savedPhone) {
                if (authReqCard) authReqCard.style.display = 'none';
                if (filterBar) filterBar.style.display = 'flex';
                fetchTicketsByPhone(savedPhone);
            } else {
                if (authReqCard) authReqCard.style.display = 'block';
                if (filterBar) filterBar.style.display = 'none';
                if (emptyAlert) emptyAlert.style.display = 'none';
                var container = document.getElementById('orderHistoryContainer');
                if (container) container.innerHTML = '';
            }
        }
    }

    async function fetchTicketsByCustomerId(customerId) {
        var spinner = document.getElementById('historyLoadingSpinner');
        var emptyAlert = document.getElementById('emptyHistoryAlert');
        var btn = document.getElementById('btnLookupTickets');

        if (spinner) spinner.style.display = 'block';
        if (emptyAlert) emptyAlert.style.display = 'none';
        if (btn) btn.disabled = true;

        try {
            var formData = new FormData();
            formData.append('customer_id', customerId);

            var res = await fetch('/travell/my-tickets', {
                method: 'POST'
                , headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    , 'Accept': 'application/json'
                    , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
                , body: formData
            });

            var json = await res.json();
            if (spinner) spinner.style.display = 'none';
            if (btn) btn.disabled = false;

            if (json && json.success && Array.isArray(json.data)) {
                allHistoryOrders = json.data;

                // Merge into localStorage cache
                var localHistory = JSON.parse(localStorage.getItem('rivian_orders') || '[]');
                json.data.forEach(function(dbItem) {
                    var match = false;
                    for (var j = 0; j < localHistory.length; j++) {
                        if (localHistory[j].bookingCode === dbItem.bookingCode) {
                            localHistory[j] = Object.assign({}, localHistory[j], dbItem);
                            match = true;
                            break;
                        }
                    }
                    if (!match) localHistory.unshift(dbItem);
                });
                localStorage.setItem('rivian_orders', JSON.stringify(localHistory.slice(0, 15)));

                renderHistoryList();
            } else {
                loadOrderHistory();
            }
        } catch (err) {
            if (spinner) spinner.style.display = 'none';
            if (btn) btn.disabled = false;
            console.log('Error fetching tickets by customer_id:', err);
            loadOrderHistory();
        }
    }

    async function fetchTicketsByPhone(phone) {
        var spinner = document.getElementById('historyLoadingSpinner');
        var emptyAlert = document.getElementById('emptyHistoryAlert');
        var phoneBadge = document.getElementById('lookupPhoneBadge');
        var btn = document.getElementById('btnLookupTickets');

        if (spinner) spinner.style.display = 'block';
        if (emptyAlert) emptyAlert.style.display = 'none';
        if (btn) btn.disabled = true;

        try {
            var formData = new FormData();
            formData.append('phone', phone);

            var res = await fetch('/travell/my-tickets', {
                method: 'POST'
                , headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    , 'Accept': 'application/json'
                    , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
                , body: formData
            });

            var json = await res.json();
            if (spinner) spinner.style.display = 'none';
            if (btn) btn.disabled = false;

            if (json && json.success && Array.isArray(json.data)) {
                allHistoryOrders = json.data;
                localStorage.setItem('rivian_customer_phone', phone);
                if (phoneBadge) phoneBadge.innerText = 'Tersinkron: ' + phone;

                // Merge into localStorage cache
                var localHistory = JSON.parse(localStorage.getItem('rivian_orders') || '[]');
                json.data.forEach(function(dbItem) {
                    var match = false;
                    for (var j = 0; j < localHistory.length; j++) {
                        if (localHistory[j].bookingCode === dbItem.bookingCode) {
                            localHistory[j] = Object.assign({}, localHistory[j], dbItem);
                            match = true;
                            break;
                        }
                    }
                    if (!match) localHistory.unshift(dbItem);
                });
                localStorage.setItem('rivian_orders', JSON.stringify(localHistory.slice(0, 15)));

                renderHistoryList();
            } else {
                loadOrderHistory();
            }
        } catch (err) {
            if (spinner) spinner.style.display = 'none';
            if (btn) btn.disabled = false;
            console.log('Error fetching tickets by phone:', err);
            loadOrderHistory();
        }
    }

    function filterHistoryTabs(tab) {
        currentHistoryTab = tab;
        var tabAll = document.getElementById('tabFilterAll');
        var tabPending = document.getElementById('tabFilterPending');
        var tabConfirmed = document.getElementById('tabFilterConfirmed');

        [tabAll, tabPending, tabConfirmed].forEach(function(btn) {
            if (btn) btn.classList.remove('active');
        });

        if (tab === 'pending' && tabPending) {
            tabPending.classList.add('active');
        } else if (tab === 'confirmed' && tabConfirmed) {
            tabConfirmed.classList.add('active');
        } else if (tabAll) {
            tabAll.classList.add('active');
        }

        renderHistoryList();
    }

    function loadOrderHistory() {
        var localHistory = JSON.parse(localStorage.getItem('rivian_orders') || '[]');
        allHistoryOrders = localHistory;
        renderHistoryList();
    }

    function renderHistoryList() {
        var container = document.getElementById('orderHistoryContainer');
        var emptyAlert = document.getElementById('emptyHistoryAlert');
        var countBadge = document.getElementById('ticketCountBadge');
        if (!container) return;

        var filtered = allHistoryOrders.filter(function(item) {
            if (currentHistoryTab === 'pending') {
                return (item.bookingStatus || 'pending').toLowerCase() === 'pending';
            }
            if (currentHistoryTab === 'confirmed') {
                return (item.bookingStatus || '').toLowerCase() === 'confirmed';
            }
            return true;
        });

        if (countBadge) {
            countBadge.innerText = filtered.length + ' Tiket';
        }

        if (filtered.length === 0) {
            container.innerHTML = '';
            if (emptyAlert) emptyAlert.style.display = 'block';
            return;
        }

        if (emptyAlert) emptyAlert.style.display = 'none';

        container.innerHTML = filtered.map(function(item) {
            var bStatus = (item.bookingStatus || 'pending').toLowerCase();
            var statusPill = '';
            if (bStatus === 'confirmed' || item.paymentStatus === 'LUNAS') {
                statusPill = '<span class="status-badge paid"><i class="fas fa-circle-check"></i> LUNAS (PAID)</span>';
            } else if (bStatus === 'completed') {
                statusPill = '<span class="status-badge completed"><i class="fas fa-flag-checkered"></i> SELESAI</span>';
            } else if (bStatus === 'cancelled') {
                statusPill = '<span class="status-badge cancelled"><i class="fas fa-ban"></i> BATAL</span>';
            } else {
                statusPill = '<span class="status-badge pending"><i class="fas fa-clock"></i> VERIFIKASI PEMBAYARAN</span>';
            }

            return '<div class="history-order-card">' +
                '<div class="history-card-header">' +
                '<div>' +
                '<div class="history-booking-code">#' + item.bookingCode + '</div>' +
                '<div class="history-booking-date"><i class="far fa-calendar-alt"></i> ' + (item.createdAt || 'Hari ini') + '</div>' +
                '</div>' +
                statusPill +
                '</div>' +

                '<div class="history-route-box">' +
                '<div class="history-route-cities">' +
                '<span>' + item.origin + '</span>' +
                '<i class="fas fa-arrow-right"></i>' +
                '<span>' + item.destination + '</span>' +
                '</div>' +
                '<div class="history-route-meta">' +
                '<span><i class="far fa-clock"></i> ' + (item.departureDate || '-') + ' (' + item.departureTime + ')</span>' +
                '<span class="history-seats-tag"><i class="fas fa-chair"></i> ' + (item.seats || '4 Kursi') + '</span>' +
                '</div>' +
                '</div>' +

                '<div class="history-card-footer">' +
                '<div>' +
                '<div class="history-total-label">Total Tagihan</div>' +
                '<div class="history-total-price">' + item.totalFormatted + '</div>' +
                '</div>' +
                '<button type="button" onclick="viewHistoryDetail(\'' + item.bookingCode + '\')" class="history-open-ticket-btn">' +
                '<i class="fas fa-ticket"></i>' +
                '<span>Buka E-Ticket</span>' +
                '</button>' +
                '</div>' +
                '</div>';
        }).join('');
    }

    function viewHistoryDetail(bookingCode) {
        try {
            for (var i = 0; i < allHistoryOrders.length; i++) {
                if (allHistoryOrders[i].bookingCode === bookingCode) {
                    state.currentOrder = allHistoryOrders[i];
                    renderTicket(allHistoryOrders[i]);
                    switchView('viewSuccessTicket');
                    return;
                }
            }
            // Fallback to local
            var history = JSON.parse(localStorage.getItem('rivian_orders') || '[]');
            for (var j = 0; j < history.length; j++) {
                if (history[j].bookingCode === bookingCode) {
                    state.currentOrder = history[j];
                    renderTicket(history[j]);
                    switchView('viewSuccessTicket');
                    return;
                }
            }
        } catch (e) {}
    }

    // 9. Charter Mobil (Kondangan vs Liburan Rates)
    var CHARTER_PRICING = {
        'kondangan': {
            'xenia_all_new': {
                name: 'Daihatsu All New Xenia'
                , price: 750000
            }
            , 'avanza_veloz': {
                name: 'Toyota Avanza / Veloz'
                , price: 700000
            }
            , 'innova_zenix': {
                name: 'Toyota Innova Zenix VIP'
                , price: 1000000
            }
            , 'hiace_premio': {
                name: 'Toyota HiAce Premio Luxury'
                , price: 1350000
            }
        }
        , 'liburan': {
            'xenia_all_new': {
                name: 'Daihatsu All New Xenia'
                , price: 950000
            }
            , 'avanza_veloz': {
                name: 'Toyota Avanza / Veloz'
                , price: 850000
            }
            , 'innova_zenix': {
                name: 'Toyota Innova Zenix VIP'
                , price: 1250000
            }
            , 'hiace_premio': {
                name: 'Toyota HiAce Premio Luxury'
                , price: 1650000
            }
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
                method: 'POST'
                , headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                    , 'Accept': 'application/json'
                }
                , body: formData
            });
            var data = await res.json();
            if (data && data.success && data.data) {
                bookingCode = data.data.booking_code || bookingCode;
                qrisPayload = data.data.qris_payload || null;
                qrisImageUrl = data.data.qris_image_url || null;
                if (data.data.formatted_amount) {
                    finalTotalFormatted = data.data.formatted_amount;
                }
                if (data.data.customer_phone) {
                    var cust = getStoredCustomer() || {};
                    cust.phone = data.data.customer_phone;
                    cust.name = data.data.customer_name || name;
                    if (data.data.customer_points !== undefined) {
                        cust.points = data.data.customer_points;
                    }
                    setStoredCustomer(cust);
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
            id: 'ORD-CHR-' + Date.now()
            , bookingCode: bookingCode
            , orderType: 'CHARTER'
            , passengerName: name
            , phone: phone
            , origin: orig
            , destination: dest
            , departureTime: (purpose === 'kondangan' ? 'Kondangan (12 Jam)' : 'Liburan (24 Jam)')
            , departureDate: date
            , seats: fleetInfo.name + ' (' + days + ' Hari)'
            , pickupAddress: pickup
            , dropoffAddress: dest
            , fleetName: fleetInfo.name
            , totalPrice: total
            , totalFormatted: finalTotalFormatted
            , qrisPayload: qrisPayload
            , qrisImageUrl: qrisImageUrl
            , paymentStatus: 'MENUNGGU PEMBAYARAN'
            , createdAt: new Date().toISOString()
        };

        saveOrderToHistory(state.currentOrder);
        renderPaymentScreen(state.currentOrder);
        switchView('viewPayment');
    }

    // 10. Paket Kilat
    var PACKAGE_RATES = {
        'dokumen': {
            name: 'Dokumen / Surat Penting'
            , price: 50000
        }
        , 'barang_kecil': {
            name: 'Barang Kecil (< 5 kg)'
            , price: 75000
        }
        , 'barang_sedang': {
            name: 'Kardus Sedang (< 15 kg)'
            , price: 120000
        }
        , 'frozen_food': {
            name: 'Makanan / Frozen Kilat'
            , price: 90000
        }
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
