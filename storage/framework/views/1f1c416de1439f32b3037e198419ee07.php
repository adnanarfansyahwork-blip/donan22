

<?php $__env->startSection('title', 'Tutorials - Donan22'); ?>
<?php $__env->startSection('meta_description', 'Learn IT and programming with our comprehensive tutorials.'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">
            <i class="bi bi-book mr-2"></i> Tutorials
        </h1>
        <p class="text-purple-100">Learn IT and programming with our comprehensive tutorials.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar -->
        <aside class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                <h3 class="font-bold text-gray-900 mb-4">Categories</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="<?php echo e(route('tutorials.index')); ?>" 
                           class="block px-3 py-2 rounded-lg <?php echo e(!request('category') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                            All Tutorials
                        </a>
                    </li>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(route('tutorials.index', ['category' => $category->slug])); ?>" 
                               class="flex justify-between items-center px-3 py-2 rounded-lg <?php echo e(request('category') == $category->slug ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                                <span><?php echo e($category->name); ?></span>
                                <span class="text-xs text-gray-400"><?php echo e($category->posts_count); ?></span>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </aside>
        
        <!-- Posts Grid -->
        <main class="lg:col-span-3">
            <?php if($posts->count()): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('components.post-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <div class="mt-8">
                    <?php echo e($posts->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <i class="bi bi-book text-6xl text-gray-300"></i>
                    <h3 class="text-xl font-medium text-gray-600 mt-4">No tutorials found</h3>
                    <p class="text-gray-500 mt-2">Try adjusting your filters or check back later.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/posts/tutorials.blade.php ENDPATH**/ ?>