

<?php $__env->startSection('title', 'Software Downloads - Donan22'); ?>
<?php $__env->startSection('meta_description', 'Download free and premium software for Windows, macOS, and Linux.'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-r from-primary-600 to-primary-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">
            <i class="bi bi-box-seam mr-2"></i> Software Downloads
        </h1>
        <p class="text-primary-100">Download free and premium software for your computer.</p>
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
                        <a href="<?php echo e(route('software.index')); ?>" 
                           class="block px-3 py-2 rounded-lg <?php echo e(!request('category') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                            All Software
                        </a>
                    </li>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php echo e(route('software.index', ['category' => $category->slug])); ?>" 
                               class="flex justify-between items-center px-3 py-2 rounded-lg <?php echo e(request('category') == $category->slug ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                                <span><?php echo e($category->name); ?></span>
                                <span class="text-xs text-gray-400"><?php echo e($category->posts_count); ?></span>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                
                <div class="mt-6 pt-6 border-t">
                    <h3 class="font-bold text-gray-900 mb-4">Sort By</h3>
                    <div class="space-y-2">
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'latest'])); ?>" 
                           class="block px-3 py-2 rounded-lg <?php echo e(request('sort', 'latest') == 'latest' ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                            <i class="bi bi-clock mr-2"></i> Latest
                        </a>
                        <a href="<?php echo e(request()->fullUrlWithQuery(['sort' => 'popular'])); ?>" 
                           class="block px-3 py-2 rounded-lg <?php echo e(request('sort') == 'popular' ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                            <i class="bi bi-fire mr-2"></i> Most Popular
                        </a>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Posts Grid -->
        <main class="lg:col-span-3">
            <?php if($posts->count()): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('components.software-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <div class="mt-8">
                    <?php echo e($posts->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-16">
                    <i class="bi bi-inbox text-6xl text-gray-300"></i>
                    <h3 class="text-xl font-medium text-gray-600 mt-4">No software found</h3>
                    <p class="text-gray-500 mt-2">Try adjusting your filters or check back later.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/posts/software.blade.php ENDPATH**/ ?>