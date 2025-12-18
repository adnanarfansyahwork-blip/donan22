<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\ImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request, ImageService $imageService): RedirectResponse
    {
        $data = $request->except(['_token', '_method', 'site_logo', 'site_favicon']);
        
        // Handle checkboxes
        $checkboxes = ['comments_enabled', 'comments_moderation', 'comments_require_login', 'maintenance_mode'];
        foreach ($checkboxes as $checkbox) {
            $data[$checkbox] = $request->has($checkbox) ? '1' : '0';
        }
        
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value ?? '', 'group' => $this->getGroup($key)]
            );
        }
        
        // Handle logo upload
        if ($request->hasFile('site_logo')) {
            $path = $imageService->upload($request->file('site_logo'), 'settings', 400);
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => '/storage/' . $path, 'group' => 'general']);
        }
        
        // Handle favicon upload
        if ($request->hasFile('site_favicon')) {
            $path = $imageService->upload($request->file('site_favicon'), 'settings', 64);
            Setting::updateOrCreate(['key' => 'site_favicon'], ['value' => '/storage/' . $path, 'group' => 'general']);
        }
        
        // Clear settings cache
        Cache::forget('site_settings');

        return back()->with('success', 'Settings updated successfully.');
    }

    public function clearCache(): RedirectResponse
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        
        return back()->with('success', 'All caches cleared successfully.');
    }
    
    private function getGroup(string $key): string
    {
        if (str_starts_with($key, 'social_')) return 'social';
        if (str_starts_with($key, 'default_meta') || $key === 'google_analytics_id') return 'seo';
        if (str_starts_with($key, 'comments_')) return 'comments';
        if ($key === 'maintenance_mode') return 'system';
        return 'general';
    }
}
