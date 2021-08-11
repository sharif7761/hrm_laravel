<form class="px-3" method="post" action="<?php echo e(route('projects.update',[$currentWorkspace->slug,$project->id])); ?>">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="projectname" class="form-control-label"><?php echo e(__('Name')); ?></label>
            <input class="form-control" type="text" id="projectname" name="name" required="" placeholder="<?php echo e(__('Project Name')); ?>" value="<?php echo e($project->name); ?>">
        </div>
        <div class="form-group col-md-12">
            <label for="description" class="form-control-label"><?php echo e(__('Description')); ?></label>
            <textarea class="form-control" id="description" name="description" required="" placeholder="<?php echo e(__('Add Description')); ?>"><?php echo e($project->description); ?></textarea>
        </div>
        <div class="form-group col-md-6">
            <label for="status" class="form-control-label"><?php echo e(__('Status')); ?></label>
            <select id="status" name="status" class="form-control select2">
                <option value="Ongoing"><?php echo e(__('Ongoing')); ?></option>
                <option value="Finished" <?php if($project->status == 'Finished'): ?> selected <?php endif; ?>><?php echo e(__('Finished')); ?></option>
                <option value="OnHold" <?php if($project->status == 'OnHold'): ?> selected <?php endif; ?>><?php echo e(__('OnHold')); ?></option>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="budget" class="form-control-label"><?php echo e(__('Budget')); ?></label>
            <div class="form-icon-user">
                <span class="currency-icon"><?php echo e((!empty($currentWorkspace->currency)) ? $currentWorkspace->currency : '$'); ?></span>
                <input class="form-control" type="number" min="0" id="budget" name="budget" value="<?php echo e($project->budget); ?>" placeholder="<?php echo e(__('Project Budget')); ?>">
            </div>
        </div>
        <div class="form-group col-md-6">
            <label for="start_date" class="form-control-label"><?php echo e(__('Start Date')); ?></label>
            <input class="form-control datepicker" type="text" id="start_date" name="start_date" value="<?php echo e($project->start_date); ?>" autocomplete="off" required="required">
        </div>
        <div class="form-group col-md-6">
            <label for="end_date" class="form-control-label"><?php echo e(__('End Date')); ?></label>
            <input class="form-control datepicker" type="text" id="end_date" name="end_date" value="<?php echo e($project->end_date); ?>" autocomplete="off" required="required">
        </div>
        <div class="col-md-12">
            <input type="submit" class="btn-create badge-blue" value="<?php echo e(__('Save')); ?>">
            <input type="button" class="btn-create bg-gray" data-dismiss="modal" value="<?php echo e(__('Cancel')); ?>">
        </div>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/projects/edit.blade.php ENDPATH**/ ?>