{{-- Category Sidebar with Icons - Inspired by yasir252.com --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-5 py-4">
        <h3 class="text-white font-bold text-center text-lg">
            {{ $title ?? 'Kategori Software' }}
        </h3>
    </div>
    
    {{-- Category Grid --}}
    <div class="p-5">
        <div class="grid grid-cols-2 gap-x-4 gap-y-3">
            @foreach($categories as $category)
                <a href="{{ route('categories.show', $category->slug) }}" 
                   class="flex items-center gap-3 py-2 group">
                    {{-- Icon --}}
                    @if($category->image)
                        <img src="{{ asset('storage/' . $category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="w-7 h-7 object-contain flex-shrink-0">
                    @elseif($category->icon)
                        <span class="w-7 h-7 flex items-center justify-center text-lg flex-shrink-0 text-blue-500">
                            <i class="bi {{ $category->icon }}"></i>
                        </span>
                    @else
                        <span class="w-7 h-7 flex items-center justify-center text-lg flex-shrink-0 text-gray-400">
                            <i class="bi bi-folder"></i>
                        </span>
                    @endif
                    
                    {{-- Name --}}
                    <span class="text-sm text-blue-600 font-medium group-hover:text-blue-800 group-hover:underline transition-colors truncate">
                        {{ $category->name }}
                    </span>
                </a>
            @endforeach
        </div>
        
        {{-- View All Link --}}
        @if(isset($showViewAll) && $showViewAll)
            <div class="mt-5 pt-4 border-t border-gray-100 text-center">
                <a href="{{ route('categories.index') }}" 
                   class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                    Lihat Semua Kategori
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        @endif
    </div>
</div>
