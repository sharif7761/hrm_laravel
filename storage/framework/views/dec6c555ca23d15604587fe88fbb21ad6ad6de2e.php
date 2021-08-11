<form class="px-3" method="post" action="<?php echo e(route('tax.store',[$currentWorkspace->slug])); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="name" class="form-control-label"><?php echo e(__('Name')); ?></label>
        <input type="text" class="form-control" id="name" name="name" required/>
    </div>
    <div class="form-group">
        <label for="rate" class="form-control-label"><?php echo e(__('Rate')); ?></label>
        <input type="number" class="form-control" id="rate" name="rate" min="0" step=".01" required/>
    </div>
    <div class="form-group">
        <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/users/create_tax.blade.php ENDPATH**/ ?>