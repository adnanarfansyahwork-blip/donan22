<?php $__env->startSection('title', 'Edit Post: ' . $post->title); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.posts._form', ['post' => $post], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u828471719/domains/donan22.com/public_html/resources/views/admin/posts/edit.blade.php ENDPATH**/ ?>