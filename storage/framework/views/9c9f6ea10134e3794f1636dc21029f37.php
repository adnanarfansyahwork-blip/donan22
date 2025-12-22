<article class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group">
    <a href="<?php echo e($post->url); ?>" class="block">
        <!-- Image -->
        <div class="aspect-video bg-gray-100 overflow-hidden">
            <img src="<?php echo e($post->featured_image_url); ?>" 
                 alt="<?php echo e($post->featured_image_alt ?? $post->title); ?>" 
                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" 
                 loading="lazy">
        </div>
        
        <!-- Content -->
        <div class="p-4">
            <!-- Category & Type Badge -->
            <div class="flex items-center gap-2 mb-2">
                <?php if($post->category): ?>
                    <span class="text-xs font-medium text-primary-600 bg-primary-50 px-2 py-1 rounded">
                        <?php echo e($post->category->name); ?>

                    </span>
                <?php endif; ?>
                <?php if(isset($featured) && $featured): ?>
                    <span class="text-xs font-medium text-yellow-600 bg-yellow-50 px-2 py-1 rounded">
                        <i class="bi bi-star-fill"></i> Featured
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- Title -->
            <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-primary-600 transition-colors">
                <?php echo e($post->title); ?>

            </h3>
            
            <!-- Excerpt -->
            <?php if($post->excerpt): ?>
                <p class="text-sm text-gray-600 line-clamp-2 mb-3"><?php echo e($post->excerpt); ?></p>
            <?php endif; ?>
            
            <!-- Meta -->
            <div class="flex items-center justify-between text-xs text-gray-500">
                <div class="flex items-center gap-3">
                    <span><i class="bi bi-eye mr-1"></i><?php echo e(number_format($post->views_count)); ?></span>
                    <?php if($post->downloads_count > 0): ?>
                        <span><i class="bi bi-download mr-1"></i><?php echo e(number_format($post->downloads_count)); ?></span>
                    <?php endif; ?>
                </div>
                <time datetime="<?php echo e($post->published_at?->toIso8601String()); ?>">
                    <?php echo e($post->published_at?->diffForHumans() ?? 'Draft'); ?>

                </time>
            </div>
        </div>
    </a>
</article>
<?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/components/post-card.blade.php ENDPATH**/ ?>