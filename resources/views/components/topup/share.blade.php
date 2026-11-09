{{--
    Tombol + lembar "Bagikan" halaman top up.
    - HP (iPhone/Android): tombol utama membuka lembar berbagi bawaan (Web Share API) -> semua aplikasi, termasuk IG & TikTok.
    - Pilihan langsung: WhatsApp, Telegram, Facebook, Threads, X. Instagram & TikTok tidak punya link share web:
      caption + link disalin dulu, lalu aplikasinya dibuka.
    Props: url (link yang dibagikan), text (caption tanpa link), title.
--}}
@props(['url', 'text', 'title' => 'Top Up Game'])
@php
    $full = $text . "\n\n" . $url;
    $enc = fn ($v) => rawurlencode($v);
    $targets = [
        ['WhatsApp', 'fa-brands fa-whatsapp', 'background:#25D366', 'https://wa.me/?text=' . $enc($full)],
        ['Telegram', 'fa-brands fa-telegram', 'background:#229ED9', 'https://t.me/share/url?url=' . $enc($url) . '&text=' . $enc($text)],
        ['Facebook', 'fa-brands fa-facebook-f', 'background:#1877F2', 'https://www.facebook.com/sharer/sharer.php?u=' . $enc($url) . '&quote=' . $enc($text)],
        ['Threads', 'fa-brands fa-threads', 'background:#000;border:1px solid rgba(255,255,255,.2)', 'https://www.threads.net/intent/post?text=' . $enc($full)],
        ['X', 'fa-brands fa-x-twitter', 'background:#000;border:1px solid rgba(255,255,255,.2)', 'https://twitter.com/intent/tweet?text=' . $enc($text) . '&url=' . $enc($url)],
    ];
    // Tanpa link share web: salin caption, lalu buka aplikasinya.
    $copyApps = [
        ['Instagram', 'fa-brands fa-instagram', 'background:linear-gradient(45deg,#F58529,#DD2A7B,#8134AF)', 'instagram://app', 'https://www.instagram.com/'],
        ['TikTok', 'fa-brands fa-tiktok', 'background:#000;border:1px solid rgba(255,255,255,.2)', 'snssdk1233://', 'https://www.tiktok.com/'],
    ];
@endphp

<div x-data="{
        open: false, copied: '',
        share: @js(['title' => $title, 'text' => $text, 'url' => $url, 'full' => $full]),
        async start() {
            // HP: lembar berbagi bawaan (bisa ke semua aplikasi). Desktop / tidak didukung: buka pilihan.
            if (navigator.share && window.matchMedia('(pointer: coarse)').matches) {
                try { await navigator.share({ title: this.share.title, text: this.share.text, url: this.share.url }); return; }
                catch (e) { if (e.name === 'AbortError') return; }
            }
            this.open = true;
        },
        async copy(label) {
            try { await navigator.clipboard.writeText(this.share.full); }
            catch (e) { const t = document.createElement('textarea'); t.value = this.share.full; document.body.appendChild(t); t.select(); document.execCommand('copy'); t.remove(); }
            this.copied = label; setTimeout(() => this.copied = '', 2500);
        },
        async copyThenOpen(label, appUrl, webUrl) {
            await this.copy(label);
            const isMobile = window.matchMedia('(pointer: coarse)').matches;
            setTimeout(() => { window.location.href = isMobile ? appUrl : webUrl; }, 600);
        },
    }" {{ $attributes }}>
    <button type="button" @click="start()" data-share-button
            class="inline-flex items-center justify-center gap-2 w-full lg:w-full mt-3 px-4 py-2.5 rounded-xl bg-white/[0.06] border border-white/15 text-sm font-semibold text-white hover:bg-white/10 active:scale-[0.98] transition">
        <i class="fa-solid fa-share-nodes text-cyan-300"></i> Bagikan ke teman
    </button>

    {{-- Lembar pilihan (desktop, atau bila lembar bawaan HP tidak tersedia). Dipindah ke <body> agar
         tidak tertutup konten: induknya (kartu sticky) membuat stacking context sendiri. --}}
    <template x-teleport="body">
    <div x-show="open" x-cloak class="fixed inset-0 z-[90] flex items-end sm:items-center justify-center" role="dialog" aria-modal="true" aria-label="Bagikan" @keydown.escape.window="open = false">
        <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" @click="open = false"></div>
        <div class="relative w-full sm:max-w-md bg-[#0F172A] border border-white/10 rounded-t-3xl sm:rounded-3xl p-5 pb-[calc(1.25rem+env(safe-area-inset-bottom))]"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="translate-y-full sm:translate-y-0 sm:opacity-0" x-transition:enter-end="translate-y-0 sm:opacity-100">
            <div class="w-10 h-1.5 bg-white/15 rounded-full mx-auto mb-4 sm:hidden"></div>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-base font-bold text-white">Bagikan</h3>
                <button type="button" @click="open = false" class="w-8 h-8 rounded-full bg-white/5 text-white/60 hover:text-white" aria-label="Tutup"><i class="fa-solid fa-xmark"></i></button>
            </div>

            {{-- Pratinjau caption --}}
            <div class="rounded-2xl bg-white/[0.04] border border-white/10 p-3 text-xs text-white/75 whitespace-pre-line max-h-32 overflow-y-auto" data-share-caption>{{ $full }}</div>

            <div class="mt-4 grid grid-cols-4 gap-3 text-center">
                @foreach($targets as [$label, $icon, $style, $href])
                <a href="{{ $href }}" target="_blank" rel="noopener" class="flex flex-col items-center gap-1.5 group" data-share-target="{{ strtolower($label) }}">
                    <span class="w-12 h-12 rounded-2xl flex items-center justify-center text-white text-xl group-active:scale-95 transition" style="{{ $style }}"><i class="{{ $icon }}"></i></span>
                    <span class="text-[11px] text-white/70">{{ $label }}</span>
                </a>
                @endforeach
                @foreach($copyApps as [$label, $icon, $style, $app, $web])
                <button type="button" @click="copyThenOpen(@js($label), @js($app), @js($web))" class="flex flex-col items-center gap-1.5 group" data-share-target="{{ strtolower($label) }}">
                    <span class="w-12 h-12 rounded-2xl flex items-center justify-center text-white text-xl group-active:scale-95 transition" style="{{ $style }}"><i class="{{ $icon }}"></i></span>
                    <span class="text-[11px] text-white/70">{{ $label }}</span>
                </button>
                @endforeach
                <button type="button" @click="copy('Link')" class="flex flex-col items-center gap-1.5 group" data-share-target="copy">
                    <span class="w-12 h-12 rounded-2xl bg-white/10 flex items-center justify-center text-white text-lg group-active:scale-95 transition"><i class="fa-solid fa-link"></i></span>
                    <span class="text-[11px] text-white/70">Salin</span>
                </button>
            </div>

            <p class="mt-4 min-h-[1.25rem] text-center text-xs" aria-live="polite">
                <span x-show="copied === 'Link'" x-cloak class="text-emerald-300"><i class="fa-solid fa-check mr-1"></i>Caption & link tersalin</span>
                <span x-show="copied && copied !== 'Link'" x-cloak class="text-emerald-300"><i class="fa-solid fa-check mr-1"></i>Caption tersalin, tempel di <span x-text="copied"></span></span>
                <span x-show="!copied" class="text-white/40">Instagram &amp; TikTok: caption disalin otomatis, tinggal tempel di story/bio.</span>
            </p>
        </div>
    </div>
    </template>
</div>
