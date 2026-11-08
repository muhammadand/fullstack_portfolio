{{--
    Standar tampilan admin di HP (< 1024px). Berlaku untuk SEMUA halaman di dalam <main>,
    termasuk halaman yang memakai markup sendiri. Desktop (>= 1024px) tidak terpengaruh.

    Skala tipografi HP: judul halaman 16px, angka stat 20px, isi 14px, keterangan 12px, label 11px.
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

        /* Input: 16px agar iOS tidak auto-zoom saat fokus. */
        main :is(input, select, textarea):not([type=checkbox]):not([type=radio]) { font-size: 16px; }
    }
</style>
