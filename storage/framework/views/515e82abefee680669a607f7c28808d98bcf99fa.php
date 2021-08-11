<form class="px-3" method="post" action="<?php echo e(route('users.update',[$currentWorkspace->slug,$user->id])); ?>">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-md-12">
            <label for="name" class="form-control-label"><?php echo e(__('Name')); ?></label>
            <input type="text" class="form-control" id="name" name="name" value="<?php echo e($user->name); ?>"/>
        </div>
        <div class="col-md-12">
            <input type="submit" value="<?php echo e(__('Save')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/users/edit.blade.php ENDPATH**/ ?>