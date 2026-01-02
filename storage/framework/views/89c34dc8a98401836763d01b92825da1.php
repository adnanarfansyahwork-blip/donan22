<article class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group">
    <a href="<?php echo e($post->url); ?>" class="block p-4">
        <div class="flex gap-4">
            <!-- Icon/Image -->
            <div class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-xl overflow-hidden">
                <img src="<?php echo e($post->featured_image_url); ?>" 
                     alt="<?php echo e($post->title); ?>" 
                     class="w-full h-full object-cover" 
                     loading="lazy">
            </div>
            
            <!-- Content -->
            <div class="flex-1">
                <h3 class="font-semibold text-gray-900 mb-1 group-hover:text-primary-600 transition-colors leading-tight">
                    <?php echo e($post->title); ?>

                </h3>
                
                <!-- Software Info -->
                <?php if($post->softwareDetail): ?>
                    <div class="flex flex-wrap gap-2 text-xs text-gray-500 mb-2">
                        <?php if($post->softwareDetail->version): ?>
                            <span class="bg-gray-100 px-2 py-0.5 rounded">v<?php echo e($post->softwareDetail->version); ?></span>
                        <?php endif; ?>
                        <?php if($post->softwareDetail->platform): ?>
                            <span class="bg-gray-100 px-2 py-0.5 rounded capitalize">
                                <i class="bi bi-<?php echo e($post->softwareDetail->platform === 'android' ? 'android2' : ($post->softwareDetail->platform === 'ios' ? 'apple' : 'windows')); ?> mr-1"></i>
                                <?php echo e($post->softwareDetail->platform_label); ?>

                            </span>
                        <?php endif; ?>
                        <?php if($post->softwareDetail->is_free): ?>
                            <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded">Free</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Meta -->
                <div class="flex items-center gap-3 text-xs text-gray-500">
                    <span><i class="bi bi-download mr-1"></i><?php echo e(number_format($post->downloads_count)); ?></span>
                    <span><i class="bi bi-eye mr-1"></i><?php echo e(number_format($post->views_count)); ?></span>
                </div>
            </div>
        </div>
    </a>
</article>
<?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/components/software-card.blade.php ENDPATH**/ ?>