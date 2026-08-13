<!-- Background Decoration -->
<div class="fixed top-0 left-0 w-full h-64 bg-blue-600/20 rounded-full blur-[100px] -translate-y-1/2 pointer-events-none z-0"></div>
<div class="fixed bottom-0 right-0 w-64 h-64 bg-indigo-600/20 rounded-full blur-[100px] translate-y-1/2 translate-x-1/3 pointer-events-none z-0"></div>

<div class="relative z-10 w-full max-w-md mx-auto flex flex-col min-h-screen px-4 pt-6">

    @if($affiliate->status === 'pending')
    <x-affiliate.header-pending :affiliate="$affiliate" />
    <x-affiliate.pending-message />
    @else
    <x-affiliate.header :affiliate="$affiliate" />

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

    <x-affiliate.check-in-card :affiliate="$affiliate" />

    <x-affiliate.balance-card :affiliate="$affiliate" />

    <!-- Hidden input for copy -->
    <input type="text" readonly value="{{ url('/sobat-scalify?ref=' . $affiliate->affiliate_code) }}" class="absolute -left-[9999px] opacity-0" id="affiliate-link">

    <x-affiliate.grid-menu :totalProjects="$totalProjects" :totalClicks="$totalClicks" />

    <x-affiliate.promo-banner />

    <x-affiliate.recent-activities :withdrawals="$withdrawals" />
    @endif
</div>

@if($affiliate->status !== 'pending')
<x-affiliate.bottom-nav />
<x-affiliate.modals :affiliate="$affiliate" />
@endif

<x-affiliate.scripts />
