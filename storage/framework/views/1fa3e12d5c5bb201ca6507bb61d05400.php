<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-500">Welcome back, <?php echo e($currentAdmin->name ?? 'Admin'); ?>!</p>
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
                <p class="text-3xl font-bold"><?php echo e(number_format($stats['total_posts'])); ?></p>
            </div>
        </div>
        <div class="flex items-center text-sm border-t border-white/20 pt-3">
            <span class="text-blue-100"><?php echo e($stats['published_posts']); ?> published</span>
            <span class="mx-2 text-white/40">|</span>
            <span class="text-blue-100"><?php echo e($stats['draft_posts']); ?> drafts</span>
        </div>
    </div>
    
    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-6 text-white">
        <div class="flex items-center justify-between mb-4">
            <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                <i class="bi bi-people text-2xl"></i>
            </div>
            <div class="text-right">
                <p class="text-green-100 text-sm">Total Users</p>
                <p class="text-3xl font-bold"><?php echo e(number_format($stats['total_users'])); ?></p>
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
                <p class="text-3xl font-bold"><?php echo e(number_format($stats['total_comments'])); ?></p>
            </div>
        </div>
        <div class="flex items-center text-sm border-t border-white/20 pt-3">
            <?php if($stats['pending_comments'] > 0): ?>
                <span class="bg-yellow-400 text-yellow-900 px-2 py-0.5 rounded-full text-xs font-medium">
                    <?php echo e($stats['pending_comments']); ?> pending
                </span>
            <?php else: ?>
                <span class="text-purple-100">All approved</span>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Posts -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">Recent Posts</h2>
            <a href="<?php echo e(route('admin.posts.create')); ?>" class="text-sm text-primary-600 hover:text-primary-700">
                <i class="bi bi-plus"></i> New Post
            </a>
        </div>
        <div class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $recentPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                            <img src="<?php echo e($post->featured_image_url); ?>" 
                                 class="w-10 h-10 rounded-lg object-cover">
                        </div>
                        <div>
                            <a href="<?php echo e(route('admin.posts.edit', $post)); ?>" class="font-medium text-gray-900 hover:text-primary-600 line-clamp-1">
                                <?php echo e($post->title); ?>

                            </a>
                            <p class="text-xs text-gray-500"><?php echo e($post->created_at->diffForHumans()); ?></p>
                        </div>
                    </div>
                    <span class="text-xs px-2 py-1 rounded <?php echo e($post->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'); ?>">
                        <?php echo e(ucfirst($post->status)); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-8 text-center text-gray-500">No posts yet</div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Pending Comments -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-900">
                Pending Comments
                <?php if($stats['pending_comments'] > 0): ?>
                    <span class="ml-2 text-xs bg-red-100 text-red-700 px-2 py-1 rounded-full"><?php echo e($stats['pending_comments']); ?></span>
                <?php endif; ?>
            </h2>
            <a href="<?php echo e(route('admin.comments.index', ['status' => 'pending'])); ?>" class="text-sm text-primary-600 hover:text-primary-700">
                View All
            </a>
        </div>
        <div class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $pendingComments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="p-4 hover:bg-gray-50">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start space-x-3">
                            <img src="<?php echo e($comment->author_avatar); ?>" class="w-8 h-8 rounded-full">
                            <div>
                                <p class="font-medium text-gray-900 text-sm"><?php echo e($comment->author_name); ?></p>
                                <p class="text-sm text-gray-600 line-clamp-2"><?php echo e($comment->content); ?></p>
                                <p class="text-xs text-gray-400 mt-1">
                                    on <a href="<?php echo e(route('admin.posts.edit', $comment->post)); ?>" class="text-primary-600 hover:underline"><?php echo e(Str::limit($comment->post->title, 30)); ?></a>
                                </p>
                            </div>
                        </div>
                        <div class="flex space-x-1">
                            <form action="<?php echo e(route('admin.comments.approve', $comment)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="p-1.5 text-green-600 hover:bg-green-100 rounded" title="Approve">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            <form action="<?php echo e(route('admin.comments.reject', $comment)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="p-1.5 text-red-600 hover:bg-red-100 rounded" title="Reject">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-8 text-center text-gray-500">
                    <i class="bi bi-check-circle text-4xl text-green-400"></i>
                    <p class="mt-2">No pending comments</p>
                </div>
            <?php endif; ?>
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
            <?php $__empty_1 = true; $__currentLoopData = $topPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center space-x-3">
                        <span class="text-gray-400 font-semibold"><?php echo e($index + 1); ?></span>
                        <div>
                            <a href="<?php echo e(route('admin.posts.edit', $post)); ?>" class="text-gray-900 hover:text-primary-600 line-clamp-1 font-medium">
                                <?php echo e(Str::limit($post->title, 40)); ?>

                            </a>
                            <p class="text-xs text-gray-500">
                                <?php echo e(number_format($post->views_count)); ?> views
                                <?php if($post->downloads_count > 0): ?>
                                    • <?php echo e(number_format($post->downloads_count)); ?> downloads
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-8 text-center text-gray-500">No published posts yet</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Top Categories -->
    <div class="bg-white rounded-xl shadow-sm">
        <div class="p-6 border-b">
            <h2 class="text-lg font-semibold text-gray-900">Top Categories</h2>
        </div>
        <div class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $topCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="p-4 flex items-center justify-between hover:bg-gray-50">
                    <div class="flex items-center space-x-3">
                        <?php if($category->image_url): ?>
                            <img src="<?php echo e($category->image_url); ?>" class="w-10 h-10 rounded-lg object-cover">
                        <?php else: ?>
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class="bi bi-folder text-blue-600"></i>
                            </div>
                        <?php endif; ?>
                        <div>
                            <a href="<?php echo e(route('admin.categories.index')); ?>" class="text-gray-900 hover:text-primary-600 font-medium">
                                <?php echo e($category->name); ?>

                            </a>
                            <p class="text-xs text-gray-500"><?php echo e($category->posts_count); ?> <?php echo e(Str::plural('post', $category->posts_count)); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="p-8 text-center text-gray-500">No categories yet</div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u828471719/domains/donan22.com/public_html/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>