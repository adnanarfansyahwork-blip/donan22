<article class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group">
    <a href="{{ $post->url }}" class="block">
        <!-- Image -->
        <div class="aspect-video bg-gray-100 overflow-hidden">
            <img src="{{ $post->featured_image_url }}" 
                 alt="{{ $post->featured_image_alt ?? $post->title }}" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                 loading="lazy">
        </div>
        
        <!-- Content -->
        <div class="p-4">
            <!-- Category & Type Badge -->
            <div class="flex items-center gap-2 mb-2">
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
            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-600 transition-colors">
                {{ $post->title }}
            </h3>
            
            <!-- Excerpt -->
            @if($post->excerpt)
                <p class="text-sm text-gray-600 mb-3 line-clamp-3">
                    @if(isset($excerpt_limit))
                        {{ Str::limit($post->excerpt, $excerpt_limit) }}
                    @else
                        {{ $post->excerpt }}
                    @endif
                </p>
            @endif
            
            <!-- Meta -->
            <div class="flex items-center justify-between text-xs text-gray-500">
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
