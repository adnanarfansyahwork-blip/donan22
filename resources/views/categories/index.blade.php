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
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
        @foreach($categories as $category)
            <a href="{{ route('categories.show', $category->slug) }}" 
               class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-lg transition-shadow group text-center">
                {{-- Category Image --}}
                <div class="w-16 h-16 mx-auto mb-3 rounded-lg overflow-hidden bg-gray-100 flex items-center justify-center">
                    @if($category->image)
                        <img src="{{ asset('uploads/categories/' . $category->image) }}" 
                             alt="{{ $category->name }}" 
                             class="w-full h-full object-contain"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <i class="bi bi-folder text-2xl text-gray-400" style="display: none;"></i>
                    @else
                        <i class="bi bi-folder text-2xl text-gray-400"></i>
                    @endif
                </div>
                
                {{-- Category Name --}}
                <h2 class="text-sm font-bold text-gray-900 group-hover:text-emerald-600 transition-colors truncate">
                    {{ $category->name }}
                </h2>
                
                {{-- Post Count --}}
                <div class="text-xs text-gray-400 mt-1">{{ $category->posts_count }} posts</div>
            </a>
        @endforeach
    </div>
</div>
@endsection
