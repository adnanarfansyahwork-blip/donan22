<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(Request $request): View
    {
        $comments = Comment::with(['post', 'user'])
            ->when($request->status, fn($q, $status) => $q->where('status', $status))
            ->latest()
            ->paginate(20);

        $counts = [
            'all' => Comment::count(),
            'pending' => Comment::pending()->count(),
            'approved' => Comment::approved()->count(),
            'spam' => Comment::spam()->count(),
        ];

        return view('admin.comments.index', compact('comments', 'counts'));
    }

    public function approve(Comment $comment): RedirectResponse
    {
        $comment->approve();
        return back()->with('success', 'Comment approved.');
    }

    public function reject(Comment $comment): RedirectResponse
    {
        $comment->reject();
        return back()->with('success', 'Comment rejected.');
    }

    public function spam(Comment $comment): RedirectResponse
    {
        $comment->markAsSpam();
        return back()->with('success', 'Comment marked as spam.');
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();
        return back()->with('success', 'Comment deleted.');
    }
}
