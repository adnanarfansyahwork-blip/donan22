<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\MonetizedLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class DownloadController extends Controller
{
    /**
     * Redirect to download URL (replacement for go.php)
     */
    public function redirect($id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        // Increment download count
        $post->increment('downloads');

        // Check for monetized link
        $monetizedLink = MonetizedLink::where('post_id', $post->id)
            ->where('is_active', true)
            ->first();

        if ($monetizedLink) {
            return redirect($monetizedLink->monetized_url);
        }

        // Redirect to original download URL
        if ($post->download_link) {
            return redirect($post->download_link);
        }

        return redirect()->back()->with('error', 'Download link not available.');
    }

    /**
     * Track download via slug
     */
    public function track($slug): RedirectResponse
    {
        $post = Post::where('slug', $slug)->firstOrFail();

        // Increment download count
        $post->increment('downloads');

        // Check for monetized link
        $monetizedLink = MonetizedLink::where('post_id', $post->id)
            ->where('is_active', true)
            ->first();

        if ($monetizedLink) {
            return redirect($monetizedLink->monetized_url);
        }

        // Redirect to original download URL
        if ($post->download_link) {
            return redirect($post->download_link);
        }

        return redirect()->back()->with('error', 'Download link not available.');
    }
}
