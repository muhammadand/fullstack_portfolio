@php
$perks = [
    ['fa-stopwatch', 'text-amber-300', 'from-amber-500/25 to-amber-500/5', 'Bayar dalam hitungan detik',
        'Pilih nominal, scan QRIS, selesai. Pembayaran terdeteksi otomatis, tanpa upload bukti transfer.'],
    ['fa-gem', 'text-cyan-300', 'from-cyan-500/25 to-cyan-500/5', 'Pengiriman otomatis',
        'Begitu pembayaran terkonfirmasi, pesanan langsung diproses ke akun game kamu tanpa menunggu admin.'],
    ['fa-qrcode', 'text-blue-300', 'from-blue-500/25 to-blue-500/5', 'Satu QRIS untuk semua',
        'Bayar dengan GoPay, OVO, DANA, ShopeePay, atau m-banking apa pun yang mendukung QRIS.'],
    ['fa-shield-halved', 'text-emerald-300', 'from-emerald-500/25 to-emerald-500/5', 'Harga transparan & aman',
        'Harga tampil jelas sebelum membayar, tanpa biaya tersembunyi. Riwayat transaksi tercatat rapi di akunmu.'],
    ['fa-headset', 'text-indigo-300', 'from-indigo-500/25 to-indigo-500/5', 'Layanan pelanggan ramah',
        'Ada kendala dengan pesananmu? Tim kami siap membantu lewat WhatsApp.'],
    ['fa-coins', 'text-rose-300', 'from-rose-500/25 to-rose-500/5', 'Rewards untuk setiap akun',
        'Daftar gratis dan dapatkan bonus poin reward, plus riwayat pesanan yang tersimpan di satu tempat.'],
];
@endphp

<section class="bg-brand-dark px-4 sm:px-6 lg:px-8 pb-14 sm:pb-20" aria-labelledby="tentang-topup">
    <div class="max-w-6xl mx-auto">

        <div class="max-w-3xl">
            <h2 id="tentang-topup" class="font-sans font-extrabold text-2xl sm:text-3xl tracking-tight text-white">
                Scalify <span class="text-brand-accent">Top</span> Indonesia
            </h2>
            <p class="mt-3 text-base sm:text-lg font-semibold text-white/90 leading-snug">
                Website top up game yang cepat, aman, dan mudah digunakan.
            </p>
            <p class="mt-3 text-sm text-white/60 leading-relaxed">
                Beli diamond, voucher, dan item game favoritmu dengan lancar: cukup masukkan ID game, pilih nominal, lalu bayar via QRIS. Tidak wajib daftar atau login, dan pesananmu diproses otomatis 24 jam. Top up Mobile Legends, Free Fire, dan berbagai game lainnya di satu tempat.
            </p>
        </div>

        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
            @foreach($perks as [$icon, $color, $gradient, $title, $desc])
            <div class="flex items-start gap-4 p-4 sm:p-5 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md hover:bg-white/[0.06] hover:border-white/20 transition-colors">
                <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 bg-gradient-to-br {{ $gradient }} border border-white/10 {{ $color }}">
                    <i class="fa-solid {{ $icon }} text-lg"></i>
                </div>
                <div class="min-w-0">
                    <h3 class="text-sm sm:text-base font-bold text-white leading-snug">{{ $title }}</h3>
                    <p class="text-xs sm:text-[13px] text-white/60 mt-1 leading-relaxed">
                        {{ $desc }}
                        @if($icon === 'fa-headset')
                        <a href="https://wa.me/6285221694067?text=Halo%20Scalify,%20saya%20butuh%20bantuan%20top%20up" target="_blank" rel="noopener" class="font-semibold text-brand-accent hover:underline">Hubungi kami</a>
                        @elseif($icon === 'fa-coins')
                            @guest('customer')
                            <a href="{{ route('customer.register') }}" class="font-semibold text-brand-accent hover:underline">Daftar sekarang</a>
                            @endguest
                        @endif
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
