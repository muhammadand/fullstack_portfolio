<div id="setup-banner" class="hidden mb-6">
    <div class="glass-card rounded-2xl p-4 border border-blue-500/30">
        <h4 class="text-white text-sm font-bold mb-3 flex items-center gap-2">
            <i class="fa-solid fa-gear text-blue-400"></i> Pengaturan Disarankan
        </h4>

        <div class="space-y-3">
            <!-- Install App Item -->
            <div id="install-app-item" class="hidden items-center justify-between gap-4 p-3 bg-white/5 rounded-xl border border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-indigo-500/20 flex items-center justify-center flex-shrink-0 text-indigo-400">
                        <i class="fa-solid fa-mobile-screen-button text-sm"></i>
                    </div>
                    <div>
                        <h5 class="text-white text-xs font-bold">Install Aplikasi</h5>
                        <p class="text-white/60 text-[10px] mt-0.5">Akses lebih cepat dari layar utama.</p>
                    </div>
                </div>
                <button id="install-app-btn" class="px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white text-[11px] font-bold rounded-lg transition-colors whitespace-nowrap flex-shrink-0">
                    Install
                </button>
            </div>

            <!-- Push Notification Item -->
            <div id="push-notif-item" class="hidden items-center justify-between gap-4 p-3 bg-white/5 rounded-xl border border-white/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0 text-blue-400">
                        <i class="fa-solid fa-bell text-sm"></i>
                    </div>
                    <div>
                        <h5 class="text-white text-xs font-bold">Aktifkan Pengingat</h5>
                        <p class="text-white/60 text-[10px] mt-0.5">Dapatkan notifikasi harian otomatis.</p>
                    </div>
                </div>
                <button id="enable-push-btn" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-[11px] font-bold rounded-lg transition-colors whitespace-nowrap flex-shrink-0">
                    Aktifkan
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const setupBanner = document.getElementById('setup-banner');
        const installItem = document.getElementById('install-app-item');
        const notifItem = document.getElementById('push-notif-item');
        const installBtn = document.getElementById('install-app-btn');
        const enablePushBtn = document.getElementById('enable-push-btn');

        let deferredPrompt;
        let isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        let pushGranted = ('Notification' in window) ? (Notification.permission === 'granted') : false;

        function evaluateBannerVisibility() {
            let showAny = false;

            // Cek status aplikasi terinstall (hanya muncul kalau diakses via browser)
            if (!isStandalone) {
                installItem.classList.remove('hidden');
                installItem.classList.add('flex');
                showAny = true;
            } else {
                installItem.classList.add('hidden');
                installItem.classList.remove('flex');
            }

            // Cek status push notification (hanya muncul kalau belum diizinkan dan tidak ditolak)
            if ('serviceWorker' in navigator && 'PushManager' in window && !pushGranted) {
                if (Notification.permission !== 'denied') {
                    notifItem.classList.remove('hidden');
                    notifItem.classList.add('flex');
                    showAny = true;
                }
            } else {
                notifItem.classList.add('hidden');
                notifItem.classList.remove('flex');
            }

            // Tampilkan/Sembunyikan Card Induk
            if (showAny) {
                setupBanner.classList.remove('hidden');
            } else {
                setupBanner.classList.add('hidden');
            }
        }

        // Tangkap event PWA (Android / Chrome Desktop)
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
        });

        installBtn.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const {
                    outcome
                } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    deferredPrompt = null;
                    isStandalone = true;
                    evaluateBannerVisibility();
                }
            } else {
                // Deteksi iOS Safari
                const isIos = /ipad|iphone|ipod/.test(navigator.userAgent.toLowerCase());
                if (isIos) {
                    alert('Untuk menginstall di iPhone/iPad:\n1. Tekan tombol Share (Kotak dengan panah ke atas) di menu bawah Safari\n2. Geser ke bawah lalu pilih "Add to Home Screen"');
                } else {
                    alert('Untuk menginstall, tekan tombol opsi (tiga titik) di browser Anda, lalu cari menu "Install App" atau "Add to Home Screen".');
                }
            }
        });

        enablePushBtn.addEventListener('click', async () => {
            enablePushBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            enablePushBtn.disabled = true;

            try {
                const permission = await Notification.requestPermission();

                if (permission === 'granted') {
                    pushGranted = true;
                    evaluateBannerVisibility();
                    subscribeUserToPush();
                } else {
                    enablePushBtn.innerHTML = 'Ditolak';
                    setTimeout(() => {
                        notifItem.classList.add('hidden');
                        notifItem.classList.remove('flex');
                        evaluateBannerVisibility();
                    }, 2000);
                }
            } catch (error) {
                console.error('Error requesting notification permission:', error);
                enablePushBtn.innerHTML = 'Aktifkan';
                enablePushBtn.disabled = false;
            }
        });

        evaluateBannerVisibility();

        // VAPID Public Key
        const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";

        function urlB64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }

        async function subscribeUserToPush() {
            try {
                const registration = await navigator.serviceWorker.ready;
                const subscribeOptions = {
                    userVisibleOnly: true
                    , applicationServerKey: urlB64ToUint8Array(vapidPublicKey)
                };

                const pushSubscription = await registration.pushManager.subscribe(subscribeOptions);

                await sendSubscriptionToBackEnd(pushSubscription);

                if (typeof showToast === 'function') {
                    showToast('Pengingat harian berhasil diaktifkan!', 'success');
                }
            } catch (error) {
                console.error('Error subscribing to push:', error);
                if (typeof showToast === 'function') {
                    showToast('Gagal mengaktifkan pengingat.', 'error');
                }
            }
        }

        async function sendSubscriptionToBackEnd(subscription) {
            const response = await fetch("{{ route('affiliate.push.subscribe') }}", {
                method: 'POST'
                , headers: {
                    'Content-Type': 'application/json'
                    , 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? .getAttribute('content') || "{{ csrf_token() }}"
                }
                , body: JSON.stringify(subscription)
            });

            if (!response.ok) {
                throw new Error('Bad status code from server.');
            }
            return response.json();
        }
    });

</script>
