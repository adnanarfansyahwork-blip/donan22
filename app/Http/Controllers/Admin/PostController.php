<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\PostType;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     */
    public function index(Request $request): View
    {
        $query = Post::with(['user', 'category', 'postType'])
            ->latest();

        // Filter by search
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->status($request->status);
        }

        // Filter by post type
        if ($request->filled('type')) {
            $query->ofType($request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->inCategory($request->category);
        }

        $posts = $query->paginate(20)->withQueryString();
        $postTypes = PostType::active()->orderBy('name')->get();
        $categories = Category::active()->ordered()->get();

        return view('admin.posts.index', compact('posts', 'postTypes', 'categories'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create(): View
    {
        $categories = Category::active()->ordered()->get();
        $postTypes = PostType::active()->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.posts.create', compact('categories', 'postTypes', 'tags'));
    }

    /**
     * Store a newly created post in storage.
     */
    public function store(PostRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Prepare post data
            $data = $request->validatedWithDefaults();
            $data['user_id'] = Auth::id();

            // Handle featured image upload
            if ($request->hasFile('featured_image')) {
                $data['featured_image'] = $this->uploadFeaturedImage($request->file('featured_image'));
            }

            // Remove non-post fields before creating
            $postData = collect($data)->except(['tags', 'software', 'download_links', 'remove_featured_image'])->toArray();
            
            // Create the post
            $post = Post::create($postData);

            // Sync tags
            if (!empty($data['tags'])) {
                $post->syncTags($data['tags']);
            }

            // Save software details
            if (!empty($data['software'])) {
                $post->saveSoftwareDetail($data['software']);
            }

            // Sync download links
            if (!empty($data['download_links'])) {
                $post->syncDownloadLinks($data['download_links']);
            }

            DB::commit();

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Post berhasil dibuat.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create post: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal membuat post. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for editing the specified post.
     */
    public function edit(Post $post): View
    {
        // Load relations
        $post->load(['softwareDetail', 'downloadLinks', 'tags']);

        $categories = Category::active()->ordered()->get();
        $postTypes = PostType::active()->orderBy('name')->get();
        $tags = Tag::orderBy('name')->get();

        return view('admin.posts.edit', compact('post', 'categories', 'postTypes', 'tags'));
    }

    /**
     * Update the specified post in storage.
     */
    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        try {
            DB::beginTransaction();

            // Prepare post data
            $data = $request->validatedWithDefaults();

            // Handle featured image
            if ($request->hasFile('featured_image')) {
                // Delete old image
                $this->deleteFeaturedImage($post->featured_image);
                $data['featured_image'] = $this->uploadFeaturedImage($request->file('featured_image'));
            } elseif ($request->boolean('remove_featured_image')) {
                $this->deleteFeaturedImage($post->featured_image);
                $data['featured_image'] = null;
            } else {
                // Don't update featured_image if no new file uploaded
                unset($data['featured_image']);
            }

            // Remove non-post fields before updating
            $postData = collect($data)->except(['tags', 'software', 'download_links', 'remove_featured_image'])->toArray();

            // Update the post
            $post->update($postData);

            // Sync tags
            $post->syncTags($data['tags'] ?? []);

            // Save software details
            if (!empty($data['software'])) {
                $post->saveSoftwareDetail($data['software']);
            }

            // Sync download links
            if (isset($data['download_links'])) {
                $post->syncDownloadLinks($data['download_links']);
            }

            DB::commit();

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Post berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update post: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui post. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {
        try {
            // Soft delete the post
            $post->delete();

            return redirect()
                ->route('admin.posts.index')
                ->with('success', 'Post berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Failed to delete post: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus post.');
        }
    }

    /**
     * Publish the specified post.
     */
    public function publish(Post $post): RedirectResponse
    {
        try {
            $post->publish();

            return back()->with('success', 'Post berhasil dipublikasikan.');

        } catch (\Exception $e) {
            Log::error('Failed to publish post: ' . $e->getMessage());

            return back()->with('error', 'Gagal mempublikasikan post.');
        }
    }

    /**
     * Unpublish the specified post.
     */
    public function unpublish(Post $post): RedirectResponse
    {
        try {
            $post->unpublish();

            return back()->with('success', 'Post berhasil di-unpublish.');

        } catch (\Exception $e) {
            Log::error('Failed to unpublish post: ' . $e->getMessage());

            return back()->with('error', 'Gagal meng-unpublish post.');
        }
    }

    /**
     * Bulk delete posts.
     */
    public function bulkDelete(Request $request): RedirectResponse
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:posts,id',
        ]);

        try {
            Post::whereIn('id', $request->ids)->delete();

            return back()->with('success', count($request->ids) . ' post berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Failed to bulk delete posts: ' . $e->getMessage());

            return back()->with('error', 'Gagal menghapus posts.');
        }
    }

    /**
     * Upload featured image.
     */
    protected function uploadFeaturedImage($file): string
    {
        // Create directory if not exists
        $uploadPath = public_path('uploads/posts');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Generate unique filename
        $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
        
        // Save directly to public/uploads/posts
        $file->move($uploadPath, $filename);
        
        // Return just the filename (not full path)
        return $filename;
    }

    /**
     * Delete featured image.
     */
    protected function deleteFeaturedImage(?string $filename): void
    {
        if (empty($filename)) {
            return;
        }

        // Delete from public/uploads/posts
        $filePath = public_path('uploads/posts/' . basename($filename));
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
}
