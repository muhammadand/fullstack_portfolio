@props(['affiliate'])

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
