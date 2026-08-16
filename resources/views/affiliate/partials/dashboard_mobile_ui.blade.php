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

    @if(!$hasTemplates)
    <div class="mb-6 relative overflow-hidden rounded-2xl bg-gradient-to-r from-teal-600/20 to-blue-500/20 border border-teal-500/30 p-4">
        <div class="absolute -right-6 -top-6 w-24 h-24 bg-teal-500/20 rounded-full blur-xl pointer-events-none"></div>
        <div class="flex items-start gap-4 relative z-10">
            <div class="w-10 h-10 shrink-0 rounded-full bg-teal-500/20 flex items-center justify-center text-teal-400">
                <i class="fa-solid fa-message"></i>
            </div>
            <div>
                <h3 class="text-sm font-bold text-white mb-1">Buat Template Chat Pertamamu!</h3>
                <p class="text-[11px] text-teal-100/70 mb-3 leading-relaxed">
                    Sebelum membagikan proposal ke calon klien, kamu wajib membuat Template Chat pribadi untuk memudahkan follow up via WhatsApp.
                </p>
                <a href="{{ route('affiliate.chat_templates.index') }}" class="inline-flex items-center justify-center px-4 py-2 bg-teal-500 hover:bg-teal-600 text-white text-xs font-bold rounded-xl transition-all shadow-[0_0_15px_rgba(20,184,166,0.3)] gap-2">
                    Buat Template Sekarang <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
    @endif

    <x-affiliate.grid-menu :totalProjects="$totalProjects" :totalClicks="$totalClicks" />

    <x-affiliate.promo-banner />

    <x-affiliate.target-ideas />
    @endif
</div>

@if($affiliate->status !== 'pending')
<x-affiliate.bottom-nav />
<x-affiliate.modals :affiliate="$affiliate" />
@endif

<x-affiliate.scripts />
