@extends('layouts.app')

@section('title', $category->meta_title ?? $category->name . ' - Donan22')
@section('meta_description', $category->meta_description ?? $category->description ?? 'Browse ' . $category->name . ' - Download software, apps and tutorials.')
@section('canonical', route('categories.show', $category->slug))
@section('robots', request()->has('page') ? 'noindex, follow' : 'index, follow')

@section('content')
<div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-gray-400 mb-4">
            <a href="{{ route('home') }}" class="hover:text-white">Home</a>
            <i class="bi bi-chevron-right text-xs"></i>
            <a href="{{ route('categories.index') }}" class="hover:text-white">Categories</a>
            @if($category->parent)
                <i class="bi bi-chevron-right text-xs"></i>
                <a href="{{ route('categories.show', $category->parent->slug) }}" class="hover:text-white">{{ $category->parent->name }}</a>
            @endif
            <i class="bi bi-chevron-right text-xs"></i>
            <span class="text-white">{{ $category->name }}</span>
        </nav>
        
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 flex items-center justify-center bg-white/10 rounded-xl">
                <i class="bi {{ $category->icon ?? 'bi-folder' }} text-3xl"></i>
            </div>
            <div>
                <h1 class="text-3xl font-bold">{{ $category->name }}</h1>
                @if($category->description)
                    <p class="text-gray-300 mt-1">{{ $category->description }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Subcategories -->
    @if($category->children->count())
        <div class="mb-8">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Subcategories</h2>
            <div class="flex flex-wrap gap-3">
                @foreach($category->children as $child)
                    <a href="{{ route('categories.show', $child->slug) }}" 
                       class="px-4 py-2 bg-white border border-gray-200 rounded-lg hover:border-primary-300 hover:bg-primary-50 transition-colors">
                        {{ $child->name }}
                    </a>
                @endforeach
            </div>
        </div>
    @endif
    
    <!-- Posts -->
    @if($posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($posts as $post)
                @include('components.post-card', ['post' => $post])
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <i class="bi bi-folder text-6xl text-gray-300"></i>
            <h3 class="text-xl font-medium text-gray-600 mt-4">No posts in this category</h3>
            <p class="text-gray-500 mt-2">Check back later for new content.</p>
        </div>
    @endif
    
    <!-- Sibling Categories -->
    @if($siblingCategories->count())
        <div class="mt-12 pt-8 border-t">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Related Categories</h2>
            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach($siblingCategories as $sibling)
                    <a href="{{ route('categories.show', $sibling->slug) }}" 
                       class="bg-white rounded-lg p-4 text-center hover:shadow-md transition-shadow border border-gray-200">
                        <i class="bi {{ $sibling->icon ?? 'bi-folder' }} text-2xl text-primary-600 mb-2"></i>
                        <h3 class="font-medium text-gray-900 text-sm">{{ $sibling->name }}</h3>
                        <span class="text-xs text-gray-500">{{ $sibling->posts_count }} posts</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
