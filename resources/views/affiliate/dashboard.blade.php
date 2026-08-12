@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen pb-20">
    <!-- Premium Header Background -->
    <div class="relative bg-brand-dark pt-32 pb-40 overflow-hidden" style="background-color: #0A0E2A; background-image: radial-gradient(circle at top right, rgba(59,130,246,0.15), transparent 50%);">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-5"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                <div>
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 text-blue-300 text-xs font-bold mb-4 tracking-wider uppercase border border-white/10 backdrop-blur-sm">
                        <i class="fa-solid fa-crown mr-2"></i> Scalify Partner
                    </div>
                    <h1 class="text-3xl md:text-5xl font-bold text-white font-display tracking-tight mb-2">Partner Dashboard</h1>
                    <p class="text-blue-100/70 text-lg">Selamat datang kembali, <span class="text-white font-semibold">{{ $affiliate->name }}</span>!</p>
                </div>

                <form action="{{ route('affiliate.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="group flex items-center gap-2 px-5 py-2.5 bg-white/5 hover:bg-red-500/10 text-white/70 hover:text-red-400 font-medium rounded-xl transition-all duration-300 border border-white/10 hover:border-red-500/30 backdrop-blur-md">
                        <i class="fa-solid fa-arrow-right-from-bracket group-hover:-translate-x-1 transition-transform"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content Container (Overlapping Header) -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-24">

        {{-- Session Messages --}}
        @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl mb-6 flex items-center justify-between" role="alert">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-check"></i>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 flex items-center justify-between" role="alert">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-circle-exclamation"></i>
                <span class="block sm:inline">{{ $errors->first() }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-red-700 hover:text-red-900">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        @endif

        @if($affiliate->status === 'pending')
        <!-- Pending Approval Message -->
        <div class="bg-white rounded-3xl shadow-xl shadow-yellow-900/5 border border-yellow-100 p-8 md:p-12 text-center max-w-3xl mx-auto mt-8">
            <div class="w-24 h-24 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center text-4xl mx-auto mb-6 shadow-sm">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-slate-800 mb-4">Akun Sedang Direview</h2>
            <p class="text-slate-600 text-lg mb-8 leading-relaxed">Terima kasih telah mendaftar sebagai Partner Sobat Scalify! Saat ini pendaftaran Anda sedang dalam tahap peninjauan oleh tim kami. Kami akan segera menghubungi Anda jika akun sudah disetujui.</p>
            <div class="inline-flex items-center justify-center px-6 py-3 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-xl font-medium">
                <i class="fa-solid fa-clock mr-2"></i> Status: Menunggu Persetujuan
            </div>
        </div>
        @else

        <!-- Affiliate Link Box (Hero Style) -->
        <div class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 border border-slate-100 p-8 md:p-10 mb-8 flex flex-col md:flex-row items-center justify-between gap-8 relative overflow-hidden">
            <!-- Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-70 -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>

            <div class="flex-1 relative z-10 w-full">
                <h2 class="text-xl font-bold text-slate-800 mb-2 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-link"></i>
                    </div>
                    Link Referral Spesial Anda
                </h2>
                <p class="text-slate-500 mb-5 pl-13">Sebarkan link ini ke teman atau klien. Jika mereka memesan via link ini, Anda mendapat komisi otomatis!</p>

                <div class="flex flex-col sm:flex-row items-center gap-3 w-full">
                    <div class="relative w-full flex-1">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-earth-americas text-slate-400"></i>
                        </div>
                        <input type="text" readonly value="{{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}" class="w-full bg-slate-50 border-2 border-slate-200 text-slate-700 font-medium rounded-xl py-4 pl-12 pr-4 focus:outline-none focus:border-blue-400 focus:bg-white transition-all shadow-inner" id="affiliate-link">
                    </div>
                    <button onclick="copyLink()" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 transition-all duration-300 transform hover:-translate-y-0.5 whitespace-nowrap flex items-center justify-center gap-2">
                        <i class="fa-regular fa-copy"></i> Salin Link
                    </button>
                </div>
            </div>
        </div>

        <!-- Quick Actions (New Features) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Katalog Proposal -->
            <div class="bg-white rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 p-6 flex items-center justify-between group">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center text-2xl group-hover:bg-rose-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Katalog Proposal</h3>
                        <p class="text-sm text-slate-500">Pilih dan bagikan link spesifik klien</p>
                    </div>
                </div>
                <a href="{{ route('affiliate.proposals') }}" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 hover:bg-rose-50 hover:text-rose-600 flex items-center justify-center transition-colors shrink-0">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <!-- Akses Login -->
            <div class="bg-white rounded-3xl shadow-sm hover:shadow-md transition-all duration-300 border border-slate-100 p-6 flex items-center justify-between group">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-500 flex items-center justify-center text-2xl group-hover:bg-purple-500 group-hover:text-white transition-colors">
                        <i class="fa-solid fa-key"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Akses Login (Magic Link)</h3>
                        <p class="text-sm text-slate-500">Login otomatis via QR untuk device lain</p>
                    </div>
                </div>
                <a href="{{ route('affiliate.magic_login_qr') }}" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 hover:bg-purple-50 hover:text-purple-600 flex items-center justify-center transition-colors shrink-0">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Clicks -->
            <div class="bg-white rounded-3xl shadow-sm hover:shadow-md transition-shadow border border-slate-100 p-8 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-blue-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-2xl mb-6 shadow-sm">
                        <i class="fa-solid fa-hand-pointer"></i>
                    </div>
                    <h3 class="text-slate-500 font-medium mb-1">Total Klik Link</h3>
                    <div class="text-4xl font-black text-slate-800 mb-2 font-display">{{ $totalClicks }}</div>
                    <p class="text-sm text-emerald-600 font-medium flex items-center gap-1">
                        <i class="fa-solid fa-arrow-trend-up"></i> Leads potensial masuk
                    </p>
                </div>
            </div>

            <!-- Projects -->
            <div class="bg-white rounded-3xl shadow-sm hover:shadow-md transition-shadow border border-slate-100 p-8 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-6 shadow-sm">
                        <i class="fa-solid fa-handshake-angle"></i>
                    </div>
                    <h3 class="text-slate-500 font-medium mb-1">Project Sukses (Deal)</h3>
                    <div class="text-4xl font-black text-slate-800 mb-2 font-display">{{ $totalProjects }}</div>
                    <p class="text-sm text-slate-500 font-medium flex items-center gap-1">
                        <i class="fa-regular fa-circle-check"></i> Menghasilkan komisi
                    </p>
                </div>
            </div>

            <!-- Balance -->
            <div class="bg-white rounded-3xl shadow-sm hover:shadow-md transition-shadow border border-slate-100 p-8 relative overflow-hidden group flex flex-col justify-between border-b-4 border-b-yellow-400">
                <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
                <div class="relative z-10">
                    <div class="w-14 h-14 rounded-2xl bg-yellow-100 text-yellow-600 flex items-center justify-center text-2xl mb-6 shadow-sm">
                        <i class="fa-solid fa-wallet"></i>
                    </div>
                    <h3 class="text-slate-500 font-medium mb-1">Saldo Komisi Tersedia</h3>
                    <div class="text-3xl lg:text-4xl font-black text-slate-800 mb-6 font-display tracking-tight">
                        <span class="text-xl lg:text-2xl text-slate-400 font-medium mr-1">Rp</span>{{ number_format($affiliate->balance, 0, ',', '.') }}
                    </div>
                </div>

                @if($affiliate->balance < 50000) <button type="button" onclick="alert('Maaf, saldo komisi Anda minimal Rp 50.000 untuk dapat melakukan penarikan.')" class="relative z-10 w-full py-3.5 bg-gray-300 text-gray-500 font-bold rounded-xl cursor-not-allowed flex items-center justify-center gap-2" title="Saldo minimal Rp 50.000">
                    <i class="fa-solid fa-money-bill-transfer"></i> Tarik Komisi (Min. 50rb)
                    </button>
                    @else
                    <button onclick="openWithdrawModal()" class="relative z-10 w-full py-3.5 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold rounded-xl transition-all shadow-sm flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                        <i class="fa-solid fa-money-bill-transfer"></i> Tarik Komisi
                    </button>
                    @endif
            </div>
        </div>

        <!-- Links -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('affiliate.history') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors shadow-sm">
                <i class="fa-solid fa-clock-rotate-left"></i> Lihat Seluruh Riwayat Komisi & Penarikan
            </a>
        </div>

        @endif
    </div>
</div>

<!-- Withdraw Modal -->
<div id="withdrawModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
    <div class="bg-white w-full max-w-md p-6 rounded-3xl shadow-2xl transform scale-95 transition-transform duration-300" id="withdrawModalContent">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-slate-800">Tarik Komisi</h3>
            <button type="button" onclick="closeWithdrawModal()" class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 w-8 h-8 rounded-full flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        @if($affiliate->balance < 50000) <div class="text-center py-6">
            <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center text-3xl mx-auto mb-4">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <h4 class="text-lg font-bold text-slate-800 mb-2">Saldo Belum Cukup</h4>
            <p class="text-sm text-slate-600 mb-6">Maaf, saldo komisi Anda saat ini <b>Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</b>. Minimal penarikan adalah Rp 50.000.</p>
            <button type="button" onclick="closeWithdrawModal()" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all">
                Tutup
            </button>
    </div>
    @else
    <form action="{{ route('affiliate.withdraw') }}" method="POST">
        @csrf
        <div class="mb-5">
            <label class="block text-sm font-medium text-slate-700 mb-2">Jumlah Penarikan (Rp)</label>
            <input type="number" name="amount" min="50000" max="{{ $affiliate->balance }}" required class="w-full bg-slate-50 border-2 border-slate-200 text-slate-800 font-bold rounded-xl py-3 px-4 focus:outline-none focus:border-blue-400 transition-colors" placeholder="Contoh: 100000">
            <p class="text-xs text-slate-500 mt-2">Minimal penarikan Rp 50.000. Maksimal Rp {{ number_format($affiliate->balance, 0, ',', '.') }}</p>
        </div>

        <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-xl">
            <p class="text-xs text-blue-800 font-medium mb-1">Informasi Rekening Anda:</p>
            <p class="text-sm font-bold text-blue-900">{{ $affiliate->bank_info }}</p>
            <p class="text-[10px] text-blue-600 mt-2">*Penarikan akan ditransfer ke rekening di atas dalam 1x24 jam kerja.</p>
        </div>

        <button type="submit" class="w-full py-3.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-sm">
            Ajukan Penarikan
        </button>
    </form>
    @endif
</div>
</div>

<script>
    function copyLink() {
        var copyText = document.getElementById("affiliate-link");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);

        // Custom Toast/Alert
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white px-6 py-3 rounded-full shadow-2xl z-50 flex items-center gap-3 transition-opacity duration-300';
        toast.innerHTML = '<i class="fa-solid fa-circle-check text-emerald-400"></i> Link berhasil disalin!';
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '0';
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    function openWithdrawModal() {
        const modal = document.getElementById('withdrawModal');
        const content = document.getElementById('withdrawModalContent');

        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }

    function closeWithdrawModal() {
        const modal = document.getElementById('withdrawModal');
        const content = document.getElementById('withdrawModalContent');

        content.classList.remove('scale-100');
        content.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('opacity-0', 'pointer-events-none');
        }, 150);
    }

</script>
@endsection
