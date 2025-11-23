    <!-- FOOTER -->
    <footer class="bg-gray-900 text-white py-16 px-6">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div>
                    <h3 class="text-2xl font-bold gradient-text mb-4">Andi Mubarok</h3>
                    <p class="text-gray-400 mb-4">Developer & Founder | Creating digital solutions with purpose</p>
                    <p class="text-gray-500 text-sm italic">"Coding with purpose, creating with heart."</p>
                </div>

                <div>
                    <p class="font-semibold mb-4">Layanan</p>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">Website Development</a></li>
                        <li><a href="#" class="hover:text-white transition">Copywriting</a></li>
                        <li><a href="#" class="hover:text-white transition">Konsultasi</a></li>
                    </ul>
                </div>

                <div>
                    <p class="font-semibold mb-4">Resources</p>
                    <ul class="space-y-2 text-gray-400 text-sm">
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Portfolio</a></li>
                        <li><a href="#" class="hover:text-white transition">About</a></li>
                    </ul>
                </div>

                <div>
                    <p class="font-semibold mb-4">Ikuti Saya</p>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-400 hover:text-white transition text-lg">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-lg">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-lg">
                            <i class="fab fa-linkedin"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-white transition text-lg">
                            <i class="fab fa-github"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-gray-400 text-sm">
                    © 2024 Muhammad Andi Mubarok. All rights reserved.
                </p>
                <div class="flex gap-6 text-sm text-gray-400">
                    <a href="#" class="hover:text-white transition">Privacy Policy</a>
                    <a href="#" class="hover:text-white transition">Terms & Conditions</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll behavior
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Add animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.animation = 'fadeInUp 0.6s ease forwards';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.card-hover, .glass-effect').forEach(el => {
            el.style.opacity = '0';
            observer.observe(el);
        });

        // Add fade-in animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        `;
        document.head.appendChild(style);
    </script>