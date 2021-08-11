<form class="px-3" method="post" action="<?php echo e(route('projects.invite.update',[$currentWorkspace->slug,$project->id])); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group col-md-12 mb-0">
        <label for="users_list"><?php echo e(__('Users')); ?></label>
        <select class="select2 form-control select2-multiple" required id="users_list" name="users_list[]" data-toggle="select2" multiple="multiple" data-placeholder="<?php echo e(__('Select Users ...')); ?>">
            <?php $__currentLoopData = $currentWorkspace->users($currentWorkspace->created_by); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($user->pivot->is_active): ?>
                    <option value="<?php echo e($user->email); ?>"><?php echo e($user->name); ?> - <?php echo e($user->email); ?></option>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-md-12">
        <input type="submit" value="<?php echo e(__('Invite Users')); ?>" class="btn-create badge-blue">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/projects/invite.blade.php ENDPATH**/ ?>