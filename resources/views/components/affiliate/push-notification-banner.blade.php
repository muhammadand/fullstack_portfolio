<div id="push-notification-banner" class="hidden mb-6">
    <div class="glass-card rounded-2xl p-4 flex items-center justify-between gap-4 border border-blue-500/30">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center flex-shrink-0 text-blue-400">
                <i class="fa-solid fa-bell text-lg"></i>
            </div>
            <div>
                <h4 class="text-white text-sm font-bold">Aktifkan Pengingat</h4>
                <p class="text-white/60 text-[11px] leading-tight mt-0.5">Dapatkan notifikasi harian agar tidak lupa check-in API.</p>
            </div>
        </div>
        <button id="enable-push-btn" class="px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-bold rounded-lg transition-colors whitespace-nowrap flex-shrink-0">
            Aktifkan
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const banner = document.getElementById('push-notification-banner');
        const enableBtn = document.getElementById('enable-push-btn');

        // Cek dukungan push notification
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            // Tampilkan banner jika belum diberi izin
            if (Notification.permission === 'default') {
                banner.classList.remove('hidden');
            }
        }

        enableBtn.addEventListener('click', async () => {
            enableBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
            enableBtn.disabled = true;

            try {
                const permission = await Notification.requestPermission();

                if (permission === 'granted') {
                    banner.classList.add('hidden');
                    subscribeUserToPush();
                } else {
                    enableBtn.innerHTML = 'Ditolak';
                    setTimeout(() => banner.classList.add('hidden'), 2000);
                }
            } catch (error) {
                console.error('Error requesting notification permission:', error);
                enableBtn.innerHTML = 'Aktifkan';
                enableBtn.disabled = false;
            }
        });

        // VAPID Public Key - harus didapat dari file .env (atau config)
        // Kita menggunakan Blade directive untuk nge-render public key-nya
        const vapidPublicKey = "{{ config('webpush.vapid.public_key') }}";

        // Helper function
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

                // Kirim subscription ke backend
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
