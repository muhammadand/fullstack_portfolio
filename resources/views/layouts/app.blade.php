<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mubarok Andi Mubarok - Developer & Founder</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            scroll-behavior: smooth;
        }
        .gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
        }
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        .badge-tech {
            display: inline-block;
            padding: 6px 14px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            border: 1px solid rgba(102, 126, 234, 0.3);
            border-radius: 20px;
            font-size: 13px;
            color: #667eea;
            font-weight: 600;
            margin: 4px;
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="bg-white text-gray-900">
    <!-- Navigation -->
  
@include('layouts.navbar')
@yield('content')

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
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth' });
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
</body>
</html>