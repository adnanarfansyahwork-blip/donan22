
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 px-5 py-4">
        <h3 class="text-white font-bold text-center text-lg">
            <?php echo e($title ?? 'Kategori Software'); ?>

        </h3>
    </div>
    
    
    <div class="p-5">
        <div class="grid grid-cols-2 gap-x-4 gap-y-3">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('categories.show', $category->slug)); ?>" 
                   class="flex items-center gap-3 py-2 group">
                    
                    <?php if($category->image): ?>
                        <img src="<?php echo e(asset('storage/' . $category->image)); ?>" 
                             alt="<?php echo e($category->name); ?>" 
                             class="w-7 h-7 object-contain flex-shrink-0">
                    <?php elseif($category->icon): ?>
                        <span class="w-7 h-7 flex items-center justify-center text-lg flex-shrink-0 text-blue-500">
                            <i class="bi <?php echo e($category->icon); ?>"></i>
                        </span>
                    <?php else: ?>
                        <span class="w-7 h-7 flex items-center justify-center text-lg flex-shrink-0 text-gray-400">
                            <i class="bi bi-folder"></i>
                        </span>
                    <?php endif; ?>
                    
                    
                    <span class="text-sm text-blue-600 font-medium group-hover:text-blue-800 group-hover:underline transition-colors truncate">
                        <?php echo e($category->name); ?>

                    </span>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        
        <?php if(isset($showViewAll) && $showViewAll): ?>
            <div class="mt-5 pt-4 border-t border-gray-100 text-center">
                <a href="<?php echo e(route('categories.index')); ?>" 
                   class="inline-flex items-center gap-2 text-sm font-semibold text-emerald-600 hover:text-emerald-700 transition-colors">
                    Lihat Semua Kategori
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/components/category-sidebar.blade.php ENDPATH**/ ?>