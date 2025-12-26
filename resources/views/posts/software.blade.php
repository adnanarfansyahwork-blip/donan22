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
    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Posts List (Left Side - 65%) --}}
        <main class="lg:w-[65%]">
            @if($posts->count())
                {{-- Filter/Sort Bar --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 text-sm">Showing</span>
                            <span class="font-semibold text-gray-900">{{ $posts->total() }}</span>
                            <span class="text-gray-500 text-sm">software</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 text-sm">Sort:</span>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'latest']) }}" 
                               class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ request('sort', 'latest') == 'latest' ? 'bg-emerald-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                <i class="bi bi-clock mr-1"></i> Latest
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'popular']) }}" 
                               class="px-3 py-1.5 rounded-lg text-sm font-medium transition-colors {{ request('sort') == 'popular' ? 'bg-emerald-500 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                                <i class="bi bi-fire mr-1"></i> Popular
                            </a>
                        </div>
                    </div>
                </div>
                
                {{-- Posts List --}}
                <div class="space-y-4">
                    @foreach($posts as $post)
                        @include('components.post-card-horizontal', ['post' => $post])
                    @endforeach
                </div>
                
                <div class="mt-8">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <i class="bi bi-inbox text-6xl text-gray-300"></i>
                    <h3 class="text-xl font-medium text-gray-600 mt-4">No software found</h3>
                    <p class="text-gray-500 mt-2">Try adjusting your filters or check back later.</p>
                </div>
            @endif
        </main>
        
        {{-- Sidebar (Right Side - 35%) --}}
        <aside class="lg:w-[35%]">
            <div class="sticky top-24 space-y-6">
                {{-- Category Sidebar --}}
                @include('components.category-sidebar', [
                    'categories' => $categories, 
                    'title' => 'Kategori Software',
                    'showViewAll' => true
                ])
                
                {{-- Active Category Indicator --}}
                @if(request('category'))
                    <div class="bg-emerald-50 rounded-xl p-4 border border-emerald-100">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-emerald-700 font-medium">
                                <i class="bi bi-funnel mr-1"></i> Filter aktif: {{ request('category') }}
                            </span>
                            <a href="{{ route('software.index') }}" 
                               class="text-xs text-emerald-600 hover:text-emerald-800">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                        </div>
                    </div>
                @endif
                
                {{-- Quick Links --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 px-5 py-3">
                        <h3 class="text-white font-bold text-center">
                            <i class="bi bi-link-45deg mr-2"></i>Quick Links
                        </h3>
                    </div>
                    <div class="p-4 space-y-2">
                        <a href="{{ route('software.index', ['sort' => 'latest']) }}" 
                           class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 flex items-center justify-center bg-green-100 text-green-600 rounded-lg text-sm">
                                <i class="bi bi-clock"></i>
                            </span>
                            <span class="text-sm font-medium text-gray-700">Software Terbaru</span>
                        </a>
                        <a href="{{ route('software.index', ['sort' => 'popular']) }}" 
                           class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 flex items-center justify-center bg-orange-100 text-orange-600 rounded-lg text-sm">
                                <i class="bi bi-fire"></i>
                            </span>
                            <span class="text-sm font-medium text-gray-700">Paling Populer</span>
                        </a>
                        <a href="{{ route('tutorials.index') }}" 
                           class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 flex items-center justify-center bg-purple-100 text-purple-600 rounded-lg text-sm">
                                <i class="bi bi-book"></i>
                            </span>
                            <span class="text-sm font-medium text-gray-700">Tutorial & Guide</span>
                        </a>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
