@extends('layouts.app')

@section('title', 'Categories - Donan22')

@section('content')
<div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">
            <i class="bi bi-grid mr-2"></i> All Categories
        </h1>
        <p class="text-gray-300">Browse all categories to find what you're looking for.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" 
               class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow group">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 flex items-center justify-center bg-primary-100 rounded-xl group-hover:bg-primary-200 transition-colors">
                        <i class="bi {{ $category->icon ?? 'bi-folder' }} text-2xl text-primary-600"></i>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
                            {{ $category->name }}
                        </h2>
                        @if($category->description)
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ $category->description }}</p>
                        @endif
                        <div class="text-sm text-gray-400 mt-2">{{ $category->posts_count }} posts</div>
                    </div>
                </div>
                
                @if($category->children->count())
                    <div class="mt-4 pt-4 border-t">
                        <div class="flex flex-wrap gap-2">
                            @foreach($category->children->take(5) as $child)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $child->name }}</span>
                            @endforeach
                            @if($category->children->count() > 5)
                                <span class="text-xs text-gray-500">+{{ $category->children->count() - 5 }} more</span>
                            @endif
                        </div>
                    </div>
                @endif
            </a>
        @endforeach
    </div>
</div>
@endsection
