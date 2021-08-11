<?php $__env->startComponent('mail::message'); ?>
# <?php echo e(__('Hello')); ?>, <?php echo e($user->name != 'No Name' ? $user->name : ''); ?>


<?php echo e(__('You are invited into new Workspace')); ?> <b> <?php echo e($workspace->name); ?></b> <?php echo e(__('by')); ?> <?php echo e($workspace->creater->name); ?>


<?php $__env->startComponent('mail::button', ['url' => route('home',[$workspace->slug])]); ?>
    <?php echo e(__('Open Workspace')); ?>

<?php if (isset($__componentOriginalb8f5c8a6ad1b73985c32a4b97acff83989288b9e)): ?>
<?php $component = $__componentOriginalb8f5c8a6ad1b73985c32a4b97acff83989288b9e; ?>
<?php unset($__componentOriginalb8f5c8a6ad1b73985c32a4b97acff83989288b9e); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>

<?php echo e(__('Thanks')); ?>,<br>
<?php echo e(config('app.name')); ?>

<?php if (isset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d)): ?>
<?php $component = $__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d; ?>
<?php unset($__componentOriginal2dab26517731ed1416679a121374450d5cff5e0d); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/email/workspace_invitation.blade.php ENDPATH**/ ?>