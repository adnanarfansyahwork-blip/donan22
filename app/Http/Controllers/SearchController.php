<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = $request->input('q', '');
        $posts = collect();

        if (strlen($query) >= 2) {
            $posts = Post::published()
                ->search($query)
                ->with(['category', 'postType', 'user', 'softwareDetail'])
                ->when($request->type, function($q, $type) {
                    $q->whereHas('postType', fn($pt) => $pt->where('slug', $type));
                })
                ->when($request->category, function($q, $cat) {
                    $q->whereHas('category', fn($c) => $c->where('slug', $cat));
                })
                ->paginate(12)
                ->withQueryString();

            // Log search (disabled - SearchLog model not implemented yet)
            // \App\Models\SearchLog::create([
            //     'query' => $query,
            //     'results_count' => $posts->total(),
            //     'ip_address' => $request->ip(),
            //     'user_id' => Auth::id(),
            // ]);
        }

        return view('search.index', compact('query', 'posts'));
    }

    public function live(Request $request): JsonResponse
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        $posts = Post::published()
            ->search($query)
            ->with(['category', 'postType'])
            ->select('id', 'title', 'slug', 'featured_image', 'category_id', 'post_type_id')
            ->limit(8)
            ->get()
            ->map(fn($post) => [
                'id' => $post->id,
                'title' => $post->title,
                'url' => $post->url,
                'image' => $post->featured_image_url,
                'category' => $post->category?->name,
                'type' => $post->postType?->name,
            ]);

        return response()->json(['results' => $posts]);
    }
}
