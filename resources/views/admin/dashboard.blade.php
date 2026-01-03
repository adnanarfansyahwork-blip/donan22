@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-500">Welcome back, {{ $currentAdmin->name ?? 'Admin' }}!</p>
</div>

<!-- Stats Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="bi bi-file-earmark-text text-2xl"></i>
            </div>
            <div class="text-right">
                <p class="text-blue-100 text-sm">Total Posts</p>
                <p class="text-3xl font-bold">{{ number_format($stats['total_posts']) }}</p>
            </div>
        </div>
        <div class="flex items-center text-sm border-t border-white/20 pt-3">
            <span class="text-blue-100">{{ $stats['published_posts'] }} published</span>
            <span class="mx-2 text-white/40">|</span>
            <span class="text-blue-100">{{ $stats['draft_posts'] }} drafts</span>
        </div>
    </div>
    
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="bi bi-people text-2xl"></i>
            </div>
            <div class="text-right">
                <p class="text-green-100 text-sm">Total Users</p>
                <p class="text-3xl font-bold">{{ number_format($stats['total_users']) }}</p>
            </div>
        </div>
        <div class="flex items-center text-sm border-t border-white/20 pt-3">
            <span class="text-green-100">Registered members</span>
        </div>
    </div>
    
    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="bi bi-chat-dots text-2xl"></i>
            </div>
            <div class="text-right">
                <p class="text-purple-100 text-sm">Comments</p>
                <p class="text-3xl font-bold">{{ number_format($stats['total_comments']) }}</p>
            </div>
        </div>
        <div class="flex items-center text-sm border-t border-white/20 pt-3">
            @if($stats['pending_comments'] > 0)
                <span class="bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded-full text-xs font-medium">
                    {{ $stats['pending_comments'] }} pending
                </span>
            @else
                <span class="text-purple-100">All approved</span>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Posts -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Recent Posts</h2>
            <a href="{{ route('admin.posts.create') }}" class="text-sm text-primary-600 hover:text-primary-700">
                <i class="bi bi-plus"></i> New Post
            </a>
        </div>
        <div class="divide-y">
            @forelse($recentPosts as $post)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                            <img src="{{ $post->featured_image_url }}" 
                                 class="w-10 h-10 rounded-lg object-cover">
                        </div>
                        <div>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="font-medium text-gray-900 hover:text-primary-600 line-clamp-1">
                                {{ $post->title }}
                            </a>
                            <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded {{ $post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($post->status) }}
                    </span>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">No posts yet</div>
            @endforelse
        </div>
    </div>
    
    <!-- Pending Comments -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">
                Pending Comments
                @if($stats['pending_comments'] > 0)
                    <span class="ml-2 text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full">{{ $stats['pending_comments'] }}</span>
                @endif
            </h2>
            <a href="{{ route('admin.comments.index', ['status' => 'pending']) }}" class="text-sm text-primary-600 hover:text-primary-700">
                View All
            </a>
        </div>
        <div class="divide-y">
            @forelse($pendingComments as $comment)
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3">
                            <img src="{{ $comment->author_avatar }}" class="w-8 h-8 rounded-full">
                            <div>
                                <p class="font-medium text-gray-900 text-sm">{{ $comment->author_name }}</p>
                                <p class="text-sm text-gray-600 line-clamp-2">{{ $comment->content }}</p>
                                <p class="text-xs text-gray-400 mt-1">
                                    on <a href="{{ route('admin.posts.edit', $comment->post) }}" class="text-primary-600 hover:underline">{{ \Illuminate\Support\Str::limit($comment->post->title, 30) }}</a>
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-1.5 text-green-600 hover:bg-green-100 rounded" title="Approve">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.comments.reject', $comment) }}" method="POST">
                                @csrf
                                <button type="submit" class="p-1.5 text-red-600 hover:bg-red-100 rounded" title="Reject">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-check-circle text-4xl text-green-400"></i>
                    <p class="mt-2">No pending comments</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Top Posts and Categories -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <!-- Top Posts -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Top Posts by Views</h2>
        </div>
        <div class="divide-y">
            @forelse($topPosts as $index => $post)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center space-x-3">
                        <span class="text-gray-400 font-semibold">{{ $index + 1 }}</span>
                        <div>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="text-gray-900 hover:text-primary-600 line-clamp-1 font-medium">
                                {{ \Illuminate\Support\Str::limit($post->title, 40) }}
                            </a>
                            <p class="text-xs text-gray-500">
                                {{ number_format($post->views_count) }} views
                                @if($post->downloads_count > 0)
                                    • {{ number_format($post->downloads_count) }} downloads
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">No published posts yet</div>
            @endforelse
        </div>
    </div>

    <!-- Top Categories -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Top Categories</h2>
        </div>
        <div class="divide-y">
            @forelse($topCategories as $category)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center space-x-3">
                        @if($category->image_url)
                            <img src="{{ $category->image_url }}" class="w-10 h-10 rounded-lg object-cover">
                        @else
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-folder text-blue-600"></i>
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('admin.categories.index') }}" class="text-gray-900 hover:text-primary-600 font-medium">
                                {{ $category->name }}
                            </a>
                            <p class="text-xs text-gray-500">{{ $category->posts_count }} {{ \Illuminate\Support\Str::plural('post', $category->posts_count) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-gray-500">No categories yet</div>
            @endforelse
        </div>
    </div>
</div>
@endsection

