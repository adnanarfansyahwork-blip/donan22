<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostTypeController extends Controller
{
    public function index(): View
    {
        $postTypes = PostType::withCount('posts')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.post-types.index', compact('postTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_types,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        PostType::create($validated);

        return redirect()->route('admin.post-types.index')
            ->with('success', 'Post type created successfully.');
    }

    public function update(Request $request, PostType $postType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:post_types,name,' . $postType->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $postType->update($validated);

        return redirect()->route('admin.post-types.index')
            ->with('success', 'Post type updated successfully.');
    }

    public function destroy(PostType $postType): RedirectResponse
    {
        if ($postType->posts()->exists()) {
            return back()->with('error', 'Cannot delete post type with associated posts.');
        }

        $postType->delete();

        return redirect()->route('admin.post-types.index')
            ->with('success', 'Post type deleted successfully.');
    }
}
