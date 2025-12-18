<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::active()
            ->parents()
            ->with(['children' => fn($q) => $q->active()])
            ->withCount(['posts' => fn($q) => $q->published()])
            ->ordered()
            ->get();

        return view('categories.index', compact('categories'));
    }

    public function show(Request $request, string $slug): View
    {
        $category = Category::where('slug', $slug)
            ->active()
            ->with(['parent', 'children' => fn($q) => $q->active()])
            ->firstOrFail();

        // Get all category IDs (including children)
        $categoryIds = $category->getAllChildren()->pluck('id');

        $posts = Post::published()
            ->whereIn('category_id', $categoryIds)
            ->with(['category', 'postType', 'user', 'softwareDetail'])
            ->when($request->type, function($q, $type) {
                $q->whereHas('postType', fn($pt) => $pt->where('slug', $type));
            })
            ->when($request->sort === 'popular', fn($q) => $q->popular(), fn($q) => $q->recent())
            ->paginate(12);

        // Sibling categories for navigation
        $siblingCategories = Category::active()
            ->where('parent_id', $category->parent_id)
            ->where('id', '!=', $category->id)
            ->withCount(['posts' => fn($q) => $q->published()])
            ->ordered()
            ->limit(10)
            ->get();

        return view('categories.show', compact('category', 'posts', 'siblingCategories'));
    }
}
