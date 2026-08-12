<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Partner Dashboard - Mobile</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-color: #0B1120;
            /* Midnight blue */
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }

        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.2), rgba(30, 58, 138, 0.1));
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3);
        }

        .dana-blue {
            background-color: #118EEA;
        }

        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

    </style>
</head>
<body class="pb-24 overflow-x-hidden min-h-screen flex flex-col relative">

    <!-- Background Decoration -->
    <div class="fixed top-0 left-0 w-full h-64 bg-blue-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>
    <div class="fixed bottom-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

        @if($affiliate->status === 'pending')
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-300">
                    <i class="fa-solid fa-user"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-400">Halo, Partner</p>
                    <h1 class="text-sm font-bold truncate max-w-[150px]">{{ $affiliate->name }}</h1>
                </div>
            </div>
            <form action="{{ route('affiliate.logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-slate-300 hover:text-white">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>

        <!-- Pending Approval Message -->
        <div class="glass-panel rounded-3xl p-8 text-center mt-10">
            <div class="w-20 h-20 bg-yellow-500/20 text-yellow-400 rounded-full flex items-center justify-center text-4xl mx-auto mb-6 shadow-lg shadow-yellow-500/10">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <h2 class="text-2xl font-bold mb-3 text-white">Akun Sedang Direview</h2>
            <p class="text-slate-400 text-sm mb-8 leading-relaxed">Terima kasih telah mendaftar! Pendaftaran Anda sedang dalam tahap peninjauan. Kami akan menghubungi jika akun sudah disetujui.</p>
            <div class="inline-flex items-center px-4 py-2 bg-yellow-500/10 border border-yellow-500/30 text-yellow-400 rounded-xl text-sm font-medium">
                <i class="fa-solid fa-clock mr-2"></i> Menunggu Persetujuan
            </div>
        </div>

        @else
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-blue-500 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/30 font-bold">
                    {{ substr($affiliate->name, 0, 1) }}
                </div>
                <div>
                    <p class="text-[11px] text-blue-200/70 font-medium uppercase tracking-wider">Scalify Partner</p>
                    <h1 class="text-base font-bold text-white tracking-wide truncate max-w-[150px]">{{ $affiliate->name }}</h1>
                </div>
            </div>
            <div class="flex gap-2">
                <button onclick="openNotificationModal()" class="w-10 h-10 rounded-full glass-panel flex items-center justify-center text-blue-300 hover:text-white transition-colors relative">
                    <i class="fa-solid fa-bell"></i>
                    @if($affiliate->unreadNotifications->count() > 0)
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                    @endif
                </button>
            </div>
        </div>

        {{-- Session Messages --}}
        @if(session('success'))
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                showToast("{{ session('success') }}", 'success');
            });

        </script>
        @endif

        @if(session('error') || $errors->any())
        <script>
            window.addEventListener('DOMContentLoaded', () => {
                showToast("{{ session('error') ?? $errors->first() }}", 'error');
            });

        </script>
        @endif

        <!-- DANA-like Balance Card -->
        <div class="glass-card rounded-3xl p-5 mb-6 relative overflow-hidden">
            <!-- Decorative circle inside card -->
            <div class="absolute -right-8 -top-8 w-32 h-32 bg-white/5 rounded-full"></div>

            <p class="text-sm text-blue-100/80 font-medium mb-1 relative z-10 flex items-center gap-2">
                <i class="fa-solid fa-wallet text-blue-400"></i> Saldo Komisi
            </p>
            <div class="flex justify-between items-end relative z-10 mb-4">
                <div class="text-3xl font-bold text-white tracking-tight">
                    <span class="text-lg text-blue-200/70 font-medium mr-1">Rp</span>{{ number_format($affiliate->balance, 0, ',', '.') }}
                </div>
            </div>

            <div class="flex gap-3 relative z-10 mt-6">
                @if($affiliate->balance < 50000) <button onclick="alert('Maaf, saldo komisi Anda minimal Rp 50.000 untuk dapat melakukan penarikan.')" class="flex-1 py-2 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl transition-colors backdrop-blur-md flex flex-col justify-center items-center gap-1">
                    <i class="fa-solid fa-money-bill-transfer text-[18px]"></i>
                    <span class="text-[10px]">Tarik (Min 50rb)</span>
                    </button>
                    @else
                    <button onclick="openWithdrawModal()" class="flex-1 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-xl shadow-lg shadow-blue-500/30 transition-colors flex flex-col justify-center items-center gap-1">
                        <i class="fa-solid fa-money-bill-transfer text-[18px]"></i>
                        <span class="text-[10px]">Tarik Komisi</span>
                    </button>
                    @endif
                    <button onclick="copyLink()" class="flex-1 py-2 glass-panel text-white font-semibold rounded-xl transition-colors flex flex-col justify-center items-center gap-1">
                        <i class="fa-solid fa-link text-blue-300 text-[18px]"></i>
                        <span class="text-[10px]">Salin Link</span>
                    </button>
            </div>
        </div>

        <!-- Hidden input for copy -->
        <input type="text" readonly value="{{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}" class="absolute -left-[9999px] opacity-0" id="affiliate-link">

        <!-- Grid Menu -->
        <div class="grid grid-cols-3 gap-y-6 gap-x-4 mb-8">
            <!-- 1. Bagikan Web -->
            <div class="flex flex-col items-center gap-2 cursor-pointer" onclick="openShareModal()">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-indigo-400 text-lg shadow-inner relative transition-transform active:scale-95">
                    <i class="fa-solid fa-share-nodes"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Bagikan<br>Web</span>
            </div>

            <!-- 2. Katalog Proposal -->
            <a href="{{ route('affiliate.proposals') }}" class="flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-rose-400 text-lg shadow-inner relative transition-transform active:scale-95">
                    <i class="fa-solid fa-folder-open"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Katalog<br>Proposal</span>
            </a>

            <!-- 3. Riwayat Dana -->
            <a href="{{ route('affiliate.history') }}" class="flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-blue-400 text-lg shadow-inner transition-transform active:scale-95">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Riwayat<br>Dana</span>
            </a>

            <!-- 4. Bagikan Akses -->
            <a href="{{ route('affiliate.magic_login_qr') }}" class="flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-purple-400 text-lg shadow-inner transition-transform active:scale-95">
                    <i class="fa-solid fa-key"></i>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Akses<br>Login</span>
            </a>

            <!-- 5. Project Deal -->
            <div class="flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-emerald-400 text-lg shadow-inner">
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-sm">{{ $totalProjects }}</span>
                    </div>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Project<br>Deal</span>
            </div>

            <!-- 5. Total Klik -->
            <div class="flex flex-col items-center gap-2">
                <div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center text-yellow-400 text-lg shadow-inner">
                    <div class="flex items-center gap-1">
                        <span class="font-bold text-sm">{{ $totalClicks }}</span>
                    </div>
                </div>
                <span class="text-[10px] text-slate-300 font-medium text-center leading-tight">Total<br>Klik</span>
            </div>
        </div>

        <!-- Promo / Info Banner -->
        <div class="glass-panel rounded-2xl p-4 mb-8 flex items-center gap-4 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-20 h-20 bg-blue-500/20 rounded-full blur-xl"></div>
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-xl flex-shrink-0 shadow-lg">
                <i class="fa-solid fa-bullhorn"></i>
            </div>
            <div>
                <h4 class="text-sm font-bold text-white mb-1">Tingkatkan Penghasilan!</h4>
                <p class="text-[11px] text-slate-300 leading-tight">Dapatkan 10% komisi dari setiap project deal. Sebarkan link Anda ke berbagai grup WA & Sosial Media.</p>
            </div>
        </div>

        <!-- Recent Transactions Preview -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-bold text-white">Aktivitas Terakhir</h3>
            <a href="{{ route('affiliate.history') }}" class="text-[11px] font-semibold text-blue-400">Lihat Semua</a>
        </div>

        <div class="glass-panel rounded-2xl p-2 mb-8">
            @forelse($withdrawals->take(3) as $w)
            <div class="flex items-center justify-between p-3 border-b border-white/5 last:border-0">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-blue-300">
                        @if($w->status === 'Pending')
                        <i class="fa-solid fa-clock"></i>
                        @elseif($w->status === 'Completed')
                        <i class="fa-solid fa-check text-emerald-400"></i>
                        @else
                        <i class="fa-solid fa-xmark text-red-400"></i>
                        @endif
                    </div>
                    <div>
                        <p class="text-sm font-medium text-white">Penarikan Dana</p>
                        <p class="text-[10px] text-slate-400">{{ $w->created_at->format('d M, H:i') }} • {{ $w->status }}</p>
                    </div>
                </div>
                <div class="text-sm font-bold text-white">
                    -Rp {{ number_format($w->amount, 0, ',', '.') }}
                </div>
            </div>
            @empty
            <div class="p-6 text-center text-slate-400 text-sm">
                Belum ada aktivitas penarikan.
            </div>
            @endforelse
        </div>

        @endif
    </div>

    <!-- Bottom Navigation -->
    <div class="fixed bottom-0 left-0 w-full glass-panel border-t border-white/10 z-50">
        <div class="max-w-md mx-auto flex justify-between items-center px-6 py-3">
            <a href="{{ route('affiliate.dashboard') }}" class="flex flex-col items-center gap-1 text-blue-400">
                <i class="fa-solid fa-house text-xl"></i>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>
            <a href="{{ route('affiliate.history') }}" class="flex flex-col items-center gap-1 text-slate-400 hover:text-blue-300 transition-colors">
                <i class="fa-solid fa-clock-rotate-left text-xl"></i>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>
            <form action="{{ route('affiliate.logout') }}" method="POST" class="flex flex-col items-center">
                @csrf
                <button type="submit" class="flex flex-col items-center gap-1 text-slate-400 hover:text-red-400 transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xl"></i>
                    <span class="text-[10px] font-medium">Keluar</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Withdraw Modal (Mobile Friendly) -->
    <div id="withdrawModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-[#1e293b] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300" id="withdrawModalContent">
            <div class="p-6">
                <div class="w-12 h-1.5 bg-slate-600 rounded-full mx-auto mb-6"></div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">Tarik Komisi</h3>
                    <button type="button" onclick="closeWithdrawModal()" class="w-8 h-8 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                @if($affiliate->balance < 50000) <div class="text-center py-6">
                    <div class="w-16 h-16 bg-red-500/20 text-red-400 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                        <i class="fa-solid fa-circle-xmark"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Saldo Belum Cukup</h4>
                    <p class="text-sm text-slate-400 mb-6">Saldo Anda <b>Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</b>. Minimal penarikan Rp 50.000.</p>
                    <button type="button" onclick="closeWithdrawModal()" class="w-full py-3.5 glass-panel text-white font-bold rounded-xl">
                        Tutup
                    </button>
            </div>
            @else
            <form action="{{ route('affiliate.withdraw') }}" method="POST">
                @csrf
                <div class="mb-5">
                    <label class="block text-sm font-medium text-slate-300 mb-2">Jumlah Penarikan (Rp)</label>
                    <input type="number" name="amount" min="50000" max="{{ $affiliate->balance }}" required class="w-full bg-slate-900/50 border border-white/10 text-white font-bold rounded-xl py-3.5 px-4 focus:outline-none focus:border-blue-500 transition-colors" placeholder="Contoh: 100000">
                    <p class="text-[11px] text-slate-400 mt-2 flex justify-between">
                        <span>Min: Rp 50.000</span>
                        <span class="text-blue-400">Max: Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</span>
                    </p>
                </div>

                <div class="mb-6 p-4 glass-panel rounded-xl">
                    <p class="text-xs text-slate-400 font-medium mb-1">Rekening Pencairan:</p>
                    <p class="text-sm font-bold text-white">{{ $affiliate->bank_info }}</p>
                </div>

                <button type="submit" class="w-full py-3.5 bg-blue-500 hover:bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all">
                    Konfirmasi Penarikan
                </button>
            </form>
            @endif
        </div>
    </div>

    <!-- Notification Modal (Mobile Friendly) -->
    <div id="notificationModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-[#1e293b] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300 flex flex-col max-h-[85vh]" id="notificationModalContent">
            <div class="p-6 pb-2 border-b border-white/10 shrink-0">
                <div class="w-12 h-1.5 bg-slate-600 rounded-full mx-auto mb-6"></div>
                <div class="flex justify-between items-center mb-2">
                    <h3 class="text-xl font-bold text-white">Notifikasi</h3>
                    <button type="button" onclick="closeNotificationModal()" class="w-8 h-8 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                @if($affiliate->notifications->count() > 0)
                <div class="flex justify-end mb-2">
                    <form action="{{ route('affiliate.notifications.clear') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-xs text-slate-400 hover:text-red-400 transition-colors">
                            <i class="fa-solid fa-trash-can mr-1"></i> Bersihkan Semua
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <div class="p-6 overflow-y-auto hide-scrollbar flex-1">
                @forelse($affiliate->notifications as $notification)
                <div class="mb-4 relative">
                    <div class="glass-panel p-4 rounded-2xl {{ empty($notification->read_at) ? 'border-blue-500/50 bg-blue-500/5' : '' }}">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full shrink-0 flex items-center justify-center 
                                {{ $notification->data['type'] === 'success' ? 'bg-emerald-500/10 text-emerald-400' : '' }}
                                {{ $notification->data['type'] === 'info' ? 'bg-blue-500/10 text-blue-400' : '' }}
                                {{ $notification->data['type'] === 'warning' ? 'bg-yellow-500/10 text-yellow-400' : '' }}
                            ">
                                @if($notification->data['type'] === 'success')
                                <i class="fa-solid fa-check"></i>
                                @elseif($notification->data['type'] === 'warning')
                                <i class="fa-solid fa-exclamation"></i>
                                @else
                                <i class="fa-solid fa-bell"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start mb-1">
                                    <h4 class="text-sm font-bold text-white">{{ $notification->data['title'] ?? 'Pemberitahuan' }}</h4>
                                    <span class="text-[10px] text-slate-400">{{ $notification->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-xs text-slate-300 leading-relaxed">{{ $notification->data['message'] ?? '' }}</p>

                                @if(empty($notification->read_at))
                                <div class="mt-3 flex justify-end">
                                    <form action="{{ route('affiliate.notifications.read', $notification->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-[11px] px-3 py-1.5 bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 rounded-lg transition-colors font-medium">
                                            Tandai Dibaca
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-10">
                    <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center text-4xl mx-auto mb-4 text-slate-500">
                        <i class="fa-regular fa-bell-slash"></i>
                    </div>
                    <h4 class="text-lg font-bold text-white mb-2">Belum ada notifikasi</h4>
                    <p class="text-sm text-slate-400">Pemberitahuan seputar komisi dan penarikan akan muncul di sini.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Share Modal (QR Code) -->
    <div id="shareModal" class="fixed inset-0 z-[60] flex flex-col justify-end bg-slate-900/80 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-[#1e293b] border-t border-white/10 w-full rounded-t-3xl transform translate-y-full transition-transform duration-300" id="shareModalContent">
            <div class="p-6">
                <div class="w-12 h-1.5 bg-slate-600 rounded-full mx-auto mb-6"></div>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">Bagikan Link Anda</h3>
                    <button type="button" onclick="closeShareModal()" class="w-8 h-8 rounded-full glass-panel flex items-center justify-center text-slate-400 hover:text-white">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>

                <div class="flex flex-col items-center mb-6">
                    <div class="bg-white p-3 rounded-2xl mb-4 shadow-xl">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(url('/sobat-scalify?ref=' . $affiliate->affiliate_code)) }}" alt="QR Code" class="w-40 h-40 rounded-lg">
                    </div>
                    <p class="text-xs text-slate-400 text-center px-4 leading-relaxed">
                        Prospek bisa langsung <b>Scan QR Code</b> ini untuk membuka website dengan kode afiliasi Anda.
                    </p>
                </div>

                <div class="glass-panel p-3.5 rounded-xl flex items-center justify-between gap-3 mb-2">
                    <div class="truncate flex-1 text-sm font-medium text-blue-300">
                        {{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}
                    </div>
                    <button onclick="copyLink()" class="w-10 h-10 rounded-xl bg-blue-500 hover:bg-blue-600 shadow-lg shadow-blue-500/30 text-white flex items-center justify-center shrink-0 transition-colors">
                        <i class="fa-solid fa-copy"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showToast(message, type = 'success') {
            const toast = document.createElement('div');
            // Base styles
            toast.className = 'fixed top-10 left-1/2 -translate-x-1/2 px-5 py-3 rounded-full shadow-2xl z-[80] flex items-center gap-3 text-sm font-medium transition-all duration-500 transform -translate-y-10 opacity-0 min-w-[280px] max-w-[90vw] justify-center';

            if (type === 'success') {
                toast.classList.add('bg-slate-800', 'border', 'border-emerald-500/30', 'text-white');
                toast.innerHTML = `<div class="w-6 h-6 rounded-full bg-emerald-500/20 flex items-center justify-center text-emerald-400 shrink-0"><i class="fa-solid fa-check text-xs"></i></div> <span class="truncate">${message}</span>`;
            } else {
                toast.classList.add('bg-slate-800', 'border', 'border-red-500/30', 'text-white');
                toast.innerHTML = `<div class="w-6 h-6 rounded-full bg-red-500/20 flex items-center justify-center text-red-400 shrink-0"><i class="fa-solid fa-xmark text-xs"></i></div> <span class="truncate">${message}</span>`;
            }

            document.body.appendChild(toast);

            // Animate in
            setTimeout(() => {
                toast.classList.remove('-translate-y-10', 'opacity-0');
            }, 10);

            // Animate out
            setTimeout(() => {
                toast.classList.add('-translate-y-10', 'opacity-0');
                setTimeout(() => toast.remove(), 500);
            }, 3000);
        }

        function copyLink() {
            var copyText = document.getElementById("affiliate-link");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);

            showToast('Link website berhasil disalin!', 'success');
        }

        function copyLoginLink() {
            var copyText = document.getElementById("login-link-input");
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            navigator.clipboard.writeText(copyText.value);

            showToast('Link Akses Login berhasil disalin!', 'success');
        }

        function openWithdrawModal() {
            const modal = document.getElementById('withdrawModal');
            const content = document.getElementById('withdrawModalContent');

            modal.classList.remove('opacity-0', 'pointer-events-none');
            // Bottom sheet slide up animation
            setTimeout(() => {
                content.classList.remove('translate-y-full');
            }, 10);
        }

        function closeWithdrawModal() {
            const modal = document.getElementById('withdrawModal');
            const content = document.getElementById('withdrawModalContent');

            content.classList.add('translate-y-full');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 300);
        }

        function openNotificationModal() {
            const modal = document.getElementById('notificationModal');
            const content = document.getElementById('notificationModalContent');

            modal.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                content.classList.remove('translate-y-full');
            }, 10);
        }

        function closeNotificationModal() {
            const modal = document.getElementById('notificationModal');
            const content = document.getElementById('notificationModalContent');

            content.classList.add('translate-y-full');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 300);
        }

        function openShareModal() {
            const modal = document.getElementById('shareModal');
            const content = document.getElementById('shareModalContent');

            modal.classList.remove('opacity-0', 'pointer-events-none');
            setTimeout(() => {
                content.classList.remove('translate-y-full');
            }, 10);
        }

        function closeShareModal() {
            const modal = document.getElementById('shareModal');
            const content = document.getElementById('shareModalContent');

            content.classList.add('translate-y-full');
            setTimeout(() => {
                modal.classList.add('opacity-0', 'pointer-events-none');
            }, 300);
        }

    </script>
</body>
</html>
