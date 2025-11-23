<div class="px-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">

    @forelse ($latestPortfolios as $item)
        <div class="group relative rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2">
            
            {{-- Background Image with Overlay --}}
            <div class="relative h-80 overflow-hidden">
                @if ($item->thumbnail_image)
                    <img src="{{ asset('storage/' . $item->thumbnail_image) }}"
                        class="w-full h-full object-cover transition-all duration-700 group-hover:scale-110"
                        alt="{{ $item->title }}">
                @else
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-400 to-blue-500"></div>
                @endif
                
                {{-- Dark Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/20"></div>
                
                {{-- Category Badge (Top Left) --}}
                @php
                    $techs = is_array($item->technologies) ? $item->technologies : explode(',', $item->technologies);
                    $firstTech = !empty($techs) ? trim($techs[0]) : '';
                @endphp
                
                @if($firstTech)
                    <div class="absolute top-4 left-4">
                        <span class="px-4 py-1.5 text-xs font-semibold rounded-full bg-blue-600/90 text-white uppercase tracking-wide backdrop-blur-sm">
                            {{ $firstTech }}
                        </span>
                    </div>
                @endif
                
                {{-- Content (Bottom) --}}
                <div class="absolute bottom-0 left-0 right-0 p-6">
                    {{-- Title --}}
                    <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-purple-300 transition-colors duration-300">
                        {{ $item->title }}
                    </h3>
                    
                    {{-- URL/Link --}}
                    @if(isset($item->project_url))
                        <p class="text-white/80 text-sm font-light tracking-wide">
                            {{ parse_url($item->project_url, PHP_URL_HOST) ?? 'View Project' }}
                        </p>
                    @else
                        <p class="text-white/80 text-sm font-light">
                            {{ $item->short_description }}
                        </p>
                    @endif
                </div>
                
                {{-- Hover Effect - View Details --}}
                <div class="absolute inset-0 bg-purple-600/0 group-hover:bg-purple-600/20 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <div class="transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300">
                        <a href="{{ route('portfolio.read', $item->slug) }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-white text-purple-600 font-bold rounded-full hover:bg-purple-600 hover:text-white transition-all duration-300 shadow-lg">
                            Lihat Detail
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>

    @empty
        <div class="col-span-3 text-center py-16">
            <i class="fas fa-folder-open text-6xl text-gray-300 mb-4"></i>
            <p class="text-gray-500 text-lg">Belum ada portfolio.</p>
        </div>
    @endforelse

</div>