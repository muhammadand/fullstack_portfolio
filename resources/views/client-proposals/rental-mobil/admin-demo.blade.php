<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Demo - {{ $client->brand_name }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#0d6efd'
                            , dark: '#212529'
                            , light: '#f8f9fa'
                            , gray: '#6c757d'
                            , border: '#dee2e6'
                        }
                    }
                    , fontFamily: {
                        sans: ['Inter', 'sans-serif']
                    , }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            color: #212529;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        #tour-overlay {
            position: fixed;
            inset: 0;
            background: rgba(33, 37, 41, 0.8);
            z-index: 9998;
            display: none;
        }

        .tour-highlight {
            position: relative;
            z-index: 9999 !important;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.5);
            border-radius: 0.25rem;
            background-color: white;
            pointer-events: none;
        }

        #tour-tooltip {
            position: absolute;
            z-index: 10000;
            background: white;
            padding: 1rem;
            border-radius: 0.5rem;
            width: 280px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
            display: none;
            transition: all 0.3s ease;
        }

    </style>
</head>
<body class="flex h-screen overflow-hidden antialiased text-[13px]">

    <!-- Sidebar Overlay -->
    <div id="sidebarOverlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-[100] hidden md:hidden"></div>

    <!-- Sidebar -->
    <aside class="fixed md:static inset-y-0 left-0 z-[110] w-60 bg-brand-dark text-white flex flex-col shrink-0 transform -translate-x-full md:translate-x-0 transition-transform duration-300" id="tour-sidebar">
        <div class="h-14 flex items-center justify-between px-5 border-b border-gray-800">
            <div class="flex items-center">
                <div class="w-7 h-7 rounded bg-brand-blue flex items-center justify-center mr-2 text-[12px]"><i class="fas fa-car"></i></div>
                <span class="font-bold text-[14px] truncate">{{ $client->brand_name }}</span>
            </div>
            <button onclick="toggleSidebar()" class="md:hidden text-gray-400 hover:text-white">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="px-4 py-3">
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-2">Main Menu</p>
            <nav class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2 bg-brand-blue rounded text-white font-medium">
                    <i class="fas fa-chart-pie w-4 text-center"></i> Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:bg-gray-800 hover:text-white rounded font-medium transition">
                    <i class="fas fa-calendar-alt w-4 text-center"></i> Bookings
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:bg-gray-800 hover:text-white rounded font-medium transition">
                    <i class="fas fa-car-side w-4 text-center"></i> Fleet List
                </a>
            </nav>
        </div>

        <div class="px-4 py-3">
            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-2">Operations</p>
            <nav class="space-y-1">
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:bg-gray-800 hover:text-white rounded font-medium transition" id="tour-inspection">
                    <i class="fas fa-clipboard-check w-4 text-center"></i> Inspections
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:bg-gray-800 hover:text-white rounded font-medium transition" id="tour-gps">
                    <i class="fas fa-map-marked-alt w-4 text-center"></i> GPS Tracking
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2 text-gray-400 hover:bg-gray-800 hover:text-white rounded font-medium transition">
                    <i class="fas fa-file-invoice-dollar w-4 text-center"></i> Finance
                </a>
            </nav>
        </div>

        <div class="mt-auto p-4 border-t border-gray-800">
            <a href="{{ route('landing.dynamic', $client->slug) }}" class="flex items-center justify-center gap-2 w-full py-2 bg-gray-800 hover:bg-gray-700 rounded text-[12px] font-medium transition">
                <i class="fas fa-external-link-alt"></i> View Website
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-screen overflow-hidden w-full">

        <!-- Topbar -->
        <header class="h-14 bg-white border-b border-brand-border flex items-center justify-between px-4 md:px-6 shrink-0">
            <div class="flex items-center gap-3 md:gap-4">
                <button onclick="toggleSidebar()" class="md:hidden text-brand-dark hover:text-brand-blue">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <h2 class="font-semibold text-[14px] text-brand-dark">Overview</h2>
            </div>

            <div class="flex items-center gap-4">
                <button class="w-8 h-8 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center text-brand-gray relative transition">
                    <i class="fas fa-bell text-[12px]"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full border border-white"></span>
                </button>
                <div class="flex items-center gap-2 border-l border-brand-border pl-4">
                    <div class="w-7 h-7 rounded-full bg-brand-blue text-white flex items-center justify-center font-bold text-[11px]">A</div>
                    <div class="text-[12px]">
                        <p class="font-semibold text-brand-dark leading-none">Admin</p>
                        <p class="text-[10px] text-brand-gray">Manager</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto p-6">

            <!-- Welcome Alert -->
            <div class="bg-blue-50 border border-blue-200 rounded p-4 mb-6 flex justify-between items-center" id="tour-welcome">
                <div class="flex gap-3 items-start">
                    <i class="fas fa-info-circle text-brand-blue mt-0.5"></i>
                    <div>
                        <h3 class="font-bold text-[14px] text-brand-dark mb-0.5">Simulasi Backend Admin</h3>
                        <p class="text-[12px] text-brand-gray">Ini adalah simulasi dashboard yang digunakan oleh Anda untuk mengelola armada dan pesanan.</p>
                    </div>
                </div>
                <button onclick="startTour()" class="bg-brand-blue text-white hover:bg-blue-700 px-4 py-1.5 rounded font-medium text-[12px] transition whitespace-nowrap">
                    Mulai Tour Fitur
                </button>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded border border-brand-border p-4 shadow-sm">
                    <p class="text-[11px] font-medium text-brand-gray uppercase tracking-wider mb-1">Total Fleet</p>
                    <div class="flex items-end gap-2">
                        <p class="text-2xl font-bold text-brand-dark leading-none">24</p>
                        <p class="text-[11px] text-brand-gray mb-0.5">Units</p>
                    </div>
                </div>

                <div class="bg-white rounded border border-brand-border p-4 shadow-sm" id="tour-utilization">
                    <div class="flex justify-between items-start">
                        <p class="text-[11px] font-medium text-brand-gray uppercase tracking-wider mb-1">On Rent</p>
                        <span class="bg-green-100 text-green-700 text-[10px] px-1.5 py-0.5 rounded font-bold">75% Util</span>
                    </div>
                    <div class="flex items-end gap-2">
                        <p class="text-2xl font-bold text-brand-dark leading-none">18</p>
                        <p class="text-[11px] text-brand-gray mb-0.5">Units</p>
                    </div>
                </div>

                <div class="bg-white rounded border border-brand-border p-4 shadow-sm">
                    <p class="text-[11px] font-medium text-brand-gray uppercase tracking-wider mb-1">Active Bookings</p>
                    <div class="flex items-end gap-2">
                        <p class="text-2xl font-bold text-brand-dark leading-none">5</p>
                        <p class="text-[11px] text-brand-gray mb-0.5">Today</p>
                    </div>
                </div>

                <div class="bg-white rounded border border-brand-border p-4 shadow-sm">
                    <p class="text-[11px] font-medium text-brand-gray uppercase tracking-wider mb-1">Maintenance</p>
                    <div class="flex items-end gap-2">
                        <p class="text-2xl font-bold text-red-600 leading-none">2</p>
                        <p class="text-[11px] text-brand-gray mb-0.5">Needs Service</p>
                    </div>
                </div>
            </div>

            <!-- Main Layout Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Chart Area -->
                <div class="lg:col-span-2 bg-white rounded border border-brand-border p-5 shadow-sm" id="tour-chart">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-[14px] text-brand-dark">Revenue Overview</h3>
                        <select class="text-[11px] border border-brand-border rounded px-2 py-1 outline-none text-brand-gray">
                            <option>This Month</option>
                            <option>Last Month</option>
                        </select>
                    </div>
                    <div class="h-60">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded border border-brand-border p-5 shadow-sm flex flex-col">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-[14px] text-brand-dark">Recent Bookings</h3>
                        <a href="#" class="text-[11px] text-brand-blue hover:underline">View All</a>
                    </div>

                    <div class="space-y-3 flex-1 overflow-y-auto hide-scrollbar">
                        <div class="flex items-center gap-3 p-2.5 rounded border border-brand-border bg-gray-50">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-brand-blue flex items-center justify-center font-bold text-[10px] shrink-0">AS</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-[12px] text-brand-dark truncate">Andi Susanto</p>
                                <p class="text-[10px] text-brand-gray truncate">Avanza • 3 Days (Keyless)</p>
                            </div>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-700 text-[9px] font-bold rounded">PENDING DP</span>
                        </div>

                        <div class="flex items-center gap-3 p-2.5 rounded border border-brand-border bg-gray-50">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-brand-blue flex items-center justify-center font-bold text-[10px] shrink-0">BM</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-[12px] text-brand-dark truncate">Budi Maulana</p>
                                <p class="text-[10px] text-brand-gray truncate">Innova • 1 Day (+Driver)</p>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-[9px] font-bold rounded">PAID</span>
                        </div>

                        <div class="flex items-center gap-3 p-2.5 rounded border border-brand-border bg-gray-50">
                            <div class="w-8 h-8 rounded-full bg-blue-100 text-brand-blue flex items-center justify-center font-bold text-[10px] shrink-0">CD</div>
                            <div class="flex-1 min-w-0">
                                <p class="font-bold text-[12px] text-brand-dark truncate">Citra Dewi</p>
                                <p class="text-[10px] text-brand-gray truncate">Brio • 2 Days (Keyless)</p>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-700 text-[9px] font-bold rounded">PAID</span>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Interactive Tour UI -->
    <div id="tour-overlay"></div>
    <div id="tour-tooltip" class="flex flex-col">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-5 h-5 rounded bg-brand-blue text-white flex items-center justify-center font-bold text-[10px]" id="tour-step-indicator">1</div>
            <h4 class="font-bold text-[13px] text-brand-dark flex-1" id="tour-title">Judul Tour</h4>
            <button onclick="closeTour()" class="text-gray-400 hover:text-brand-dark"><i class="fas fa-times text-[14px]"></i></button>
        </div>
        <p class="text-[11px] text-brand-gray mb-4 leading-relaxed" id="tour-content">Isi petunjuk tour.</p>
        <div class="flex justify-between items-center mt-auto border-t border-brand-border pt-2">
            <button id="tour-prev" onclick="prevStep()" class="text-[10px] font-semibold text-brand-gray hover:text-brand-dark invisible">Sebelumnya</button>
            <button id="tour-next" onclick="nextStep()" class="bg-brand-dark hover:bg-black text-white px-3 py-1 rounded text-[10px] font-semibold transition">Selanjutnya</button>
        </div>
    </div>

    <script>
        // Sidebar Toggle Logic
        function toggleSidebar() {
            const sidebar = document.getElementById('tour-sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Chart Config
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line'
            , data: {
                labels: ['1', '5', '10', '15', '20', '25', '30']
                , datasets: [{
                    label: 'Pendapatan (Juta Rp)'
                    , data: [2.5, 4.2, 3.8, 8.5, 7.2, 10.5, 12]
                    , borderColor: '#0d6efd'
                    , backgroundColor: 'rgba(13, 110, 253, 0.1)'
                    , borderWidth: 2
                    , tension: 0.3
                    , fill: true
                    , pointBackgroundColor: '#fff'
                    , pointBorderColor: '#0d6efd'
                    , pointBorderWidth: 2
                }]
            }
            , options: {
                responsive: true
                , maintainAspectRatio: false
                , plugins: {
                    legend: {
                        display: false
                    }
                }
                , scales: {
                    y: {
                        beginAtZero: true
                        , grid: {
                            borderDash: [4, 4]
                            , color: '#f1f5f9'
                        }
                        , ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                    , x: {
                        grid: {
                            display: false
                        }
                        , ticks: {
                            font: {
                                size: 10
                            }
                        }
                    }
                }
            }
        });

        // Tour Logic
        const tourSteps = [{
                elementId: 'tour-utilization'
                , title: 'Monitoring Utilisasi'
                , content: 'Lacak persentase mobil yang aktif (disewa) dibandingkan yang menganggur. Semakin tinggi persentase, semakin optimal bisnis Anda.'
            }
            , {
                elementId: 'tour-inspection'
                , title: 'Inspeksi & Serah Terima Digital'
                , content: 'Gantikan form kertas dengan checklist digital saat serah terima, termasuk upload foto kondisi mobil & TTE pelanggan.'
            }
            , {
                elementId: 'tour-gps'
                , title: 'Integrasi Pelacakan GPS'
                , content: 'Pantau lokasi mobil secara live-tracking di satu dashboard. Tersedia fitur matikan mesin (engine cut-off) jarak jauh jika terindikasi fraud.'
            }
            , {
                elementId: 'tour-chart'
                , title: 'Laporan Keuangan Otomatis'
                , content: 'Grafik pendapatan sewa harian/bulanan dihitung secara otomatis, memudahkan Anda memonitor cashflow bisnis.'
            }
        ];

        let currentStep = 0;
        const overlay = document.getElementById('tour-overlay');
        const tooltip = document.getElementById('tour-tooltip');

        function startTour() {
            currentStep = 0;
            overlay.style.display = 'block';
            tooltip.style.display = 'flex';
            showStep(currentStep);
        }

        function closeTour() {
            overlay.style.display = 'none';
            tooltip.style.display = 'none';
            tourSteps.forEach(step => {
                const el = document.getElementById(step.elementId);
                if (el) el.classList.remove('tour-highlight');
            });
        }

        function showStep(index) {
            tourSteps.forEach(step => {
                const el = document.getElementById(step.elementId);
                if (el) el.classList.remove('tour-highlight');
            });

            const step = tourSteps[index];
            const targetEl = document.getElementById(step.elementId);

            if (targetEl) {
                targetEl.classList.add('tour-highlight');

                const rect = targetEl.getBoundingClientRect();
                let top = rect.bottom + 10;
                let left = rect.left;

                if (rect.bottom + 150 > window.innerHeight) {
                    top = rect.top - 160;
                }

                if (window.innerWidth < 400) {
                    left = 15;
                    tooltip.style.width = (window.innerWidth - 30) + 'px';
                } else {
                    tooltip.style.width = '280px';
                    if (left + 280 > window.innerWidth) {
                        left = window.innerWidth - 300;
                    }
                }

                tooltip.style.top = top + 'px';
                tooltip.style.left = left + 'px';

                document.getElementById('tour-step-indicator').innerText = index + 1;
                document.getElementById('tour-title').innerText = step.title;
                document.getElementById('tour-content').innerText = step.content;
                document.getElementById('tour-prev').style.visibility = index === 0 ? 'hidden' : 'visible';

                const nextBtn = document.getElementById('tour-next');
                nextBtn.innerText = index === tourSteps.length - 1 ? 'Selesai' : 'Selanjutnya';
            }
        }

        function nextStep() {
            if (currentStep < tourSteps.length - 1) {
                currentStep++;
                showStep(currentStep);
            } else {
                closeTour();
            }
        }

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        }

    </script>
</body>
</html>
