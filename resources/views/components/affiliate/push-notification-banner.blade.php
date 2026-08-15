<div id="quick-setup-card" class="mb-6 glass-card rounded-2xl p-4 border border-white/10">
    <h3 class="text-[11px] font-bold text-slate-400 mb-3 uppercase tracking-wider flex items-center gap-2">
        <i class="fa-solid fa-bolt text-yellow-400"></i> Pengaturan Cepat
    </h3>

    <!-- Install App -->
    <div class="flex items-center justify-between mb-3 pb-3 border-b border-white/5">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-indigo-500/20 text-indigo-400 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-mobile-screen"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-white leading-tight">Aplikasi HP</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Install ke layar utama</p>
            </div>
        </div>
        <button id="quick-install-btn" class="px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white text-[11px] font-bold rounded-lg transition-colors shadow-sm">
            Install
        </button>
        <div id="quick-installed-badge" class="hidden px-3 py-1.5 bg-emerald-500/20 text-emerald-400 text-[11px] font-bold rounded-lg border border-emerald-500/30">
            <i class="fa-solid fa-check mr-1"></i> Terinstall
        </div>
    </div>

    <!-- Push Notification Toggle -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-blue-500/20 text-blue-400 flex items-center justify-center shrink-0">
                <i class="fa-solid fa-bell"></i>
            </div>
            <div>
                <p class="text-sm font-bold text-white leading-tight">Pengingat Harian</p>
                <p class="text-[10px] text-slate-400 mt-0.5">Notifikasi jam 10 pagi</p>
            </div>
        </div>

        <!-- Toggle Switch -->
        <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" id="quick-notify-toggle" class="sr-only peer">
            <div class="w-9 h-5 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-500"></div>
        </label>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const installBtn = document.getElementById('quick-install-btn');
        const installedBadge = document.getElementById('quick-installed-badge');
        const notifyToggle = document.getElementById('quick-notify-toggle');

        let deferredPrompt;
        let isStandalone = (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches) || window.navigator.standalone === true;
        let pushGranted = (typeof Notification !== 'undefined' && Notification.permission === 'granted');

        // Setup Initial UI State
        if (isStandalone) {
            installBtn.classList.add('hidden');
            installedBadge.classList.remove('hidden');
            installedBadge.classList.add('flex');
        }

        if (pushGranted) {
            notifyToggle.checked = true;
            notifyToggle.disabled = true; // Kalau sudah diizinkan, browser tidak mengizinkan disable via script
        } else if (typeof Notification !== 'undefined' && Notification.permission === 'denied') {
            notifyToggle.disabled = true;
        }

        // Tangkap event PWA (Android / Chrome Desktop)
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
        });

        // Install Button Logic
        installBtn.addEventListener('click', async () => {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                const {
                    outcome
                } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    deferredPrompt = null;
                    installBtn.classList.add('hidden');
                    installedBadge.classList.remove('hidden');
                    installedBadge.classList.add('flex');
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

        // VAPID Public Key
        const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";

        function urlB64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);
            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }

        // Toggle Logic
        notifyToggle.addEventListener('change', async function() {
            if (this.checked) {
                // Coba request permission
                this.disabled = true; // disable sementara saat loading

                try {
                    const permission = await Notification.requestPermission();

                    if (permission === 'granted') {
                        await subscribeUserToPush();
                    } else {
                        // User klik block atau dismiss
                        this.checked = false;
                        if (permission === 'denied') {
                            this.disabled = true;
                            if (typeof showToast === 'function') showToast('Izin notifikasi diblokir browser', 'error');
                        } else {
                            this.disabled = false;
                        }
                    }
                } catch (error) {
                    console.error('Error:', error);
                    this.checked = false;
                    this.disabled = false;
                }
            }
        });

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
                notifyToggle.checked = false;
                notifyToggle.disabled = false;
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
