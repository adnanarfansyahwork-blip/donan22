{{-- Post Card Horizontal - Inspired by yasir252.com & sadeempc.com --}}
<article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
    <a href="{{ $post->url }}" class="flex flex-col sm:flex-row h-full">
        {{-- Thumbnail Image - Fixed size container --}}
        <div class="relative w-full sm:w-44 md:w-48 flex-shrink-0">
            <div class="h-32 sm:h-full w-full bg-gray-100 overflow-hidden">
                <img src="{{ $post->featured_image_url }}" 
                     alt="{{ $post->featured_image_alt ?? $post->title }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     loading="lazy"
                     onerror="this.onerror=null;this.src='/images/no-image.svg'">
            </div>
            {{-- Comment Count Badge --}}
            <div class="absolute top-2 left-2 flex items-center gap-1 bg-emerald-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-md">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                </svg>
                <span>{{ $post->comments_count ?? 0 }}</span>
            </div>
        </div>
        
        {{-- Content --}}
        <div class="flex-1 p-4 flex flex-col min-w-0">
            {{-- Category & Date Row --}}
            <div class="flex flex-wrap items-center gap-2 mb-2 text-xs">
                @if($post->category)
                    <span class="font-bold uppercase tracking-wider text-emerald-600">
                        {{ $post->category->name }}
                    </span>
                    <span class="text-gray-300">|</span>
                @endif
                <time datetime="{{ $post->published_at?->toIso8601String() }}" 
                      class="text-gray-400 font-medium uppercase tracking-wide">
                    {{ $post->published_at?->format('M d, Y') ?? 'Draft' }}
                </time>
            </div>
            
            {{-- Title --}}
            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors duration-200 leading-snug">
                {{ $post->title }}
            </h3>
            
            {{-- Excerpt --}}
            @if($post->excerpt)
                <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed flex-1">
                    {{ Str::limit($post->excerpt, 120) }}
                </p>
            @endif
        </div>
    </a>
</article>
