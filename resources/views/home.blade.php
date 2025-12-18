@extends('layouts.app')

@section('title', 'Donan22 - IT & Software Learning Hub')
@section('meta_description', 'Download software PC, mobile apps Android & iOS, and learn IT tutorials. Your trusted source for technology.')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl lg:text-5xl font-extrabold mb-6">
                IT & Software Learning Hub
            </h1>
            <p class="text-xl text-primary-100 mb-8">
                Download software, mobile apps, and learn IT tutorials.
                Your trusted source for the latest technology.
            </p>

            <!-- Quick Stats -->
            <div class="flex flex-wrap justify-center gap-8 mt-8">
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ \App\Models\Post::where('post_type', 'software')->count() }}+</div>
                    <div class="text-primary-200 text-sm">Software</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ \App\Models\Post::where('post_type', 'mobile-app')->count() }}+</div>
                    <div class="text-primary-200 text-sm">Mobile Apps</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">{{ \App\Models\Post::where('post_type', 'tutorial')->count() }}+</div>
                    <div class="text-primary-200 text-sm">Tutorials</div>
                </div>
            </div>
        </div>
    </div>
</section>

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

<!-- Latest Posts -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-clock text-gray-600 mr-2"></i> Latest Updates
            </h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestPosts as $post)
                @include('components.post-card', ['post' => $post])
            @endforeach
        </div>
    </div>
</section>

<!-- Categories -->
@if($categories->count())
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-grid text-primary-600 mr-2"></i> Browse Categories
            </h2>
            <a href="{{ route('categories.index') }}" class="text-primary-600 hover:text-primary-700 font-medium">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @foreach($categories->take(12) as $category)
                <a href="{{ route('categories.show', $category->slug) }}"
                   class="bg-white rounded-xl p-4 text-center hover:shadow-lg transition-shadow border border-gray-200 group">
                    @if($category->icon)
                        <i class="bi {{ $category->icon }} text-3xl text-primary-600 mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                    @else
                        <i class="bi bi-folder text-3xl text-primary-600 mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                    @endif
                    <h3 class="font-medium text-gray-900 text-sm">{{ $category->name }}</h3>
                    <span class="text-xs text-gray-500">{{ $category->posts_count }} posts</span>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-primary-600 to-primary-800 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
        <p class="text-primary-100 mb-8">Get notified about new software releases, tutorials, and updates.</p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
            <input type="email" placeholder="Enter your email"
                   class="flex-1 px-6 py-3 rounded-lg text-gray-900 focus:ring-4 focus:ring-primary-300">
            <button type="submit" class="px-8 py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                Subscribe
            </button>
        </form>
    </div>
</section>
@endsection
