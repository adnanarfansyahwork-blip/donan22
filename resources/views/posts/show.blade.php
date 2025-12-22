@extends('layouts.app')

@section('title', ($post->meta_title ?? $post->title) . ' - Donan22')
@section('meta_description', $post->meta_description ?? $post->excerpt)
@section('meta_keywords', $post->meta_keywords)
@section('og_title', $post->meta_title ?? $post->title)
@section('og_description', $post->meta_description ?? $post->excerpt)
@section('og_image', $post->featured_image_url)
@section('og_type', 'article')

@push('styles')
<style>
/* Post Content Styling */
.post-content {
    max-width: none;
    color: #374151;
    line-height: 1.75;
}

/* Headings */
.post-content h1 {
    font-size: 1.875rem !important;
    font-weight: 700 !important;
    color: #111827 !important;
    margin-top: 2rem !important;
    margin-bottom: 1rem !important;
    padding-bottom: 0.75rem !important;
    border-bottom: 2px solid #3b82f6 !important;
    line-height: 1.25 !important;
}

.post-content h2 {
    font-size: 1.5rem !important;
    font-weight: 700 !important;
    color: #111827 !important;
    margin-top: 1.75rem !important;
    margin-bottom: 0.75rem !important;
    padding-bottom: 0.5rem !important;
    border-bottom: 1px solid #e5e7eb !important;
    line-height: 1.3 !important;
}

.post-content h3 {
    font-size: 1.25rem !important;
    font-weight: 700 !important;
    color: #111827 !important;
    margin-top: 1.5rem !important;
    margin-bottom: 0.75rem !important;
    line-height: 1.35 !important;
}

.post-content h4 {
    font-size: 1.125rem !important;
    font-weight: 600 !important;
    color: #111827 !important;
    margin-top: 1.25rem !important;
    margin-bottom: 0.5rem !important;
    line-height: 1.4 !important;
}

.post-content h5 {
    font-size: 1rem !important;
    font-weight: 600 !important;
    color: #111827 !important;
    margin-top: 1rem !important;
    margin-bottom: 0.5rem !important;
}

