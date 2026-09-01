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

    /* Wrapper that positions the entire trigger widget */
    #scalify-chat-wrapper {
        position: fixed;
        bottom: 24px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
    }

    /* Tooltip label above the button */
    #scalify-chat-tooltip {
        background: rgba(15, 23, 42, 0.85);
        border: 1px solid rgba(99, 102, 241, 0.4);
        color: #e0e7ff;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        letter-spacing: 0.02em;
        padding: 6px 14px;
        border-radius: 999px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.4), 0 0 15px rgba(99, 102, 241, 0.2);
        white-space: nowrap;
        opacity: 0;
        transform: translateY(6px) scale(0.95);
        transition: opacity 0.25s ease, transform 0.25s ease;
        pointer-events: none;
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
    }

    #scalify-chat-tooltip.visible {
        opacity: 1;
        transform: translateY(0px) scale(1);
    }

    /* The custom trigger button */
    #scalify-chat-btn {
        width: 66px;
        height: 66px;
        border-radius: 50%;
        background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
        border: 2px solid rgba(99, 102, 241, 0.6);
        box-shadow: 0 10px 30px rgba(79, 70, 229, 0.45), 0 2px 10px rgba(0, 0, 0, 0.5);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.3s ease;
        animation: scalify-pulse 2.8s infinite, scalify-float 4s ease-in-out infinite;
        overflow: hidden;
        position: relative;
    }

    #scalify-chat-btn:hover {
        transform: scale(1.08);
        box-shadow: 0 14px 40px rgba(99, 102, 241, 0.65), 0 4px 16px rgba(0, 0, 0, 0.6);
    }

    #scalify-chat-btn img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        display: block;
    }

    /* Notification status dot */
    #scalify-chat-btn::after {
        content: '';
        position: absolute;
        top: 3px;
        right: 3px;
        width: 11px;
        height: 11px;
        background: #10b981;
        border-radius: 50%;
        border: 2px solid #0f172a;
        box-shadow: 0 0 8px rgba(16, 185, 129, 0.9);
    }

    /* Mobile Backdrop Overlay */
    #scalify-chat-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(4, 7, 18, 0.65);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        z-index: 99997;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
        display: none;
    }

    #scalify-chat-backdrop.active {
        opacity: 1;
        pointer-events: auto;
    }

    /* Dedicated Mobile Glass Top Header Bar with Prominent Close Button */
    #scalify-mobile-topbar {
        position: fixed;
        top: 10px;
        left: 10px;
        right: 10px;
        height: 52px;
        border-radius: 16px;
        background: rgba(15, 23, 42, 0.92);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(99, 102, 241, 0.4);
        box-shadow: 0 10px 35px rgba(0, 0, 0, 0.6), 0 0 20px rgba(99, 102, 241, 0.2);
        z-index: 100002;
        display: none;
        align-items: center;
        justify-content: space-between;
        padding: 0 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        opacity: 0;
        transform: translateY(-8px);
        transition: opacity 0.25s ease, transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        pointer-events: none;
    }

    #scalify-mobile-topbar.active {
        display: flex;
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }

    #scalify-mobile-close-action {
        background: rgba(239, 68, 68, 0.22);
        border: 1px solid rgba(239, 68, 68, 0.55);
        color: #fca5a5;
        font-family: inherit;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 14px;
        border-radius: 999px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 2px 10px rgba(239, 68, 68, 0.25);
        transition: all 0.2s ease;
        line-height: 1;
    }

    #scalify-mobile-close-action:active {
        background: rgba(239, 68, 68, 0.5);
        color: #ffffff;
        transform: scale(0.95);
    }

</style>

<div id="scalify-chat-backdrop"></div>

