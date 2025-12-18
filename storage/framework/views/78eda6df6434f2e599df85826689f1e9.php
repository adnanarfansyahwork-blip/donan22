

<?php $__env->startSection('title', 'Posts'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Posts</h1>
            <p class="text-gray-600 mt-1">Kelola semua post Anda</p>
        </div>
        <a href="<?php echo e(route('admin.posts.create')); ?>" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
            <i class="bi bi-plus-lg mr-2"></i>
            Buat Post Baru
        </a>
    </div>
</div>

<!-- Flash Messages -->
<?php if(session('success')): ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg flex items-center">
        <i class="bi bi-check-circle mr-2"></i>
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg flex items-center">
        <i class="bi bi-exclamation-circle mr-2"></i>
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm p-4 mb-6">
    <form method="GET" action="<?php echo e(route('admin.posts.index')); ?>" class="flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
            <input type="text" 
                   name="search" 
                   value="<?php echo e(request('search')); ?>" 
                   placeholder="Cari judul post..." 
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        
        <div class="w-40">
            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Status</option>
                <?php $__currentLoopData = \App\Models\Post::getStatuses(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>" <?php echo e(request('status') === $value ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        <div class="w-40">
            <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
            <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Tipe</option>
                <?php $__currentLoopData = $postTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($type->slug); ?>" <?php echo e(request('type') === $type->slug ? 'selected' : ''); ?>>
                        <?php echo e($type->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="w-40">
            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
            <select name="category" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Semua Kategori</option>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                <i class="bi bi-search mr-1"></i> Filter
            </button>
            <?php if(request()->hasAny(['search', 'status', 'type', 'category'])): ?>
                <a href="<?php echo e(route('admin.posts.index')); ?>" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                    <i class="bi bi-x-lg"></i>
                </a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Posts Table -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Post</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tipe</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Statistik</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-14 h-14 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                    <img src="<?php echo e($post->featured_image_url); ?>" 
                                         alt="<?php echo e($post->title); ?>"
                                         class="w-14 h-14 object-cover"
                                         onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'w-14 h-14 flex items-center justify-center bg-gray-100\'><i class=\'bi bi-image text-gray-400 text-xl\'></i></div>';">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <a href="<?php echo e(route('admin.posts.edit', $post)); ?>" 
                                       class="font-medium text-gray-900 hover:text-blue-600 line-clamp-1 transition-colors">
                                        <?php echo e($post->title); ?>

                                    </a>
                                    <p class="text-sm text-gray-500 mt-0.5">
                                        oleh <?php echo e($post->user->name ?? 'Unknown'); ?>

                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-gray-600">
                                <?php echo e($post->category->name ?? '-'); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?php if($post->postType): ?>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                    <?php echo e($post->postType->name); ?>

                                </span>
                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo e($post->status_badge_class); ?>">
                                <?php echo e($post->status_label); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3 text-sm text-gray-500">
                                <span title="Views">
                                    <i class="bi bi-eye"></i> <?php echo e(number_format($post->views_count)); ?>

                                </span>
                                <span title="Downloads">
                                    <i class="bi bi-download"></i> <?php echo e(number_format($post->downloads_count)); ?>

                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500">
                                <?php echo e($post->created_at->format('d M Y')); ?>

                            </div>
                            <div class="text-xs text-gray-400">
                                <?php echo e($post->created_at->format('H:i')); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end space-x-1">
                                <?php if($post->status === 'published'): ?>
                                    <a href="<?php echo e($post->url); ?>" 
                                       target="_blank" 
                                       class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-colors"
                                       title="Lihat Post">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="<?php echo e(route('admin.posts.edit', $post)); ?>" 
                                   class="p-2 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition-colors"
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="<?php echo e(route('admin.posts.destroy', $post)); ?>" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus post ini?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            class="p-2 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition-colors"
                                            title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <i class="bi bi-inbox text-5xl text-gray-300"></i>
                                <p class="mt-4 text-gray-500">Belum ada post</p>
                                <a href="<?php echo e(route('admin.posts.create')); ?>" 
                                   class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">
                                    <i class="bi bi-plus-lg mr-2"></i>
                                    Buat Post Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <?php if($posts->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200">
            <?php echo e($posts->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Stats Summary -->
<div class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <div class="text-2xl font-bold text-gray-900"><?php echo e(\App\Models\Post::count()); ?></div>
        <div class="text-sm text-gray-500">Total Posts</div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <div class="text-2xl font-bold text-green-600"><?php echo e(\App\Models\Post::published()->count()); ?></div>
        <div class="text-sm text-gray-500">Published</div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <div class="text-2xl font-bold text-yellow-600"><?php echo e(\App\Models\Post::draft()->count()); ?></div>
        <div class="text-sm text-gray-500">Drafts</div>
    </div>
    <div class="bg-white rounded-lg p-4 shadow-sm">
        <div class="text-2xl font-bold text-blue-600"><?php echo e(\App\Models\Post::scheduled()->count()); ?></div>
        <div class="text-sm text-gray-500">Scheduled</div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/admin/posts/index.blade.php ENDPATH**/ ?>