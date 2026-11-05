{{-- 1. Data akun --}}
@if(count($fields) > 0)
<section class="p-4 sm:p-5 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md">
    <h2 class="flex items-center gap-2.5 font-sans font-bold text-sm sm:text-base text-white mb-3">
        <span class="w-6 h-6 rounded-lg bg-btn-gradient flex items-center justify-center text-[11px] font-black">1</span>
        Masukkan Data Akun
    </h2>
    <div class="grid gap-3 {{ count($fields) > 1 ? 'grid-cols-[1fr_7rem] sm:grid-cols-2' : 'grid-cols-1' }}">
        @foreach($fields as $f)
        <label class="block">
            <span class="block text-xs font-semibold text-white/70 mb-1.5">{{ $f['label'] }}</span>
            <input type="text" name="{{ $f['key'] }}" x-model.trim="values['{{ $f['key'] }}']" @blur="touched['{{ $f['key'] }}'] = true"
                inputmode="{{ $f['inputmode'] }}" placeholder="{{ $f['placeholder'] }}" autocomplete="off" enterkeyhint="next"
                :class="errors['{{ $f['key'] }}'] ? 'border-red-400/70' : 'border-white/15 focus:border-brand-accent/60'"
                class="w-full h-12 rounded-xl bg-white/5 border focus:bg-white/10 focus:outline-none text-white placeholder:text-white/30 text-base px-4 transition-colors">
            <span x-show="errors['{{ $f['key'] }}']" x-text="errors['{{ $f['key'] }}']" style="display:none" class="block text-[11px] text-red-300 mt-1"></span>
        </label>
        @endforeach
    </div>
    @if($form['hint'])
    <p class="flex gap-2 text-[11px] text-white/50 leading-relaxed mt-3">
        <i class="fa-solid fa-circle-info mt-0.5 text-brand-accent/80"></i><span>{{ $form['hint'] }}</span>
    </p>
    @endif
</section>
@endif
