<form class="px-3" method="post" action="<?php echo e(route('projects.share',[$currentWorkspace->slug,$project->id])); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group col-md-12 mb-0">
        <label for="users_list"><?php echo e(__('Clients')); ?></label>
        <select class="select2 form-control select2-multiple" data-toggle="select2" required name="clients[]" multiple="multiple" data-placeholder="<?php echo e(__('Select Clients ...')); ?>">
            <?php $__currentLoopData = $currentWorkspace->clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($client->pivot->is_active): ?>
                    <option value="<?php echo e($client->id); ?>"><?php echo e($client->name); ?> - <?php echo e($client->email); ?></option>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="form-group col-md-12">
        <input type="submit" value="<?php echo e(__('Share To Clients')); ?>" class="btn-create badge-blue">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/projects/share.blade.php ENDPATH**/ ?>