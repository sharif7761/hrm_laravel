<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/app.css')); ?>">
    <style type="text/css">
        .resize-observer {
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
            width: 100%;
            height: 100%;
            border: none;
            background-color: transparent;
            pointer-events: none;
            display: block;
            overflow: hidden;
            opacity: 0
        }

        .resize-observer object {
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            overflow: hidden;
            pointer-events: none;
            z-index: -1
        }

        p{
            line-height: 1.2em;
            margin: 0 0 2px 0;
        }

        pre{
            margin: 0;
        }


        .d-table-label .form-input{
            margin-left: 10px;
            width: 80px;
            height: 24px;
        }

        .d-table-label .form-input-mask-text{
            top: 3px;
        }

        .d-body{
            padding: 50px;
        }

        .d {
            font-size: 0.9em !important;
            color: black;
            background: white;
            min-height: 1000px;
        }

        img {
            max-width: 100%;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }

        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table td, .table th {
            padding: .75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            text-align: center;
        }

        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }

        .pdf-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .task-name {
            margin-left: 1rem;
        }
    </style>
</head>
<body>
<input type="hidden" id="selected_dates" value="<?php echo e($selected_dates_pdf); ?>">
<input type="hidden" id="weeknumber" value="<?php echo e($selected_week); ?>">
<div class="container">
    <div id="app" class="content">
        <div class="editor">
            <div class="invoice-preview-inner">
                <div class="editor-content">
                    <div class="preview-main client-preview">
                        <div data-v-f2a183a6="" class="d" id="boxes">
                            <div data-v-f2a183a6="" class="d-body">
                                <h1 class="pdf-title">Weekly Timesheet of <?php echo e($project_search ? $project_search->name : $currentWorkspace->name); ?></h1>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo e(asset('assets/js/html2pdf.bundle.min.js')); ?>"></script>

<?php $url = route('timesheet.report', [$currentWorkspace->slug]); ?>



<script>
    function ajaxFilterTimesheetTableView() {

        var mainEle = $('#timesheet-table-view');
        var notfound = $('.notfound-timesheet');

        var week = parseInt($('#weeknumber').val());
        var project_id = '<?php echo e($project_id); ?>';

        var data = {
            week: week,
            project_id: project_id,
            project_user_name: '<?php echo e($project_user_name); ?>',
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

    var selected_dates = $('#selected_dates').val();

    $(document).on('click', '.weekly-dates-div i', function () {

        var weeknumber = parseInt($('#weeknumber').val());

        if ($(this).hasClass('previous')) {

            weeknumber--;
            $('#weeknumber').val(weeknumber);

        } else if ($(this).hasClass('next')) {

            weeknumber++;
            $('#weeknumber').val(weeknumber);
        }

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

<script>


    function closeScript() {

        setTimeout(function () {

            window.location.href = '<?php echo e($url); ?>';

        }, 1000);

    }


    setTimeout(function () {

        var element = document.getElementById('boxes');

        var opt = {

            filename: '<?php echo e($currentWorkspace->slug.'-timesheet'.time()); ?>',

            image: {type: 'jpeg', quality: 1},

            html2canvas: {scale: 4, dpi: 72, letterRendering: true},

            jsPDF: {unit: 'in', format: 'A4'}

        };

        html2pdf().set(opt).from(element).save().then(closeScript);

    }, 2000);
</script>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\taskly\resources\views/reports/timesheet-template.blade.php ENDPATH**/ ?>