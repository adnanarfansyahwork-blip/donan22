{{-- Post Card Horizontal - Mobile Optimized --}}
<article class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
    <a href="{{ $post->url }}" class="flex flex-col xs:flex-row">
        {{-- Thumbnail Image - Responsive --}}
        <div class="relative w-full xs:w-[140px] xs:min-w-[140px] sm:w-[150px] sm:min-w-[150px] flex-shrink-0">
            <div class="h-48 xs:h-32 sm:h-full bg-gray-100">
                <img src="{{ $post->featured_image_url }}" 
                     alt="{{ $post->featured_image_alt ?? $post->title }}" 
                     class="w-full h-full object-cover"
                     loading="lazy"
                     decoding="async"
                     width="150"
                     height="130"
                     onerror="this.onerror=null;this.src='/images/no-image.svg'">
            </div>
            {{-- Comment Badge --}}
            <div class="absolute top-2 left-2 flex items-center gap-1 bg-emerald-500 text-white text-xs font-bold px-2 py-1 rounded-full">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                </svg>
                <span>{{ $post->comments_count ?? 0 }}</span>
            </div>
        </div>
        
        {{-- Content --}}
        <div class="flex-1 p-3 sm:p-3 flex flex-col justify-center min-w-0">
            {{-- Category & Date --}}
            <div class="flex flex-wrap items-center gap-1.5 mb-1 text-xs">
                @if($post->category)
                    <span class="font-bold uppercase text-emerald-600 truncate">{{ $post->category->name }}</span>
                    <span class="text-gray-300">•</span>
                @endif
                <time datetime="{{ $post->published_at?->toIso8601String() }}" class="text-gray-400">
                    {{ $post->published_at?->format('M d, Y') ?? 'Draft' }}
                </time>
            </div>
            
            {{-- Title --}}
            <h3 class="text-sm sm:text-base font-bold text-gray-900 line-clamp-2 hover:text-emerald-600 leading-snug mb-1">
                {{ $post->title }}
            </h3>
            
            {{-- Excerpt - Hidden on mobile --}}
            @if($post->excerpt)
                <p class="hidden xs:block text-xs text-gray-500 leading-relaxed">
                    {{ $post->excerpt }}
                </p>
            @endif
        </div>
    </a>
</article>
