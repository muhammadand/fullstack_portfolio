@props(['item', 'totalProjects' => null])

<div class="w-12 h-12 rounded-2xl glass-panel flex items-center justify-center {{ $item['color'] }} text-lg shadow-inner relative transition-all duration-200 ease-out {{ $item['soon'] ? 'opacity-50' : 'active:scale-90 active:opacity-60 ' . $item['hover'] }}">
    @if($item['counter'] === 'totalProjects')
        <span class="font-bold text-sm">{{ $totalProjects ?? 0 }}</span>
    @else
        <i class="{{ $item['icon'] }}"></i>
    @endif

    @if($item['badge'])
        <span class="absolute -top-1.5 -right-1.5 {{ $item['badgeClass'] }} text-[8px] px-1.5 py-0.5 rounded-full leading-none whitespace-nowrap">{{ $item['badge'] }}</span>
    @endif
</div>
<span class="text-[10px] font-medium text-center leading-tight transition-colors {{ $item['soon'] ? 'text-slate-500' : 'text-slate-300 group-hover:text-white' }}">
    {{ $item['label'] }}@if($item['sublabel'] !== '')<br>{{ $item['sublabel'] }}@endif
</span>
