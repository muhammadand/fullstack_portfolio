<!-- Global Page Loader (Sleek Glassmorphic Midnight Blue Theme) -->
<div id="global-page-loader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#0B1120]/95 backdrop-blur-md transition-opacity duration-300">
    <!-- Ambient Glow Circles -->
    <div class="absolute w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px] pointer-events-none"></div>
    <div class="absolute w-64 h-64 bg-blue-500/10 rounded-full blur-[80px] pointer-events-none translate-x-12 translate-y-12"></div>

    <div class="relative flex items-center justify-center z-10">
        <!-- Outer Glowing Ring -->
        <div class="w-20 h-20 border-[3px] border-emerald-500/15 rounded-full"></div>
        <!-- Dual Spinning Gradient Rings -->
        <div class="absolute w-20 h-20 border-[3px] border-transparent border-t-emerald-400 border-r-teal-400 rounded-full animate-spin"></div>
        <div class="absolute w-14 h-14 border-[2px] border-transparent border-b-blue-400 border-l-cyan-400 rounded-full animate-spin" style="animation-direction: reverse; animation-duration: 1.5s;"></div>
        <!-- Center Icon with Glass Card -->
        <div class="absolute w-11 h-11 bg-slate-900/90 border border-white/10 rounded-full flex items-center justify-center shadow-xl shadow-emerald-500/20">
            <i class="fa-solid fa-bolt text-emerald-400 text-sm animate-pulse" id="global-page-loader-icon"></i>
        </div>
    </div>
    
    <!-- Dynamic Loading Text -->
    <div class="mt-4 text-center z-10 px-4">
        <p id="global-page-loader-text" class="text-xs font-bold tracking-wider text-slate-200 animate-pulse uppercase">
            Memuat...
        </p>
        <p class="text-[10px] text-slate-400 mt-0.5 font-medium">Mohon tunggu sebentar</p>
    </div>
</div>

<!-- Loader Logic & Global Controller -->
<script>
    (function() {
        let safetyTimeout = null;

        window.showPageLoader = function(msg = 'Memuat...') {
            const loader = document.getElementById('global-page-loader');
            const textEl = document.getElementById('global-page-loader-text');
            if (textEl && msg) textEl.textContent = msg;

            if (loader) {
                loader.style.display = 'flex';
                // Force reflow
                void loader.offsetWidth;
                loader.style.opacity = '1';

                // Safety timeout: auto hide after 12 seconds so user is never stuck permanently if network fails
                if (safetyTimeout) clearTimeout(safetyTimeout);
                safetyTimeout = setTimeout(() => {
                    window.hidePageLoader();
                }, 12000);
            }
        };

        window.hidePageLoader = function() {
            if (safetyTimeout) {
                clearTimeout(safetyTimeout);
                safetyTimeout = null;
            }
            const loader = document.getElementById('global-page-loader');
            if (loader) {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 300);
            }
        };

        // Auto hide on initial page load
        const initHide = () => {
            setTimeout(window.hidePageLoader, 150);
        };

        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            initHide();
        } else {
            document.addEventListener('DOMContentLoaded', initHide);
            window.addEventListener('load', initHide);
        }

        // Intercept internal link clicks
        document.addEventListener('DOMContentLoaded', () => {
            const links = document.querySelectorAll('a');
            links.forEach(link => {
                link.addEventListener('click', function(e) {
                    const target = this.getAttribute('target');
                    const href = this.getAttribute('href');
                    const isInternal = href && (href.startsWith('/') || href.startsWith(window.location.origin));
                    const isHash = href && href.startsWith('#');
                    const hasOnClick = this.getAttribute('onclick') !== null;
                    const isDownload = this.hasAttribute('download');
                    const isJavascript = href && href.startsWith('javascript:');

                    if (isInternal && !isHash && !isJavascript && target !== '_blank' && !hasOnClick && !isDownload) {
                        window.showPageLoader('Memuat Halaman...');
                    }
                });
            });

            // Intercept form submissions
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (this.getAttribute('target') !== '_blank') {
                        // Check if already custom handled
                        const currentText = document.getElementById('global-page-loader-text');
                        if (currentText && currentText.textContent === 'Memuat...') {
                            currentText.textContent = 'Memproses Permintaan...';
                        }
                        const loader = document.getElementById('global-page-loader');
                        if (loader) {
                            loader.style.display = 'flex';
                            void loader.offsetWidth;
                            loader.style.opacity = '1';
                        }
                    }
                });
            });

            // Livewire v3 SPA Navigation
            document.addEventListener('livewire:navigating', () => {
                window.showPageLoader('Menyiapkan Tampilan...');
            });

            document.addEventListener('livewire:navigated', () => {
                window.hidePageLoader();
            });
        });
    })();
</script>
