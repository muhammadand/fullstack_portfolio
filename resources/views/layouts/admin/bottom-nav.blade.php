{{-- Bottom navigation admin: hanya di HP/tablet (< lg). Desktop tetap pakai sidebar. --}}
@php
    $route = (string) \Illuminate\Support\Facades\Route::currentRouteName();
    $c = \App\Support\AdminMenu::counts();
    $wdTotal = $c['withdrawals_pending'] + $c['customer_withdrawals_pending'];
    $tabs = [
        ['Beranda', 'fa-house', route('dashboard.admin'), $route === 'dashboard.admin', 0],
        ['Order', 'fa-receipt', route('admin.orders.index'), str_starts_with($route, 'admin.orders.'), $c['orders_processing']],
        // Penarikan: buka yang sedang menunggu lebih dulu (customer, lalu partner).
        ['Penarikan', 'fa-money-bill-transfer',
            $c['customer_withdrawals_pending'] > 0 && $c['withdrawals_pending'] === 0 ? route('admin.customer_withdrawals.index') : route('admin.withdrawals.index'),
            str_starts_with($route, 'admin.withdrawals.') || str_starts_with($route, 'admin.customer_withdrawals.'), $wdTotal],
        ['Partner', 'fa-handshake',
            route('admin.affiliates.index', $c['partner_pending'] > 0 ? ['status' => 'pending'] : []),
            str_starts_with($route, 'admin.affiliates.'), $c['partner_pending']],
        ['Menu', 'fa-grip', route('admin.menu'), $route === 'admin.menu', 0],
    ];
@endphp
<nav class="lg:hidden fixed inset-x-0 bottom-0 z-40 bg-white/95 backdrop-blur border-t border-slate-200" style="padding-bottom: env(safe-area-inset-bottom);" aria-label="Navigasi admin">
    <div class="grid grid-cols-5">
        @foreach($tabs as [$label, $icon, $href, $active, $badge])
        <a href="{{ $href }}" @if($active) aria-current="page" @endif
           class="relative flex flex-col items-center justify-center gap-1 min-h-[60px] text-[11px] font-medium {{ $active ? 'text-blue-600' : 'text-slate-500' }}">
            <span class="relative">
                <i class="fa-solid {{ $icon }} text-lg"></i>
                @if($badge > 0)
                <span class="absolute -top-1.5 -right-3 min-w-[18px] h-[18px] px-1 rounded-full bg-red-500 text-white text-[10px] font-bold leading-[18px] text-center">{{ $badge > 99 ? '99+' : $badge }}</span>
                @endif
            </span>
            {{ $label }}
            @if($active)<span class="absolute top-0 inset-x-6 h-0.5 rounded-full bg-blue-600"></span>@endif
        </a>
        @endforeach
    </div>
</nav>
