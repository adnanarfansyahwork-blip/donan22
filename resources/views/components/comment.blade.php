<div class="bg-white rounded-lg p-4 border border-gray-200">
    <div class="flex gap-4">
        <img src="{{ $comment->author_avatar }}" alt="{{ $comment->author_name }}" class="w-10 h-10 rounded-full flex-shrink-0">
        
        <div class="flex-1">
            <div class="flex items-center gap-2 mb-2">
                <span class="font-medium text-gray-900">{{ $comment->author_name }}</span>
                @if($comment->user)
                    <span class="text-xs bg-primary-100 text-primary-700 px-2 py-0.5 rounded">Member</span>
                @endif
                <time class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</time>
            </div>
            
            <div class="text-gray-700 text-sm">
                {!! nl2br(e($comment->content)) !!}
            </div>
            
            <!-- Replies -->
            @if($comment->replies->count())
                <div class="mt-4 pl-4 border-l-2 border-gray-200 space-y-4">
                    @foreach($comment->replies as $reply)
                        <div class="flex gap-3">
                            <img src="{{ $reply->author_avatar }}" alt="{{ $reply->author_name }}" class="w-8 h-8 rounded-full flex-shrink-0">
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-medium text-gray-900 text-sm">{{ $reply->author_name }}</span>
                                    <time class="text-xs text-gray-500">{{ $reply->created_at->diffForHumans() }}</time>
                                </div>
                                <div class="text-gray-700 text-sm">
                                    {!! nl2br(e($reply->content)) !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