.post-content h6 {
    font-size: 0.875rem !important;
    font-weight: 600 !important;
    color: #4b5563 !important;
    margin-top: 1rem !important;
    margin-bottom: 0.5rem !important;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Paragraphs */
.post-content p {
    margin-bottom: 1rem !important;
    color: #374151 !important;
    line-height: 1.75 !important;
}

.post-content p:last-child {
    margin-bottom: 0 !important;
}

/* Links */
.post-content a {
    color: #3b82f6 !important;
    font-weight: 500;
    text-decoration: none;
}

.post-content a:hover {
    text-decoration: underline;
    color: #2563eb !important;
}

/* Strong & Em */
.post-content strong, 
.post-content b {
    font-weight: 600 !important;
    color: #111827 !important;
}

.post-content em, 
.post-content i {
    font-style: italic !important;
}

/* Lists */
.post-content ul,
.post-content ol {
    margin: 1rem 0 !important;
    padding-left: 1.5rem !important;
}

.post-content ul {
    list-style-type: disc !important;
}

.post-content ol {
    list-style-type: decimal !important;
}

.post-content li {
    margin: 0.5rem 0 !important;
    color: #374151 !important;
    line-height: 1.75 !important;
}

.post-content li > ul,
.post-content li > ol {
    margin: 0.5rem 0 !important;
}

/* Images */
.post-content img {
    max-width: 100% !important;
    height: auto !important;
    border-radius: 0.5rem;
    margin: 1.5rem 0 !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    border: 1px solid #e5e7eb;
}

/* Code */
.post-content code {
    background-color: #f3f4f6 !important;
    color: #1f2937 !important;
    padding: 0.125rem 0.375rem !important;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-family: ui-monospace, monospace !important;
}

.post-content pre {
    background-color: #1f2937 !important;
    color: #f3f4f6 !important;
    padding: 1rem !important;
    border-radius: 0.5rem;
    overflow-x: auto;
    margin: 1.25rem 0 !important;
}

.post-content pre code {
    background-color: transparent !important;
    color: #f3f4f6 !important;
    padding: 0 !important;
}

/* Blockquotes */
.post-content blockquote {
    border-left: 4px solid #3b82f6 !important;
    padding-left: 1rem !important;
    padding-top: 0.5rem !important;
    padding-bottom: 0.5rem !important;
    margin: 1.5rem 0 !important;
    font-style: italic;
    color: #4b5563 !important;
    background-color: #f9fafb;
    border-radius: 0 0.5rem 0.5rem 0;
}

.post-content blockquote p {
    margin: 0 !important;
}

/* HR */
.post-content hr {
    border: none !important;
    border-top: 1px solid #e5e7eb !important;
    margin: 2rem 0 !important;
}

/* Tables */
.post-content table {
    width: 100% !important;
    border-collapse: collapse !important;
    margin: 1.5rem 0 !important;
    font-size: 0.875rem;
}

.post-content thead {
    background-color: #f9fafb !important;
    border-bottom: 2px solid #d1d5db !important;
}

.post-content th {
    border: 1px solid #e5e7eb !important;
    padding: 0.75rem !important;
    text-align: left !important;
    font-weight: 600 !important;
    color: #111827 !important;
}

.post-content td {
    border: 1px solid #e5e7eb !important;
    padding: 0.75rem !important;
    color: #374151 !important;
}

.post-content tbody tr:nth-child(even) {
    background-color: #f9fafb;
}

/* Remove Summernote default margins */
.post-content * {
    margin-top: 0;
}

.post-content > *:first-child {
    margin-top: 0 !important;
}

.post-content > *:last-child {
    margin-bottom: 0 !important;
}
</style>
@endpush

@section('content')
<article class="py-6 lg:py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Main Content -->
            <div class="lg:col-span-2">
                
                <!-- Breadcrumb -->
                <nav class="flex items-center flex-wrap gap-1 text-sm text-gray-500 mb-5" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-primary-600 transition-colors">
                        <i class="bi bi-house-door"></i>
                    </a>
                    <i class="bi bi-chevron-right text-xs text-gray-400"></i>
                    @if($post->postType)
                        <a href="{{ route($post->postType->slug . '.index') }}" class="hover:text-primary-600 transition-colors">{{ $post->postType->name }}</a>
                        <i class="bi bi-chevron-right text-xs text-gray-400"></i>
                    @endif
                    @if($post->category)
                        <a href="{{ route('categories.show', $post->category->slug) }}" class="hover:text-primary-600 transition-colors">{{ $post->category->name }}</a>
                        <i class="bi bi-chevron-right text-xs text-gray-400"></i>
                    @endif
                    <span class="text-gray-700 truncate max-w-[180px]">{{ Str::limit($post->title, 40) }}</span>
                </nav>

                <!-- Header Card -->
                <div class="bg-white rounded-xl border border-gray-200 p-5 mb-6 shadow-sm">
                    <div class="flex gap-4">
                        <!-- App Icon/Thumbnail -->
                        <div class="w-40 h-40 sm:w-[300px] sm:h-[300px] flex-shrink-0 rounded-xl overflow-hidden bg-gray-100 border border-gray-200 shadow-sm">
                            <img src="{{ $post->featured_image_url }}" 
                                 alt="{{ $post->featured_image_alt ?? $post->title }}"
                                 class="w-full h-full object-cover"
                                 loading="lazy"
                                 width="300" height="300">
                        </div>
                        
                        <!-- Title & Meta -->
                        <div class="flex-1 min-w-0">
                            <!-- Badges -->
                            <div class="flex flex-wrap gap-1.5 mb-2">
                                @if($post->postType)
                                    <span class="inline-flex items-center text-xs font-medium bg-primary-50 text-primary-700 px-2 py-0.5 rounded">
                                        <i class="bi {{ $post->postType->icon ?? 'bi-folder' }} mr-1 text-[10px]"></i>{{ $post->postType->name }}
                                    </span>
                                @endif
                                @if($post->category)
                                    <span class="inline-flex items-center text-xs font-medium bg-gray-100 text-gray-600 px-2 py-0.5 rounded">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                                @if($post->is_featured)
                                    <span class="inline-flex items-center text-xs font-medium bg-amber-50 text-amber-700 px-2 py-0.5 rounded">
                                        <i class="bi bi-star-fill mr-1 text-[10px]"></i>Featured
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Title -->
                            <h1 class="text-xl sm:text-2xl lg:text-[1.75rem] font-bold text-gray-900 leading-tight mb-2">
                                {{ $post->title }}
                            </h1>
                            
                            <!-- Stats -->
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs sm:text-sm text-gray-500">
                                <span class="flex items-center">
                                    <i class="bi bi-calendar3 mr-1"></i>{{ $post->published_at?->format('M d, Y') }}
                                </span>
                                <span class="flex items-center">
                                    <i class="bi bi-eye mr-1"></i>{{ number_format($post->views_count) }}
                                </span>
                                <span class="flex items-center">
                                    <i class="bi bi-clock mr-1"></i>{{ $post->reading_time }} min
                                </span>
                            </div>
                        </div>
                    </div>
                    

                </div>

                <!-- Content -->
                <div class="bg-white rounded-xl border border-gray-200 p-5 sm:p-6 mb-6 shadow-sm">
                    <div class="post-content">
                        {!! $post->content !!}
                    </div>
                </div>

                <!-- Tags -->
                @if($post->tags instanceof \Illuminate\Support\Collection && $post->tags->count())
                <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6 shadow-sm">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-gray-500 text-sm font-medium">
                            <i class="bi bi-tags mr-1"></i>Tags:
                        </span>
                        @foreach($post->tags as $tag)
                            <a href="{{ route('search', ['tag' => $tag->slug]) }}"
                               class="inline-flex items-center text-sm bg-gray-100 hover:bg-primary-50 text-gray-700 hover:text-primary-700 px-3 py-1 rounded-full transition-colors">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Share -->
                <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-500 text-sm font-medium">Share:</span>
                        <div class="flex items-center gap-2">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($post->url) }}" 
                               target="_blank" rel="noopener"
                               class="w-9 h-9 flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors"
                               aria-label="Share on Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($post->url) }}&text={{ urlencode($post->title) }}" 
                               target="_blank" rel="noopener"
                               class="w-9 h-9 flex items-center justify-center bg-gray-900 hover:bg-gray-800 text-white rounded-lg transition-colors"
                               aria-label="Share on X">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . $post->url) }}" 
                               target="_blank" rel="noopener"
                               class="w-9 h-9 flex items-center justify-center bg-green-500 hover:bg-green-600 text-white rounded-lg transition-colors"
                               aria-label="Share on WhatsApp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                            <button onclick="navigator.clipboard.writeText('{{ $post->url }}'); this.classList.add('bg-green-500'); this.innerHTML='<i class=\'bi bi-check\'></i>'; setTimeout(() => { this.classList.remove('bg-green-500'); this.innerHTML='<i class=\'bi bi-link-45deg\'></i>'; }, 1500)"
                                    class="w-9 h-9 flex items-center justify-center bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors"
                                    aria-label="Copy link">
                                <i class="bi bi-link-45deg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Comments Section -->
                @if($post->allow_comments)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-5 py-4 bg-gray-50 border-b border-gray-200">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center">
                            <i class="bi bi-chat-dots mr-2 text-primary-600"></i>
                            Comments <span class="ml-1 text-gray-500 font-normal">({{ $post->comments_count ?? 0 }})</span>
                        </h2>
                    </div>
                    
                    <div class="p-5">
                        <!-- Comment Form -->
                        <form action="{{ route('comments.store') }}" method="POST" class="mb-6">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                                <div>
                                    <input type="text" name="author_name" placeholder="Your Name *" required
                                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                           value="{{ old('author_name') }}">
                                    @error('author_name')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <input type="email" name="author_email" placeholder="Your Email *" required
                                           class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition"
                                           value="{{ old('author_email') }}">
                                    @error('author_email')
                                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <textarea name="content" rows="3" placeholder="Write your comment..." required
                                          class="w-full px-4 py-2.5 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition resize-none">{{ old('content') }}</textarea>
                                @error('content')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <button type="submit" 
                                    class="inline-flex items-center px-5 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-lg transition-colors">
                                <i class="bi bi-send mr-2"></i>Post Comment
                            </button>
                        </form>

                        <!-- Comments List -->
                        @if(isset($comments) && $comments->count())
                            <div class="space-y-4">
                                @foreach($comments as $comment)
                                    <div class="flex gap-3 p-4 bg-gray-50 rounded-lg">
                                        <div class="w-10 h-10 rounded-full bg-primary-100 flex items-center justify-center text-primary-700 font-bold text-sm flex-shrink-0">
                                            {{ strtoupper(substr($comment->guest_name ?? $comment->user?->name ?? 'A', 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <span class="font-semibold text-gray-900 text-sm">{{ $comment->guest_name ?? $comment->user?->name ?? 'Anonymous' }}</span>
                                                <span class="text-xs text-gray-400"></span>
                                                <time class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</time>
                                            </div>
                                            <p class="text-gray-700 text-sm leading-relaxed">{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($comments->hasPages())
                                <div class="mt-5 pt-4 border-t border-gray-100">
                                    {{ $comments->links() }}
                                </div>
                            @endif
                        @else
                            <div class="text-center py-8">
                                <i class="bi bi-chat text-4xl text-gray-300 mb-2"></i>
                                <p class="text-gray-500 text-sm">No comments yet. Be the first to comment!</p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
                
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-1 space-y-5">
                
                <!-- Download Card - Priority -->
                <div id="download-card" class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm lg:sticky lg:top-4">
                    <div class="px-4 py-3 bg-gradient-to-r from-green-600 to-green-500">
                        <h3 class="font-bold text-white flex items-center">
                            <i class="bi bi-download mr-2"></i>Download
                        </h3>
                    </div>
                    
                    <div class="p-4">
                        @if($post->downloadLinks && $post->downloadLinks->count())
                            <div class="space-y-2">
                                @foreach($post->downloadLinks as $link)
                                    <a href="{{ route('go.download', ['post' => $post->slug, 'linkIndex' => $loop->index]) }}"
                                       class="download-link-ad flex items-center gap-3 p-3 bg-gray-50 hover:bg-green-50 rounded-lg border border-gray-200 hover:border-green-300 transition-all group" data-link-id="{{ $loop->index }}">
                                        <div class="w-10 h-10 rounded-lg bg-green-100 group-hover:bg-green-200 flex items-center justify-center text-green-600 transition-colors flex-shrink-0">
                                            <i class="bi bi-cloud-arrow-down text-lg"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-medium text-gray-900 text-sm truncate group-hover:text-green-700 transition-colors">
                                                <span class="download-text">{{ $link->name ?? 'Download' }}</span>
                                            </div>
                                            <div class="text-xs text-gray-500 flex items-center gap-2">
                                                @if($link->provider)
                                                    <span>{{ $link->provider }}</span>
                                                @endif
                                                @if($link->file_size)
                                                    <span class="text-gray-300"></span>
                                                    <span>{{ $link->file_size }}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <i class="bi bi-chevron-right text-gray-400 group-hover:text-green-600 transition-colors"></i>
                                    </a>
                                @endforeach
                            </div>
                            
                            @if($post->downloadLinks->first()?->password)
                                <div class="mt-3 p-3 bg-amber-50 border border-amber-200 rounded-lg">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-amber-700 font-medium">Password:</span>
                                        <code class="text-sm text-amber-800 bg-amber-100 px-2 py-0.5 rounded font-mono select-all cursor-pointer" 
                                              onclick="navigator.clipboard.writeText(this.innerText)"
                                              title="Click to copy">{{ $post->downloadLinks->first()->password }}</code>
                                    </div>
                                </div>
                            @endif
                            
                            <p class="mt-3 text-xs text-gray-400 text-center flex items-center justify-center gap-1">
                                <i class="bi bi-shield-check text-green-500"></i>
                                <span>Scanned for viruses</span>
                            </p>
                        @else
                            <div class="text-center py-6">
                                <i class="bi bi-file-earmark-x text-3xl text-gray-300 mb-2"></i>
                                <p class="text-gray-500 text-sm">No downloads available</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Software Details Card -->
                @if($post->softwareDetail)
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900 text-sm flex items-center">
                            <i class="bi bi-info-circle mr-2 text-primary-600"></i>Software Info
                        </h3>
                    </div>
                    <div class="p-4">
                        <dl class="space-y-2.5 text-sm">
                            @if($post->softwareDetail->version)
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500">Version</dt>
                                <dd class="font-medium text-gray-900">{{ $post->softwareDetail->version }}</dd>
                            </div>
                            @endif
                            @if($post->softwareDetail->developer)
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500">Developer</dt>
                                <dd class="font-medium text-gray-900 text-right">
                                    @if($post->softwareDetail->developer_url)
                                        <a href="{{ $post->softwareDetail->developer_url }}" target="_blank" class="text-primary-600 hover:underline">
                                            {{ $post->softwareDetail->developer }}
                                        </a>
                                    @else
                                        {{ $post->softwareDetail->developer }}
                                    @endif
                                </dd>
                            </div>
                            @endif
                            @if($post->softwareDetail->platform)
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500">Platform</dt>
                                <dd class="font-medium text-gray-900">{{ $post->softwareDetail->platform_label ?? $post->softwareDetail->platform }}</dd>
                            </div>
                            @endif
                            @if($post->softwareDetail->file_size)
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500">Size</dt>
                                <dd class="font-medium text-gray-900">{{ $post->softwareDetail->file_size }}</dd>
                            </div>
                            @endif
                            @if($post->softwareDetail->license_type)
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500">License</dt>
                                <dd class="font-medium text-gray-900">{{ $post->softwareDetail->license_type }}</dd>
                            </div>
                            @endif
                            <div class="flex justify-between items-center pt-2 border-t border-gray-100">
                                <dt class="text-gray-500">Price</dt>
                                <dd class="font-semibold {{ $post->softwareDetail->is_free ? 'text-green-600' : 'text-gray-900' }}">
                                    {{ $post->softwareDetail->price_formatted ?? ($post->softwareDetail->is_free ? 'Free' : 'Paid') }}
                                </dd>
                            </div>
                        </dl>

                        @if($post->softwareDetail->official_website)
                            <a href="{{ $post->softwareDetail->official_website }}" target="_blank" rel="noopener"
                               class="flex items-center justify-center gap-1 mt-4 py-2 text-sm text-primary-600 hover:text-primary-700 hover:bg-primary-50 rounded-lg transition-colors">
                                <i class="bi bi-box-arrow-up-right text-xs"></i>
                                <span>Official Website</span>
                            </a>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Post Meta -->
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900 text-sm flex items-center">
                            <i class="bi bi-bar-chart mr-2 text-primary-600"></i>Statistics
                        </h3>
                    </div>
                    <div class="p-4">
                        <dl class="space-y-2.5 text-sm">
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500">Category</dt>
                                <dd class="font-medium text-gray-900">{{ $post->category?->name ?? 'Uncategorized' }}</dd>
                            </div>
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500">Published</dt>
                                <dd class="font-medium text-gray-900">{{ $post->published_at?->format('M d, Y') }}</dd>
                            </div>
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500">Views</dt>
                                <dd class="font-medium text-gray-900">{{ number_format($post->views_count) }}</dd>
                            </div>
                            <div class="flex justify-between items-center">
                                <dt class="text-gray-500">Downloads</dt>
                                <dd class="font-medium text-gray-900">{{ number_format($post->downloads_count ?? 0) }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Related Posts -->
                @if(isset($relatedPosts) && $relatedPosts->count())
                <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                    <div class="px-4 py-3 bg-gray-50 border-b border-gray-200">
                        <h3 class="font-semibold text-gray-900 text-sm flex items-center">
                            <i class="bi bi-collection mr-2 text-primary-600"></i>Related
                        </h3>
                    </div>
                    <div class="divide-y divide-gray-100">
                        @foreach($relatedPosts->take(4) as $related)
                            <a href="{{ $related->url }}" class="flex gap-3 p-3 hover:bg-gray-50 transition-colors group">
                                <div class="w-12 h-12 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                    <img src="{{ $related->featured_image_url }}" 
                                         alt="{{ $related->title }}"
                                         class="w-full h-full object-cover"
                                         loading="lazy"
                                         width="48" height="48">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-medium text-gray-900 text-sm line-clamp-2 group-hover:text-primary-600 transition-colors leading-snug">
                                        {{ $related->title }}
                                    </h4>
                                    <div class="text-xs text-gray-500 mt-1">
                                        <i class="bi bi-eye mr-1"></i>{{ number_format($related->views_count) }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
                
            </aside>
        </div>
    </div>
</article>
@push('scripts')
<!-- Popunder Ads Script -->
<script type="text/javascript" src="https://demolitionnutsgrease.com/e4/5e/d3/e45ed341f028607fadcfb84f48836611.js"></script>
<script>
    // Popunder on ANY click (including links, buttons, etc)
    document.addEventListener('DOMContentLoaded', function() {
        const popunderDelay = 5000; // 5 seconds cooldown between popunders
        
        // Trigger popunder on ANY click anywhere on the page
        document.body.addEventListener('click', function(e) {
            // Check if enough time has passed since last popunder
            const lastTrigger = parseInt(localStorage.getItem('last_popunder_trigger') || '0');
            const now = Date.now();
            
            if (now - lastTrigger > popunderDelay) {
                localStorage.setItem('last_popunder_trigger', now.toString());
                // Popunder script will handle the actual popup
            }
        }, true);
        
        // Download links - add visual feedback only
        const downloadLinks = document.querySelectorAll('.download-link-ad');
        downloadLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                const textElement = this.querySelector('.download-text');
                if (textElement) {
                    const originalText = textElement.innerText;
                    textElement.innerText = 'Opening Download...';
                    setTimeout(() => {
                        textElement.innerText = originalText;
                    }, 2000);
                }
            });
        });
    });
</script>
@endpush

@endsection

@push('styles')
<style>
    /* Prose overrides */
    .prose img { max-width: 100%; height: auto; }
    .prose > :first-child { margin-top: 0; }
    .prose > :last-child { margin-bottom: 0; }
    
    /* Smooth scroll for anchor links */
    html { scroll-behavior: smooth; }
    
    /* Focus states for accessibility */
    a:focus-visible, button:focus-visible, input:focus-visible, textarea:focus-visible {
        outline: 2px solid rgb(var(--color-primary-500));
        outline-offset: 2px;
    }
</style>
@endpush