<?php $__env->startSection('title', 'Mobile Apps - Donan22'); ?>
<?php $__env->startSection('meta_description', 'Download mobile apps for Android and iOS devices.'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gradient-to-r from-green-600 to-green-800 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold mb-2">
            <i class="bi bi-phone mr-2"></i> Mobile Apps
        </h1>
        <p class="text-green-100">Download apps for your Android and iOS devices.</p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Platform Filter -->
    <div class="flex gap-4 mb-8">
        <a href="<?php echo e(route('mobile-apps.index')); ?>" 
           class="px-4 py-2 rounded-lg font-medium <?php echo e(!request('platform') ? 'bg-primary-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'); ?>">
            All
        </a>
        <a href="<?php echo e(route('mobile-apps.index', ['platform' => 'android'])); ?>" 
           class="px-4 py-2 rounded-lg font-medium <?php echo e(request('platform') == 'android' ? 'bg-green-600 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'); ?>">
            <i class="bi bi-android2 mr-1"></i> Android
        </a>
        <a href="<?php echo e(route('mobile-apps.index', ['platform' => 'ios'])); ?>" 
           class="px-4 py-2 rounded-lg font-medium <?php echo e(request('platform') == 'ios' ? 'bg-gray-900 text-white' : 'bg-white border border-gray-300 text-gray-700 hover:bg-gray-50'); ?>">
            <i class="bi bi-apple mr-1"></i> iOS
        </a>
    </div>
    
    <?php if($posts->count()): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('components.software-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <div class="mt-8">
            <?php echo e($posts->links()); ?>

        </div>
    <?php else: ?>
        <div class="text-center py-16">
            <i class="bi bi-phone text-6xl text-gray-300"></i>
            <h3 class="text-xl font-medium text-gray-600 mt-4">No apps found</h3>
            <p class="text-gray-500 mt-2">Try adjusting your filters or check back later.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/posts/mobile-apps.blade.php ENDPATH**/ ?>