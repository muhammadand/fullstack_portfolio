<script>
    document.addEventListener('DOMContentLoaded', () => {
        const installBtn = document.getElementById('header-install-btn');
        const enablePushBtn = document.getElementById('header-notify-btn');
        
        let deferredPrompt;
        let isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        let pushGranted = ('Notification' in window) ? (Notification.permission === 'granted') : false;

        function evaluateVisibility() {
            // Cek status aplikasi terinstall
            if (!isStandalone) {
                if(installBtn) {
                    installBtn.classList.remove('hidden');
                    installBtn.classList.add('flex');
                }
            } else {
                if(installBtn) {
                    installBtn.classList.add('hidden');
                    installBtn.classList.remove('flex');
                }
            }

            // Cek status push notification (jika belum diizinkan dan belum di-block)
            if ('serviceWorker' in navigator && 'PushManager' in window && !pushGranted) {
                if (Notification.permission !== 'denied') {
                    if(enablePushBtn) {
                        enablePushBtn.classList.remove('hidden');
                        enablePushBtn.classList.add('flex');
                    }
                }
            } else {
                if(enablePushBtn) {
                    enablePushBtn.classList.add('hidden');
                    enablePushBtn.classList.remove('flex');
                }
            }
        }

        // Tangkap event PWA (Android / Chrome Desktop)
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            evaluateVisibility();
        });

        if(installBtn) {
            installBtn.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    if (outcome === 'accepted') {
                        deferredPrompt = null;
                        isStandalone = true;
                        evaluateVisibility();
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
        }

        if(enablePushBtn) {
            enablePushBtn.addEventListener('click', async () => {
                enablePushBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                enablePushBtn.disabled = true;

                try {
                    const permission = await Notification.requestPermission();
                    
                    if (permission === 'granted') {
                        pushGranted = true;
                        evaluateVisibility();
                        subscribeUserToPush();
                    } else {
                        enablePushBtn.innerHTML = '<i class="fa-solid fa-bell-slash"></i>';
                        setTimeout(() => {
                            enablePushBtn.classList.add('hidden');
                            enablePushBtn.classList.remove('flex');
                        }, 2000);
                    }
                } catch (error) {
                    console.error('Error requesting notification permission:', error);
                    enablePushBtn.innerHTML = '<i class="fa-solid fa-bell-concierge"></i>';
                    enablePushBtn.disabled = false;
                }
            });
        }

        evaluateVisibility();
        
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
                    userVisibleOnly: true,
                    applicationServerKey: urlB64ToUint8Array(vapidPublicKey)
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
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || "{{ csrf_token() }}"
                },
                body: JSON.stringify(subscription)
            });

            if (!response.ok) {
                throw new Error('Bad status code from server.');
            }
            return response.json();
        }
    });
</script>
