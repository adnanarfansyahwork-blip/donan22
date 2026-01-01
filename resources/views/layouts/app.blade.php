<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Donan22'))</title>
    <meta name="description" content="@yield('meta_description', 'Download software, mobile apps, and IT tutorials')">
    <meta name="keywords" content="@yield('meta_keywords', 'software, download, apps, tutorials, IT')">
    <meta name="author" content="Donan22">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    
    <!-- Google Site Verification -->
    <meta name="google-site-verification" content="57FjeBMKdUbN9FCNyR8ChLgsWir5KB4IWo21JzdPLPw">
    
    <!-- Canonical URL -->
    <link rel="canonical" href="@yield('canonical', url()->current())">
    
    <!-- Pagination SEO Links -->
    @stack('seo_pagination')
    
    <!-- Open Graph -->
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Download software, mobile apps, and IT tutorials')">
    <meta property="og:image" content="@yield('og_image', asset('assets/images/og-default.png'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="id_ID">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('twitter_description', 'Download software, mobile apps, and IT tutorials')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('assets/images/og-default.png'))">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/apple-touch-icon.png') }}">
    
    <!-- Web Manifest for PWA -->
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#3b82f6">
    
    <!-- Fonts - Optimized -->
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preload" href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap"></noscript>
    
    <!-- Icons - Deferred -->
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"></noscript>
    
    <!-- Styles - Optimized -->
    @if (file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <link rel="stylesheet" href="/build/assets/app-Dh07Ywdd.css">
        <script src="/build/assets/app-CAiCLEjY.js" defer></script>
    @endif
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Remove underline from all links */
        a {
            text-decoration: none !important;
        }
        
        a:hover {
            text-decoration: none !important;
        }
        
        /* Keep underline for content/prose links only */
        .prose a:hover,
        .content a:hover {
            text-decoration: underline !important;
        }
    </style>
    
    @stack('styles')
    
    <!-- Schema Markup (JSON-LD) for SEO -->
    @stack('schema')
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-900 min-h-screen flex flex-col">
    <!-- Navigation -->
    @include('layouts.partials.navigation')
    
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative max-w-7xl mx-auto mt-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    
    <!-- Main Content -->
    <main class="flex-1">
        @yield('content')
    </main>
    
    <!-- Footer -->
    @include('layouts.partials.footer')
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('scripts')
</body>
</html>
