<style>
    [x-cloak]{display:none!important}
    @keyframes tp-pop{0%{transform:scale(.3);opacity:0}60%{transform:scale(1.12);opacity:1}100%{transform:scale(1)}}
    @keyframes tp-ring{0%{transform:scale(1);opacity:.8}100%{transform:scale(1.6);opacity:0}}
    @keyframes tp-draw{from{stroke-dashoffset:40}to{stroke-dashoffset:0}}
    .tp-pop{animation:tp-pop .6s cubic-bezier(.2,.9,.3,1.2) both}
    .tp-ring{animation:tp-ring 1.6s ease-out .5s infinite}
    .tp-check{stroke-dasharray:40;stroke-dashoffset:40;animation:tp-draw .5s ease-out .45s forwards}
    @media (prefers-reduced-motion:reduce){.tp-pop,.tp-ring,.tp-check{animation:none;stroke-dashoffset:0}}
</style>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('topupForm', (cfg) => ({
        fields: cfg.fields,
        products: cfg.products,
        values: Object.fromEntries(cfg.fields.map(f => [f.key, ''])),
        touched: {},
        selected: null,
        note: '',
        email: cfg.email,
        emailTouched: false,
        submitted: false,

        // modal: none | confirm | qris | success | expired
        modal: 'none',
        paying: false,
        error: '',
        order: { no: '', qr: '', total: 0, emailMasked: '', expiresAt: null },
        countdown: '--:--',
        pollTimer: null,
        tickTimer: null,

        init() {
            this.$watch('modal', (m) => { document.body.style.overflow = m === 'none' ? '' : 'hidden'; });
        },

        get errors() {
            const e = {};
            this.fields.forEach(f => {
                const v = this.values[f.key];
                if ((this.touched[f.key] || this.submitted) && !new RegExp(f.pattern).test(v)) {
                    e[f.key] = v ? `${f.label} tidak valid` : `${f.label} wajib diisi`;
                }
            });
            if ((this.emailTouched || this.submitted) && this.email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.email)) {
                e.email = 'Format email tidak valid';
            }
            if (this.submitted && !this.selected) e.product = 'Pilih nominal terlebih dahulu';
            return e;
        },

        rupiah(n) { return 'Rp ' + Math.round(n).toLocaleString('id-ID'); },

        // Tombol Checkout: validasi lalu buka modal pembayaran (belum ada yang disimpan).
        submit() {
            this.submitted = true;
            if (Object.keys(this.errors).length) {
                this.$nextTick(() => document.querySelector('.border-red-400\\/70')?.focus());
                return;
            }
            this.error = '';
            this.modal = 'confirm';
        },

        // Tombol Bayar: buat order + tagihan QRIS di server.
        async pay() {
            if (this.paying) return;
            this.paying = true;
            this.error = '';
            try {
                const res = await fetch(cfg.checkoutUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    },
                    body: JSON.stringify({ product_id: this.selected, account: this.values, email: this.email || null, note: this.note || null }),
                });
                const json = await res.json().catch(() => ({}));
                if (!res.ok) {
                    this.error = json.errors ? Object.values(json.errors)[0][0] : (json.message || 'Gagal membuat pembayaran, coba lagi.');
                    return;
                }
                this.order = { no: json.order_no, qr: json.qr_url, total: json.total, emailMasked: '', expiresAt: new Date(json.expires_at) };
                this.modal = 'qris';
                this.startTimers();
            } catch (e) {
                this.error = 'Koneksi bermasalah, coba lagi.';
            } finally {
                this.paying = false;
            }
        },

        startTimers() {
            this.stopTimers();
            const tick = () => {
                const left = Math.max(0, Math.floor((this.order.expiresAt - Date.now()) / 1000));
                this.countdown = String(Math.floor(left / 60)).padStart(2, '0') + ':' + String(left % 60).padStart(2, '0');
                if (left === 0 && this.modal === 'qris') { this.stopTimers(); this.modal = 'expired'; }
            };
            tick();
            this.tickTimer = setInterval(tick, 1000);
            this.pollTimer = setInterval(() => this.poll(), 3000);
        },

        stopTimers() { clearInterval(this.pollTimer); clearInterval(this.tickTimer); },

        async poll() {
            if (this.modal !== 'qris') return;
            try {
                const res = await fetch(cfg.statusUrl.replace('__NO__', this.order.no), { headers: { 'Accept': 'application/json' } });
                if (!res.ok) return;
                const s = await res.json();
                if (s.is_paid) {
                    this.order.emailMasked = s.email || '';
                    this.stopTimers();
                    this.modal = 'success';
                } else if (s.is_expired) {
                    this.stopTimers();
                    this.modal = 'expired';
                }
            } catch (e) { /* jaringan putus sesaat, coba lagi di siklus berikutnya */ }
        },

        closeModal() {
            if (this.paying) return;
            this.stopTimers();
            this.modal = 'none';
        },

        // Setelah sukses: kosongkan form untuk top up berikutnya.
        finish() {
            this.modal = 'none';
            this.selected = null;
            this.submitted = false;
            this.touched = {};
            this.fields.forEach(f => this.values[f.key] = '');
            this.note = '';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
    }));
});
</script>
