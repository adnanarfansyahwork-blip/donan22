<?php $__env->startSection('title', 'Categories - Donan22'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-r from-gray-700 to-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">
            <i class="bi bi-grid mr-2"></i> All Categories
        </h1>
        <p class="text-gray-300">Browse all categories to find what you're looking for.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('categories.show', $category->slug)); ?>" 
               class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-lg transition-shadow group">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 flex items-center justify-center bg-primary-100 rounded-xl group-hover:bg-primary-200 transition-colors">
                        <i class="bi <?php echo e($category->icon ?? 'bi-folder'); ?> text-2xl text-primary-600"></i>
                    </div>
                    <div class="flex-1">
                        <h2 class="text-lg font-bold text-gray-900 group-hover:text-primary-600 transition-colors">
                            <?php echo e($category->name); ?>

                        </h2>
                        <?php if($category->description): ?>
                            <p class="text-sm text-gray-500 mt-1 line-clamp-2"><?php echo e($category->description); ?></p>
                        <?php endif; ?>
                        <div class="text-sm text-gray-400 mt-2"><?php echo e($category->posts_count); ?> posts</div>
                    </div>
                </div>
                
                <?php if($category->children->count()): ?>
                    <div class="mt-4 pt-4 border-t">
                        <div class="flex flex-wrap gap-2">
                            <?php $__currentLoopData = $category->children->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded"><?php echo e($child->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php if($category->children->count() > 5): ?>
                                <span class="text-xs text-gray-500">+<?php echo e($category->children->count() - 5); ?> more</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u828471719/domains/donan22.com/public_html/resources/views/categories/index.blade.php ENDPATH**/ ?>