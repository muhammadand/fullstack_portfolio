{{-- Scalify Custom Native AI Chatbot Widget (Ultra Glassmorphism UI) --}}
<style>
    /* Trigger Button Animations */
    @keyframes scalify-glow-pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(99, 102, 241, 0.6), 0 10px 30px rgba(0, 0, 0, 0.5);
        }
        50% {
            box-shadow: 0 0 0 14px rgba(99, 102, 241, 0), 0 15px 40px rgba(99, 102, 241, 0.4);
        }
    }

    @keyframes scalify-gentle-float {
        0%, 100% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-5px);
        }
    }

    @keyframes scalify-dot-bounce {
        0%, 80%, 100% {
            transform: scale(0);
            opacity: 0.3;
        }
        40% {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Floating Launcher Button */
    #scalify-native-launcher {
        position: fixed;
        bottom: 24px;
        right: 20px;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
    }

    #scalify-native-btn {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(145deg, #1e293b 0%, #0f172a 100%);
        border: 2px solid rgba(99, 102, 241, 0.6);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        animation: scalify-glow-pulse 3s infinite, scalify-gentle-float 4s ease-in-out infinite;
        transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
        position: relative;
        outline: none;
    }

    #scalify-native-btn:hover {
        transform: scale(1.08);
        animation: none;
        box-shadow: 0 12px 35px rgba(99, 102, 241, 0.6);
    }

    #scalify-native-btn img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        display: block;
    }

    #scalify-native-btn .status-badge {
        position: absolute;
        top: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: #10b981;
        border-radius: 50%;
        border: 2px solid #0f172a;
        box-shadow: 0 0 8px #10b981;
    }

    #scalify-native-tooltip {
        background: rgba(15, 23, 42, 0.9);
        border: 1px solid rgba(99, 102, 241, 0.4);
        color: #e0e7ff;
        font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        font-size: 12.5px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 999px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
        white-space: nowrap;
        opacity: 0;
        transform: translateY(6px);
        transition: all 0.25s ease;
        pointer-events: none;
        backdrop-filter: blur(12px);
    }

    #scalify-native-launcher:hover #scalify-native-tooltip {
        opacity: 1;
        transform: translateY(0);
    }

    /* Backdrop */
    #scalify-chat-overlay {
        position: fixed;
        inset: 0;
        background: rgba(4, 7, 18, 0.65);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 100000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
        display: none;
    }

    #scalify-chat-overlay.open {
        display: block;
        opacity: 1;
        pointer-events: auto;
    }

    /* Chat Modal Box Container */
    #scalify-chat-modal {
        position: fixed;
        bottom: 24px;
        right: 20px;
        width: 400px;
        height: 600px;
        max-height: calc(100dvh - 40px);
        background: rgba(11, 17, 33, 0.94);
        backdrop-filter: blur(28px) saturate(190%);
        -webkit-backdrop-filter: blur(28px) saturate(190%);
        border: 1.5px solid rgba(99, 102, 241, 0.35);
        border-radius: 24px;
        box-shadow: 0 25px 65px -10px rgba(0, 0, 0, 0.8), 0 0 35px rgba(99, 102, 241, 0.2);
        z-index: 100001;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        opacity: 0;
        transform: translateY(20px) scale(0.95);
        pointer-events: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    #scalify-chat-modal.open {
        opacity: 1;
        transform: translateY(0) scale(1);
        pointer-events: auto;
    }

    /* Mobile view for Chat Modal */
    @media (max-width: 640px) {
        #scalify-chat-modal {
            top: 12px !important;
            bottom: 12px !important;
            left: 10px !important;
            right: 10px !important;
            width: calc(100vw - 20px) !important;
            height: calc(100dvh - 24px) !important;
            max-height: calc(100dvh - 24px) !important;
            border-radius: 20px !important;
            transform: translateY(30px) scale(0.98);
        }

        #scalify-chat-modal.open {
            transform: translateY(0) scale(1) !important;
        }
    }

    /* Messages Scrollbar */
    #scalify-messages-container {
        scrollbar-width: thin;
        scrollbar-color: rgba(99, 102, 241, 0.35) transparent;
    }
    #scalify-messages-container::-webkit-scrollbar {
        width: 5px;
    }
    #scalify-messages-container::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.35);
        border-radius: 999px;
    }

    /* Typing Dots */
    .typing-dot {
        display: inline-block;
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: #818cf8;
        animation: scalify-dot-bounce 1.4s infinite ease-in-out both;
    }
    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }
</style>

<!-- Backdrop Overlay -->
<div id="scalify-chat-overlay"></div>

