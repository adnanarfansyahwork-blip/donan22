<article class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group h-full flex flex-col">
    <a href="{{ $post->url }}" class="block flex flex-col h-full">
        <!-- Image -->
        <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden relative flex-shrink-0">
            <img src="{{ $post->featured_image_url }}" 
                 alt="{{ $post->featured_image_alt ?? $post->title }}" 
                 class="w-full h-full object-contain object-center group-hover:scale-105 transition-transform duration-300 p-2" 
                 loading="lazy"
                 onerror="this.style.display='none'">
        </div>
        
        <!-- Content -->
        <div class="p-4 flex flex-col flex-grow">
            <!-- Category & Type Badge -->
            <div class="flex items-center gap-2 mb-2 flex-shrink-0">
                @if($post->category)
                    <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-1 rounded">
                        {{ $post->category->name }}
                    </span>
                @endif
                @if(isset($featured) && $featured)
                    <span class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded">
                        <i class="bi bi-star-fill"></i> Featured
                    </span>
                @endif
            </div>
            
            <!-- Title -->
            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-600 transition-colors flex-shrink-0">
                {{ $post->title }}
            </h3>
            
            <!-- Excerpt -->
            @if($post->excerpt)
                <p class="text-sm text-gray-600 mb-3 line-clamp-2 flex-grow">
                    @if(isset($excerpt_limit))
                        {{ Str::limit($post->excerpt, $excerpt_limit) }}
                    @else
                        {{ Str::limit($post->excerpt, 100) }}
                    @endif
                </p>
            @else
                <div class="flex-grow"></div>
            @endif
            
            <!-- Meta -->
            <div class="flex items-center justify-between text-xs text-gray-500 mt-auto flex-shrink-0">
                <div class="flex items-center gap-3">
                    <span><i class="bi bi-eye mr-1"></i>{{ number_format($post->views_count) }}</span>
                    @if($post->downloads_count > 0)
                        <span><i class="bi bi-download mr-1"></i>{{ number_format($post->downloads_count) }}</span>
                    @endif
                </div>
                <time datetime="{{ $post->published_at?->toIso8601String() }}">
                    {{ $post->published_at?->diffForHumans() ?? 'Draft' }}
                </time>
            </div>
        </div>
    </a>
</article>