<!-- DEDICATED MOBILE TOP BAR (Always on top with clear close button) -->
<div id="scalify-mobile-topbar">
    <div style="display: flex; align-items: center; gap: 10px;">
        <div style="position: relative; width: 34px; height: 34px; border-radius: 50%; overflow: hidden; border: 1.5px solid rgba(99, 102, 241, 0.6); flex-shrink: 0;">
            <img src="{{ asset('assistenscalify.png') }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Bot" />
        </div>
        <div>
            <div style="font-size: 13.5px; font-weight: 700; color: #ffffff; line-height: 1.2;">Scalify AI Assistant</div>
            <div style="font-size: 11px; color: #34d399; display: flex; align-items: center; gap: 5px; line-height: 1; margin-top: 2px;">
                <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981; display: inline-block; box-shadow: 0 0 6px #10b981;"></span> Online
            </div>
        </div>
    </div>
    <button id="scalify-mobile-close-action" type="button" aria-label="Tutup Chat">
        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round">
            <line x1="18" y1="6" x2="6" y2="18"></line>
            <line x1="6" y1="6" x2="18" y2="18"></line>
        </svg>
        Tutup
    </button>
</div>

<div id="scalify-chat-wrapper">
    <div id="scalify-chat-tooltip">✨ Tanya Scalify AI</div>
    <button id="scalify-chat-btn" aria-label="Buka Assisten AI Scalify" title="Assisten Scalify Intelligence">
        <img src="{{ asset('assistenscalify.png') }}" alt="Assisten Scalify" />
    </button>
</div>

