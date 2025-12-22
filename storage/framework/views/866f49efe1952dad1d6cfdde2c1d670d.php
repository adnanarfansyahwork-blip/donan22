<?php $__env->startSection('title', 'Tags'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Tags</h1>
        <p class="text-gray-700 mt-1">Manage post tags for better organization</p>
    </div>
    <button onclick="openModal()" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium">
        <i class="bi bi-plus mr-1"></i> New Tag
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <!-- Quick Stats -->
    <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
        <span class="text-sm text-gray-600">Total: <strong><?php echo e($tags->total()); ?></strong> tags</span>
        <div class="flex items-center space-x-2 text-sm text-gray-500">
            <i class="bi bi-info-circle"></i>
            <span>Tags help users find related content</span>
        </div>
    </div>

    <!-- Tags Grid -->
    <div class="p-6">
        <?php if($tags->count() > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php $__currentLoopData = $tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border rounded-lg p-4 hover:shadow-md transition-shadow bg-white group">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <?php if($tag->color): ?>
                                        <span class="w-3 h-3 rounded-full" data-color="<?php echo e($tag->color); ?>"></span>
                                    <?php else: ?>
                                        <span class="w-3 h-3 rounded-full bg-gray-300"></span>
                                    <?php endif; ?>
                                    <h3 class="font-medium text-gray-900 truncate"><?php echo e($tag->name); ?></h3>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    <?php echo e($tag->posts_count); ?> <?php echo e(Str::plural('post', $tag->posts_count)); ?>

                                </p>
                                <?php if($tag->description): ?>
                                    <p class="text-xs text-gray-400 mt-1 truncate"><?php echo e($tag->description); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button type="button" class="edit-btn p-1.5 text-gray-400 hover:text-primary-600 rounded" title="Edit"
                                        data-id="<?php echo e($tag->id); ?>"
                                        data-name="<?php echo e($tag->name); ?>"
                                        data-description="<?php echo e($tag->description); ?>"
                                        data-color="<?php echo e($tag->color); ?>">
                                    <i class="bi bi-pencil text-sm"></i>
                                </button>
                                <form action="<?php echo e(route('admin.tags.destroy', $tag)); ?>" method="POST" class="inline" onsubmit="return confirm('Delete this tag?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 rounded" title="Delete">
                                        <i class="bi bi-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-12 text-gray-500">
                <i class="bi bi-tags text-4xl"></i>
                <p class="mt-2">No tags found</p>
                <button onclick="openModal()" class="mt-4 text-primary-600 hover:underline">Create your first tag</button>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if($tags->hasPages()): ?>
        <div class="px-6 py-4 border-t">
            <?php echo e($tags->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Modal -->
<div id="tagModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4">
        <form id="tagForm" method="POST">
            <?php echo csrf_field(); ?>
            <div id="methodField"></div>
            
            <div class="p-6 border-b">
                <h3 id="modalTitle" class="text-lg font-semibold text-gray-900">New Tag</h3>
            </div>
            
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="tagName" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                           placeholder="e.g., Windows, Android, Free">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="tagDescription" rows="2"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500"
                              placeholder="Optional description"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <div class="flex items-center space-x-3">
                        <input type="color" name="color" id="tagColor" value="#6366f1"
                               class="w-12 h-10 rounded cursor-pointer border-0">
                        <div class="flex-1">
                            <div class="flex flex-wrap gap-2">
                                <?php $__currentLoopData = ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#6366f1', '#8b5cf6', '#ec4899', '#6b7280']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <button type="button" class="color-preset w-6 h-6 rounded-full border-2 border-white shadow hover:scale-110 transition-transform"
                                            data-color="<?php echo e($color); ?>"></button>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6 border-t bg-gray-50 flex justify-end space-x-3">
                <button type="button" onclick="closeModal()" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg font-medium">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium">
                    Save
                </button>
            </div>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    const modal = document.getElementById('tagModal');
    const form = document.getElementById('tagForm');
    const methodField = document.getElementById('methodField');
    
    // Apply colors from data attributes
    document.querySelectorAll('[data-color]').forEach(el => {
        if (el.dataset.color) {
            el.style.backgroundColor = el.dataset.color;
        }
    });
    
    // Color preset click handler
    document.addEventListener('click', function(e) {
        if (e.target.closest('.color-preset')) {
            const color = e.target.closest('.color-preset').dataset.color;
            document.getElementById('tagColor').value = color;
        }
    });
    
    function openModal() {
        form.action = '<?php echo e(route("admin.tags.store")); ?>';
        methodField.innerHTML = '';
        document.getElementById('modalTitle').textContent = 'New Tag';
        document.getElementById('tagName').value = '';
        document.getElementById('tagDescription').value = '';
        document.getElementById('tagColor').value = '#6366f1';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function editTag(id, name, description, color) {
        form.action = '/admin/tags/' + id;
        methodField.innerHTML = '<?php echo method_field("PUT"); ?>';
        document.getElementById('modalTitle').textContent = 'Edit Tag';
        document.getElementById('tagName').value = name;
        document.getElementById('tagDescription').value = description || '';
        document.getElementById('tagColor').value = color || '#6366f1';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    
    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });
    
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.edit-btn');
        if (btn) {
            editTag(
                btn.dataset.id,
                btn.dataset.name,
                btn.dataset.description,
                btn.dataset.color
            );
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/admin/tags/index.blade.php ENDPATH**/ ?>