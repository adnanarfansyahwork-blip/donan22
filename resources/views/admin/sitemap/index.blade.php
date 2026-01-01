@extends('admin.layouts.app')

@section('title', 'Sitemap & SEO')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Sitemap & SEO</h1>
    <p class="text-gray-500">Monitor and manage your sitemaps and robots.txt</p>
</div>

<!-- Quick Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Published Posts</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_posts'] }}</p>
            </div>
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-file-earmark-text text-blue-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Active Categories</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-folder text-green-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Sitemap URLs</p>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['sitemap_urls'] }}</p>
            </div>
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-link-45deg text-purple-600"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-xl shadow-sm p-4 border border-gray-200">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Sitemap Files</p>
                <p class="text-2xl font-bold text-green-600">{{ $stats['sitemap_files'] }} / 4</p>
            </div>
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                <i class="bi bi-check-circle text-green-600"></i>
            </div>
        </div>
    </div>
</div>

<!-- Generate Button -->
<div class="mb-6 bg-white rounded-xl shadow-sm border border-gray-200 p-4">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-semibold text-gray-900">Sitemap Generation</h2>
            <p class="text-sm text-gray-500">Auto-generates on post create/update/delete. Manual regenerate below.</p>
        </div>
        <form action="{{ route('admin.sitemap.generate') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium">
                <i class="bi bi-arrow-clockwise mr-1"></i> Regenerate All Sitemaps
            </button>
        </form>
    </div>
</div>

<!-- Sitemap Files Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    @foreach($sitemaps as $filename => $sitemap)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 border-b border-gray-200 {{ $sitemap['exists'] ? 'bg-green-50' : 'bg-red-50' }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    @if($sitemap['exists'])
                        <i class="bi bi-check-circle-fill text-green-600 mr-2"></i>
                    @else
                        <i class="bi bi-x-circle-fill text-red-600 mr-2"></i>
                    @endif
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $sitemap['name'] }}</h3>
                        <p class="text-xs text-gray-500">{{ $sitemap['filename'] }}</p>
                    </div>
                </div>
                @if($sitemap['exists'])
                    <a href="{{ $sitemap['public_url'] }}" target="_blank" class="text-primary-600 hover:text-primary-700 text-sm">
                        <i class="bi bi-box-arrow-up-right"></i> View
                    </a>
                @endif
            </div>
        </div>
        
        <div class="p-4">
            <p class="text-sm text-gray-500 mb-3">{{ $sitemap['description'] }}</p>
            
            @if($sitemap['exists'])
                <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                    <div>
                        <span class="text-gray-500">URLs:</span>
                        <span class="font-medium ml-1">{{ $sitemap['url_count'] }}</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Size:</span>
                        <span class="font-medium ml-1">{{ number_format($sitemap['info']['size'] / 1024, 2) }} KB</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-500">Modified:</span>
                        <span class="font-medium ml-1">{{ date('d M Y, H:i:s', $sitemap['info']['modified']) }}</span>
                    </div>
                </div>
                
                <!-- URLs Preview (collapsible) -->
                <details class="group">
                    <summary class="cursor-pointer text-sm text-primary-600 hover:text-primary-700 flex items-center">
                        <i class="bi bi-chevron-right group-open:rotate-90 transition-transform mr-1"></i>
                        Show URLs ({{ $sitemap['url_count'] }})
                    </summary>
                    <div class="mt-2 bg-gray-50 rounded-lg p-3 max-h-64 overflow-y-auto">
                        <ul class="space-y-1.5 text-xs">
                            @foreach($sitemap['urls'] as $url)
                                <li class="flex items-start">
                                    @if(isset($url['type']) && $url['type'] === 'sitemap')
                                        <i class="bi bi-file-earmark-code text-purple-500 mt-0.5 mr-1.5 flex-shrink-0"></i>
                                    @else
                                        <i class="bi bi-link text-gray-400 mt-0.5 mr-1.5 flex-shrink-0"></i>
                                    @endif
                                    <a href="{{ $url['loc'] }}" target="_blank" class="text-primary-600 hover:underline break-all">
                                        {{ $url['loc'] }}
                                    </a>
                                    @if(isset($url['priority']) && $url['priority'])
                                        <span class="ml-1 text-[10px] bg-gray-200 px-1.5 py-0.5 rounded flex-shrink-0">{{ $url['priority'] }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </details>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-file-earmark-x text-2xl text-gray-300 mb-2"></i>
                    <p class="text-sm text-gray-500">File not found. Click regenerate above.</p>
                </div>
            @endif
        </div>
    </div>
    @endforeach
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Robots.txt -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                <i class="bi bi-robot text-primary-600 mr-2"></i>Robots.txt
            </h2>
        </div>
        
        <div class="p-6">
            @if($robotsExists)
                <form action="{{ route('admin.sitemap.robots') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Edit robots.txt</label>
                        <textarea name="content" rows="12" class="w-full font-mono text-sm border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-primary-500 focus:border-primary-500">{{ $robotsContent }}</textarea>
                    </div>
                    <div class="flex justify-between items-center">
                        <a href="{{ url('robots.txt') }}" target="_blank" class="text-sm text-primary-600 hover:text-primary-700">
                            <i class="bi bi-box-arrow-up-right mr-1"></i> View public file
                        </a>
                        <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg text-sm font-medium">
                            <i class="bi bi-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center py-8">
                    <i class="bi bi-robot text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">robots.txt not found.</p>
                </div>
            @endif
        </div>
    </div>
    
    <!-- SEO Tools -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                <i class="bi bi-tools text-primary-600 mr-2"></i>SEO Tools
            </h2>
        </div>
        
        <div class="p-6">
            <div class="space-y-3">
                <a href="https://search.google.com/search-console" target="_blank" 
                   class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors">
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="bi bi-google text-red-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900 text-sm">Google Search Console</h3>
                        <p class="text-xs text-gray-500">Monitor search performance</p>
                    </div>
                    <i class="bi bi-arrow-right text-gray-400"></i>
                </a>
                
                <a href="https://www.bing.com/webmasters" target="_blank" 
                   class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="bi bi-microsoft text-blue-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900 text-sm">Bing Webmaster</h3>
                        <p class="text-xs text-gray-500">Bing search tools</p>
                    </div>
                    <i class="bi bi-arrow-right text-gray-400"></i>
                </a>
                
                <a href="https://pagespeed.web.dev/analysis?url={{ urlencode(config('app.url')) }}" target="_blank" 
                   class="flex items-center p-3 border border-gray-200 rounded-lg hover:border-primary-500 hover:bg-primary-50 transition-colors">
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <i class="bi bi-speedometer2 text-green-600 text-sm"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900 text-sm">PageSpeed Insights</h3>
                        <p class="text-xs text-gray-500">Check site performance</p>
                    </div>
                    <i class="bi bi-arrow-right text-gray-400"></i>
                </a>
            </div>
            
            <!-- Quick Links -->
            <div class="mt-6 pt-4 border-t border-gray-200">
                <h3 class="font-medium text-gray-900 mb-3 text-sm">Quick Submit</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="https://www.google.com/ping?sitemap={{ urlencode(url('sitemap.xml')) }}" target="_blank"
                       class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-lg text-xs">
                        <i class="bi bi-send mr-1.5"></i> Ping Google
                    </a>
                    <a href="https://www.bing.com/ping?sitemap={{ urlencode(url('sitemap.xml')) }}" target="_blank"
                       class="inline-flex items-center px-3 py-1.5 bg-gray-100 hover:bg-gray-200 rounded-lg text-xs">
                        <i class="bi bi-send mr-1.5"></i> Ping Bing
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
