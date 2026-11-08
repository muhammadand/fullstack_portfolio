{{--
    Standar tampilan admin di HP (< 1024px). Berlaku untuk SEMUA halaman di dalam <main>,
    termasuk halaman yang memakai markup sendiri. Desktop (>= 1024px) tidak terpengaruh.

    Skala tipografi HP: judul halaman 16px, angka stat 18px, isi 14px, keterangan 12px, label 11px.

    Tabel: di HP (< 768px) setiap tabel ber-<thead> otomatis tampil sebagai kartu (label kolom : nilai).
    Kecualikan dengan <table data-no-stack>. Halaman yang punya versi kartu sendiri menyembunyikan tabelnya (hidden md:block).
--}}
<style>
    .admin-num { font-variant-numeric: tabular-nums; overflow-wrap: anywhere; }

    @media (max-width: 1023.98px) {
        /* Tipografi: batasi heading besar dari markup lama. */
        main .text-4xl { font-size: 1.5rem !important; line-height: 2rem !important; }
        main .text-3xl { font-size: 1.375rem !important; line-height: 1.875rem !important; }
        main .text-2xl { font-size: 1.25rem !important; line-height: 1.75rem !important; }
        main .text-xl  { font-size: 1.0625rem !important; line-height: 1.5rem !important; }

        /* Kartu: padding seragam 16px, tanpa efek hover yang mengganggu di layar sentuh. */
        main .p-5, main .p-6, main .p-8 { padding: 1rem !important; }
        main .hover\:-translate-y-0\.5:hover { transform: none !important; }

        /* Isi kartu tidak boleh meluber: item grid boleh menyusut, teks panjang dipatahkan. */
        main .grid > * { min-width: 0; }
        main h1, main h2, main h3, main p, main dd, main td { overflow-wrap: anywhere; }

        /* Tabel: ringkas, bisa digeser di dalam kartu, header tidak terlipat. */
        main table { font-size: 0.75rem; }
        main table :is(th, td) { padding: 0.5rem 0.625rem !important; }
        main table th { white-space: nowrap; }
        main .overflow-x-auto { -webkit-overflow-scrolling: touch; overscroll-behavior-x: contain; }

        /* Header halaman: tombol ber-ikon jadi kotak ikon 40px (label tetap dibaca screen reader lewat aria-label). */
        .admin-header-actions :is(a, button):has(> i) { width: 2.5rem; height: 2.5rem; padding: 0; }
        .admin-header-actions :is(a, button):has(> i) .admin-btn-label { display: none; }

        /* Input: 16px agar iOS tidak auto-zoom saat fokus. */
        main :is(input, select, textarea):not([type=checkbox]):not([type=radio]) { font-size: 16px; }
    }
    @media (max-width: 767.98px) {
        main table.admin-stack, main table.admin-stack > tbody, main table.admin-stack > tbody > tr, main table.admin-stack > tbody > tr > td { display: block; width: 100%; }
        main table.admin-stack > thead { display: none; }
        main .overflow-x-auto:has(> table.admin-stack) { overflow: visible; }
        main table.admin-stack > tbody { border: 0 !important; }
        main table.admin-stack > tbody > tr { background: #fff; border: 1px solid #e2e8f0 !important; border-radius: 0.75rem; padding: 0.375rem 0.75rem; margin: 0.625rem; width: auto; }
        main table.admin-stack > tbody > tr > td { display: flex; align-items: flex-start; justify-content: space-between; gap: 0.75rem; padding: 0.375rem 0 !important; border: 0 !important; text-align: right; white-space: normal !important; max-width: none !important; }
        main table.admin-stack > tbody > tr > td + td { border-top: 1px dashed #f1f5f9 !important; }
        main table.admin-stack > tbody > tr > td::before { content: attr(data-label); flex-shrink: 0; max-width: 42%; text-align: left; font-size: 11px; font-weight: 600; color: #64748b; text-transform: none; }
        main table.admin-stack > tbody > tr > td:not([data-label])::before, main table.admin-stack > tbody > tr > td[data-label=""]::before { display: none; }
        main table.admin-stack > tbody > tr > td[colspan] { justify-content: center; text-align: center; }
        main table.admin-stack > tbody > tr > td > * { min-width: 0; }
        main table.admin-stack > tbody > tr > td :is(.truncate) { max-width: 100%; }
    }
</style>
<script>
    // Beri label kolom ke setiap sel agar tabel bisa tampil sebagai kartu di HP. Dijalankan ulang saat konten berubah (Livewire).
    (function () {
        const stack = () => document.querySelectorAll('main table:not([data-no-stack])').forEach((table) => {
            const heads = [...table.querySelectorAll(':scope > thead th')].map((th) => th.textContent.replace(/\s+/g, ' ').trim());
            if (!heads.length) return;
            table.classList.add('admin-stack');
            table.querySelectorAll(':scope > tbody > tr').forEach((tr) => {
                [...tr.children].forEach((td, i) => {
                    if (!td.hasAttribute('colspan') && heads[i] !== undefined && td.dataset.label !== heads[i]) td.dataset.label = heads[i];
                });
            });
        });
        document.addEventListener('DOMContentLoaded', () => {
            stack();
            const main = document.querySelector('main');
            if (main) {
                let t;
                new MutationObserver(() => { clearTimeout(t); t = setTimeout(stack, 50); }).observe(main, { childList: true, subtree: true });
            }
        });
    })();
</script>
