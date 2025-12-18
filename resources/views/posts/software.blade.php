@extends('layouts.app')

@section('title', 'Software Downloads - Donan22')
@section('meta_description', 'Download free and premium software for Windows, macOS, and Linux.')

@section('content')
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">
            <i class="bi bi-box-seam mr-2"></i> Software Downloads
        </h1>
        <p class="text-primary-100">Download free and premium software for your computer.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <aside class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                <h3 class="font-bold text-gray-900 mb-4">Categories</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('software.index') }}" 
                           class="block px-3 py-2 rounded-lg {{ !request('category') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                            All Software
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('software.index', ['category' => $category->slug]) }}" 
                               class="flex justify-between items-center px-3 py-2 rounded-lg {{ request('category') == $category->slug ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <span>{{ $category->name }}</span>
                                <span class="text-xs text-gray-400">{{ $category->posts_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                
                <div class="mt-6 pt-6 border-t">
                    <h3 class="font-bold text-gray-900 mb-4">Sort By</h3>
                    <div class="space-y-2">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" 
                           class="block px-3 py-2 rounded-lg {{ request('sort', 'latest') == 'latest' ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                            <i class="bi bi-clock mr-2"></i> Latest
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" 
                           class="block px-3 py-2 rounded-lg {{ request('sort') == 'popular' ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                            <i class="bi bi-fire mr-2"></i> Most Popular
                        </a>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Posts Grid -->
        <main class="lg:col-span-3">
            @if($posts->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($posts as $post)
                        @include('components.software-card', ['post' => $post])
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <i class="bi bi-inbox text-6xl text-gray-300"></i>
                    <h3 class="text-xl font-medium text-gray-600 mt-4">No software found</h3>
                    <p class="text-gray-500 mt-2">Try adjusting your filters or check back later.</p>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
