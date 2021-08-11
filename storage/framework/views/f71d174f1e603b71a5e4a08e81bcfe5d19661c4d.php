<?php if($currentWorkspace && $task): ?>

    <div class="p-2">
        <div class="form-control-label"><?php echo e(__('Description')); ?>:</div>

        <p class="text-muted mb-4">
            <?php echo e($task->description); ?>

        </p>

        <div class="row mb-4">
            <div class="col-md-3">
                <div class="form-control-label"><?php echo e(__('Create Date')); ?></div>
                <p class="mt-1"><?php echo e(\App\Utility::dateFormat($task->created_at)); ?></p>
            </div>
            <div class="col-md-3">
                <div class="form-control-label"><?php echo e(__('Due Date')); ?></div>
                <p class="mt-1"><?php echo e(\App\Utility::dateFormat($task->due_date)); ?></p>
            </div>
            <div class="col-md-3">
                <div class="form-control-label"><?php echo e(__('Assigned')); ?></div>
                <?php if($users = $task->users()): ?>
                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img <?php if($user->avatar): ?> src="<?php echo e(asset('/storage/avatars/'.$user->avatar)); ?>" <?php else: ?> avatar="<?php echo e($user->name); ?>" <?php endif; ?> class="rounded-circle mt-1 w-20">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
                <div class="form-control-label"><?php echo e(__('Milestone')); ?></div>
                <?php ($milestone = $task->milestone()); ?>
                <p class="mt-1"><?php if($milestone): ?> <?php echo e($milestone->title); ?> <?php endif; ?></p>
            </div>
        </div>
    </div>

    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
        <li>
            <a class=" active" id="comments-tab" data-toggle="tab" href="#comments-data" role="tab" aria-controls="home" aria-selected="false"> <?php echo e(__('Comments')); ?> </a>
        </li>
        <li class="annual-billing">
            <a id="file-tab" data-toggle="tab" href="#file-data" role="tab" aria-controls="profile" aria-selected="false"> <?php echo e(__('Files')); ?> </a>
        </li>
        <li class="annual-billing">
            <a id="sub-task-tab" data-toggle="tab" href="#sub-task-data" role="tab" aria-controls="contact" aria-selected="true"> <?php echo e(__('Sub Task')); ?> </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade active show" id="comments-data" role="tabpanel" aria-labelledby="home-tab">
            <form method="post" id="form-comment" data-action="<?php echo e(route('comment.store',[$currentWorkspace->slug,$task->project_id,$task->id,$clientID])); ?>">
                <textarea class="form-control form-control-light mb-2" name="comment" placeholder="<?php echo e(__('Write message')); ?>" id="example-textarea" rows="3" required></textarea>
                <div class="text-right">
                    <div class="btn-group mb-2 ml-2 d-sm-inline-block">
                        <button type="button" class="btn-create badge-blue"><?php echo e(__('Submit')); ?></button>
                    </div>
                </div>
            </form>
            <ul class="list-unstyled list-unstyled-border mt-3" id="task-comments">
                <?php $__currentLoopData = $task->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="media border-bottom mb-3">
                        <img class="mr-3 avatar-sm rounded-circle img-thumbnail" width="60"
                             <?php if($comment->user_type != 'Client'): ?> <?php if($comment->user->avatar): ?> src="<?php echo e(asset('/storage/avatars/'.$comment->user->avatar)); ?>" <?php else: ?> avatar="<?php echo e($comment->user->name); ?>" <?php endif; ?> alt="<?php echo e($comment->user->name); ?>"
                             <?php else: ?> avatar="<?php echo e($comment->client->name); ?>" alt="<?php echo e($comment->client->name); ?>" <?php endif; ?> />
                        <div class="media-body mb-2">
                            <div class="float-left">
                                <h5 class="mt-0 mb-1 form-control-label"><?php if($comment->user_type!='Client'): ?><?php echo e($comment->user->name); ?><?php else: ?> <?php echo e($comment->client->name); ?> <?php endif; ?></h5>
                                <?php echo e($comment->comment); ?>

                            </div>
                            <?php if(auth()->guard('web')->check()): ?>
                                <div class="float-right">
                                    <a href="#" class="delete-icon delete-comment" data-url="<?php echo e(route('comment.destroy',[$currentWorkspace->slug,$task->project_id,$task->id,$comment->id])); ?>">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <div class="tab-pane fade" id="file-data" role="tabpanel" aria-labelledby="profile-tab">
            <div class="form-group m-0">
                <form method="post" id="form-file" enctype="multipart/form-data" data-url="<?php echo e(route('comment.store.file',[$currentWorkspace->slug,$task->project_id,$task->id,$clientID])); ?>">
                    <div class="choose-file form-group">
                        <label for="file" class="form-control-label">
                            <div><?php echo e(__('Choose file here')); ?></div>
                            <input type="file" class="form-control" name="file" id="file" data-filename="file_create">
                            <span class="invalid-feedback" id="file-error" role="alert">
                                <strong></strong>
                            </span>
                        </label>
                        <p class="file_create"></p>
                    </div>
                    <div class="text-right">
                        <div class="btn-group mb-2 ml-2 d-none d-sm-inline-block">
                            <button type="submit" class="btn-create badge-blue"><?php echo e(__('Upload')); ?></button>
                        </div>
                    </div>
                </form>
            </div>

            <div id="comments-file" class="mt-3">
                <?php $__currentLoopData = $task->taskFiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="card pb-0 mb-1 shadow-none border">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-sm">
                                        <span class="avatar-title rounded text-uppercase">
                                            <?php echo e($file->extension); ?>

                                        </span>
                                    </div>
                                </div>
                                <div class="col pl-0">
                                    <a href="#" class="text-muted form-control-label"><?php echo e($file->name); ?></a>
                                    <p class="mb-0"><?php echo e($file->file_size); ?></p>
                                </div>
                                <div class="col-auto">
                                    <!-- Button -->
                                    <a download href="<?php echo e(asset('/storage/tasks/'.$file->file)); ?>" class="edit-icon">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <?php if(auth()->guard('web')->check()): ?>
                                        <a href="#" class="delete-icon delete-comment-file" data-url="<?php echo e(route('comment.destroy.file',[$currentWorkspace->slug,$task->project_id,$task->id,$file->id])); ?>">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="tab-pane fade mt-3" id="sub-task-data" role="tabpanel" aria-labelledby="contact-tab">

            <div class="text-right mb-3">
                <a href="#" class="btn-create badge-blue" data-toggle="collapse" data-target="#form-subtask"><?php echo e(__('Add Sub Task')); ?></a>
            </div>
            <form method="post" id="form-subtask" class="collapse" data-action="<?php echo e(route('subtask.store',[$currentWorkspace->slug,$task->project_id,$task->id,$clientID])); ?>">
                <?php echo csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label"><?php echo e(__('Name')); ?></label>
                                <input type="text" name="name" class="form-control" required placeholder="<?php echo e(__('Sub Task Name')); ?>">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-control-label"><?php echo e(__('Due Date')); ?></label>
                                <input class="form-control datepicker" type="text" id="due_date" name="due_date" autocomplete="off" required="required">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="btn-group mb-2 ml-2 d-sm-inline-block">
                            <button type="submit" class="btn-create badge-blue create-subtask"><?php echo e(__('Create')); ?></button>
                        </div>
                    </div>
                </div>
            </form>
            <ul class="list-group mt-3" id="subtasks">
                <?php $__currentLoopData = $task->sub_tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subTask): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="list-group-item py-3">
                        <div class="custom-control custom-switch float-left">
                            <input type="checkbox" class="custom-control-input" name="option" id="option<?php echo e($subTask->id); ?>" <?php if($subTask->status): ?> checked <?php endif; ?> data-url="<?php echo e(route('subtask.update',[$currentWorkspace->slug,$task->project_id,$subTask->id])); ?>">
                            <label class="custom-control-label form-control-label" for="option<?php echo e($subTask->id); ?>"><?php echo e($subTask->name); ?></label>
                        </div>
                        <div class="float-right">
                            <a href="#" class="delete-icon delete-subtask" data-url="<?php echo e(route('subtask.destroy',[$currentWorkspace->slug,$task->project_id,$subTask->id])); ?>">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>

<?php else: ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body p-4">
                <div class="page-error">
                    <div class="page-inner">
                        <h1>404</h1>
                        <div class="page-description">
                            <?php echo e(__('Page Not Found')); ?>

                        </div>
                        <div class="page-search">
                            <p class="text-muted mt-3"><?php echo e(__("It's looking like you may have taken a wrong turn. Don't worry... it happens to the best of us. Here's a little tip that might help you get back on track.")); ?></p>
                            <div class="mt-3">
                                <a class="btn-return-home badge-blue" href="<?php echo e(route('home')); ?>"><i class="fas fa-reply"></i> <?php echo e(__('Return Home')); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/projects/taskShow.blade.php ENDPATH**/ ?>