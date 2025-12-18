@extends('layouts.app')

@section('title', 'Tutorials - Donan22')
@section('meta_description', 'Learn IT and programming with our comprehensive tutorials.')

@section('content')
<div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">
            <i class="bi bi-book mr-2"></i> Tutorials
        </h1>
        <p class="text-purple-100">Learn IT and programming with our comprehensive tutorials.</p>
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
                        <a href="{{ route('tutorials.index') }}" 
                           class="block px-3 py-2 rounded-lg {{ !request('category') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                            All Tutorials
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('tutorials.index', ['category' => $category->slug]) }}" 
                               class="flex justify-between items-center px-3 py-2 rounded-lg {{ request('category') == $category->slug ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                                <span>{{ $category->name }}</span>
                                <span class="text-xs text-gray-400">{{ $category->posts_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>
        
        <!-- Posts Grid -->
        <main class="lg:col-span-3">
            @if($posts->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($posts as $post)
                        @include('components.post-card', ['post' => $post])
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <i class="bi bi-book text-6xl text-gray-300"></i>
                    <h3 class="text-xl font-medium text-gray-600 mt-4">No tutorials found</h3>
                    <p class="text-gray-500 mt-2">Try adjusting your filters or check back later.</p>
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
