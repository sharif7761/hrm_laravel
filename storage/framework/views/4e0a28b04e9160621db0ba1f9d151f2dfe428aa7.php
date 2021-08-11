<?php $__env->startComponent('mail::message'); ?>
#  <?php echo e(__('Hello')); ?>, <?php echo e($client->name); ?>


<?php echo e(__('You are invited into new project')); ?> <b> <?php echo e($project->name); ?></b> <?php echo e(__('by')); ?> <?php echo e($project->creater->name); ?>


<?php $__env->startComponent('mail::button', ['url' => route('client.projects.show',[$project->workspaceData->slug,$project->id])]); ?>])
<?php echo e(__('Open Project')); ?>

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
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/email/share.blade.php ENDPATH**/ ?>