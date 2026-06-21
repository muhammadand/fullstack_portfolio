<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.3/cdn.min.js" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/x-icon" href="{{ asset('scalify.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"></noscript>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" media="print" onload="this.media='all'">
</head>

<body class="bg-brand-dark text-white font-sans overflow-x-hidden scroll-smooth">

    @include('layouts.navbar')
    <main id="main-content">
        @yield('content')
    </main>
    <footer class="bg-brand-navy border-t border-white/5 pt-12 pb-8 px-6 text-white/60 text-xs">
        <div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center md:items-start justify-between gap-10 mb-8">

            {{-- Brand Section --}}
            <div class="flex flex-col items-center md:items-start gap-4">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-btn-gradient flex items-center justify-center shadow-glow-sm">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="font-display font-bold text-lg text-white/80 tracking-wide">Scalify<span class="text-brand-accent"> Intelligence</span></span>
                </div>
                <p class="text-center md:text-left max-w-xs leading-relaxed text-white/50">
                    Solusi cerdas automasi AI. Tingkatkan efisiensi dan performa bisnis Anda ke level berikutnya.
                </p>
            </div>

            {{-- Contact Information --}}
            <div class="flex flex-col items-center md:items-start gap-3">
                <h3 class="text-white/80 font-bold mb-1 text-sm tracking-wider uppercase">Hubungi Kami</h3>

                <div class="flex items-center gap-3 text-white/60 hover:text-white transition-colors cursor-default">
                    <div class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center">
                        <i class="fa-solid fa-map-pin text-brand-accent/80 text-[10px]"></i>
                    </div>
                    <span>Jakarta, Kuningan</span>
                </div>

                <a href="mailto:sales@scalifyintellegence.my.id" class="flex items-center gap-3 text-white/60 hover:text-white transition-colors">
                    <div class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center">
                        <i class="fa-solid fa-envelope text-brand-accent/80 text-[10px]"></i>
                    </div>
                    <span>sales@scalifyintellegence.my.id</span>
                </a>

                <div class="flex flex-col gap-2 mt-1">
                    <a href="https://wa.me/6287761036385" target="_blank" class="flex items-center gap-3 text-white/60 hover:text-white transition-colors">
                        <div class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center">
                            <i class="fa-solid fa-phone text-brand-accent/80 text-[10px]"></i>
                        </div>
                        <span><span class="text-white/70 mr-1">Bisnis:</span> +62 877 6103 6385</span>
                    </a>

                    <a href="https://wa.me/6285221694067" target="_blank" class="flex items-center gap-3 text-white/60 hover:text-white transition-colors">
                        <div class="w-6 h-6 rounded-full bg-white/5 flex items-center justify-center">
                            <i class="fa-brands fa-whatsapp text-green-400/80 text-[11px]"></i>
                        </div>
                        <span><span class="text-white/70 mr-1">Owner:</span> 0852 2169 4067</span>
                    </a>
                </div>
            </div>

        </div>

        {{-- Copyright --}}
        <div class="border-t border-white/5 pt-6 text-center text-white/50">
            <p>© 2026 Scalify Intelligence · All rights reserved</p>
        </div>
    </footer>

    {{-- ===== Flowise AI Assistant Chatbot ===== --}}
    <style>
        /* Flowise custom button pulse ring animation */
        @keyframes scalify-pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.55);
            }

            70% {
                box-shadow: 0 0 0 14px rgba(99, 102, 241, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(99, 102, 241, 0);
            }
        }

        @keyframes scalify-float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        /* Wrapper that positions the entire widget */
        #scalify-chat-wrapper {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 10px;
        }

        /* Tooltip label above the button */
        #scalify-chat-tooltip {
            background: linear-gradient(135deg, #1e2a4a 0%, #0f172a 100%);
            border: 1px solid rgba(99, 102, 241, 0.35);
            color: #c7d2fe;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.01em;
            padding: 7px 14px;
            border-radius: 999px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(99, 102, 241, 0.15);
            white-space: nowrap;
            opacity: 0;
            transform: translateY(6px) scale(0.95);
            transition: opacity 0.25s ease, transform 0.25s ease;
            pointer-events: none;
            backdrop-filter: blur(10px);
        }

        #scalify-chat-tooltip.visible {
            opacity: 1;
            transform: translateY(0px) scale(1);
        }

        /* The custom trigger button */
        #scalify-chat-btn {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background: linear-gradient(145deg, #1e2a4a 0%, #0d1628 100%);
            border: 2.5px solid rgba(99, 102, 241, 0.55);
            box-shadow: 0 8px 32px rgba(79, 70, 229, 0.5), 0 2px 8px rgba(0, 0, 0, 0.5);
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
            animation: scalify-pulse 2.5s infinite, scalify-float 4s ease-in-out infinite;
            overflow: hidden;
            position: relative;
        }

        #scalify-chat-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 14px 44px rgba(79, 70, 229, 0.7), 0 4px 16px rgba(0, 0, 0, 0.5);
            animation: none;
        }

        #scalify-chat-btn img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
            display: block;
        }

        /* Notification dot */
        #scalify-chat-btn::after {
            content: '';
            position: absolute;
            top: 4px;
            right: 4px;
            width: 10px;
            height: 10px;
            background: #22d3ee;
            border-radius: 50%;
            border: 2px solid #0f172a;
            box-shadow: 0 0 6px rgba(34, 211, 238, 0.8);
        }

    </style>

    {{-- Custom wrapper & button --}}
    <div id="scalify-chat-wrapper">
        <div id="scalify-chat-tooltip">✨ Tanya Assisten Scalify</div>
        <button id="scalify-chat-btn" aria-label="Buka Assisten AI Scalify" title="Assisten Scalify Intelligence">
            <img src="{{ asset('assistenscalify.png') }}" alt="Assisten Scalify" />
        </button>
    </div>

    {{-- Flowise Embed --}}
    <script type="module">
        import Chatbot from "https://cdn.jsdelivr.net/npm/flowise-embed/dist/web.js"
        Chatbot.init({
            chatflowid: "46f54e64-6f56-414c-9562-78d301f06b05",
            apiHost: "https://cloud.flowiseai.com",
            theme: {
                button: {
                    backgroundColor: "transparent",
                    right: 28,
                    bottom: 28,
                    size: 62,
                    dragAndDrop: false,
                    iconColor: "transparent",
                    customIconSrc: "",
                    autoWindowOpen: {
                        autoOpen: false
                    }
                },
                tooltip: {
                    showTooltip: false
                },
                chatWindow: {
                    showTitle: true,
                    showAgentMessages: true,
                    title: "Assisten Scalify AI",
                    titleAvatarSrc: "{{ asset('assistenscalify.png') }}",
                    welcomeMessage: "Halo! 👋 Saya Assisten AI Scalify Intelligence. Ada yang bisa saya bantu mengenai layanan automasi bisnis kami?",
                    errorMessage: "Maaf, terjadi kesalahan. Silakan coba lagi.",
                    backgroundColor: "#ffffff",
                    backgroundImage: "",
                    height: 560,
                    width: 400,
                    fontSize: 14,
                    starterPrompts: [
                        "Apa saja layanan Scalify Intelligence?",
                        "Bagaimana cara memulai automasi bisnis?",
                        "Berapa biaya paket layanan?"
                    ],
                    starterPromptFontSize: 13,
                    clearChatOnReload: false,
                    sourceDocsTitle: "Sumber:",
                    renderHTML: true,
                    botMessage: {
                        backgroundColor: "#f0f4ff",
                        textColor: "#1e293b",
                        showAvatar: true,
                        avatarSrc: "{{ asset('assistenscalify.png') }}"
                    },
                    userMessage: {
                        backgroundColor: "#4f46e5",
                        textColor: "#ffffff",
                        showAvatar: false
                    },
                    textInput: {
                        placeholder: "Ketik pesan Anda...",
                        backgroundColor: "#f8fafc",
                        textColor: "#1e293b",
                        sendButtonColor: "#4f46e5",
                        maxChars: 500,
                        maxCharsWarningMessage: "Pesan terlalu panjang.",
                        autoFocus: true,
                        sendMessageSound: false,
                        receiveMessageSound: false
                    },
                    feedback: {
                        color: "#4f46e5"
                    },
                    dateTimeToggle: {
                        date: true,
                        time: true
                    },
                    footer: {
                        textColor: "#64748b",
                        text: "Powered by",
                        company: "Scalify Intelligence",
                        companyLink: "https://scalifyintellegence.my.id"
                    }
                }
            }
        })

        // Wire custom button to open/close Flowise window
        document.addEventListener('DOMContentLoaded', function () {
            const btn     = document.getElementById('scalify-chat-btn');
            const tooltip = document.getElementById('scalify-chat-tooltip');
            const isMobile = () => window.innerWidth <= 640;

            /* ── Mobile close button overlay ── */
            const mobileClose = document.createElement('button');
            mobileClose.id = 'scalify-mobile-close';
            Object.assign(mobileClose.style, {
                position: 'fixed', zIndex: '10001', display: 'none',
                alignItems: 'center', justifyContent: 'center',
                width: '32px', height: '32px', borderRadius: '50%',
                background: '#1e2a4a', border: '1.5px solid rgba(99,102,241,0.5)',
                color: '#c7d2fe', fontSize: '16px', cursor: 'pointer',
                boxShadow: '0 2px 12px rgba(0,0,0,0.4)', lineHeight: '1'
            });
            mobileClose.innerHTML = '✕';
            mobileClose.setAttribute('aria-label', 'Tutup chat');
            document.body.appendChild(mobileClose);

            /* ── Backdrop ── */
            const backdrop = document.createElement('div');
            backdrop.id = 'scalify-chat-backdrop';
            Object.assign(backdrop.style, {
                position: 'fixed', inset: '0', background: 'rgba(0,0,0,0.35)',
                backdropFilter: 'blur(3px)', zIndex: '9998',
                opacity: '0', pointerEvents: 'none',
                transition: 'opacity 0.25s ease', display: 'none'
            });
            document.body.appendChild(backdrop);

            /* ── Helper: find Flowise chat window element inside shadow root ── */
            function getChatWindow(shadowRoot) {
                // Try common Flowise class names / attribute patterns
                return shadowRoot.querySelector('.chat-window')
                    ?? shadowRoot.querySelector('[class*="chatWindow"]')
                    ?? shadowRoot.querySelector('[class*="chat-window"]')
                    ?? (() => {
                        // Fallback: find largest fixed-position div (the chat panel)
                        const divs = [...shadowRoot.querySelectorAll('div')];
                        return divs.find(d => {
                            const s = d.getAttribute('style') || '';
                            return (s.includes('position: fixed') || s.includes('position:fixed'))
                                && (s.includes('height') || s.includes('bottom'));
                        }) ?? null;
                    })();
            }

            /* ── Force compact panel on mobile via inline styles ── */
            function forceMobilePanel(chatWin) {
                if (!chatWin || !isMobile()) return;
                const PANEL_W  = Math.min(window.innerWidth - 24, 340); // max 340px, 12px gap each side
                const PANEL_H  = Math.min(window.innerHeight - 120, 460); // max 460px, space for button
                const RIGHT    = 12;
                const BOTTOM   = 95; // above the FAB button

                chatWin.style.setProperty('position',   'fixed',          'important');
                chatWin.style.setProperty('bottom',     BOTTOM + 'px',    'important');
                chatWin.style.setProperty('right',      RIGHT  + 'px',    'important');
                chatWin.style.setProperty('left',       'auto',           'important');
                chatWin.style.setProperty('top',        'auto',           'important');
                chatWin.style.setProperty('width',      PANEL_W + 'px',   'important');
                chatWin.style.setProperty('max-width',  PANEL_W + 'px',   'important');
                chatWin.style.setProperty('height',     PANEL_H + 'px',   'important');
                chatWin.style.setProperty('max-height', PANEL_H + 'px',   'important');
                chatWin.style.setProperty('border-radius', '18px',        'important');
                chatWin.style.setProperty('box-shadow', '0 8px 40px rgba(0,0,0,0.35)', 'important');
                chatWin.style.setProperty('overflow',   'hidden',         'important');
                chatWin.style.setProperty('z-index',    '10000',          'important');

                // Position close button at top-right corner of panel
                mobileClose.style.display = 'flex';
                mobileClose.style.top    = (window.innerHeight - BOTTOM - PANEL_H - 16) + 'px';
                mobileClose.style.right  = RIGHT + 'px';
            }

            /* ── Show / hide backdrop + close button on mobile ── */
            function setMobileUI(isOpen) {
                if (!isMobile()) { mobileClose.style.display = 'none'; return; }
                if (isOpen) {
                    backdrop.style.display = 'block';
                    requestAnimationFrame(() => { backdrop.style.opacity = '1'; backdrop.style.pointerEvents = 'auto'; });
                } else {
                    backdrop.style.opacity = '0';
                    backdrop.style.pointerEvents = 'none';
                    mobileClose.style.display = 'none';
                    setTimeout(() => { if (backdrop.style.opacity === '0') backdrop.style.display = 'none'; }, 250);
                }
            }

            /* ── Close helper ── */
            function closeChat() {
                const bubble = document.querySelector('flowise-chatbot') ?? document.querySelector('flowise-fullchatbot');
                const shadowBtn = bubble?.shadowRoot?.querySelector('button[part="button"]')
                               ?? bubble?.shadowRoot?.querySelector('.chatbot-button');
                if (shadowBtn) shadowBtn.click();
            }

            backdrop.addEventListener('click', closeChat);
            mobileClose.addEventListener('click', closeChat);

            let styleInjected = false;
            let rafId = null;

            /* ── MutationObserver: watches for Flowise DOM changes ── */
            const observer = new MutationObserver(() => {
                const bubble = document.querySelector('flowise-chatbot')
                            ?? document.querySelector('flowise-fullchatbot');
                if (!bubble?.shadowRoot) return;

                // Inject base CSS once (hides Flowise default button)
                if (!styleInjected) {
                    const styleEl = document.createElement('style');
                    styleEl.textContent = `button[part="button"],.chatbot-button{display:none!important;visibility:hidden!important;}`;
                    bubble.shadowRoot.appendChild(styleEl);
                    styleInjected = true;
                }

                // Hide Flowise default button inline too (belt + suspenders)
                const flowiseBtn = bubble.shadowRoot.querySelector('button[part="button"]')
                                ?? bubble.shadowRoot.querySelector('.chatbot-button');
                if (flowiseBtn) {
                    flowiseBtn.style.cssText = 'display:none!important;visibility:hidden!important;opacity:0!important;pointer-events:none!important;';
                }

                if (isMobile()) {
                    const chatWin = getChatWindow(bubble.shadowRoot);
                    const isOpen  = chatWin
                                 && getComputedStyle(chatWin).display !== 'none'
                                 && chatWin.offsetHeight > 0;

                    setMobileUI(isOpen);

                    if (isOpen) {
                        // Keep forcing the compact size — Flowise may try to reset it
                        cancelAnimationFrame(rafId);
                        let ticks = 0;
                        function lockFrame() {
                            forceMobilePanel(chatWin);
                            if (ticks++ < 30) rafId = requestAnimationFrame(lockFrame); // ~0.5s of locking
                        }
                        lockFrame();
                    }
                }
            });
            observer.observe(document.body, { childList: true, subtree: true, attributes: true, attributeFilter: ['style', 'class'] });

            // Show tooltip on hover (desktop only)
            btn.addEventListener('mouseenter', () => { if (!isMobile()) tooltip.classList.add('visible'); });
            btn.addEventListener('mouseleave', () => tooltip.classList.remove('visible'));

            // Toggle chat window on button click
            btn.addEventListener('click', function () {
                const bubble = document.querySelector('flowise-chatbot')
                                ?? document.querySelector('flowise-fullchatbot');
                if (bubble) {
                    const shadowBtn = bubble.shadowRoot?.querySelector('button[part="button"]')
                                   ?? bubble.shadowRoot?.querySelector('.chatbot-button');
                    if (shadowBtn) shadowBtn.click();
                }
            });
        });
    </script>

</body>

</html>
