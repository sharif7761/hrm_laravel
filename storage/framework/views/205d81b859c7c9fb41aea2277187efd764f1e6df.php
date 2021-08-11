<form class="px-3" method="post" action="<?php echo e(route('projects.store',$currentWorkspace->slug)); ?>">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="projectname" class="form-control-label"><?php echo e(__('Name')); ?></label>
            <input class="form-control" type="text" id="projectname" name="name" required="" placeholder="<?php echo e(__('Project Name')); ?>">
        </div>
        <div class="form-group col-md-12">
            <label for="description" class="form-control-label"><?php echo e(__('Description')); ?></label>
            <textarea class="form-control" id="description" name="description" required="" placeholder="<?php echo e(__('Add Description')); ?>"></textarea>
        </div>
        <div class="col-md-12">
            <label for="users_list"><?php echo e(__('Users')); ?></label>
            <select class="select2 select2-multiple" id="users_list" name="users_list[]" data-toggle="select2" multiple="multiple" data-placeholder="<?php echo e(__('Select Users ...')); ?>">
                <?php $__currentLoopData = $currentWorkspace->users($currentWorkspace->created_by); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($user->email); ?>"><?php echo e($user->name); ?> - <?php echo e($user->email); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div class="col-md-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/projects/create.blade.php ENDPATH**/ ?>