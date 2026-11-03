<!DOCTYPE html>
<html lang="id" class="overflow-x-hidden w-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! $meta_tags ?? '' !!}
    @hasSection('meta_tags')
    @yield('meta_tags')
    @else
    <title>Scalify Intelligence — Automasi Cerdas, Tingkatkan Efisiensi dan Performa Bisnis.</title>
    <meta name="title" content="Scalify Intelligence — Automasi Cerdas, Bisnis Naik Kelas" />
    <meta name="description" content="Scalify Intelligence menghadirkan solusi kecerdasan buatan, otomasi bisnis, chatbot AI, dan analisis data untuk perusahaan dan UMKM Indonesia. Skalakan bisnis Anda dengan teknologi cerdas." />
    <meta name="keywords" content="automasi bisnis, kecerdasan buatan, AI chatbot, chatbot WhatsApp, otomasi UMKM, analisis data bisnis, sistem CRM otomatis, Scalify Intelligence, digital transformation Indonesia, landing page premium, web aplikasi bisnis" />
    <meta name="author" content="Scalify Intelligence" />
    <meta name="robots" content="index, follow" />
    <meta name="language" content="Indonesian" />
    <meta name="revisit-after" content="7 days" />

    {{-- ===== SEO: Open Graph / Facebook / WhatsApp ===== --}}
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:title" content="Scalify Intelligence — Automasi Cerdas, Bisnis Naik Kelas" />
    <meta property="og:description" content="Kami mengintegrasikan AI, sains data, dan otomasi ke sistem operasional Anda. Skalakan bisnis tanpa batas — biarkan algoritma yang bekerja." />
    <meta property="og:image" content="{{ asset('og-image.png') }}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:image:alt" content="Scalify Intelligence — Platform Automasi Bisnis AI" />
    <meta property="og:site_name" content="Scalify Intelligence" />
    <meta property="og:locale" content="id_ID" />

    {{-- ===== SEO: Twitter Card ===== --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:url" content="{{ url()->current() }}" />
    <meta name="twitter:title" content="Scalify Intelligence — Automasi Cerdas, Tingkatkan Efisiensi dan Performa Bisnis." />
    <meta name="twitter:description" content="Kami mengintegrasikan AI, sains data, dan otomasi ke sistem operasional Anda. Skalakan bisnis tanpa batas — biarkan algoritma yang bekerja." />
    <meta name="twitter:image" content="{{ asset('og-image.png') }}" />
    @endif
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- ===== SEO: JSON-LD Structured Data ===== --}}
    @verbatim
    <script type="application/ld+json">
        {
            "@context": "https://schema.org"
            , "@graph": [{
                    "@type": "Organization"
                    , "@id": "https://scalifyintellegence.my.id/#organization"
                    , "name": "Scalify Intelligence"
                    , "url": "https://scalifyintellegence.my.id"
                    , "logo": {
                        "@type": "ImageObject"
                        , "url": "https://scalifyintellegence.my.id/scalify.png"
                    }
                    , "description": "Scalify Intelligence menghadirkan solusi kecerdasan buatan, otomasi bisnis, chatbot AI, dan analisis data untuk perusahaan dan UMKM Indonesia."
                    , "contactPoint": {
                        "@type": "ContactPoint"
                        , "telephone": "+62-852-2169-4067"
                        , "contactType": "customer service"
                        , "availableLanguage": "Indonesian"
                    }
                    , "areaServed": "ID"
                    , "sameAs": [
                        "https://wa.me/6285221694067"
                    ]
                }
                , {
                    "@type": "WebSite"
                    , "@id": "https://scalifyintellegence.my.id/#website"
                    , "url": "https://scalifyintellegence.my.id"
                    , "name": "Scalify Intelligence"
                    , "publisher": {
                        "@id": "https://scalifyintellegence.my.id/#organization"
                    }
                    , "inLanguage": "id-ID"
                }
                , {
                    "@type": "WebPage"
                    , "@id": "https://scalifyintellegence.my.id/#webpage"
                    , "url": "https://scalifyintellegence.my.id"
                    , "name": "Scalify Intelligence — Automasi Cerdas, Bisnis Naik Kelas"
                    , "isPartOf": {
                        "@id": "https://scalifyintellegence.my.id/#website"
                    }
                    , "about": {
                        "@id": "https://scalifyintellegence.my.id/#organization"
                    }
                    , "description": "Kami mengintegrasikan kecerdasan buatan, sains data, dan automasi ke dalam sistem operasional Anda. Skalakan bisnis tanpa batas, biarkan algoritma yang bekerja."
                }
                , {
                    "@type": "LocalBusiness"
                    , "name": "Scalify Intelligence"
                    , "image": "https://scalifyintellegence.my.id/og-image.png"
                    , "url": "https://scalifyintellegence.my.id"
                    , "telephone": "+62-852-2169-4067"
                    , "priceRange": "$$"
                    , "address": {
                        "@type": "PostalAddress"
                        , "addressCountry": "ID"
                    }
                    , "description": "Solusi teknologi AI dan otomasi bisnis untuk perusahaan dan UMKM Indonesia."
                    , "openingHours": "Mo-Su 00:00-24:00"
                    , "hasOfferCatalog": {
                        "@type": "OfferCatalog"
                        , "name": "Layanan Scalify Intelligence"
                        , "itemListElement": [{
                                "@type": "Offer"
                                , "itemOffered": {
                                    "@type": "Service"
                                    , "name": "Digital Presence"
                                    , "description": "Landing page elegan, company profile website, desain responsif dan cepat."
                                }
                            }
                            , {
                                "@type": "Offer"
                                , "itemOffered": {
                                    "@type": "Service"
                                    , "name": "Smart Automation"
                                    , "description": "Web/aplikasi bisnis kustom, integrasi chatbot AI (Flowise), sistem automasi order/kasir."
                                }
                            }
                            , {
                                "@type": "Offer"
                                , "itemOffered": {
                                    "@type": "Service"
                                    , "name": "Intelligence & Data"
                                    , "description": "Segmentasi pasar (K-Means), prediksi bisnis (Metode C45), arsitektur data terpusat."
                                }
                            }
                        ]
                    }
                }
            ]
        }

    </script>
    @endverbatim

    {{-- ===== Performance: DNS Prefetch & Preconnect ===== --}}
    <link rel="dns-prefetch" href="//fonts.googleapis.com" />
    <link rel="dns-prefetch" href="//cdnjs.cloudflare.com" />
    <link rel="dns-prefetch" href="//www.youtube.com" />

    {{-- Alpine Plugins --}}
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>
    {{-- Alpine Core --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('scalify.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"></noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">

    @stack('meta')
    @stack('styles')
</head>

<body class="bg-brand-dark text-white font-sans overflow-x-hidden scroll-smooth">

    <div class="@hasSection('hide_navbar_mobile') hidden md:block @endif">
        @include('layouts.navbar')
    </div>
    <main id="main-content">
        @yield('content')
    </main>
    <div class="@hasSection('hide_footer_mobile') hidden md:block @endif">
        @php $footerProposals = \App\Models\ClientProposal::take(3)->get(['slug', 'brand_name']); @endphp
        <footer class="bg-brand-navy border-t border-white/5 pt-10 pb-6 px-5 sm:px-6 text-white/60 text-xs">
            <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-[1.3fr_1fr_1fr_1.3fr] gap-x-6 gap-y-8 md:gap-x-10 mb-8">

                {{-- Brand --}}
                <div class="col-span-2 md:col-span-1 flex flex-col gap-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-btn-gradient flex items-center justify-center shadow-glow-sm">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <span class="font-display font-bold text-base text-white/85 tracking-wide">Scalify<span class="text-brand-accent"> Intelligence</span></span>
                    </div>
                    <p class="max-w-xs leading-relaxed text-white/50">
                        Solusi cerdas automasi AI. Tingkatkan efisiensi dan performa bisnis Anda ke level berikutnya.
                    </p>
                </div>

                {{-- Program & Karir --}}
                <nav aria-label="Program dan karir" class="flex flex-col gap-2.5">
                    <h3 class="text-white/80 font-bold text-[11px] tracking-wider uppercase mb-0.5">Program</h3>
                    <a href="{{ route('sobat-scalify') }}" class="flex items-center gap-2 text-white/60 hover:text-amber-400 transition-colors">
                        <i class="fa-solid fa-handshake text-amber-400 text-[11px] w-4 text-center"></i><span>Sobat Scalify</span>
                    </a>
                    <a href="{{ route('landing.careers') }}" class="flex items-center gap-2 text-white/60 hover:text-emerald-400 transition-colors">
                        <i class="fa-solid fa-briefcase text-emerald-400 text-[11px] w-4 text-center"></i><span>Karir</span>
                    </a>
                    <a href="{{ route('landing.portfolio') }}" class="flex items-center gap-2 text-white/60 hover:text-brand-accent transition-colors">
                        <i class="fa-solid fa-laptop-code text-brand-accent/80 text-[11px] w-4 text-center"></i><span>Portofolio</span>
                    </a>
                </nav>

                {{-- Project Khusus (dinamis dari database) --}}
                @if($footerProposals->isNotEmpty())
                <nav aria-label="Project khusus" class="flex flex-col gap-2.5">
                    <h3 class="text-white/80 font-bold text-[11px] tracking-wider uppercase mb-0.5">Project Khusus</h3>
                    @foreach($footerProposals as $proposal)
                    <a href="{{ route('landing.dynamic', $proposal->slug) }}" class="flex items-center gap-2 text-white/60 hover:text-white transition-colors min-w-0">
                        <i class="fa-solid fa-globe text-brand-accent/80 text-[11px] w-4 text-center"></i><span class="truncate">{{ $proposal->brand_name }}</span>
                    </a>
                    @endforeach
                </nav>
                @endif

                {{-- Kontak: tombol ringkas, 2 kolom di mobile --}}
                <div class="col-span-2 md:col-span-1 flex flex-col gap-3">
                    <h3 class="text-white/80 font-bold text-[11px] tracking-wider uppercase">Hubungi Kami</h3>
                    <div class="grid grid-cols-2 md:grid-cols-1 gap-2">
                        <a href="https://wa.me/6287761036385" target="_blank" rel="noopener" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/[0.04] border border-white/10 hover:bg-white/[0.08] hover:text-white transition-colors">
                            <i class="fa-brands fa-whatsapp text-green-400 text-base"></i>
                            <span class="leading-tight"><span class="block text-[10px] text-white/45">Bisnis</span>+62 877 6103 6385</span>
                        </a>
                        <a href="https://wa.me/6285221694067" target="_blank" rel="noopener" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/[0.04] border border-white/10 hover:bg-white/[0.08] hover:text-white transition-colors">
                            <i class="fa-brands fa-whatsapp text-green-400 text-base"></i>
                            <span class="leading-tight"><span class="block text-[10px] text-white/45">Owner</span>0852 2169 4067</span>
                        </a>
                        <a href="mailto:sales@scalifyintellegence.my.id" class="col-span-2 md:col-span-1 flex items-center gap-2.5 px-3 py-2.5 rounded-xl bg-white/[0.04] border border-white/10 hover:bg-white/[0.08] hover:text-white transition-colors min-w-0">
                            <i class="fa-solid fa-envelope text-brand-accent text-sm"></i>
                            <span class="truncate">sales@scalifyintellegence.my.id</span>
                        </a>
                    </div>
                    <p class="flex items-center gap-2 text-white/45"><i class="fa-solid fa-map-pin text-brand-accent/70 text-[11px]"></i>Jakarta, Kuningan</p>
                </div>
            </div>

            <div class="border-t border-white/5 pt-5 text-center text-white/40 text-[11px]">
                <p>&copy; 2026 Scalify Intelligence · All rights reserved</p>
            </div>
        </footer>
    </div>


    @unless(View::hasSection('hide_chatbot'))
    @include("partials.flowise")
    @endunless

    @stack('scripts')
</body>

</html>
