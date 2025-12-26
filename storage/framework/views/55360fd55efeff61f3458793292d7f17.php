
<article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 group">
    <a href="<?php echo e($post->url); ?>" class="flex flex-col sm:flex-row">
        
        <div class="relative sm:w-52 md:w-60 flex-shrink-0">
            <div class="aspect-video sm:aspect-[4/3] h-full bg-gradient-to-br from-gray-100 to-gray-200 overflow-hidden">
                <img src="<?php echo e($post->featured_image_url); ?>" 
                     alt="<?php echo e($post->featured_image_alt ?? $post->title); ?>" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     loading="lazy"
                     onerror="this.onerror=null;this.src='/images/no-image.svg'">>
            </div>
            
            <div class="absolute top-2 left-2 flex items-center gap-1 bg-emerald-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-md">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
                </svg>
                <span><?php echo e($post->comments_count ?? 0); ?></span>
            </div>
        </div>
        
        
        <div class="flex-1 p-4 flex flex-col min-w-0">
            
            <div class="flex flex-wrap items-center gap-2 mb-2 text-xs">
                <?php if($post->category): ?>
                    <span class="font-bold uppercase tracking-wider text-emerald-600">
                        <?php echo e($post->category->name); ?>

                    </span>
                    <span class="text-gray-300">|</span>
                <?php endif; ?>
                <time datetime="<?php echo e($post->published_at?->toIso8601String()); ?>" 
                      class="text-gray-400 font-medium uppercase tracking-wide">
                    <?php echo e($post->published_at?->format('M d, Y') ?? 'Draft'); ?>

                </time>
            </div>
            
            
            <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-emerald-600 transition-colors duration-200 leading-snug">
                <?php echo e($post->title); ?>

            </h3>
            
            
            <?php if($post->excerpt): ?>
                <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed flex-1">
                    <?php echo e(Str::limit($post->excerpt, 120)); ?>

                </p>
            <?php endif; ?>
        </div>
    </a>
</article>
<?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/components/post-card-horizontal.blade.php ENDPATH**/ ?>