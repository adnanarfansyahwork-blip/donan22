

<?php $__env->startSection('title', 'Administrators'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Administrators</h1>
        <p class="text-gray-700 mt-1">Manage administrators</p>
    </div>
    <a href="<?php echo e(route('admin.users.create')); ?>" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white rounded-lg font-medium">
        <i class="bi bi-plus mr-1"></i> New Admin
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">User</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Login</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y">
            <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <img src="<?php echo e($user->avatar_url); ?>" class="w-10 h-10 rounded-full">
                            <div>
                                <div class="font-medium text-gray-900"><?php echo e($user->username); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($user->email); ?></div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs bg-<?php echo e($user->role === 'super_admin' ? 'purple' : ($user->role === 'admin' ? 'blue' : 'gray')); ?>-100 text-<?php echo e($user->role === 'super_admin' ? 'purple' : ($user->role === 'admin' ? 'blue' : 'gray')); ?>-700 px-2 py-1 rounded">
                            <?php echo e(ucfirst(str_replace('_', ' ', $user->role))); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <?php if($user->status === 'active'): ?>
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded">Active</span>
                        <?php else: ?>
                            <span class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded"><?php echo e(ucfirst($user->status)); ?></span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">
                        <?php echo e($user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->diffForHumans() : 'Never'); ?>

                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <a href="<?php echo e(route('admin.users.edit', $user)); ?>" class="p-2 text-gray-400 hover:text-primary-600" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <?php if($user->id !== ($currentAdmin->id ?? 0)): ?>
                                <form action="<?php echo e(route('admin.users.destroy', $user)); ?>" method="POST" onsubmit="return confirm('Delete this administrator?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="p-2 text-gray-400 hover:text-red-600" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <i class="bi bi-people text-4xl"></i>
                        <p class="mt-2">No administrators found</p>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <?php if($users->hasPages()): ?>
        <div class="px-6 py-4 border-t">
            <?php echo e($users->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/admin/users/index.blade.php ENDPATH**/ ?>