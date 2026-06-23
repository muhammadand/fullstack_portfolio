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
    <div id="scalify-chat-wrapper">
        <div id="scalify-chat-tooltip">✨ Tanya Assisten Scalify</div>
        <button id="scalify-chat-btn" aria-label="Buka Assisten AI Scalify" title="Assisten Scalify Intelligence">
            <img src="{{ asset('assistenscalify.png') }}" alt="Assisten Scalify" />
        </button>
    </div>

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
