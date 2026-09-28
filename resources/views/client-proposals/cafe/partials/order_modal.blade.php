<!-- Quick Order & Item Detail Modal on Landing Page -->
<div id="quickOrderModal" class="fixed inset-0 z-50 bg-black/80 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-[#1C1713] rounded-2xl border border-[#3A2C22] max-w-sm w-full p-5 text-white shadow-2xl relative">
        
        <button onclick="closeQuickOrderModal()" class="absolute top-3 right-3 w-7 h-7 rounded-full bg-white/10 text-white/70 hover:text-white flex items-center justify-center transition text-xs">
            <i class="fas fa-times"></i>
        </button>

        <!-- Product Image & Meta -->
        <div class="relative h-40 rounded-xl overflow-hidden mb-3 border border-white/10">
            <img id="modalProductImage" src="" alt="" class="w-full h-full object-cover">
            <span id="modalProductBadge" class="absolute top-2 left-2 px-2 py-0.5 rounded text-[9px] font-semibold bg-[#140F0C]/85 text-[#D8AA73] border border-white/10">
                Best Seller
            </span>
        </div>

        <div>
            <h3 id="modalProductName" class="font-serif font-bold text-base text-white">Caramel Macchiato</h3>
            <p id="modalProductDesc" class="text-xs text-white/60 mt-0.5 leading-relaxed font-light">Deskripsi produk kopi...</p>
            <div class="mt-2 text-sm font-bold font-mono text-[#D8AA73]" id="modalProductPrice">Rp 38.000</div>
        </div>

        <!-- Table Selector for Order -->
        <div class="mt-4 pt-3 border-t border-white/10 space-y-2.5">
            <div>
                <label class="text-[10px] font-semibold text-white/70 uppercase tracking-wider block mb-1">
                    Pilih Nomor Meja:
                </label>
                <select id="modalTableSelect" class="w-full bg-[#120E0C] border border-[#3A2C22] rounded-lg px-2.5 py-1.5 text-xs text-white focus:outline-none focus:border-[#C59B6C]">
                    @php
                    $tables = $cafeDatabase['tables'] ?? [];
                    @endphp
                    @foreach($tables as $t)
                    <option value="{{ $t['id'] }}">{{ $t['name'] }} ({{ $t['area'] }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="text-[10px] font-semibold text-white/70 uppercase tracking-wider block mb-1">
                    Catatan Khusus:
                </label>
                <input type="text" id="modalOrderNote" placeholder="Less sugar, oat milk, es sedikit..." class="w-full bg-[#120E0C] border border-white/10 rounded-lg px-2.5 py-1.5 text-xs text-white placeholder-white/40 focus:outline-none focus:border-[#C59B6C]">
            </div>
        </div>

        <!-- Action Button -->
        <div class="mt-4 pt-3 border-t border-white/10">
            @if(isset($client->slug))
            <a id="btnModalGoDemo" href="{{ route('demo.customer.cafe', $client->slug) }}" class="w-full py-2.5 rounded-xl bg-[#C59B6C] hover:bg-[#D8AA73] text-[#140F0C] text-xs font-bold text-center transition flex items-center justify-center gap-1.5">
                <i class="fas fa-mobile-alt text-xs"></i>
                <span>Lanjut ke Demo Self-Order HP</span>
            </a>
            @else
            <button onclick="alert('Pesanan diteruskan ke barista meja!'); closeQuickOrderModal();" class="w-full py-2.5 rounded-xl bg-[#C59B6C] text-[#140F0C] text-xs font-bold transition">
                Konfirmasi Pesanan
            </button>
            @endif
        </div>

    </div>
</div>
