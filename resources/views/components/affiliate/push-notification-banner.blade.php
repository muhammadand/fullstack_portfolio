<div id="quick-setup-card" class="mb-6 glass-card rounded-2xl p-4 border border-white/10">
    <h3 class="text-[11px] font-bold text-slate-400 mb-3 uppercase tracking-wider flex items-center gap-2">
        <i class="fa-solid fa-bell text-blue-400"></i> Pengingat Otomatis
    </h3>

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
        const notifyToggle = document.getElementById('quick-notify-toggle');
        let pushGranted = (typeof Notification !== 'undefined' && Notification.permission === 'granted');

        // Setup Initial UI State
        if (pushGranted) {
            notifyToggle.checked = true;
            notifyToggle.disabled = true; // Kalau sudah diizinkan, browser tidak mengizinkan disable via script
        } else if (typeof Notification !== 'undefined' && Notification.permission === 'denied') {
            notifyToggle.disabled = true;
        }

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
        if (notifyToggle) {
            notifyToggle.addEventListener('change', async function() {
                if (this.checked) {
                    // Coba request permission
                    this.disabled = true; // disable sementara saat loading

                    try {
                        if (typeof Notification === 'undefined' || !Notification.requestPermission) {
                            throw new Error("Browser/HP ini tidak mendukung notifikasi atau Anda belum menggunakan link HTTPS.");
                        }

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
                        if (typeof showToast === 'function') {
                            showToast(error.message, 'error');
                        } else {
                            alert("Gagal: " + error.message);
                        }
                    }
                }
            });
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
