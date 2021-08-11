<form class="px-3" method="post" action="<?php echo e(route('store_lang_workspace')); ?>">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="col-md-12">
            <label for="code" class="form-control-label"><?php echo e(__('Language Code')); ?></label>
            <input class="form-control" type="text" id="code" name="code" required="" placeholder="<?php echo e(__('Language Code')); ?>">
        </div>
        <div class="col-md-12">
            <input type="submit" value="<?php echo e(__('Save')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/lang/create.blade.php ENDPATH**/ ?>