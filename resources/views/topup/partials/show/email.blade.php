{{-- 3. Email struk (opsional) --}}
<section class="p-4 sm:p-5 rounded-2xl bg-white/[0.04] border border-white/10 backdrop-blur-md">
    <h2 class="flex items-center gap-2.5 font-sans font-bold text-sm sm:text-base text-white mb-3">
        <span class="w-6 h-6 rounded-lg bg-btn-gradient flex items-center justify-center text-[11px] font-black">{{ $n + 1 }}</span>
        Email Struk <span class="text-white/40 font-medium text-xs">(opsional)</span>
    </h2>
    <input type="email" name="email" x-model.trim="email" @blur="emailTouched = true" inputmode="email" autocomplete="email" placeholder="nama@email.com"
        :class="errors.email ? 'border-red-400/70' : 'border-white/15 focus:border-brand-accent/60'"
        class="w-full h-12 rounded-xl bg-white/5 border focus:bg-white/10 focus:outline-none text-white placeholder:text-white/30 text-base px-4 transition-colors">
    <span x-show="errors.email" x-text="errors.email" style="display:none" class="block text-[11px] text-red-300 mt-1"></span>
    <p class="flex gap-2 text-[11px] text-white/50 leading-relaxed mt-2.5">
        <i class="fa-solid fa-receipt mt-0.5 text-brand-accent/80"></i><span>Isi email untuk menerima struk otomatis begitu item masuk ke akun game kamu.</span>
    </p>
</section>
