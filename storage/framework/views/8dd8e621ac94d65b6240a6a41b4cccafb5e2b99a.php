<?php $__env->startSection('page-title'); ?> <?php echo e(__('Tasks')); ?> <?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
    <style>
        .page-content .select2-container {
            z-index: 0 !important;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <?php if(auth()->guard('web')->check()): ?>
        <?php if($currentWorkspace->creater->id == Auth::user()->id): ?>
            <section class="row my-5">
                <div class="col-12">
                    <div class="">
                        <div class="col-md-4 float-left">
                            <select class="select2 " size="sm" name="project_name" id="custom_search">
                                <option value=""><?php echo e(__('All Projects')); ?></option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->name); ?>"><?php echo e($project->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-8 float-right">
                            <label for="issue_from">From</label>
                            <input type="date" name="issue_from" id="start_date1" class="custom-input">
                            <label for="issue_to">To</label>
                            <input type="date" name="issue_to" id="end_date1" class="custom-input">

                            <button type="submit" class="btn btn-xs btn-info"
                                    formaction="<?php echo e(route('task.report', $currentWorkspace->slug)); ?>" id="custom_search_btn">
                                Search
                            </button>
                        </div>
                        <form method="post" class="float-right">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-12">
                                <div class=" mb-3">
                                    <input type="text" name="project_name" id="project_name_hidden" class="d-none">
                                    <input type="date" name="start_date" id="start_date1_hidden" class="d-none">
                                    <input type="date" name="end_date" id="end_date1_hidden" class="d-none">
                                    <button type="submit" class="btn btn-xs btn-success pdf-download-btn float-right"
                                            formaction="<?php echo e(route('task.report.print', $currentWorkspace->slug)); ?>"><i class="fa fa-file"></i> <?php echo e(__('Download PDF')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
    <section class="section">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-centered table-hover mb-0 animated"
                                   id="tasks-selection-datatable">
                                <thead>
                                <th><?php echo e(__('Task')); ?></th>
                                <th><?php echo e(__('Project')); ?></th>
                                <th><?php echo e(__('Milestone')); ?></th>
                                <th><?php echo e(__('Due Date')); ?></th>
                                <?php if($currentWorkspace->permission == 'Owner' || Auth::user()->getGuard() == 'client'): ?>
                                    <th><?php echo e(__('Assigned to')); ?></th>
                                <?php endif; ?>
                                <th><?php echo e(__('Status')); ?></th>
                                <th><?php echo e(__('Priority')); ?></th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css-page'); ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            var table = $("#tasks-selection-datatable").DataTable({
                order: [],
                select: {style: "multi"},
                "language": dataTableLang,
                drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            });

            $(document).on("click", "#custom_search_btn", function () {
                getData($('#custom_search').val());
                $("#project_name_hidden:text").val($('#custom_search').val());
                $("#start_date1_hidden").val($('#start_date1').val());
            });

            $(document).on("change", "#custom_search", function () {
                $("#project_name_hidden:text").val($('#custom_search').val());
            });
            $(document).on("change", "#start_date1", function () {
                $("#start_date1_hidden").val($('#start_date1').val());
            });
            $(document).on("change", "#end_date1", function () {
                $("#end_date1_hidden").val($('#end_date1').val());
            });

            $(document).on("click", ".btn-filter", function () {
                getData();
            });

            function getData(project_name = '') {
                table.clear().draw();
                $("#tasks-selection-datatable tbody tr").html('<td colspan="11" class="text-center"> <?php echo e(__("Loading ...")); ?></td>');

                var data = {
                    project: $("#project").val(),
                    assign_to: $("#all_users").val(),
                    priority: $("#priority").val(),
                    due_date_order: $("#due_date_order").val(),
                    status: $("#status").val(),
                    start_date: $("#start_date1").val(),
                    end_date: $("#end_date1").val(),
                    project_name: project_name
                };

                $.ajax({
                    url: '<?php echo e(route('tasks.ajax',[$currentWorkspace->slug])); ?>',
                    type: 'POST',
                    data: data,
                    success: function (data) {
                        table.rows.add(data.data).draw();
                        loadConfirm();
                    },
                    error: function (data) {
                        show_toastr('Info', data.error, 'info')
                    }
                })
            }

            getData();

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/reports/task.blade.php ENDPATH**/ ?>