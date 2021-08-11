<form class="px-3" method="post" action="<?php echo e(route('invoices.update',[$currentWorkspace->slug,$invoice->id])); ?>">
    <?php echo csrf_field(); ?>
    <?php echo e(method_field('PUT')); ?>

    <div class="row">
        <div class="form-group col-md-6">
            <label for="status" class="form-control-label"><?php echo e($currentWorkspace->slug,$invoice->id); ?></label>
            <select class="form-control select2" name="status" id="status">
                <option value="sent" <?php if($invoice->status == 'sent'): ?> selected <?php endif; ?>><?php echo e(__('Sent')); ?></option>
                <option value="paid" <?php if($invoice->status == 'paid'): ?> selected <?php endif; ?>><?php echo e(__('Paid')); ?></option>
                <option value="canceled" <?php if($invoice->status == 'canceled'): ?> selected <?php endif; ?>><?php echo e(__('Canceled')); ?></option>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="discount" class="form-control-label"><?php echo e(__('Discount')); ?></label>
            <div class="form-icon-user">
                <span class="currency-icon"><?php echo e((!empty($currentWorkspace->currency)) ? $currentWorkspace->currency : '$'); ?></span>
                <input class="form-control" type="number" min="0" id="discount" name="discount" value="<?php echo e($invoice->discount); ?>" placeholder="<?php echo e(__('Enter Discount')); ?>">
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="issue_date" class="form-control-label"><?php echo e(__('Issue Date')); ?></label>
            <input class="form-control datepicker" type="text" id="issue_date" name="issue_date" value="<?php echo e($invoice->issue_date); ?>" autocomplete="off" required="required">
        </div>
        <div class="form-group col-md-6">
            <label for="due_date" class="form-control-label"><?php echo e(__('Due Date')); ?></label>
            <input class="form-control datepicker" type="text" id="due_date" name="due_date" value="<?php echo e($invoice->due_date); ?>" autocomplete="off" required="required">
        </div>
        <div class="form-group col-md-6">
            <label for="tax_id" class="form-control-label"><?php echo e(__('Tax')); ?>%</label>
            <select class="form-control select2" name="tax_id" id="tax_id">
                <option value=""><?php echo e(__('Select Tax')); ?></option>
                <?php $__currentLoopData = $taxes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p->id); ?>" <?php if($invoice->tax_id == $p->id): ?> selected <?php endif; ?>><?php echo e($p->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="client_id" class="form-control-label"><?php echo e(__('Client')); ?></label>
            <select class="form-control select2" name="client_id" id="client_id">
                <option value=""><?php echo e(__('Select Client')); ?></option>
                <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p->id); ?>" <?php if($invoice->client_id == $p->id): ?> selected <?php endif; ?>><?php echo e($p->name); ?> - <?php echo e($p->email); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-12">
            <input type="submit" class="btn-create badge-blue" value="<?php echo e(__('Save')); ?>">
            <input type="button" class="btn-create bg-gray" data-dismiss="modal" value="<?php echo e(__('Cancel')); ?>">
        </div>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/invoices/edit.blade.php ENDPATH**/ ?>