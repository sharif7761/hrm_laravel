<?php $__env->startComponent('mail::message'); ?>
# <?php echo e(__('Hello')); ?>, <?php echo e($user->name); ?>


<?php echo e(__('Your login detail for')); ?> <?php echo e(config('app.name')); ?> is

<table>
    <tr>
        <td><?php echo e(__('Username')); ?></td>
        <td>:</td>
        <td><?php echo e($user->email); ?></td>
    </tr>
    <tr>
        <td><?php echo e(__('Password')); ?></td>
        <td>:</td>
        <td><?php echo e($user->password); ?></td>
    </tr>
</table>

<?php $__env->startComponent('mail::button', ['url' => route('client.login')]); ?>
    <?php echo e(__('Login')); ?>

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
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/email/login/client_detail.blade.php ENDPATH**/ ?>