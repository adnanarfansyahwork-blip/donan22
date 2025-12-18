@extends('admin.layouts.app')

@section('title', 'Settings')

@section('content')
<!-- Header with Save Button -->
<div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 sticky top-0 bg-gray-100 py-4 px-4 -mx-4 z-50 shadow-sm">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
        <p class="text-gray-700 text-sm mt-1">Configure your website settings</p>
    </div>
    <button type="submit" form="settingsForm" class="px-4 py-2 sm:px-6 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-sm whitespace-nowrap">
        <i class="bi bi-check-circle mr-1"></i> Save Settings
    </button>
</div>

<form id="settingsForm" action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- General Settings -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">General Settings</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Donan22' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site Description</label>
                        <textarea name="site_description" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">{{ $settings['site_description'] ?? '' }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Site URL</label>
                        <input type="url" name="site_url" value="{{ $settings['site_url'] ?? config('app.url') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Admin Email</label>
                            <input type="email" name="admin_email" value="{{ $settings['admin_email'] ?? '' }}"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Posts Per Page</label>
                            <input type="number" name="posts_per_page" value="{{ $settings['posts_per_page'] ?? 12 }}" min="1"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- SEO Settings -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">SEO Settings</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Meta Title</label>
                        <input type="text" name="default_meta_title" value="{{ $settings['default_meta_title'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Meta Description</label>
                        <textarea name="default_meta_description" rows="2"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">{{ $settings['default_meta_description'] ?? '' }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Default Meta Keywords</label>
                        <input type="text" name="default_meta_keywords" value="{{ $settings['default_meta_keywords'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                               placeholder="keyword1, keyword2, keyword3">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Google Analytics ID</label>
                        <input type="text" name="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500"
                               placeholder="G-XXXXXXXXXX">
                    </div>
                </div>
            </div>
            
            <!-- Social Media -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Social Media</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-facebook text-blue-600"></i> Facebook
                        </label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-twitter-x"></i> X / Twitter
                        </label>
                        <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-instagram text-pink-600"></i> Instagram
                        </label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-youtube text-red-600"></i> YouTube
                        </label>
                        <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-telegram text-blue-500"></i> Telegram
                        </label>
                        <input type="url" name="social_telegram" value="{{ $settings['social_telegram'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="bi bi-github"></i> GitHub
                        </label>
                        <input type="url" name="social_github" value="{{ $settings['social_github'] ?? '' }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500">
                    </div>
                </div>
            </div>
            
            <!-- Comments Settings -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Comments Settings</h3>
                <div class="space-y-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="comments_enabled" value="1" {{ ($settings['comments_enabled'] ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Enable comments on new posts</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" name="comments_moderation" value="1" {{ ($settings['comments_moderation'] ?? true) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Comments must be manually approved</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="checkbox" name="comments_require_login" value="1" {{ ($settings['comments_require_login'] ?? false) ? 'checked' : '' }}
                               class="w-4 h-4 text-primary-600 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-700">Users must be logged in to comment</span>
                    </label>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Save Button -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <button type="submit" class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium">
                    <i class="bi bi-check-lg mr-1"></i> Save Settings
                </button>
            </div>
            
            <!-- Logo -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Site Logo</label>
                @if(!empty($settings['site_logo']))
                    <img src="{{ $settings['site_logo'] }}" class="w-32 h-auto mb-3">
                @endif
                <input type="file" name="site_logo" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700">
            </div>
            
            <!-- Favicon -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                @if(!empty($settings['site_favicon']))
                    <img src="{{ $settings['site_favicon'] }}" class="w-8 h-8 mb-3">
                @endif
                <input type="file" name="site_favicon" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700">
            </div>
            
            <!-- Maintenance -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Maintenance Mode</h3>
                <label class="flex items-center">
                    <input type="checkbox" name="maintenance_mode" value="1" {{ ($settings['maintenance_mode'] ?? false) ? 'checked' : '' }}
                           class="w-4 h-4 text-red-600 border-gray-300 rounded">
                    <span class="ml-2 text-sm text-gray-700">Enable maintenance mode</span>
                </label>
                <p class="text-xs text-gray-500 mt-2">When enabled, only admins can access the site.</p>
            </div>
            
            <!-- Cache -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Cache</h3>
                <a href="#" onclick="alert('Cache cleared manually via terminal')" 
                   class="w-full block text-center py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg text-sm"
                   onclick="return confirm('Clear all caches?')">
                    <i class="bi bi-arrow-clockwise mr-1"></i> Clear Cache
                </a>
            </div>
        </div>
    </div>
</form>
@endsection

