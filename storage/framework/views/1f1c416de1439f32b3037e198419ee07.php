<?php $__env->startSection('title', 'Tutorials - Donan22'); ?>
<?php $__env->startSection('meta_description', 'Learn IT and programming with our comprehensive tutorials.'); ?>
<?php $__env->startSection('canonical', route('tutorials.index')); ?>
<?php $__env->startSection('robots', request()->has('page') || request()->has('category') ? 'noindex, follow' : 'index, follow'); ?>

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
    
    <div class="mb-6">
        <?php echo $__env->make('components.ads.banner-468x60', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-8">
        
        <main class="lg:w-[65%]">
            <?php if($posts->count()): ?>
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <span class="text-gray-500 text-sm">Showing</span>
                            <span class="font-semibold text-gray-900"><?php echo e($posts->total()); ?></span>
                            <span class="text-gray-500 text-sm">tutorials</span>
                        </div>
                        <?php if(request('category')): ?>
                            <a href="<?php echo e(route('tutorials.index')); ?>" 
                               class="text-sm text-purple-600 hover:text-purple-800 font-medium">
                                <i class="bi bi-x-circle mr-1"></i> Reset Filter
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                
                <div class="space-y-4">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('components.post-card-horizontal', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                
                <div class="mt-8">
                    <?php echo e($posts->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-gray-100">
                    <i class="bi bi-book text-6xl text-gray-300"></i>
                    <h3 class="text-xl font-medium text-gray-600 mt-4">No tutorials found</h3>
                    <p class="text-gray-500 mt-2">Try adjusting your filters or check back later.</p>
                </div>
            <?php endif; ?>
        </main>
        
        
        <aside class="lg:w-[35%]">
            <div class="sticky top-24 space-y-6">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-5 py-3">
                        <h3 class="text-white font-bold text-center">
                            Kategori Tutorial
                        </h3>
                    </div>
                    <div class="p-4">
                        <ul class="space-y-1">
                            <li>
                                <a href="<?php echo e(route('tutorials.index')); ?>" 
                                   class="flex items-center justify-between px-3 py-2 rounded-lg transition-colors <?php echo e(!request('category') ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                                    <span class="flex items-center gap-2 text-sm">
                                        <i class="bi bi-grid-3x3-gap"></i>
                                        <span class="font-medium">Semua Tutorial</span>
                                    </span>
                                </a>
                            </li>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(route('tutorials.index', ['category' => $category->slug])); ?>" 
                                       class="flex items-center justify-between px-3 py-2 rounded-lg transition-colors <?php echo e(request('category') == $category->slug ? 'bg-purple-50 text-purple-700' : 'text-gray-600 hover:bg-gray-50'); ?>">
                                        <span class="flex items-center gap-2 text-sm">
                                            <?php if($category->icon): ?>
                                                <i class="bi <?php echo e($category->icon); ?>"></i>
                                            <?php else: ?>
                                                <i class="bi bi-folder"></i>
                                            <?php endif; ?>
                                            <span class="font-medium"><?php echo e($category->name); ?></span>
                                        </span>
                                        <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">
                                            <?php echo e($category->posts_count); ?>

                                        </span>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
                
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-500 to-blue-500 px-5 py-3">
                        <h3 class="text-white font-bold text-center">
                            <i class="bi bi-lightning mr-2"></i>Explore More
                        </h3>
                    </div>
                    <div class="p-4 space-y-2">
                        <a href="<?php echo e(route('software.index')); ?>" 
                           class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 flex items-center justify-center bg-blue-100 text-blue-600 rounded-lg text-sm">
                                <i class="bi bi-box-seam"></i>
                            </span>
                            <span class="text-sm font-medium text-gray-700">Download Software</span>
                        </a>
                        <a href="<?php echo e(route('mobile-apps.index')); ?>" 
                           class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 flex items-center justify-center bg-green-100 text-green-600 rounded-lg text-sm">
                                <i class="bi bi-phone"></i>
                            </span>
                            <span class="text-sm font-medium text-gray-700">Mobile Apps</span>
                        </a>
                        <a href="<?php echo e(route('categories.index')); ?>" 
                           class="flex items-center gap-3 p-2.5 rounded-lg hover:bg-gray-50 transition-colors">
                            <span class="w-7 h-7 flex items-center justify-center bg-orange-100 text-orange-600 rounded-lg text-sm">
                                <i class="bi bi-grid"></i>
                            </span>
                            <span class="text-sm font-medium text-gray-700">Semua Kategori</span>
                        </a>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/posts/tutorials.blade.php ENDPATH**/ ?>