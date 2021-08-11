<form class="px-3" method="post" action="<?php echo e(route('clients.store',$currentWorkspace->slug)); ?>">
    <?php echo csrf_field(); ?>
    <div class="row">
        <div class="form-group col-md-12">
            <label for="name" class="form-control-label"><?php echo e(__('Name')); ?></label>
            <input class="form-control" type="text" id="name" name="name" required="" placeholder="<?php echo e(__('Enter Name')); ?>">
        </div>
        <div class="form-group col-md-12">
            <label for="email" class="form-control-label"><?php echo e(__('Email')); ?></label>
            <input class="form-control" type="email" id="email" name="email" required="" placeholder="<?php echo e(__('Enter Email')); ?>">
        </div>
        <div class="form-group col-md-12">
            <label for="password" class="form-control-label"><?php echo e(__('Password')); ?></label>
            <input class="form-control" type="text" id="password" name="password" required="" placeholder="<?php echo e(__('Enter Password')); ?>">
        </div>
        <div class="col-md-12">
            <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
            <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
        </div>
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/clients/create.blade.php ENDPATH**/ ?>