<!-- Chatbot Trigger Button -->
<div id="scalify-native-launcher">
    <div id="scalify-native-tooltip">✨ Konsultasi dengan Scalify AI</div>
    <button id="scalify-native-btn" aria-label="Buka Chat Scalify AI">
        <img src="{{ asset('assistenscalify.png') }}" alt="Scalify Bot" />
        <span class="status-badge"></span>
    </button>
</div>

<!-- Chat Modal Window -->
<div id="scalify-chat-modal" role="dialog" aria-modal="true" aria-label="Scalify Intelligence Assistant">
    {{-- Header --}}
    <div style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0;">
        <div style="display: flex; align-items: center; gap: 11px;">
            <div style="position: relative; width: 38px; height: 38px; border-radius: 50%; overflow: hidden; border: 1.5px solid rgba(99, 102, 241, 0.7); box-shadow: 0 0 10px rgba(99, 102, 241, 0.3);">
                <img src="{{ asset('assistenscalify.png') }}" style="width: 100%; height: 100%; object-fit: cover;" alt="Scalify AI" />
            </div>
            <div>
                <div style="font-weight: 700; font-size: 14.5px; color: #ffffff; line-height: 1.2;">Scalify AI Assistant</div>
                <div style="font-size: 11px; color: #34d399; display: flex; align-items: center; gap: 5px; margin-top: 2px;">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #10b981; display: inline-block; box-shadow: 0 0 6px #10b981;"></span> Online 24/7
                </div>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 8px;">
            {{-- Reset Chat Button --}}
            <button id="scalify-reset-btn" title="Bersihkan Chat" type="button" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #94a3b8; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="1 4 1 10 7 10"></polyline>
                    <polyline points="23 20 23 14 17 14"></polyline>
                    <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4l-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                </svg>
            </button>

            {{-- Close Button --}}
            <button id="scalify-close-btn" title="Tutup Chat" type="button" style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.5); color: #fca5a5; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s ease;">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    </div>

    {{-- Chat Body / Messages Area --}}
    <div id="scalify-messages-container" style="flex: 1; overflow-y: auto; padding: 16px; display: flex; flex-direction: column; gap: 14px;">
        {{-- Welcome Bubble --}}
        <div style="display: flex; gap: 10px; align-items: flex-start;">
            <img src="{{ asset('assistenscalify.png') }}" style="width: 28px; height: 28px; border-radius: 50%; border: 1px solid rgba(99,102,241,0.5); flex-shrink: 0; margin-top: 4px;" alt="AI" />
            <div style="background: rgba(22, 32, 56, 0.85); border: 1px solid rgba(99, 102, 241, 0.25); color: #f1f5f9; padding: 12px 15px; border-radius: 18px 18px 18px 4px; max-width: 85%; font-size: 13.5px; line-height: 1.55; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                Halo! 👋 Saya <strong>Assisten AI Scalify Intelligence</strong>.<br />Ada yang bisa saya bantu terkait pembuatan website, landing page, atau otomasi bisnis Anda hari ini?
            </div>
        </div>

        {{-- Quick Prompts Container --}}
        <div id="scalify-quick-prompts" style="display: flex; flex-direction: column; gap: 8px; margin-left: 38px; margin-top: 2px;">
            <button type="button" class="quick-prompt-btn" data-text="Apa saja layanan yang ditawarkan Scalify Intelligence?" style="background: rgba(30, 41, 69, 0.6); border: 1px solid rgba(99, 102, 241, 0.35); color: #c7d2fe; padding: 8px 13px; border-radius: 12px; font-size: 12.5px; text-align: left; cursor: pointer; transition: all 0.2s ease; backdrop-filter: blur(8px);">
                💡 Apa saja layanan Scalify Intelligence?
            </button>
            <button type="button" class="quick-prompt-btn" data-text="Berapa estimasi biaya pembuatan website dan sistem otomasi?" style="background: rgba(30, 41, 69, 0.6); border: 1px solid rgba(99, 102, 241, 0.35); color: #c7d2fe; padding: 8px 13px; border-radius: 12px; font-size: 12.5px; text-align: left; cursor: pointer; transition: all 0.2s ease; backdrop-filter: blur(8px);">
                💰 Berapa estimasi biaya layanan?
            </button>
            <button type="button" class="quick-prompt-btn" data-text="Bagaimana cara konsultasi dan memulai proyek bisnis saya?" style="background: rgba(30, 41, 69, 0.6); border: 1px solid rgba(99, 102, 241, 0.35); color: #c7d2fe; padding: 8px 13px; border-radius: 12px; font-size: 12.5px; text-align: left; cursor: pointer; transition: all 0.2s ease; backdrop-filter: blur(8px);">
                🚀 Bagaimana cara konsultasi proyek?
            </button>
        </div>
    </div>

    {{-- Typing Indicator (Hidden by default) --}}
    <div id="scalify-typing-indicator" style="display: none; padding: 4px 16px 10px 48px;">
        <div style="background: rgba(22, 32, 56, 0.8); border: 1px solid rgba(99, 102, 241, 0.2); padding: 8px 14px; border-radius: 14px; display: inline-flex; align-items: center; gap: 5px;">
            <span class="typing-dot"></span>
            <span class="typing-dot"></span>
            <span class="typing-dot"></span>
        </div>
    </div>

    {{-- Input & Action Bar --}}
    <div style="background: rgba(15, 23, 42, 0.88); border-top: 1px solid rgba(255, 255, 255, 0.08); padding: 12px 14px; display: flex; flex-direction: column; gap: 8px; flex-shrink: 0; backdrop-filter: blur(16px);">
        <form id="scalify-chat-form" style="display: flex; align-items: center; gap: 8px; margin: 0;">
            <input 
                id="scalify-chat-input" 
                type="text" 
                placeholder="Tulis pesan Anda..." 
                autocomplete="off"
                style="flex: 1; background: rgba(22, 32, 56, 0.65); border: 1px solid rgba(99, 102, 241, 0.35); color: #f8fafc; padding: 11px 15px; border-radius: 14px; font-size: 13.5px; outline: none; font-family: inherit; transition: all 0.2s ease;"
            />
            <button 
                type="submit" 
                id="scalify-send-btn" 
                title="Kirim Pesan"
                style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); border: none; color: #ffffff; width: 42px; height: 42px; border-radius: 12px; display: flex; align-items: center; justify-content: center; cursor: pointer; flex-shrink: 0; box-shadow: 0 4px 14px rgba(79, 70, 229, 0.4); transition: all 0.2s ease;"
            >
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="22" y1="2" x2="11" y2="13"></line>
                    <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
            </button>
        </form>

        <div style="display: flex; align-items: center; justify-content: space-between; font-size: 11px; color: #64748b; padding: 0 4px;">
            <span>Powered by <a href="https://scalifyintellegence.my.id" target="_blank" style="color: #818cf8; text-decoration: none; font-weight: 600;">Scalify Intelligence</a></span>
            <a href="https://wa.me/6285221694067?text=Halo%20Scalify%2C%20saya%20ingin%20konsultasi%20layanan" target="_blank" style="color: #34d399; text-decoration: none; display: flex; align-items: center; gap: 4px; font-weight: 500;">
                <span>💬 WhatsApp</span>
            </a>
        </div>
    </div>