<script type="module">
    import Chatbot from "https://cdn.jsdelivr.net/npm/flowise-embed/dist/web.js"

    const customShadowCss = `
        /* ── GLOBAL DARK GLASSMORPHISM THEME FOR FLOWISE SHADOW DOM ── */
        :host {
            --font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif !important;
        }

        /* Hide default Flowise floating button */
        button[part="button"], .chatbot-button, [class*="chatbot-button"] {
            display: none !important;
            visibility: hidden !important;
            opacity: 0 !important;
            pointer-events: none !important;
        }

        /* Chat Window Container */
        .chat-window, div[class*="chat-window"], div[part="chat-window"], div[class*="chatWindow"] {
            background: rgba(11, 17, 33, 0.92) !important;
            backdrop-filter: blur(24px) saturate(180%) !important;
            -webkit-backdrop-filter: blur(24px) saturate(180%) !important;
            border: 1px solid rgba(99, 102, 241, 0.35) !important;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.75), 0 0 30px rgba(99, 102, 241, 0.2) !important;
            border-radius: 24px !important;
            overflow: hidden !important;
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif !important;
            color: #f1f5f9 !important;
            position: fixed !important;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        /* Mobile specific floating modal bounds - Frame neatly below the mobile topbar */
        @media (max-width: 640px) {
            .chat-window, div[class*="chat-window"], div[part="chat-window"], div[class*="chatWindow"], div[style*="position: fixed"], div[style*="position:fixed"] {
                top: 70px !important;
                bottom: 12px !important;
                left: 10px !important;
                right: 10px !important;
                width: calc(100vw - 20px) !important;
                max-width: calc(100vw - 20px) !important;
                height: calc(100dvh - 84px) !important;
                max-height: calc(100dvh - 84px) !important;
                border-radius: 20px !important;
                border: 1px solid rgba(99, 102, 241, 0.4) !important;
                box-shadow: 0 20px 50px rgba(0, 0, 0, 0.8), 0 0 25px rgba(79, 70, 229, 0.3) !important;
                z-index: 100000 !important;
            }

            /* Hide internal header on mobile to prevent double headers since mobile has dedicated topbar */
            header, div[part="header"], div[class*="header"] {
                display: none !important;
            }
        }

        /* Desktop Header Styling */
        @media (min-width: 641px) {
            header, div[part="header"], div[class*="header"], [class*="header-container"] {
                background: rgba(15, 23, 42, 0.85) !important;
                backdrop-filter: blur(16px) !important;
                -webkit-backdrop-filter: blur(16px) !important;
                border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
                color: #ffffff !important;
                padding: 14px 54px 14px 18px !important;
                position: relative !important;
            }

            header span, header h2, div[part="header"] span {
                color: #ffffff !important;
                font-weight: 700 !important;
                font-size: 15px !important;
                letter-spacing: 0.01em !important;
            }

            #flowise-glass-close-btn {
                position: absolute !important;
                top: 12px !important;
                right: 14px !important;
                width: 32px !important;
                height: 32px !important;
                border-radius: 50% !important;
                background: rgba(255, 255, 255, 0.12) !important;
                border: 1px solid rgba(255, 255, 255, 0.2) !important;
                color: #ffffff !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                cursor: pointer !important;
                z-index: 99999 !important;
                transition: all 0.2s ease !important;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3) !important;
                outline: none !important;
            }

            #flowise-glass-close-btn:hover {
                background: rgba(239, 68, 68, 0.85) !important;
                border-color: rgba(239, 68, 68, 1) !important;
                transform: scale(1.1) !important;
            }

            #flowise-glass-close-btn svg {
                width: 14px !important;
                height: 14px !important;
                stroke: currentColor !important;
                stroke-width: 2.5 !important;
            }
        }

        /* Chat Body & Scrollbar */
        .chat-body, div[class*="chat-body"], div[class*="messages-container"], div[class*="chatBody"] {
            background: transparent !important;
            scrollbar-width: thin;
            scrollbar-color: rgba(99, 102, 241, 0.4) transparent;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(99, 102, 241, 0.35);
            border-radius: 999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(99, 102, 241, 0.6);
        }

        /* Bot Message Bubbles */
        [class*="bot-message"], [class*="botMessage"], div[part="bot-message"] {
            background: rgba(22, 32, 56, 0.75) !important;
            border: 1px solid rgba(99, 102, 241, 0.25) !important;
            color: #f1f5f9 !important;
            border-radius: 18px 18px 18px 4px !important;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.25) !important;
            line-height: 1.55 !important;
            font-size: 13.5px !important;
        }

        /* User Message Bubbles */
        [class*="user-message"], [class*="userMessage"], div[part="user-message"] {
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%) !important;
            color: #ffffff !important;
            border-radius: 18px 18px 4px 18px !important;
            box-shadow: 0 4px 16px rgba(79, 70, 229, 0.4) !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
            line-height: 1.5 !important;
            font-size: 13.5px !important;
        }

        /* Starter Prompt Buttons */
        [class*="starter-prompt"], button[class*="starterPrompt"], [class*="starterPrompt"] {
            background: rgba(30, 41, 69, 0.6) !important;
            border: 1px solid rgba(99, 102, 241, 0.35) !important;
            color: #c7d2fe !important;
            border-radius: 12px !important;
            padding: 8px 14px !important;
            font-size: 12.5px !important;
            font-weight: 500 !important;
            transition: all 0.2s ease !important;
            backdrop-filter: blur(8px) !important;
        }

        [class*="starter-prompt"]:hover, button[class*="starterPrompt"]:hover {
            background: rgba(79, 70, 229, 0.35) !important;
            border-color: rgba(99, 102, 241, 0.7) !important;
            color: #ffffff !important;
            transform: translateY(-1px) !important;
        }

        /* Input Container */
        [class*="input-container"], div[class*="inputContainer"], div[part="input-container"] {
            background: rgba(15, 23, 42, 0.85) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.08) !important;
            padding: 10px 14px !important;
            backdrop-filter: blur(12px) !important;
        }

        /* Input Field (Textarea / Input) */
        textarea, input[type="text"] {
            background: rgba(22, 32, 56, 0.6) !important;
            border: 1px solid rgba(99, 102, 241, 0.3) !important;
            color: #f8fafc !important;
            border-radius: 12px !important;
            font-size: 13.5px !important;
            font-family: inherit !important;
            transition: border-color 0.2s ease, box-shadow 0.2s ease !important;
        }

        textarea:focus, input[type="text"]:focus {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.25) !important;
            outline: none !important;
        }

        textarea::placeholder, input::placeholder {
            color: #64748b !important;
        }

        /* Send Button */
        button[type="submit"], [class*="send-button"], [class*="sendButton"] {
            background: #6366f1 !important;
            color: #ffffff !important;
            border-radius: 10px !important;
            transition: all 0.2s ease !important;
            box-shadow: 0 2px 10px rgba(99, 102, 241, 0.4) !important;
        }

        button[type="submit"]:hover, [class*="send-button"]:hover {
            background: #4f46e5 !important;
            transform: scale(1.05) !important;
        }

        /* Links in messages */
        a {
            color: #38bdf8 !important;
            text-decoration: underline !important;
            text-underline-offset: 2px !important;
        }
        a:hover {
            color: #7dd3fc !important;
        }

        /* Footer */
        [class*="footer"], div[part="footer"] {
            background: transparent !important;
            color: #64748b !important;
            font-size: 11px !important;
            padding: 4px 0 8px 0 !important;
        }

        [class*="footer"] a, div[part="footer"] a {
            color: #818cf8 !important;
            text-decoration: none !important;
        }
    `;

    Chatbot.init({
        chatflowid: "46f54e64-6f56-414c-9562-78d301f06b05",
        apiHost: "https://cloud.flowiseai.com",
        theme: {
            button: {
                backgroundColor: "transparent",
                right: 20,
                bottom: 24,
                size: 66,
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
                title: "Scalify AI Assistant",
                titleAvatarSrc: "{{ asset('assistenscalify.png') }}",
                welcomeMessage: "Halo! 👋 Saya Asisten AI Scalify Intelligence. Ada yang bisa saya bantu terkait layanan website, landing page, atau automasi bisnis Anda?",
                errorMessage: "Maaf, terjadi kendala koneksi. Silakan coba lagi atau hubungi WhatsApp kami.",
                backgroundColor: "rgba(11, 17, 33, 0.92)",
                backgroundImage: "",
                height: 560,
                width: 390,
                fontSize: 14,
                starterPrompts: [
                    "Apa saja layanan Scalify?",
                    "Berapa estimasi biaya pembuatan web?",
                    "Bagaimana cara konsultasi proyek?"
                ],
                starterPromptFontSize: 12.5,
                clearChatOnReload: false,
                sourceDocsTitle: "Sumber:",
                renderHTML: true,
                botMessage: {
                    backgroundColor: "rgba(26, 36, 60, 0.75)",
                    textColor: "#f1f5f9",
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
                    backgroundColor: "rgba(15, 23, 42, 0.7)",
                    textColor: "#f8fafc",
                    sendButtonColor: "#6366f1",
                    maxChars: 500,
                    maxCharsWarningMessage: "Pesan terlalu panjang.",
                    autoFocus: true,
                    sendMessageSound: false,
                    receiveMessageSound: false
                },
                feedback: {
                    color: "#6366f1"
                },
                dateTimeToggle: {
                    date: false,
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
    });

    document.addEventListener('DOMContentLoaded', function () {
        const btn             = document.getElementById('scalify-chat-btn');
        const tooltip         = document.getElementById('scalify-chat-tooltip');
        const backdrop        = document.getElementById('scalify-chat-backdrop');
        const mobileTopbar    = document.getElementById('scalify-mobile-topbar');
        const mobileCloseBtn  = document.getElementById('scalify-mobile-close-action');

        const isMobile = () => window.innerWidth <= 640;

        function getChatbotElement() {
            return document.querySelector('flowise-chatbot') ?? document.querySelector('flowise-fullchatbot');
        }

        function getShadowButton(bubble) {
            return bubble?.shadowRoot?.querySelector('button[part="button"]')
                ?? bubble?.shadowRoot?.querySelector('.chatbot-button')
                ?? bubble?.shadowRoot?.querySelector('button');
        }

        function toggleChat() {
            const bubble = getChatbotElement();
            if (bubble) {
                const shadowBtn = getShadowButton(bubble);
                if (shadowBtn) shadowBtn.click();
            }
        }

        function closeChat() {
            const bubble = getChatbotElement();
            if (!bubble?.shadowRoot) return;

            const chatWin = bubble.shadowRoot.querySelector('.chat-window')
                         ?? bubble.shadowRoot.querySelector('[class*="chatWindow"]')
                         ?? bubble.shadowRoot.querySelector('[class*="chat-window"]');

            const isOpen = chatWin && getComputedStyle(chatWin).display !== 'none' && chatWin.offsetHeight > 0;
            if (isOpen) {
                const shadowBtn = getShadowButton(bubble);
                if (shadowBtn) shadowBtn.click();
            }

            // Immediately hide mobile UI
            if (mobileTopbar) mobileTopbar.classList.remove('active');
            if (backdrop) {
                backdrop.classList.remove('active');
                setTimeout(() => { backdrop.style.display = 'none'; }, 250);
            }
        }

        function attachCloseButtonToShadow(bubble) {
            if (!bubble?.shadowRoot || isMobile()) return;
            const chatWin = bubble.shadowRoot.querySelector('.chat-window')
                         ?? bubble.shadowRoot.querySelector('[class*="chatWindow"]')
                         ?? bubble.shadowRoot.querySelector('[class*="chat-window"]');

            if (chatWin && !bubble.shadowRoot.getElementById('flowise-glass-close-btn')) {
                const closeBtn = document.createElement('button');
                closeBtn.id = 'flowise-glass-close-btn';
                closeBtn.setAttribute('type', 'button');
                closeBtn.setAttribute('aria-label', 'Tutup Chatbot');
                closeBtn.setAttribute('title', 'Tutup');
                closeBtn.innerHTML = `
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                `;
                closeBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    e.preventDefault();
                    closeChat();
                });
                chatWin.appendChild(closeBtn);
            }
        }

        // Event listeners
        btn.addEventListener('click', toggleChat);
        backdrop.addEventListener('click', closeChat);
        if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeChat);

        // Tooltip hover desktop
        btn.addEventListener('mouseenter', () => { if (!isMobile()) tooltip.classList.add('visible'); });
        btn.addEventListener('mouseleave', () => tooltip.classList.remove('visible'));

        let styleApplied = false;

        // MutationObserver to handle Shadow DOM styling and Mobile UI sync
        const observer = new MutationObserver(() => {
            const bubble = getChatbotElement();
            if (!bubble || !bubble.shadowRoot) return;

            // Inject custom dark glassmorphism stylesheet once
            if (!styleApplied) {
                const styleEl = document.createElement('style');
                styleEl.id = 'scalify-custom-glass-style';
                styleEl.textContent = customShadowCss;
                bubble.shadowRoot.appendChild(styleEl);
                styleApplied = true;
            }

            attachCloseButtonToShadow(bubble);

            // Check chat window open/close state
            const chatWin = bubble.shadowRoot.querySelector('.chat-window')
                         ?? bubble.shadowRoot.querySelector('[class*="chatWindow"]')
                         ?? bubble.shadowRoot.querySelector('[class*="chat-window"]');

            const isOpen = chatWin && getComputedStyle(chatWin).display !== 'none' && chatWin.offsetHeight > 0;

            if (isOpen) {
                if (isMobile()) {
                    backdrop.style.display = 'block';
                    requestAnimationFrame(() => {
                        backdrop.classList.add('active');
                        if (mobileTopbar) mobileTopbar.classList.add('active');
                    });
                }
            } else {
                if (mobileTopbar) mobileTopbar.classList.remove('active');
                backdrop.classList.remove('active');
                setTimeout(() => {
                    if (!backdrop.classList.contains('active')) {
                        backdrop.style.display = 'none';
                    }
                }, 250);
            }
        });

        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['style', 'class']
        });
    });
</script>
