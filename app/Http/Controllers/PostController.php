<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\DownloadLink;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    public function show(string $slug): View
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->with([
                'category',
                'postType',
                'user',
                'softwareDetail',
                'downloadLinks' => fn($q) => $q->active()->ordered(),
                'tags',
            ])
            ->firstOrFail();

        // Increment view count
        $post->incrementViews();

        // Get comments
        $comments = $post->comments()
            ->approved()
            ->rootComments()
            ->with(['user', 'replies' => fn($q) => $q->approved()->with('user')])
            ->latest()
            ->paginate(20);

        // Related posts (for sidebar)
        $relatedPosts = $post->getRelatedPosts(4);
        
        // Previous/Next posts for navigation (SEO internal linking)
        $previousPost = $post->getPreviousPost();
        $nextPost = $post->getNextPost();
        
        // More related posts for bottom section (SEO - more internal links)
        $moreRelatedPosts = $post->getMoreRelatedPosts(6);

        return view('posts.show', compact(
            'post', 
            'comments', 
            'relatedPosts',
            'previousPost',
            'nextPost',
            'moreRelatedPosts'
        ));
    }

    public function download(Post $post, DownloadLink $link): RedirectResponse
    {
        abort_if(!$link->is_active || $link->post_id !== $post->id, 404);

        // Log download
        $link->logDownload(Auth::id());

        // Redirect to download URL
        return redirect()->away($link->download_url);
    }

    /**
     * Go download by link index (for view using array index)
     */
    public function goDownload(string $post, int $linkIndex): RedirectResponse
    {
        $postModel = Post::where('slug', $post)->firstOrFail();
        
        $links = $postModel->downloadLinks()->active()->ordered()->get();
        
        if (!isset($links[$linkIndex])) {
            abort(404, 'Download link not found.');
        }

        $link = $links[$linkIndex];
        
        // Log download
        $link->logDownload(Auth::id());

        // Redirect to download URL
        return redirect()->away($link->download_url);
    }

    public function storeComment(Request $request, Post $post): RedirectResponse
    {
        abort_if(!$post->allow_comments, 403, 'Comments are disabled for this post.');

        $validated = $request->validate([
            'content' => 'required|string|min:10|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
            'guest_name' => 'required_without:user_id|string|max:100',
            'guest_email' => 'required_without:user_id|email|max:255',
        ]);

        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'parent_id' => $validated['parent_id'] ?? null,
            'guest_name' => Auth::check() ? null : $validated['guest_name'],
            'guest_email' => Auth::check() ? null : $validated['guest_email'],
            'content' => $validated['content'],
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Comment submitted successfully. It will be visible after moderation.');
    }

    /**
     * Store comment via public route (comments.store)
     */
    public function storeCommentPublic(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|min:10|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
            'author_name' => 'required|string|max:100',
            'author_email' => 'required|email|max:255',
        ], [
            'content.required' => 'Comment content is required.',
            'content.min' => 'Comment must be at least 10 characters.',
            'content.max' => 'Comment must not exceed 2000 characters.',
            'author_name.required' => 'Name is required.',
            'author_name.max' => 'Name must not exceed 100 characters.',
            'author_email.required' => 'Email is required.',
            'author_email.email' => 'Please enter a valid email address.',
            'author_email.max' => 'Email must not exceed 255 characters.',
        ]);

        $post = Post::findOrFail($validated['post_id']);
        
        abort_if(!$post->allow_comments, 403, 'Comments are disabled for this post.');

        $comment = $post->comments()->create([
            'user_id' => null,
            'parent_id' => $validated['parent_id'] ?? null,
            'guest_name' => $validated['author_name'],
            'guest_email' => $validated['author_email'],
            'content' => $validated['content'],
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Comment submitted successfully. It will be visible after moderation.');
    }

    // Software listing
    public function software(Request $request): View
    {
        $posts = Post::published()
            ->software()
            ->with(['category', 'softwareDetail', 'user'])
            ->when($request->category, fn($q, $cat) => $q->whereHas('category', fn($c) => $c->where('slug', $cat)))
            ->when($request->sort === 'popular', fn($q) => $q->popular(), fn($q) => $q->recent())
            ->paginate(12);

        $categories = \App\Models\Category::active()
            ->withCount(['posts' => fn($q) => $q->published()->software()])
            ->having('posts_count', '>', 0)
            ->ordered()
            ->get();

        return view('posts.software', compact('posts', 'categories'));
    }

    // Mobile apps listing
    public function mobileApps(Request $request): View
    {
        $posts = Post::published()
            ->mobileApps()
            ->with(['category', 'softwareDetail', 'user'])
            ->when($request->platform, function($q, $platform) {
                $q->whereHas('softwareDetail', fn($sd) => $sd->where('platform', $platform));
            })
            ->when($request->sort === 'popular', fn($q) => $q->popular(), fn($q) => $q->recent())
            ->paginate(12);

        return view('posts.mobile-apps', compact('posts'));
    }

    // Tutorials listing
    public function tutorials(Request $request): View
    {
        $posts = Post::published()
            ->tutorials()
            ->with(['category', 'user'])
            ->when($request->category, fn($q, $cat) => $q->whereHas('category', fn($c) => $c->where('slug', $cat)))
            ->when($request->sort === 'popular', fn($q) => $q->popular(), fn($q) => $q->recent())
            ->paginate(12);

        $categories = \App\Models\Category::active()
            ->withCount(['posts' => fn($q) => $q->published()->tutorials()])
            ->having('posts_count', '>', 0)
            ->ordered()
            ->get();

        return view('posts.tutorials', compact('posts', 'categories'));
    }
}