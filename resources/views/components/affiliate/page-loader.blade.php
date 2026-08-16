<!-- Page Loader -->
<div id="global-page-loader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#0B1120] transition-opacity duration-300">
    <div class="relative flex items-center justify-center">
        <!-- Outer glowing ring -->
        <div class="absolute w-20 h-20 border-4 border-blue-500/20 rounded-full"></div>
        <!-- Spinning ring -->
        <div class="absolute w-20 h-20 border-4 border-transparent border-t-blue-500 border-r-blue-500 rounded-full animate-spin"></div>
        <!-- Inner icon -->
        <div class="w-12 h-12 bg-slate-800 rounded-full flex items-center justify-center shadow-lg shadow-blue-500/20 z-10">
            <i class="fa-solid fa-rocket text-blue-400 text-lg animate-pulse"></i>
        </div>
    </div>
    <p class="mt-4 text-blue-400 text-xs font-medium tracking-widest uppercase animate-pulse">Memuat...</p>
</div>

<!-- Loader Logic -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const loader = document.getElementById('global-page-loader');
        
        // Hide loader when page is fully loaded
        window.addEventListener('load', () => {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 300);
        });

        // Intercept clicks on links to show loader (only internal navigation)
        const links = document.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', function(e) {
                const target = this.getAttribute('target');
                const href = this.getAttribute('href');
                const isInternal = href && (href.startsWith('/') || href.startsWith(window.location.origin));
                const isHash = href && href.startsWith('#');
                const hasOnClick = this.getAttribute('onclick') !== null;
                const isDownload = this.hasAttribute('download');

                if (isInternal && !isHash && target !== '_blank' && !hasOnClick && !isDownload) {
                    loader.style.display = 'flex';
                    // Force reflow
                    void loader.offsetWidth;
                    loader.style.opacity = '1';
                }
            });
        });

        // Also intercept form submissions (except those with target="_blank")
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                if (this.getAttribute('target') !== '_blank') {
                    loader.style.display = 'flex';
                    // Force reflow
                    void loader.offsetWidth;
                    loader.style.opacity = '1';
                }
            });
        });

        // Safety fallback: if load event didn't fire properly after 3 seconds, hide the loader anyway
        setTimeout(() => {
            if(loader.style.display !== 'none') {
                loader.style.opacity = '0';
                setTimeout(() => loader.style.display = 'none', 300);
            }
        }, 3000);
    });
</script>