</div>

<script>
    (function () {
        const CHATFLOW_ID = "46f54e64-6f56-414c-9562-78d301f06b05";
        const API_HOST    = "https://cloud.flowiseai.com";
        const AVATAR_URL  = "{{ asset('assistenscalify.png') }}";

        const launcherBtn = document.getElementById('scalify-native-btn');
        const chatModal   = document.getElementById('scalify-chat-modal');
        const overlay     = document.getElementById('scalify-chat-overlay');
        const closeBtn    = document.getElementById('scalify-close-btn');
        const resetBtn    = document.getElementById('scalify-reset-btn');
        const chatForm    = document.getElementById('scalify-chat-form');
        const chatInput   = document.getElementById('scalify-chat-input');
        const messagesBox = document.getElementById('scalify-messages-container');
        const typingBox   = document.getElementById('scalify-typing-indicator');

        let chatHistory = [];

        function toggleChatModal(open) {
            const isOpen = open !== undefined ? open : !chatModal.classList.contains('open');
            if (isOpen) {
                overlay.style.display = 'block';
                chatModal.style.display = 'flex';
                requestAnimationFrame(() => {
                    overlay.classList.add('open');
                    chatModal.classList.add('open');
                    setTimeout(() => chatInput.focus(), 150);
                });
            } else {
                overlay.classList.remove('open');
                chatModal.classList.remove('open');
                setTimeout(() => {
                    if (!chatModal.classList.contains('open')) {
                        overlay.style.display = 'none';
                    }
                }, 300);
            }
        }

        launcherBtn.addEventListener('click', () => toggleChatModal());
        closeBtn.addEventListener('click', () => toggleChatModal(false));
        overlay.addEventListener('click', () => toggleChatModal(false));

        // Quick prompts click
        document.querySelectorAll('.quick-prompt-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const text = this.getAttribute('data-text');
                if (text) sendMessage(text);
            });
        });

        // Reset chat
        resetBtn.addEventListener('click', function () {
            if (confirm('Bersihkan percakapan ini?')) {
                chatHistory = [];
                const welcomeHtml = `
                    <div style="display: flex; gap: 10px; align-items: flex-start;">
                        <img src="${AVATAR_URL}" style="width: 28px; height: 28px; border-radius: 50%; border: 1px solid rgba(99,102,241,0.5); flex-shrink: 0; margin-top: 4px;" alt="AI" />
                        <div style="background: rgba(22, 32, 56, 0.85); border: 1px solid rgba(99, 102, 241, 0.25); color: #f1f5f9; padding: 12px 15px; border-radius: 18px 18px 18px 4px; max-width: 85%; font-size: 13.5px; line-height: 1.55; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            Halo! 👋 Ada yang bisa saya bantu terkait layanan Scalify Intelligence?
                        </div>
                    </div>
                `;
                messagesBox.innerHTML = welcomeHtml;
            }
        });

        // Form submit
        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const query = chatInput.value.trim();
            if (!query) return;
            chatInput.value = '';
            sendMessage(query);
        });

        function formatMessage(raw) {
            if (!raw) return '';
            // Convert URLs into clickable links
            const urlRegex = /(https?:\/\/[^\s]+)/g;
            let formatted = raw.replace(urlRegex, function (url) {
                return `<a href="${url}" target="_blank" rel="noopener noreferrer" style="color: #38bdf8; text-decoration: underline; word-break: break-all;">${url}</a>`;
            });
            // Convert linebreaks
            formatted = formatted.replace(/\n/g, '<br />');
            return formatted;
        }

        function appendMessage(role, text) {
            const row = document.createElement('div');
            
            if (role === 'user') {
                row.style.cssText = 'display: flex; justify-content: flex-end; margin-left: 40px;';
                row.innerHTML = `
                    <div style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: #ffffff; padding: 11px 15px; border-radius: 18px 18px 4px 18px; max-width: 85%; font-size: 13.5px; line-height: 1.5; box-shadow: 0 4px 16px rgba(79, 70, 229, 0.35); word-wrap: break-word;">
                        ${formatMessage(text)}
                    </div>
                `;
            } else {
                row.style.cssText = 'display: flex; gap: 10px; align-items: flex-start; margin-right: 20px;';
                row.innerHTML = `
                    <img src="${AVATAR_URL}" style="width: 28px; height: 28px; border-radius: 50%; border: 1px solid rgba(99,102,241,0.5); flex-shrink: 0; margin-top: 4px;" alt="AI" />
                    <div style="background: rgba(22, 32, 56, 0.85); border: 1px solid rgba(99, 102, 241, 0.25); color: #f1f5f9; padding: 12px 15px; border-radius: 18px 18px 18px 4px; max-width: 85%; font-size: 13.5px; line-height: 1.55; box-shadow: 0 4px 15px rgba(0,0,0,0.2); word-wrap: break-word;">
                        ${formatMessage(text)}
                    </div>
                `;
            }

            messagesBox.appendChild(row);
            messagesBox.scrollTop = messagesBox.scrollHeight;
        }

        async function sendMessage(text) {
            // Hide quick prompts after first user message
            const quickPrompts = document.getElementById('scalify-quick-prompts');
            if (quickPrompts) quickPrompts.style.display = 'none';

            appendMessage('user', text);
            typingBox.style.display = 'block';
            messagesBox.scrollTop = messagesBox.scrollHeight;

            try {
                const response = await fetch(`${API_HOST}/api/v1/prediction/${CHATFLOW_ID}`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ question: text, history: chatHistory })
                });

                if (!response.ok) throw new Error('Network response not ok');
                const data = await response.json();
                
                const botReply = data.text || data.json || 'Terima kasih atas pertanyaan Anda. Tim Scalify siap membantu lebih lanjut via WhatsApp: https://wa.me/6285221694067';
                typingBox.style.display = 'none';
                appendMessage('bot', botReply);

                chatHistory.push({ role: 'userMessage', content: text });
                chatHistory.push({ role: 'apiMessage', content: botReply });
            } catch (err) {
                console.error('Chat error:', err);
                typingBox.style.display = 'none';
                appendMessage('bot', 'Maaf, terjadi kendala saat menghubungi server AI. Anda bisa langsung berkonsultasi dengan tim kami melalui WhatsApp: <br /><a href="https://wa.me/6285221694067" target="_blank" style="color: #34d399; text-decoration: underline; font-weight: bold;">Klik di sini untuk Chat WhatsApp</a>');
            }
        }
    })();
</script>
