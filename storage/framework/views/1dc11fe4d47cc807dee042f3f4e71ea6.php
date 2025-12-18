

<?php $__env->startSection('title', 'Buat Post Baru'); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.posts._form', ['post' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\User\Desktop\donan22-laravel-new\resources\views/admin/posts/create.blade.php ENDPATH**/ ?>