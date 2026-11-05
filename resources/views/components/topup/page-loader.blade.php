{{--
    Loader halaman top up. Tidak tampil saat navigasi cepat: baru muncul bila berpindah halaman
    memakan waktu lebih dari 300 ms, sehingga halaman yang cepat tidak berkedip.
    Juga memicu prefetch halaman game saat pengguna menyentuh/menghover kartu (agar terbuka lebih cepat).
--}}
<div id="topup-page-loader" role="status" aria-live="polite" aria-hidden="true" style="display:none;opacity:0"
     class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#0B1120]/90 backdrop-blur-md transition-opacity duration-200">
    <div class="absolute w-64 h-64 bg-blue-500/15 rounded-full blur-[80px] pointer-events-none"></div>
    <div class="absolute w-64 h-64 bg-indigo-500/15 rounded-full blur-[80px] pointer-events-none translate-x-12 translate-y-12"></div>

    <div class="relative z-10 flex items-center justify-center">
        <div class="w-20 h-20 border-[3px] border-blue-400/15 rounded-full"></div>
        <div class="absolute w-20 h-20 border-[3px] border-transparent border-t-blue-400 border-r-indigo-400 rounded-full animate-spin"></div>
        <div class="absolute w-14 h-14 border-2 border-transparent border-b-cyan-400 border-l-sky-400 rounded-full animate-spin" style="animation-direction:reverse;animation-duration:1.5s"></div>
        <div class="absolute w-11 h-11 bg-slate-900/90 border border-white/10 rounded-full flex items-center justify-center shadow-xl shadow-blue-500/20">
            <i class="fa-solid fa-bolt text-cyan-300 text-sm animate-pulse"></i>
        </div>
    </div>

    <div class="relative z-10 mt-4 text-center px-4">
        <p id="topup-page-loader-text" class="text-xs font-bold tracking-wider text-slate-200 uppercase">Memuat...</p>
        <p class="text-[10px] text-slate-400 mt-0.5 font-medium">Mohon tunggu sebentar</p>
    </div>
</div>

<script>
(function () {
    if (window.__topupLoader) return;
    window.__topupLoader = true;

    const DELAY = 300;      // ms sebelum loader muncul
    const SAFETY = 15000;   // ms: loader pasti hilang bila jaringan macet
    let showTimer = null, safetyTimer = null;
    const el = () => document.getElementById('topup-page-loader');

    function show(msg) {
        clearTimeout(showTimer);
        showTimer = setTimeout(() => {
            const l = el(); if (!l) return;
            const t = document.getElementById('topup-page-loader-text'); if (t && msg) t.textContent = msg;
            l.style.display = 'flex'; l.setAttribute('aria-hidden', 'false');
            void l.offsetWidth; l.style.opacity = '1';
            clearTimeout(safetyTimer); safetyTimer = setTimeout(hide, SAFETY);
        }, DELAY);
    }

    function hide() {
        clearTimeout(showTimer); clearTimeout(safetyTimer);
        const l = el(); if (!l) return;
        l.style.opacity = '0'; l.setAttribute('aria-hidden', 'true');
        setTimeout(() => { if (l.style.opacity === '0') l.style.display = 'none'; }, 200);
    }

    // Kembali lewat tombol Back (bfcache) tidak memicu load ulang, pastikan loader tertutup.
    window.addEventListener('pageshow', hide);

    document.addEventListener('click', (e) => {
        if (e.defaultPrevented || e.button !== 0 || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
        const a = e.target.closest && e.target.closest('a[href]');
        if (!a || a.target === '_blank' || a.hasAttribute('download')) return;
        const href = a.getAttribute('href');
        if (!href || href.startsWith('#') || /^(javascript|mailto|tel):/i.test(href)) return;
        const url = new URL(a.href, location.href);
        if (url.origin !== location.origin || (url.pathname === location.pathname && url.search === location.search)) return;
        show('Memuat halaman...');
    });

    // Form biasa (login/daftar). Form yang ditangani JS (checkout) sudah memanggil preventDefault.
    document.addEventListener('submit', (e) => {
        if (e.defaultPrevented || e.target.target === '_blank') return;
        show('Memproses...');
    });

    // Prefetch halaman game ketika pengguna menunjukkan niat membuka (hover / sentuh).
    const prefetched = new Set();
    function prefetch(e) {
        const a = e.target.closest && e.target.closest('a[href*="/top-up-game/"]');
        if (!a || prefetched.has(a.href) || navigator.connection?.saveData) return;
        const url = new URL(a.href, location.href);
        if (url.origin !== location.origin) return;
        prefetched.add(a.href);
        const l = document.createElement('link'); l.rel = 'prefetch'; l.href = a.href; l.as = 'document';
        document.head.appendChild(l);
    }
    document.addEventListener('pointerover', prefetch, { passive: true });
    document.addEventListener('touchstart', prefetch, { passive: true });
})();
</script>
