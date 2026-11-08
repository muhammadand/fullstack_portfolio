{{-- Push notification ke HP admin: daftar perangkat lewat service worker /sw.js (dipakai bersama partner). --}}
<script>
    window.adminPush = function () {
        const VAPID = @js(config('webpush.vapid.public_key'));
        const CSRF = @js(csrf_token());
        const post = (url, body) => fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
            body: JSON.stringify(body || {}),
        });
        const toKey = (b64) => {
            const pad = '='.repeat((4 - b64.length % 4) % 4);
            const raw = atob((b64 + pad).replace(/-/g, '+').replace(/_/g, '/'));
            return Uint8Array.from([...raw].map((c) => c.charCodeAt(0)));
        };

        return {
            state: 'loading', // loading | unsupported | needs-install | denied | off | on
            busy: false,
            async init() {
                const isIos = /iphone|ipad|ipod/i.test(navigator.userAgent);
                const standalone = window.matchMedia('(display-mode: standalone)').matches || navigator.standalone;
                if (!('serviceWorker' in navigator) || !('PushManager' in window) || !VAPID) {
                    this.state = isIos && !standalone ? 'needs-install' : 'unsupported';
                    return;
                }
                if (Notification.permission === 'denied') { this.state = 'denied'; return; }
                const reg = await navigator.serviceWorker.getRegistration('/');
                const sub = reg ? await reg.pushManager.getSubscription() : null;
                this.state = sub ? 'on' : 'off';
            },
            async enable() {
                this.busy = true;
                try {
                    if (await Notification.requestPermission() !== 'granted') { this.state = 'denied'; return; }
                    const reg = await navigator.serviceWorker.register('/sw.js');
                    await navigator.serviceWorker.ready;
                    const sub = await reg.pushManager.subscribe({ userVisibleOnly: true, applicationServerKey: toKey(VAPID) });
                    const res = await post(@js(route('admin.push.subscribe')), sub.toJSON());
                    if (!res.ok) throw new Error((await res.json()).message || 'Gagal menyimpan perangkat');
                    this.state = 'on';
                    toast('success', 'Notifikasi aktif di perangkat ini');
                } catch (e) {
                    toast('error', 'Gagal mengaktifkan notifikasi: ' + e.message);
                } finally { this.busy = false; }
            },
            async disable() {
                this.busy = true;
                try {
                    const reg = await navigator.serviceWorker.getRegistration('/');
                    const sub = reg ? await reg.pushManager.getSubscription() : null;
                    if (sub) { await post(@js(route('admin.push.unsubscribe')), { endpoint: sub.endpoint }); await sub.unsubscribe(); }
                    this.state = 'off';
                    toast('info', 'Notifikasi dimatikan di perangkat ini');
                } finally { this.busy = false; }
            },
            async test() {
                const res = await post(@js(route('admin.push.test')));
                toast(res.ok ? 'success' : 'error', res.ok ? 'Notifikasi uji dikirim' : ((await res.json()).message || 'Gagal mengirim'));
            },
        };
    };
</script>
