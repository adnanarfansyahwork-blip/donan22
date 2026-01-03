@extends('layouts.app')

@section('title', 'Download Aplikasi Android & iOS Gratis Terbaru ' . date('Y') . ' - Donan22')
@section('meta_description', 'Download aplikasi mobile gratis untuk Android dan iOS. APK MOD, aplikasi premium, games, dan tools terbaru ' . date('Y') . ' dengan fitur lengkap.')
@section('meta_keywords', 'download APK gratis, aplikasi android, aplikasi iOS, APK MOD, download aplikasi premium gratis, games android')
@section('canonical', route('mobile-apps.index'))
@section('robots', request()->has('page') || request()->has('platform') ? 'noindex, follow' : 'index, follow')

@section('content')
<div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">
            <i class="bi bi-phone mr-2"></i> Mobile Apps
        </h1>
        <p class="text-green-100">Download apps for your Android and iOS devices.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Platform Filter -->
    <div class="flex gap-4 mb-8">
        <a href="{{ route('mobile-apps.index') }}" 
           class="px-4 py-2 rounded-lg font-medium {{ !request('platform') ? 'bg-primary-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50' }}">
            All
        </a>
        <a href="{{ route('mobile-apps.index', ['platform' => 'android']) }}" 
           class="px-4 py-2 rounded-lg font-medium {{ request('platform') == 'android' ? 'bg-green-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50' }}">
            <i class="bi bi-android2 mr-1"></i> Android
        </a>
        <a href="{{ route('mobile-apps.index', ['platform' => 'ios']) }}" 
           class="px-4 py-2 rounded-lg font-medium {{ request('platform') == 'ios' ? 'bg-gray-900 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50' }}">
            <i class="bi bi-apple mr-1"></i> iOS
        </a>
    </div>
    
    @if($posts->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($posts as $post)
                @include('components.software-card', ['post' => $post])
            @endforeach
        </div>
        
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <i class="bi bi-phone text-6xl text-gray-300"></i>
            <h3 class="text-xl font-medium text-gray-600 mt-4">No apps found</h3>
            <p class="text-gray-500 mt-2">Try adjusting your filters or check back later.</p>
        </div>
    @endif
</div>
@endsection
