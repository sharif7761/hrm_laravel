<form method="POST" action="<?php echo e(route('users.store')); ?>">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="fullname" class="form-control-label"><?php echo e(__('Full Name')); ?></label>
        <input class="form-control" name="name" type="text" id="fullname" placeholder="<?php echo e(__('Enter Your Name')); ?>" value="<?php echo e(old('name')); ?>" required autocomplete="name">
    </div>
    <div class="form-group">
        <label for="workspace_name" class="form-control-label"><?php echo e(__('Workspace Name')); ?></label>
        <input class="form-control" name="workspace" type="text" id="workspace_name" placeholder="<?php echo e(__('Enter Workspace Name')); ?>" value="<?php echo e(old('workspace')); ?>" required autocomplete="workspace">
    </div>
    <div class="form-group">
        <label for="emailaddress" class="form-control-label"><?php echo e(__('Email Address')); ?></label>
        <input class="form-control" name="email" type="email" id="emailaddress" required autocomplete="email" placeholder="<?php echo e(__('Enter Your Email')); ?>" value="<?php echo e(old('email')); ?>">
    </div>
    <div class="form-group">
        <label for="password" class="form-control-label"><?php echo e(__('Password')); ?></label>
        <input class="form-control" name="password" type="password" required autocomplete="new-password" id="password" placeholder="<?php echo e(__('Enter Your Password')); ?>">
    </div>
    <div class="col-md-12">
        <input type="submit" value="<?php echo e(__('Create')); ?>" class="btn-create badge-blue">
        <input type="button" value="<?php echo e(__('Cancel')); ?>" class="btn-create bg-gray" data-dismiss="modal">
    </div>
</form>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/users/create.blade.php ENDPATH**/ ?>