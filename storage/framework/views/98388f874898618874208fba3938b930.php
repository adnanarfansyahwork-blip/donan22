

<?php $__env->startSection('title', 'Manage Subscribers'); ?>
<?php $__env->startSection('page-title', 'Newsletter Subscribers'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Subscribers</p>
                    <p class="text-2xl font-bold text-gray-900"><?php echo e(number_format($stats['total'])); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Active</p>
                    <p class="text-2xl font-bold text-green-600"><?php echo e(number_format($stats['active'])); ?></p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Unsubscribed</p>
                    <p class="text-2xl font-bold text-red-600"><?php echo e(number_format($stats['unsubscribed'])); ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <form action="<?php echo e(route('admin.subscribers.index')); ?>" method="GET" class="flex flex-col sm:flex-row gap-4">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
                       placeholder="Search by email..."
                       class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                
                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                    <option value="unsubscribed" <?php echo e(request('status') === 'unsubscribed' ? 'selected' : ''); ?>>Unsubscribed</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors">
                    Filter
                </button>
            </form>

            <div class="flex gap-2">
                <a href="<?php echo e(route('admin.subscribers.broadcast')); ?>" 
                   class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                    Broadcast
                </a>
                <a href="<?php echo e(route('admin.subscribers.export', ['status' => 'active'])); ?>" 
                   class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export CSV
                </a>
            </div>
        </div>
    </div>

    <!-- Subscribers Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <form id="bulk-form" action="<?php echo e(route('admin.subscribers.bulk-delete')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" id="select-all" class="rounded border-gray-300">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subscribed At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__empty_1 = true; $__currentLoopData = $subscribers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscriber): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="ids[]" value="<?php echo e($subscriber->id); ?>" class="subscriber-checkbox rounded border-gray-300">
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm font-medium text-gray-900"><?php echo e($subscriber->email); ?></span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if($subscriber->status === 'active'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                                    <?php elseif($subscriber->status === 'pending'): ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Unsubscribed</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo e($subscriber->subscribed_at?->format('M d, Y H:i') ?? '-'); ?>

                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <?php echo e($subscriber->ip_address ?? '-'); ?>

                                </td>
                                <td class="px-6 py-4 text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <form action="<?php echo e(route('admin.subscribers.toggle-status', $subscriber)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="text-blue-600 hover:text-blue-900" title="<?php echo e($subscriber->status === 'active' ? 'Deactivate' : 'Activate'); ?>">
                                                <?php if($subscriber->status === 'active'): ?>
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                    </svg>
                                                <?php else: ?>
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                <?php endif; ?>
                                            </button>
                                        </form>

                                        <form action="<?php echo e(route('admin.subscribers.destroy', $subscriber)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this subscriber?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mt-4 text-lg font-medium">No subscribers yet</p>
                                    <p class="mt-1">Subscribers will appear here when people sign up for your newsletter.</p>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($subscribers->count() > 0): ?>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <button type="submit" onclick="return confirm('Are you sure you want to delete selected subscribers?')" 
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50" 
                                id="bulk-delete-btn" disabled>
                            Delete Selected
                        </button>
                        <div>
                            <?php echo e($subscribers->appends(request()->query())->links()); ?>

                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Select all functionality
    document.getElementById('select-all')?.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.subscriber-checkbox');
        checkboxes.forEach(cb => cb.checked = this.checked);
        updateBulkDeleteButton();
    });

    // Individual checkbox change
    document.querySelectorAll('.subscriber-checkbox').forEach(cb => {
        cb.addEventListener('change', updateBulkDeleteButton);
    });

    function updateBulkDeleteButton() {
        const checked = document.querySelectorAll('.subscriber-checkbox:checked').length;
        const btn = document.getElementById('bulk-delete-btn');
        if (btn) {
            btn.disabled = checked === 0;
            btn.textContent = checked > 0 ? `Delete Selected (${checked})` : 'Delete Selected';
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/admin/subscribers/index.blade.php ENDPATH**/ ?>