<?php $__env->startSection('page-title'); ?> <?php echo e(__('Project Detail')); ?> <?php $__env->stopSection(); ?>

<?php
    $permissions = Auth::user()->getPermission($project->id);
    $client_keyword = Auth::user()->getGuard() == 'client' ? 'client.' : '';
?>

<?php $__env->startSection('multiple-action-button'); ?>
    <?php if((isset($permissions) && in_array('show timesheet',$permissions)) || (isset($currentWorkspace) && $currentWorkspace->permission == 'Owner')): ?>
        <a href="<?php echo e(route($client_keyword.'projects.timesheet.index',[$currentWorkspace->slug,$project->id])); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><?php echo e(__('Timesheet')); ?></a>
    <?php endif; ?>
    <?php if((isset($permissions) && in_array('show gantt',$permissions)) || (isset($currentWorkspace) && $currentWorkspace->permission == 'Owner')): ?>
        <a href="<?php echo e(route($client_keyword.'projects.gantt',[$currentWorkspace->slug,$project->id])); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><?php echo e(__('Gantt Chart')); ?></a>
    <?php endif; ?>
    <?php if((isset($permissions) && in_array('show task',$permissions)) || (isset($currentWorkspace) && $currentWorkspace->permission == 'Owner')): ?>
        <a href="<?php echo e(route($client_keyword.'projects.task.board',[$currentWorkspace->slug,$project->id])); ?>" class="btn btn-xs btn-white btn-icon-only width-auto"><?php echo e(__('Task Board')); ?></a>
    <?php endif; ?>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section class="section">
        <?php if($project && $currentWorkspace): ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card project-detail-box">
                                <div class="card-header pb-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="mb-0">
                                                <?php echo e($project->name); ?>

                                                <?php if($project->status == 'Finished'): ?>
                                                    <div class="badge badge-xs badge-success"><?php echo e(__('Finished')); ?></div>
                                                <?php elseif($project->status == 'Ongoing'): ?>
                                                    <div class="badge badge-xs badge-secondary"><?php echo e(__('Ongoing')); ?></div>
                                                <?php else: ?>
                                                    <div class="badge badge-xs badge-warning"><?php echo e(__('OnHold')); ?></div>
                                                <?php endif; ?>
                                            </h6>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <?php if(!$project->is_active): ?>
                                                <a href="#" class="delete-icon" title="<?php echo e(__('Locked')); ?>">
                                                    <i class="fas fa-lock"></i>
                                                </a>
                                            <?php else: ?>
                                                <?php if(auth()->guard('web')->check()): ?>
                                                    <?php if($currentWorkspace->permission == 'Owner'): ?>
                                                        <a href="#" class="edit-icon" data-url="<?php echo e(route('projects.edit',[$currentWorkspace->slug,$project->id])); ?>" data-ajax-popup="true" data-title="<?php echo e(__('Edit Project')); ?>">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form-<?php echo e($project->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                        <form id="delete-form-<?php echo e($project->id); ?>" action="<?php echo e(route('projects.destroy',[$currentWorkspace->slug,$project->id])); ?>" method="POST" style="display: none;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                    <?php else: ?>
                                                        <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('leave-form-<?php echo e($project->id); ?>').submit();"><i class="fas fa-sign-out"></i></a>
                                                        <form id="leave-form-<?php echo e($project->id); ?>" action="<?php echo e(route('projects.leave',[$currentWorkspace->slug,$project->id])); ?>" method="POST" style="display: none;">
                                                            <?php echo csrf_field(); ?>
                                                            <?php echo method_field('DELETE'); ?>
                                                        </form>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-4 flex-grow-1">
                                    <p class="text-sm mb-0">
                                        <?php echo e($project->description); ?>

                                    </p>
                                </div>
                                <div class="card-footer py-0">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col">
                                                    <small><?php echo e(__('Start Date')); ?>:</small>
                                                    <div class="h6 mb-0"><?php echo e(Utility::dateFormat($project->start_date)); ?></div>
                                                </div>
                                                <div class="col">
                                                    <small><?php echo e(__('Due Date')); ?>:</small>
                                                    <div class="h6 mb-0"><?php echo e(Utility::dateFormat($project->end_date)); ?></div>
                                                </div>
                                                <div class="col-auto">
                                                    <small><?php echo e(__('Total Members')); ?>:</small>
                                                    <div class="h6 mb-0"><?php echo e((int) $project->users->count() + (int) $project->clients->count()); ?></div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="text-muted mb-1"><?php echo e(__('Days left')); ?></h6>
                                            <span class="h6 font-weight-bold mb-0 "><?php echo e($daysleft); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon bg-gradient-info text-white rounded-circle icon-shape">
                                                <i class="fas fas fa-calendar-day"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="text-muted mb-1"><?php echo e(__('Budget')); ?></h6>
                                            <span class="h6 font-weight-bold mb-0 "><?php echo e((!empty($currentWorkspace->currency)) ? $currentWorkspace->currency : '$'); ?><?php echo e(number_format($project->budget)); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon bg-gradient-success text-white rounded-circle icon-shape">
                                                <i class="fas fa-money-bill-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="text-muted mb-1"><?php echo e(__('Total task')); ?></h6>
                                            <span class="h6 font-weight-bold mb-0 "><?php echo e($project->countTask()); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon bg-gradient-danger text-white rounded-circle icon-shape">
                                                <i class="fas fa-check-double"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-stats">
                                <div class="card-body p-3">
                                    <div class="row">
                                        <div class="col">
                                            <h6 class="text-muted mb-1"><?php echo e(__('Comments')); ?></h6>
                                            <span class="h6 font-weight-bold mb-0 "><?php echo e($project->countTaskComments()); ?></span>
                                        </div>
                                        <div class="col-auto">
                                            <div class="icon bg-gradient-success text-white rounded-circle icon-shape">
                                                <i class="fas fa-comments"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card ">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0"><?php echo e(__('Team Members')); ?> (<?php echo e(count($project->users)); ?>)</h6>
                                        <div class="text-right">
                                            <?php if($currentWorkspace->permission == 'Owner'): ?>
                                                <a href="#" class="btn btn-xs btn-info" data-ajax-popup="true" data-title="<?php echo e(__('Invite')); ?>" data-url="<?php echo e(route('projects.invite.popup',[$currentWorkspace->slug,$project->id])); ?>"><i class="fas fa-paper-plane"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group list-group-flush">
                                    <?php $__currentLoopData = $project->users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <a href="#" class="avatar rounded-circle">
                                                        <img <?php if($user->avatar): ?> src="<?php echo e(asset('/storage/avatars/'.$user->avatar)); ?>" <?php else: ?> avatar="<?php echo e($user->name); ?>" <?php endif; ?>>
                                                    </a>
                                                </div>
                                                <div class="col ml-n2">
                                                    <a href="#" class="d-block h6 small mb-0"><?php echo e($user->name); ?></a>
                                                    <small><?php echo e($user->email); ?> <span class="bullet"></span> <span class="text-primary "><?php echo e((int) count($project->user_done_tasks($user->id))); ?> / <?php echo e((int) count($project->user_tasks($user->id))); ?></span></small>
                                                </div>
                                                <div class="col-auto">
                                                    <?php if(auth()->guard('web')->check()): ?>
                                                        <?php if($currentWorkspace->permission == 'Owner' && $user->id != Auth::id()): ?>
                                                            <a href="#" class="edit-icon" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Edit Permission')); ?>" data-url="<?php echo e(route('projects.user.permission',[$currentWorkspace->slug,$project->id,$user->id])); ?>"><i class="fa fa-lock"></i></a>

                                                            <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-user-<?php echo e($user->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                            <form id="delete-user-<?php echo e($user->id); ?>" action="<?php echo e(route('projects.user.delete',[$currentWorkspace->slug,$project->id,$user->id])); ?>" method="POST" style="display: none;">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                            </form>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0"><?php echo e(__('Clients')); ?> (<?php echo e(count($project->clients)); ?>)</h6>
                                        <div class="text-right">
                                            <?php if($currentWorkspace->permission == 'Owner'): ?>
                                                <a href="#" class="btn btn-xs btn-info" data-ajax-popup="true" data-title="<?php echo e(__('Share to Clients')); ?>" data-url="<?php echo e(route('projects.invite.popup',[$currentWorkspace->slug,$project->id])); ?>"><i class="fas fa-share-alt"></i></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="list-group list-group-flush">
                                    <?php $__currentLoopData = $project->clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="list-group-item">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <a href="#" class="avatar rounded-circle">
                                                        <img <?php if($client->avatar): ?> src="<?php echo e(asset('/storage/avatars/'.$client->avatar)); ?>" <?php else: ?> avatar="<?php echo e($client->name); ?>" <?php endif; ?>>
                                                    </a>
                                                </div>
                                                <div class="col ml-n2">
                                                    <a href="#" class="d-block h6 small mb-0"><?php echo e($client->name); ?></a>
                                                    <small><?php echo e($client->email); ?></small>
                                                </div>
                                                <div class="col-auto">
                                                    <?php if(auth()->guard('web')->check()): ?>
                                                        <?php if($currentWorkspace->permission == 'Owner'): ?>
                                                            <a href="#" class="edit-icon" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Edit Permission')); ?>" data-url="<?php echo e(route('projects.client.permission',[$currentWorkspace->slug,$project->id,$client->id])); ?>"><i class="fa fa-lock"></i></a>
                                                            <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-client-<?php echo e($client->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                            <form id="delete-client-<?php echo e($client->id); ?>" action="<?php echo e(route('projects.client.delete',[$currentWorkspace->slug,$project->id,$client->id])); ?>" method="POST" style="display: none;">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                            </form>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">

                            <?php if((isset($permissions) && in_array('show milestone', $permissions)) || $currentWorkspace->permission == 'Owner'): ?>

                                <div class="card">
                                    <div class="card-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0"><?php echo e(__('Milestones')); ?> (<?php echo e(count($project->milestones)); ?>)</h6>
                                            <div class="text-right">
                                                <?php if((isset($permissions) && in_array('create milestone',$permissions)) || $currentWorkspace->permission == 'Owner'): ?>
                                                    <a href="#" class="btn btn-xs btn-info" data-ajax-popup="true" data-title="<?php echo e(__('Create Milestone')); ?>" data-url="<?php echo e(route($client_keyword.'projects.milestone',[$currentWorkspace->slug,$project->id])); ?>"><i class="fas fa-plus"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="list-group list-group-flush">
                                        <?php $__currentLoopData = $project->milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="list-group-item">
                                                <div class="row align-items-center">
                                                    <div class="col">
                                                        <a href="#" class="d-block font-weight-500 mb-0" data-ajax-popup="true" data-title="<?php echo e(__('Milestone Details')); ?>" data-url="<?php echo e(route($client_keyword.'projects.milestone.show',[$currentWorkspace->slug,$milestone->id])); ?>">
                                                            <?php echo e($milestone->title); ?>

                                                        </a>
                                                        <small>
                                                            <?php if($milestone->status == 'complete'): ?>
                                                                <label class="badge badge-success"><?php echo e(__('Complete')); ?></label>
                                                            <?php else: ?>
                                                                <label class="badge badge-warning"><?php echo e(__('Incomplete')); ?></label>
                                                            <?php endif; ?>
                                                        </small>
                                                    </div>
                                                    <div class="col small">
                                                        <strong><?php echo e(__('Milestone Cost')); ?>:</strong>
                                                        <?php echo e((!empty($currentWorkspace->currency)) ? $currentWorkspace->currency : '$'); ?><?php echo e($milestone->cost); ?>

                                                    </div>
                                                    <div class="col-auto">
                                                        <?php if($currentWorkspace->permission == 'Owner'): ?>
                                                            <a href="#" class="edit-icon" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Edit Milestone')); ?>" data-url="<?php echo e(route('projects.milestone.edit',[$currentWorkspace->slug,$milestone->id])); ?>"><i class="fas fa-pencil-alt"></i></a>
                                                            <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form1-<?php echo e($milestone->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                            <form id="delete-form1-<?php echo e($milestone->id); ?>" action="<?php echo e(route('projects.milestone.destroy',[$currentWorkspace->slug,$milestone->id])); ?>" method="POST" style="display: none;">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('DELETE'); ?>
                                                            </form>
                                                        <?php elseif(isset($permissions)): ?>
                                                            <?php if(in_array('edit milestone',$permissions)): ?>
                                                                <a href="#" class="edit-icon" data-ajax-popup="true" data-size="lg" data-title="<?php echo e(__('Edit Milestone')); ?>" data-url="<?php echo e(route($client_keyword.'projects.milestone.edit',[$currentWorkspace->slug,$milestone->id])); ?>"><i class="fas fa-pencil-alt"></i></a>
                                                            <?php endif; ?>
                                                            <?php if(in_array('delete milestone',$permissions)): ?>
                                                                <a href="#" class="delete-icon" data-confirm="<?php echo e(__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')); ?>" data-confirm-yes="document.getElementById('delete-form1-<?php echo e($milestone->id); ?>').submit();"><i class="fas fa-trash"></i></a>
                                                                <form id="delete-form1-<?php echo e($milestone->id); ?>" action="<?php echo e(route($client_keyword.'projects.milestone.destroy',[$currentWorkspace->slug,$milestone->id])); ?>" method="POST" style="display: none;">
                                                                    <?php echo csrf_field(); ?>
                                                                    <?php echo method_field('DELETE'); ?>
                                                                </form>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if((isset($permissions) && in_array('show uploading',$permissions)) || $currentWorkspace->permission == 'Owner' || $currentWorkspace->permission == 'Member'): ?>
                                <div class="card author-box card-primary">
                                    <div class="card-body p-4">
                                        <div class="author-box-name form-control-label mb-4">
                                            <?php echo e(__('Files')); ?>

                                        </div>
                                        <div class="col-md-12 dropzone browse-file" id="dropzonewidget">
                                            <div class="dz-message" data-dz-message>
                                        <span>
                                            <?php if(Auth::user()->getGuard() == 'client'): ?>
                                                <?php echo e(__('No files available')); ?>

                                            <?php else: ?>
                                                <?php echo e(__('Drop files here to upload')); ?>

                                            <?php endif; ?>
                                        </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card card-primary">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="float-left">
                                    <?php echo e(__('Progress')); ?>

                                    <small>(<?php echo e(__('Last Week Tasks')); ?>)</small>
                                </h6>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="line-chart-example"></div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0"><?php echo e(__('Activity')); ?></h6>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-3">
                            <div class="timeline timeline-one-side top-10-scroll" data-timeline-content="axis" data-timeline-axis-style="dashed">

                                <?php if((isset($permissions) && in_array('show activity',$permissions)) || $currentWorkspace->permission == 'Owner'): ?>
                                    <?php $__currentLoopData = $project->activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="timeline-block">
                                            <?php if($activity->log_type == 'Upload File'): ?>
                                                <span class="timeline-step timeline-step-sm bg-primary border-primary text-white"> <i class="fas fa-file"></i></span>
                                            <?php elseif($activity->log_type == 'Create Milestone'): ?>
                                                <span class="timeline-step timeline-step-sm bg-info border-info text-white"> <i class="fas fa-cubes"></i></span>
                                            <?php elseif($activity->log_type == 'Create Task'): ?>
                                                <span class="timeline-step timeline-step-sm bg-success border-success text-white"> <i class="fas fa-tasks"></i></span>
                                            <?php elseif($activity->log_type == 'Create Bug'): ?>
                                                <span class="timeline-step timeline-step-sm bg-warning border-warning text-white"> <i class="fas fa-bug"></i></span>
                                            <?php elseif($activity->log_type == 'Move' || $activity->log_type == 'Move Bug'): ?>
                                                <span class="timeline-step timeline-step-sm bg-danger border-danger text-white"> <i class="fas fa-align-justify"></i></span>
                                            <?php elseif($activity->log_type == 'Create Invoice'): ?>
                                                <span class="timeline-step timeline-step-sm bg-dark border-bg-dark text-white"> <i class="fas fa-file-invoice"></i></span>
                                            <?php elseif($activity->log_type == 'Invite User'): ?>
                                                <span class="timeline-step timeline-step-sm bg-success border-success text-white"> <i class="fas fa-plus"></i></span>
                                            <?php elseif($activity->log_type == 'Share with Client'): ?>
                                                <span class="timeline-step timeline-step-sm bg-info border-info text-white"> <i class="fas fa-share"></i></span>
                                            <?php elseif($activity->log_type == 'Create Timesheet'): ?>
                                                <span class="timeline-step timeline-step-sm bg-success border-success text-white"> <i class="fas fa-clock-o"></i></span>
                                            <?php endif; ?>
                                            <div class="timeline-content">
                                                <span class="text-muted text-sm"><?php echo e($activity->log_type); ?></span>
                                                <a href="#" class="d-block h6 text-sm mb-0"><?php echo $activity->getRemark(); ?></a>
                                                <small><i class="fas fa-clock mr-1"></i><?php echo e($activity->created_at->diffForHumans()); ?></small>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
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
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css-page'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/dropzone.min.css')); ?>">
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            if ($(".top-10-scroll").length) {
                $(".top-10-scroll").css({
                    "max-height": 630
                }).niceScroll();
            }
        });
        var taskAreaOptions = {
            series: [
                    <?php $__currentLoopData = $chartData['stages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                {
                    name: "<?php echo e(__($name)); ?>",
                    data: <?php echo json_encode($chartData[$id]); ?>

                },
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            ],
            chart: {
                height: 350,
                type: 'line',
                dropShadow: {
                    enabled: true,
                    color: '#000',
                    top: 18,
                    left: 7,
                    blur: 10,
                    opacity: 0.2
                },
                toolbar: {
                    show: false
                }
            },
            colors: <?php echo json_encode($chartData['color']); ?>,
            dataLabels: {
                enabled: true,
            },
            stroke: {
                curve: 'smooth'
            },
            title: {
                text: '',
                align: 'left'
            },
            grid: {
                borderColor: '#e7e7e7',
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            markers: {
                size: 1
            },
            xaxis: {
                categories: <?php echo json_encode($chartData['label']); ?>,
                title: {
                    text: '<?php echo e(__("Days")); ?>'
                }
            },
            yaxis: {
                title: {
                    text: '<?php echo e(__("Tasks")); ?>'
                },

            },
            legend: {
                position: 'top',
                horizontalAlign: 'right',
                floating: true,
                offsetY: -25,
                offsetX: -5
            }
        };

        setTimeout(function () {
            var taskAreaChart = new ApexCharts(document.querySelector("#line-chart-example"), taskAreaOptions);
            taskAreaChart.render();
        }, 100);

    </script>

    <script src="<?php echo e(asset('assets/js/dropzone.min.js')); ?>"></script>
    <script>
        Dropzone.autoDiscover = false;
        myDropzone = new Dropzone("#dropzonewidget", {
            maxFiles: 20,
            maxFilesize: 20,
            parallelUploads: 1,
            acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg,.pdf,.txt,.doc,.docx,.zip,.rar",
            url: "<?php echo e(route('projects.file.upload',[$currentWorkspace->slug,$project->id])); ?>",
            success: function (file, response) {
                if (response.is_success) {
                    dropzoneBtn(file, response);
                } else {
                    myDropzone.removeFile(file);
                    toastr('<?php echo e(__('Error')); ?>', response.error, 'error');
                }
            },
            error: function (file, response) {
                myDropzone.removeFile(file);
                if (response.error) {
                    toastr('<?php echo e(__('Error')); ?>', response.error, 'error');
                } else {
                    toastr('<?php echo e(__('Error')); ?>', response, 'error');
                }
            }
        });
        myDropzone.on("sending", function (file, xhr, formData) {
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("project_id", <?php echo e($project->id); ?>);
        });

        <?php if(isset($permisions) && in_array('show uploading',$permisions)): ?>
        $(".dz-hidden-input").prop("disabled",true);
        myDropzone.removeEventListeners();
        <?php endif; ?>

        function dropzoneBtn(file, response) {

            var html = document.createElement('div');

            var download = document.createElement('a');
            download.setAttribute('href', response.download);
            download.setAttribute('class', "edit-icon");
            download.setAttribute('data-toggle', "tooltip");
            download.setAttribute('data-original-title', "<?php echo e(__('Download')); ?>");
            download.innerHTML = "<i class='fas fa-download'></i>";
            html.appendChild(download);

                <?php if(isset($permisions) && in_array('show uploading',$permisions)): ?>
                <?php else: ?>
            var del = document.createElement('a');
            del.setAttribute('href', response.delete);
            del.setAttribute('class', "delete-icon");
            del.setAttribute('data-toggle', "tooltip");
            del.setAttribute('data-original-title', "<?php echo e(__('Delete')); ?>");
            del.innerHTML = "<i class='fas fa-trash'></i>";

            del.addEventListener("click", function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (confirm("Are you sure ?")) {
                    var btn = $(this);
                    $.ajax({
                        url: btn.attr('href'),
                        type: 'DELETE',
                        success: function (response) {
                            if (response.is_success) {
                                btn.closest('.dz-image-preview').remove();
                            } else {
                                toastr('<?php echo e(__('Error')); ?>', response.error, 'error');
                            }
                        },
                        error: function (response) {
                            response = response.responseJSON;
                            if (response.is_success) {
                                toastr('<?php echo e(__('Error')); ?>', response.error, 'error');
                            } else {
                                toastr('<?php echo e(__('Error')); ?>', response, 'error');
                            }
                        }
                    })
                }
            });
            html.appendChild(del);
            <?php endif; ?>

            file.previewTemplate.appendChild(html);
        }

        <?php ($files = $project->files); ?>
        <?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php ($storage_file = storage_path('project_files/'.$file->file_path)); ?>
        // Create the mock file:
        var mockFile = {name: "<?php echo e($file->file_name); ?>", size: <?php echo e(file_exists($storage_file) ? filesize($storage_file) : 0); ?> };
        // Call the default addedfile event handler
        myDropzone.emit("addedfile", mockFile);
        // And optionally show the thumbnail of the file:
        myDropzone.emit("thumbnail", mockFile, "<?php echo e(asset('storage/project_files/'.$file->file_path)); ?>");
        myDropzone.emit("complete", mockFile);

        dropzoneBtn(mockFile, {download: "<?php echo e(route($client_keyword.'projects.file.download',[$currentWorkspace->slug,$project->id,$file->id])); ?>", delete: "<?php echo e(route('projects.file.delete',[$currentWorkspace->slug,$project->id,$file->id])); ?>"});

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </script>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/projects/show.blade.php ENDPATH**/ ?>