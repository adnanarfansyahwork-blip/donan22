<?php $__env->startSection('title', ($query ? "Search: $query" : 'Search') . ' - Donan22'); ?>

<?php $__env->startSection('content'); ?>
<div class="bg-gray-100 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <form action="<?php echo e(route('search')); ?>" method="GET">
            <div class="relative">
                <input type="search" name="q" value="<?php echo e($query); ?>" placeholder="Search software, apps, tutorials..." 
                       class="w-full pl-12 pr-4 py-4 text-lg border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 bg-white shadow-sm"
                       autofocus>
                <i class="bi bi-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-xl"></i>
            </div>
        </form>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php if($query): ?>
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                Search results for "<?php echo e($query); ?>"
            </h1>
            <?php if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                <p class="text-gray-500 mt-1"><?php echo e($posts->total()); ?> results found</p>
            <?php endif; ?>
        </div>
        
        <?php if($posts->count()): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('components.post-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <?php if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator): ?>
                <div class="mt-8">
                    <?php echo e($posts->links()); ?>

                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-16">
                <i class="bi bi-search text-6xl text-gray-300"></i>
                <h3 class="text-xl font-medium text-gray-600 mt-4">No results found</h3>
                <p class="text-gray-500 mt-2">Try different keywords or check your spelling.</p>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="text-center py-16">
            <i class="bi bi-search text-6xl text-gray-300"></i>
            <h3 class="text-xl font-medium text-gray-600 mt-4">Start searching</h3>
            <p class="text-gray-500 mt-2">Enter keywords to find software, apps, or tutorials.</p>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u828471719/domains/donan22.com/public_html/resources/views/search/index.blade.php ENDPATH**/ ?>