<?php $__env->startSection('page-title'); ?> <?php echo e(__('Timesheet')); ?> <?php $__env->stopSection(); ?>

<?php $client_keyword = Auth::user()->getGuard() == 'client' ? 'client.' : ''; ?>
<?php $__env->startSection('multiple-action-button'); ?>
    <div class="col-md-4 mt-2">
        <div class="weekly-dates-div">
            <i class="fa fa-arrow-left previous"></i>

            <span class="weekly-dates"></span>

            <input type="hidden" id="weeknumber" value="0">
            <input type="hidden" id="selected_dates">

            <i class="fa fa-arrow-right next"></i>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section class="section">
        <?php if($currentWorkspace): ?>
            <section class="row my-5">
                <div class="col-12">
                    <form method="post" class="float-right">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <select class="select2 " size="sm" name="timesheet_search" id="timesheet_search">

                                <option value=""><?php echo e(__('All Projects')); ?></option>
                                <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($project->name); ?>"><?php echo e($project->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <input type="hidden" name="selected_dates_pdf" id="selected_dates_pdf">
                            <input type="hidden" name="weeknumber_pdf" id="weeknumber_pdf" value="0">

                            <button type="button" id="timesheet_search_btn" class="btn btn-xs btn-success pdf-download-btn float-right my-1 ml-1">Search Project</button>
                            <button type="submit" class="btn btn-xs btn-success pdf-download-btn float-right my-1" formaction="<?php echo e(route('timesheet.report.print', $currentWorkspace->slug)); ?>" formtarget="_blank"><i class="fa fa-file"></i> <?php echo e(__('PDF')); ?></button>
                        </div>
                        <div class="row mt-3">
                            <select class="custom-input form-control form-control-light select2" id="project_user_name" name="project_user_name">
                                <option value=""><?php echo e(__('All Users')); ?></option>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($u->user->name); ?>"><?php echo e($u->user->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <button type="button" id="project_user_name_btn" class="btn btn-xs btn-success pdf-download-btn float-right my-1 ml-1">Search User</button>
                            <button type="submit" class="btn btn-xs btn-success pdf-download-btn float-right my-1" formaction="<?php echo e(route('timesheet.report.print', $currentWorkspace->slug)); ?>" formtarget="_blank"><i class="fa fa-file"></i> <?php echo e(__('PDF')); ?></button>
                        </div>
                    </form>
                </div>
            </section>
            <div class="row">
                <div class="col-md-12">
                    <div id="timesheet-table-view"></div>
                    <div class="card notfound-timesheet text-center">
                        <div class="card-body p-3">
                            <div class="page-error">
                                <div class="page-inner">
                                    <div class="page-description">
                                        <?php echo e(__("We couldn't find any data")); ?>

                                    </div>
                                    <div class="page-search">
                                        <p class="text-muted mt-3">
                                            <?php echo e(__("Sorry we can't find any timesheet records on this week.")); ?>

                                            <br>
                                            <?php if($project_id != '-1' && Auth::user()->getGuard() != 'client'): ?>
                                                <?php echo e(__('To add record go to ')); ?> <b><?php echo e(__('Add Task on Timesheet.')); ?></b>
                                            <?php else: ?>
                                                <?php echo e(__('To add timesheet record go to ')); ?>

                                                <a class="btn-return-home badge-blue" href="<?php echo e(route('projects.index', $currentWorkspace->slug)); ?>"><i class="fas fa-reply"></i> <?php echo e(__('Projects')); ?></a>
                                            <?php endif; ?>
                                        </p>
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
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        let project_name = '';
        let project_user_name = '';

        function ajaxFilterTimesheetTableView() {

            var mainEle = $('#timesheet-table-view');
            var notfound = $('.notfound-timesheet');

            var week = parseInt($('#weeknumber').val());
            var project_id = '<?php echo e($project_id); ?>';


            var data = {
                week: week,
                project_id: project_id,
                project_name: project_name,
                project_user_name: project_user_name,
            };

            $.ajax({
                <?php if(Auth::user()->getGuard() == 'client'): ?>
                url: '<?php echo e(route('client.filter.timesheet.table.view', '__slug')); ?>'.replace('__slug', '<?php echo e($currentWorkspace->slug); ?>'),
                <?php else: ?>
                url: '<?php echo e(route('filter.timesheet.table.view', '__slug')); ?>'.replace('__slug', '<?php echo e($currentWorkspace->slug); ?>'),
                <?php endif; ?>
                data: data,
                success: function (data) {

                    $('.weekly-dates-div .weekly-dates').text(data.onewWeekDate);

                    $('.weekly-dates-div #selected_dates').val(data.selectedDate);
                    $('#selected_dates_pdf').val(data.selectedDate);

                    $('#project_tasks').find('option').not(':first').remove();

                    $.each(data.tasks, function (i, item) {
                        $('#project_tasks').append($("<option></option>")
                            .attr("value", i)
                            .text(item));
                    });

                    if (data.totalrecords == 0) {
                        mainEle.hide();
                        notfound.css('display', 'block');
                    } else {
                        notfound.hide();
                        mainEle.show();
                    }

                    mainEle.html(data.html);
                }
            });
        }

        $(function () {
            ajaxFilterTimesheetTableView();
        });

        $(document).on('click', '.weekly-dates-div i', function () {

            var weeknumber = parseInt($('#weeknumber').val());

            if ($(this).hasClass('previous')) {

                weeknumber--;
                $('#weeknumber').val(weeknumber);

            } else if ($(this).hasClass('next')) {

                weeknumber++;
                $('#weeknumber').val(weeknumber);
            }
            $('#weeknumber_pdf').val(weeknumber);

            ajaxFilterTimesheetTableView();
        });

        $('#timesheet_search_btn').click(function() {
            project_name = $('#timesheet_search').val();
            project_user_name = '';
            ajaxFilterTimesheetTableView();
        });

        $('#project_user_name_btn').click(function() {
            project_name = '';
            project_user_name = $('#project_user_name').val();
            ajaxFilterTimesheetTableView();
        });

        $(document).on('click', '[data-ajax-timesheet-popup="true"]', function (e) {
            e.preventDefault();

            var data = {};
            var url = $(this).data('url');
            var type = $(this).data('type');
            var date = $(this).data('date');
            var task_id = $(this).data('task-id');
            var user_id = $(this).data('user-id');
            var p_id = $(this).data('project-id');

            data.date = date;
            data.task_id = task_id;

            if (user_id != undefined) {
                data.user_id = user_id;
            }

            if (type == 'create') {
                var title = '<?php echo e(__("Create Timesheet")); ?>';
                data.p_id = '<?php echo e($project_id); ?>';
                data.project_id = data.p_id != '-1' ? data.p_id : p_id;

            } else if (type == 'edit') {
                var title = '<?php echo e(__("Edit Timesheet")); ?>';
            }

            $("#commonModal .modal-title").html(title + ` <small>(` + moment(date).format("ddd, Do MMM YYYY") + `)</small>`);

            $.ajax({
                url: url,
                data: data,
                dataType: 'html',
                success: function (data) {

                    $('#commonModal .modal-body .card-box').html(data);
                    $("#commonModal").modal('show');
                    commonLoader();
                    loadConfirm();
                }
            });
        });

        $(document).on('click', '#project_tasks', function (e) {
            var mainEle = $('#timesheet-table-view');
            var notfound = $('.notfound-timesheet');

            var selectEle = $(this).children("option:selected");
            var task_id = selectEle.val();
            var selected_dates = $('#selected_dates').val();

            if (task_id != '') {

                $.ajax({
                    url: '<?php echo e(route('append.timesheet.task.html', '__slug')); ?>'.replace('__slug', '<?php echo e($currentWorkspace->slug); ?>'),
                    data: {
                        project_id: '<?php echo e($project_id); ?>',
                        task_id: task_id,
                        selected_dates: selected_dates,
                    },
                    success: function (data) {

                        notfound.hide();
                        mainEle.show();

                        $('#timesheet-table-view tbody').append(data.html);
                        selectEle.remove();
                    }
                });
            }
        });

        $(document).on('change', '#time_hour, #time_minute', function () {

            var hour = $('#time_hour').children("option:selected").val();
            var minute = $('#time_minute').children("option:selected").val();
            var total = $('#totaltasktime').val().split(':');

            if (hour == '00' && minute == '00') {
                $(this).val('');
                return;
            }

            hour = hour != '' ? hour : 0;
            hour = parseInt(hour) + parseInt(total[0]);

            minute = minute != '' ? minute : 0;
            minute = parseInt(minute) + parseInt(total[1]);

            if (minute > 50) {
                minute = minute - 60;
                hour++;
            }

            hour = hour < 10 ? '0' + hour : hour;
            minute = minute < 10 ? '0' + minute : minute;

            $('.display-total-time span').text('<?php echo e(__("Total Time")); ?> : ' + hour + ' <?php echo e(__("Hours")); ?> ' + minute + ' <?php echo e(__("Minutes")); ?>');
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\taskly\resources\views/reports/timesheet.blade.php ENDPATH**/ ?>