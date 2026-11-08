{{--
    Toolbar pencarian + filter standar admin (mobile-first).

    HP     : satu baris [cari][tombol filter + jumlah aktif][cari]; filter lain di panel lipat 2 kolom.
    Desktop: satu baris [cari][filter...][Filter][Reset].

    Props:
      action       URL form (default halaman ini)
      name         nama input cari (default "search"; false = tanpa kolom cari), value: nilai cari
      placeholder  teks placeholder
      active       jumlah filter selain cari yang sedang aktif (badge + panel terbuka)
      reset        URL reset; tombol Reset tampil bila ada filter/cari aktif
      hidden       [name => value] input tersembunyi yang ikut dikirim (mis. tab aktif)
    Slot default: <x-admin.select>/<x-admin.input> filter tambahan. Isi slot dirender SEKALI.

    Contoh:
      <x-admin.filter-bar :action="route('x.index')" :value="$search" :active="(int) filled($status)" :reset="route('x.index')">
          <x-admin.select name="status" ... />
      </x-admin.filter-bar>
--}}
@props([
    'action' => null, 'name' => 'search', 'value' => '', 'placeholder' => 'Cari...',
    'active' => 0, 'reset' => null, 'hidden' => [], 'bordered' => true,
])
@php $hasFilters = $slot->isNotEmpty(); $dirty = $active > 0 || filled($value); @endphp

<form method="GET" @if($action) action="{{ $action }}" @endif x-data="{ open: false }"
      {{ $attributes->class(['admin-filter p-3 lg:p-4', 'border-b border-slate-200' => $bordered]) }}>
    @foreach($hidden as $hName => $hValue)
        @if(filled($hValue))<input type="hidden" name="{{ $hName }}" value="{{ $hValue }}">@endif
    @endforeach

    <div class="flex flex-wrap lg:flex-nowrap items-center gap-2">
        @if($name !== false)
        <div class="relative flex-1 min-w-0 order-1">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
            <input type="search" name="{{ $name }}" value="{{ $value }}" placeholder="{{ $placeholder }}" enterkeyhint="search"
                   class="w-full h-10 lg:h-9 rounded-lg border border-slate-300 bg-white pl-8 pr-3 text-sm text-slate-900 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:border-blue-500 focus:ring-blue-500/20">
        </div>
        @else
        {{-- Tanpa kolom cari: di HP tombol filter melebar, di desktop filter langsung tampil. --}}
        <p class="lg:hidden order-1 flex-1 text-sm font-medium text-slate-600">Filter{{ $active ? " ({$active} aktif)" : '' }}</p>
        @endif

        @if($hasFilters)
        <button type="button" @click="open = !open" :aria-expanded="open" aria-label="Filter"
                class="lg:hidden order-2 relative h-10 w-10 shrink-0 rounded-lg border flex items-center justify-center {{ $active ? 'border-blue-300 bg-blue-50 text-blue-600' : 'border-slate-300 bg-white text-slate-600' }}">
            <i class="fa-solid fa-sliders text-sm"></i>
            @if($active)
            <span class="absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-blue-600 text-white text-[10px] font-bold leading-[18px] text-center">{{ $active }}</span>
            @endif
        </button>

        {{-- Panel filter: lipat 2 kolom di HP, sebaris di desktop (dirender sekali). --}}
        <div :class="open && '!grid'"
             class="max-lg:hidden order-4 lg:order-2 w-full lg:w-auto grid-cols-2 gap-2 lg:flex lg:items-center lg:shrink-0 [&>*]:min-w-0 [&_select]:h-10 lg:[&_select]:h-9 [&_select]:py-0 [&_input]:h-10 lg:[&_input]:h-9 [&_input]:py-0">
            {{ $slot }}
            <div class="col-span-2 flex gap-2 lg:hidden">
                <button type="submit" class="flex-1 h-10 rounded-lg bg-blue-600 text-white text-sm font-semibold">Terapkan</button>
                @if($reset && $dirty)
                <a href="{{ $reset }}" class="h-10 px-4 rounded-lg border border-slate-300 text-sm font-medium text-slate-600 flex items-center">Reset</a>
                @endif
            </div>
        </div>
        @endif

        <button type="submit" class="order-3 h-10 w-10 lg:w-auto lg:h-9 lg:px-4 shrink-0 rounded-lg bg-blue-600 lg:bg-white lg:border lg:border-slate-300 text-white lg:text-slate-700 text-sm font-medium flex items-center justify-center gap-1.5" aria-label="Cari">
            <i class="fa-solid fa-magnifying-glass text-xs lg:hidden"></i><span class="hidden lg:inline">Filter</span>
        </button>
        @if($reset && $dirty)
        <a href="{{ $reset }}" class="hidden lg:flex order-3 h-9 px-3 shrink-0 rounded-lg border border-slate-300 bg-white text-sm text-slate-600 items-center gap-1.5"><i class="fa-solid fa-xmark text-xs"></i> Reset</a>
        @endif
    </div>
</form>
