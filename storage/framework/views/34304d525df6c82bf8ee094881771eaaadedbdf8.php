<?php $__env->startSection('page-title'); ?> <?php echo e(__('User Profile')); ?> <?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="section">

        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="card">
                    <div class="card-body p-4">
                        <ul class="nav nav-tabs my-4">
                            <li>
                                <a data-toggle="tab" href="#v-pills-home" class="active"><?php echo e(__('Account')); ?></a>
                            </li>
                            <li class="annual-billing">
                                <a data-toggle="tab" href="#v-pills-profile" class=""><?php echo e(__('Change Password')); ?> </a>
                            </li>
                            <?php if(auth()->guard('client')->check()): ?>
                                <li class="annual-billing">
                                    <a data-toggle="tab" href="#v-pills-billing" class=""><?php echo e(__('Billing Details')); ?> </a>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="tab-content animated" id="v-pills-tabContent">
                                    <div class="tab-pane fade active show" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                        <form method="post" action="<?php if(auth()->guard('web')->check()): ?><?php echo e(route('update.account')); ?><?php elseif(auth()->guard()->check()): ?><?php echo e(route('client.update.account')); ?><?php endif; ?>" enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <h6 class="small-title">
                                                            <?php echo e(__('Avatar')); ?>

                                                        </h6>
                                                        <img <?php if($user->avatar): ?> src="<?php echo e(asset('/storage/avatars/'.$user->avatar)); ?>" <?php else: ?> avatar="<?php echo e($user->name); ?>" <?php endif; ?> id="myAvatar" alt="user-image" class="rounded-circle img-thumbnail w-25">
                                                        <?php if($user->avatar!=''): ?>
                                                            <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete_avatar').submit();"><i class="fas fa-trash"></i></a>
                                                        <?php endif; ?>
                                                        <div class="choose-file mt-3">
                                                            <label for="avatar">
                                                                <div><?php echo e(__('Choose file here')); ?></div>
                                                                <input type="file" class="form-control" name="avatar" id="avatar" data-filename="avatar-logo">
                                                            </label>
                                                            <p class="avatar-logo"></p>
                                                            <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong><?php echo e($message); ?></strong>
                                                            </span>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>
                                                    <small class="d-inline-block mt-2"><?php echo e(__('Please upload a valid image file. Size of image should not be more than 2MB.')); ?></small>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="name" class="form-control-label"><?php echo e(__('Full Name')); ?></label>
                                                        <input class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" type="text" id="fullname" placeholder="<?php echo e(__('Enter Your Name')); ?>" value="<?php echo e($user->name); ?>" required autocomplete="name">
                                                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong><?php echo e($message); ?></strong>
                                                        </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email" class="form-control-label"><?php echo e(__('Email')); ?></label>
                                                        <input class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" type="text" id="email" placeholder="<?php echo e(__('Enter Your Email Address')); ?>" value="<?php echo e($user->email); ?>" required autocomplete="email">
                                                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong><?php echo e($message); ?></strong>
                                                        </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <div class="">
                                                        <button type="submit" class="btn-submit">
                                                            <?php echo e(__('Update')); ?>

                                                        </button>
                                                    </div>
                                                </div> <!-- end col -->
                                            </div> <!-- end row -->
                                        </form>
                                        <?php if($user->avatar!=''): ?>
                                            <form action="<?php if(auth()->guard('web')->check()): ?><?php echo e(route('delete.avatar')); ?><?php elseif(auth()->guard()->check()): ?><?php echo e(route('client.delete.avatar')); ?><?php endif; ?>" method="post" id="delete_avatar">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                        <?php endif; ?>
                                        <?php if(auth()->guard('web')->check()): ?>
                                            <a href="#" class="btn btn-xs btn-danger mt-5" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-my-account').submit();">
                                                <?php echo e(__('Delete')); ?> <?php echo e(__('My Account')); ?>

                                            </a>
                                            <form action="<?php echo e(route('delete.my.account')); ?>" method="post" id="delete-my-account">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                        <form method="post" action="<?php if(auth()->guard('web')->check()): ?><?php echo e(route('update.password')); ?><?php elseif(auth()->guard()->check()): ?><?php echo e(route('client.update.password')); ?><?php endif; ?>">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="old_password" class="form-control-label"><?php echo e(__('Old Password')); ?></label>
                                                        <input class="form-control <?php $__errorArgs = ['old_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="old_password" type="password" id="old_password" required autocomplete="old_password" placeholder="<?php echo e(__('Enter Old Password')); ?>">
                                                        <?php $__errorArgs = ['old_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password" class="form-control-label"><?php echo e(__('Password')); ?></label>
                                                        <input class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" type="password" required autocomplete="new-password" id="password" placeholder="<?php echo e(__('Enter Your Password')); ?>">
                                                        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="invalid-feedback" role="alert">
                                                        <strong><?php echo e($message); ?></strong>
                                                    </span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="password_confirmation" class="form-control-label"><?php echo e(__('Confirm Password')); ?></label>
                                                        <input class="form-control <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password_confirmation" type="password" required autocomplete="new-password" id="password_confirmation" placeholder="<?php echo e(__('Enter Your Password')); ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <button type="submit" class="btn-submit"> <?php echo e(__('Change Password')); ?> </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <?php if(auth()->guard('client')->check()): ?>
                                        <div class="tab-pane fade" id="v-pills-billing" role="tabpanel" aria-labelledby="v-pills-billing-tab">
                                            <form method="post" action="<?php echo e(route('client.update.billing')); ?>">
                                                <?php echo csrf_field(); ?>
                                                <div class="row">
                                                    <div class="form-group col-md-12">
                                                        <label for="address" class="form-control-label"><?php echo e(__('Address')); ?></label>
                                                        <input class="form-control font-style" name="address" type="text" value="<?php echo e($user->address); ?>" id="address">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="city" class="form-control-label"><?php echo e(__('City')); ?></label>
                                                        <input class="form-control font-style" name="city" type="text" value="<?php echo e($user->city); ?>" id="city">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="state" class="form-control-label"><?php echo e(__('State')); ?></label>
                                                        <input class="form-control font-style" name="state" type="text" value="<?php echo e($user->state); ?>" id="state">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="zipcode" class="form-control-label"><?php echo e(__('Zip/Post Code')); ?></label>
                                                        <input class="form-control" name="zipcode" type="text" value="<?php echo e($user->zipcode); ?>" id="zipcode">
                                                    </div>
                                                    <div class="form-group  col-md-6">
                                                        <label for="country" class="form-control-label"><?php echo e(__('Country')); ?></label>
                                                        <input class="form-control font-style" name="country" type="text" value="<?php echo e($user->country); ?>" id="country">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="telephone" class="form-control-label"><?php echo e(__('Telephone')); ?></label>
                                                        <input class="form-control" name="telephone" type="text" value="<?php echo e($user->telephone); ?>" id="telephone">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <button type="submit" class="btn-submit">
                                                            <?php echo e(__('Update')); ?>

                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/users/account.blade.php ENDPATH**/ ?>