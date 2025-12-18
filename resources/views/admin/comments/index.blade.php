@extends('admin.layouts.app')

@section('title', 'Comments')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Comments</h1>
    <p class="text-gray-500">Manage and moderate comments</p>
</div>

<!-- Tabs -->
<div class="flex space-x-1 bg-gray-100 rounded-lg p-1 w-fit mb-6">
    <a href="{{ route('admin.comments.index') }}" 
       class="px-4 py-2 rounded-md text-sm font-medium {{ !request('status') ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
        All ({{ $counts['all'] }})
    </a>
    <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}"
       class="px-4 py-2 rounded-md text-sm font-medium {{ request('status') == 'pending' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
        Pending ({{ $counts['pending'] }})
    </a>
    <a href="{{ route('admin.comments.index', ['status' => 'approved']) }}"
       class="px-4 py-2 rounded-md text-sm font-medium {{ request('status') == 'approved' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
        Approved ({{ $counts['approved'] }})
    </a>
    <a href="{{ route('admin.comments.index', ['status' => 'spam']) }}"
       class="px-4 py-2 rounded-md text-sm font-medium {{ request('status') == 'spam' ? 'bg-white shadow text-gray-900' : 'text-gray-500 hover:text-gray-700' }}">
        Spam ({{ $counts['spam'] }})
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="divide-y">
        @forelse($comments as $comment)
            <div class="p-4 hover:bg-gray-50 {{ $comment->status === 'pending' ? 'bg-yellow-50' : '' }}">
                <div class="flex items-start justify-between">
                    <div class="flex items-start space-x-3 flex-1">
                        <img src="{{ $comment->author_avatar }}" class="w-10 h-10 rounded-full flex-shrink-0">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center space-x-2">
                                <span class="font-medium text-gray-900">{{ $comment->author_name }}</span>
                                @if($comment->author_email)
                                    <span class="text-sm text-gray-500">&lt;{{ $comment->author_email }}&gt;</span>
                                @endif
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <p class="text-gray-600 mt-1">{{ $comment->content }}</p>
                            
                            <div class="mt-2 flex items-center space-x-4 text-sm">
                                <a href="{{ route('admin.posts.edit', $comment->post) }}" class="text-primary-600 hover:underline">
                                    <i class="bi bi-file-text mr-1"></i>{{ Str::limit($comment->post->title, 40) }}
                                </a>
                                <span class="text-gray-400">IP: {{ $comment->author_ip }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-2 ml-4">
                        @if($comment->status !== 'approved')
                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 text-green-600 hover:bg-green-100 rounded-lg" title="Approve">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                        @endif
                        
                        @if($comment->status !== 'spam')
                            <form action="{{ route('admin.comments.spam', $comment) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 text-yellow-600 hover:bg-yellow-100 rounded-lg" title="Mark as Spam">
                                    <i class="bi bi-exclamation-triangle"></i>
                                </button>
                            </form>
                        @endif
                        
                        @if($comment->status !== 'rejected')
                            <form action="{{ route('admin.comments.reject', $comment) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-2 text-orange-600 hover:bg-orange-100 rounded-lg" title="Reject">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" onsubmit="return confirm('Delete this comment permanently?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-red-600 hover:bg-red-100 rounded-lg" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-gray-500">
                <i class="bi bi-chat-dots text-4xl"></i>
                <p class="mt-2">No comments found</p>
            </div>
        @endforelse
    </div>
    
    @if($comments->hasPages())
        <div class="px-6 py-4 border-t">
            {{ $comments->appends(request()->query())->links() }}
        </div>
    @endif
</div>
@endsection
