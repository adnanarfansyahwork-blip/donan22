

<?php $__env->startSection('title', 'Donan22 - IT & Software Learning Hub'); ?>
<?php $__env->startSection('meta_description', 'Download software PC, mobile apps Android & iOS, and learn IT tutorials. Your trusted source for technology.'); ?>

<?php $__env->startSection('content'); ?>
<!-- Hero Section -->
<section class="bg-gradient-to-br from-primary-600 via-primary-700 to-primary-900 text-white py-16 lg:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto">
            <h1 class="text-4xl lg:text-5xl font-extrabold mb-6">
                IT & Software Learning Hub
            </h1>
            <p class="text-xl text-primary-100 mb-8">
                Download software, mobile apps, and learn IT tutorials.
                Your trusted source for the latest technology.
            </p>

            <!-- Quick Stats -->
            <div class="flex flex-wrap justify-center gap-8 mt-8">
                <div class="text-center">
                    <div class="text-3xl font-bold"><?php echo e(\App\Models\Post::where('post_type', 'software')->count()); ?>+</div>
                    <div class="text-primary-200 text-sm">Software</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold"><?php echo e(\App\Models\Post::where('post_type', 'mobile-app')->count()); ?>+</div>
                    <div class="text-primary-200 text-sm">Mobile Apps</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold"><?php echo e(\App\Models\Post::where('post_type', 'tutorial')->count()); ?>+</div>
                    <div class="text-primary-200 text-sm">Tutorials</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Posts -->
<?php if($featuredPosts->count()): ?>
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-star-fill text-yellow-500 mr-2"></i> Featured
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $featuredPosts->take(6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('components.post-card', ['post' => $post, 'featured' => true], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Popular Software -->
<?php if($popularSoftware->count()): ?>
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-box-seam text-primary-600 mr-2"></i> Popular Software
            </h2>
            <a href="<?php echo e(route('software.index')); ?>" class="text-primary-600 hover:text-primary-700 font-medium">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $popularSoftware; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('components.software-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Mobile Apps -->
<?php if($popularApps->count()): ?>
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-phone text-green-600 mr-2"></i> Mobile Apps
            </h2>
            <a href="<?php echo e(route('mobile-apps.index')); ?>" class="text-primary-600 hover:text-primary-700 font-medium">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $popularApps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('components.software-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Latest Tutorials -->
<?php if($tutorials->count()): ?>
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-book text-purple-600 mr-2"></i> Latest Tutorials
            </h2>
            <a href="<?php echo e(route('tutorials.index')); ?>" class="text-primary-600 hover:text-primary-700 font-medium">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $__currentLoopData = $tutorials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make('components.post-card', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Latest Posts with Category Sidebar -->
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-clock text-emerald-500 mr-2"></i> Latest Updates
            </h2>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="lg:w-[65%] space-y-4">
                <?php $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make('components.post-card-horizontal', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            
            <div class="lg:w-[35%]">
                <div class="sticky top-24 space-y-6">
                    <?php echo $__env->make('components.category-sidebar', [
                        'categories' => $categories, 
                        'title' => 'Kategori Software',
                        'showViewAll' => true
                    ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-red-500 px-5 py-3">
                            <h3 class="text-white font-bold text-center">
                                <i class="bi bi-fire mr-2"></i>Tulisan Populer
                            </h3>
                        </div>
                        <div class="p-4 space-y-2">
                            <?php $__currentLoopData = $featuredPosts->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $popularPost): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e($popularPost->url); ?>" 
                                   class="flex items-start gap-3 p-2 rounded-lg hover:bg-gray-50 transition-colors group">
                                    <span class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold
                                        <?php echo e($index === 0 ? 'bg-red-500 text-white' : ($index === 1 ? 'bg-orange-500 text-white' : ($index === 2 ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-600'))); ?>">
                                        <?php echo e($index + 1); ?>

                                    </span>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-medium text-gray-800 line-clamp-2 group-hover:text-emerald-600 transition-colors leading-snug">
                                            <?php echo e($popularPost->title); ?>

                                        </h4>
                                        <span class="text-xs text-gray-400"><?php echo e(number_format($popularPost->views_count)); ?> views</span>
                                    </div>
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Categories -->
<?php if($categories->count()): ?>
<section class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-2xl font-bold text-gray-900">
                <i class="bi bi-grid text-primary-600 mr-2"></i> Browse Categories
            </h2>
            <a href="<?php echo e(route('categories.index')); ?>" class="text-primary-600 hover:text-primary-700 font-medium">
                View All <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            <?php $__currentLoopData = $categories->take(12); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('categories.show', $category->slug)); ?>"
                   class="bg-white rounded-xl p-4 text-center hover:shadow-lg transition-shadow border border-gray-200 group">
                    <?php if($category->icon): ?>
                        <i class="bi <?php echo e($category->icon); ?> text-3xl text-primary-600 mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                    <?php else: ?>
                        <i class="bi bi-folder text-3xl text-primary-600 mb-2 group-hover:scale-110 transition-transform inline-block"></i>
                    <?php endif; ?>
                    <h3 class="font-medium text-gray-900 text-sm"><?php echo e($category->name); ?></h3>
                    <span class="text-xs text-gray-500"><?php echo e($category->posts_count); ?> posts</span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-primary-600 to-primary-800 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Stay Updated</h2>
        <p class="text-primary-100 mb-8">Get notified about new software releases, tutorials, and updates.</p>
        <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
            <input type="email" placeholder="Enter your email"
                   class="flex-1 px-6 py-3 rounded-lg text-gray-900 focus:ring-4 focus:ring-primary-300">
            <button type="submit" class="px-8 py-3 bg-white text-primary-600 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
                Subscribe
            </button>
        </form>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/home.blade.php ENDPATH**/ ?>