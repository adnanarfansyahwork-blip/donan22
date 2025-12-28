@extends('layouts.app')

@section('title', 'Donan22 - IT & Software Learning Hub')
@section('meta_description', 'Download software PC, mobile apps Android & iOS, and learn IT tutorials. Your trusted source for technology.')
@section('canonical', route('home'))

@section('content')
<!-- Hero Section - Mobile Optimized -->
<section class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white py-12 sm:py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold mb-4 sm:mb-6">
                IT & Software Learning Hub
            </h1>
            <p class="text-base sm:text-lg lg:text-xl text-primary-100 mb-6 sm:mb-8">
                Download software, mobile apps, and learn IT tutorials.
                Your trusted source for the latest technology.
            </p>

            <!-- Quick Stats - Mobile Optimized -->
            <div class="flex flex-wrap justify-center gap-4 sm:gap-6 lg:gap-8 mt-6 sm:mt-8">
                <div class="text-center min-w-[80px]">
                    <div class="text-2xl sm:text-3xl font-bold">{{ \App\Models\Post::where('post_type', 'software')->count() }}+</div>
                    <div class="text-primary-200 text-xs sm:text-sm">Software</div>
                </div>
                <div class="text-center min-w-[80px]">
                    <div class="text-2xl sm:text-3xl font-bold">{{ \App\Models\Post::where('post_type', 'mobile-app')->count() }}+</div>
                    <div class="text-primary-200 text-xs sm:text-sm">Mobile Apps</div>
                </div>
                <div class="text-center min-w-[80px]">
                    <div class="text-2xl sm:text-3xl font-bold">{{ \App\Models\Post::where('post_type', 'tutorial')->count() }}+</div>
                    <div class="text-primary-200 text-xs sm:text-sm">Tutorials</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Ad Banner -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6">
    @include('components.ads.banner-468x60')
</div>

<!-- Featured Posts -->
@if($featuredPosts->count())
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-star-fill text-yellow-500 mr-2"></i> Featured
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredPosts->take(6) as $post)
                @include('components.post-card', ['post' => $post, 'featured' => true])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Popular Software -->
@if($popularSoftware->count())
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-box-seam text-primary-600 mr-2"></i> Popular Software
            </h2>
            <a href="{{ route('software.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($popularSoftware as $post)
                @include('components.software-card', ['post' => $post])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Mobile Apps -->
@if($popularApps->count())
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-phone text-green-600 mr-2"></i> Mobile Apps
            </h2>
            <a href="{{ route('mobile-apps.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($popularApps as $post)
                @include('components.software-card', ['post' => $post])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Tutorials -->
@if($tutorials->count())
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-book text-purple-600 mr-2"></i> Latest Tutorials
            </h2>
            <a href="{{ route('tutorials.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($tutorials as $post)
                @include('components.post-card', ['post' => $post])
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Latest Posts with Category Sidebar -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-clock text-emerald-500 mr-2"></i> Latest Updates
            </h2>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            {{-- Posts List (Left Side - 65%) --}}
            <div class="lg:w-[65%] space-y-4">
                @foreach($latestPosts as $post)
                    @include('components.post-card-horizontal', ['post' => $post])
                @endforeach
            </div>
            
            {{-- Category Sidebar (Right Side - 35%) --}}
            <div class="lg:w-[35%]">
                <div class="sticky top-24 space-y-6">
                    @include('components.category-sidebar', [
                        'categories' => $categories, 
                        'title' => 'Kategori Software',
                        'showViewAll' => true
                    ])
                    
                    {{-- Popular Posts Widget --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 px-5 py-3">
                            <h3 class="text-white font-bold text-center">
                                <i class="bi bi-fire mr-2"></i>Tulisan Populer
                            </h3>
                        </div>
                        <div class="p-4 space-y-2">
                            @foreach($featuredPosts->take(5) as $index => $popularPost)
                                <a href="{{ $popularPost->url }}" 
                                   class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold
                                        {{ $index === 0 ? 'bg-red-500 text-white' : ($index === 1 ? 'bg-orange-500 text-white' : ($index === 2 ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-600')) }}">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-800 line-clamp-2 group-hover:text-emerald-600 transition-colors leading-snug">
                                            {{ $popularPost->title }}
                                        </h4>
                                        <span class="text-xs text-gray-400">{{ number_format($popularPost->views_count) }} views</span>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-primary-600 to-primary-800 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
        <p class="text-primary-100 mb-8">Get notified about new software releases, tutorials, and updates.</p>
        
        <!-- Success Message -->
        <div id="subscribe-success" class="hidden mb-6 p-4 bg-green-500/20 border border-green-400 rounded-lg text-green-100">
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span id="subscribe-success-message"></span>
            </div>
        </div>

        <!-- Error Message -->
        <div id="subscribe-error" class="hidden mb-6 p-4 bg-red-500/20 border border-red-400 rounded-lg text-red-100">
            <div class="flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
                <span id="subscribe-error-message"></span>
            </div>
        </div>

        <form id="subscribe-form" class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
            @csrf
            <input type="email" name="email" id="subscribe-email" placeholder="Enter your email" required
                   class="flex-1 px-6 py-3 rounded-lg text-gray-900 focus:ring-4 focus:ring-primary-300 focus:outline-none">
            <button type="submit" id="subscribe-btn" class="px-8 py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center">
                <span id="subscribe-btn-text">Subscribe</span>
                <svg id="subscribe-loading" class="hidden w-5 h-5 ml-2 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
            </button>
        </form>
    </div>
</section>

@push('scripts')
<script>
document.getElementById('subscribe-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = this;
    const email = document.getElementById('subscribe-email').value;
    const btn = document.getElementById('subscribe-btn');
    const btnText = document.getElementById('subscribe-btn-text');
    const loading = document.getElementById('subscribe-loading');
    const successDiv = document.getElementById('subscribe-success');
    const errorDiv = document.getElementById('subscribe-error');
    const successMsg = document.getElementById('subscribe-success-message');
    const errorMsg = document.getElementById('subscribe-error-message');
    
    // Reset messages
    successDiv.classList.add('hidden');
    errorDiv.classList.add('hidden');
    
    // Show loading
    btn.disabled = true;
    btnText.textContent = 'Subscribing...';
    loading.classList.remove('hidden');
    
    try {
        const response = await fetch('{{ route("subscriber.subscribe") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ email: email })
        });
        
        const data = await response.json();
        
        if (data.success) {
            successMsg.textContent = data.message;
            successDiv.classList.remove('hidden');
            form.reset();
        } else {
            errorMsg.textContent = data.message;
            errorDiv.classList.remove('hidden');
        }
    } catch (error) {
        errorMsg.textContent = 'Something went wrong. Please try again.';
        errorDiv.classList.remove('hidden');
    } finally {
        // Reset button
        btn.disabled = false;
        btnText.textContent = 'Subscribe';
        loading.classList.add('hidden');
    }
});
</script>
@endpush
@endsection
