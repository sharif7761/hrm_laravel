<form method="post" action="<?php echo e(route('invoice.item.store',[$currentWorkspace->slug,$invoice->id])); ?>">
    <?php echo csrf_field(); ?>
    <div class="col-md-12">
        <label for="task" class="form-control-label"><?php echo e(__('Tasks')); ?></label>
        <select class="form-control select2" name="task" id="task" required>
            <option value=""><?php echo e(__('Select Task')); ?></option>
            <?php $__currentLoopData = $invoice->project->tasks(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($task->id); ?>"><?php echo e($task->title); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-md-12">
        <label for="price" class="form-control-label"><?php echo e(__('Price')); ?></label>
        <div class="form-icon-user">
            <span class="currency-icon"><?php echo e((!empty($currentWorkspace->currency)) ? $currentWorkspace->currency : '$'); ?></span>
            <input class="form-control" type="number" min="0" value="0" id="price" name="price" required>
        </div>
    </div>
    <div class="col-md-12">
        <input type="submit" class="btn-create badge-blue" value="<?php echo e(__('Add')); ?>">
        <input type="button" class="btn-create bg-gray" data-dismiss="modal" value="<?php echo e(__('Cancel')); ?>">
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/invoices/create_item.blade.php ENDPATH**/ ?>