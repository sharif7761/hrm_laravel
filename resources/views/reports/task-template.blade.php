<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css?family=Lato&amp;display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
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
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 80%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .badge {
            display: inline;
            text-transform: none;
            color: #FFF;
        }

        .badge-success {
            background-color: #36B37E !important;
        }

        .badge-warning {
            background-color: #FFAB00;
        }

        .badge-danger {
            background-color: red;
        }

        .badge-secondary {
            color: #273444;
            background-color: #EFF2F7;
        }

        .pdf-title {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div id="app" class="content">
        <div class="editor">
            <div class="invoice-preview-inner">
                <div class="editor-content">
                    <div class="preview-main client-preview">
                        <div data-v-f2a183a6="" class="d" id="boxes">
                            <div data-v-f2a183a6="" class="d-body">
                                <h1 class="pdf-title">Task Report of {{ $currentWorkspace->name }}</h1>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">Task</th>
                                        <th scope="col">Project</th>
                                        <th scope="col">Milestone</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Assigned to</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Priority</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tasks as $task)
                                        <tr>
                                            <th>{{ $task->title }}</th>
                                            <td>{{ $task->project->name }}</td>
                                            <td>{{ $task->milestone()['title'] }}</td>
                                            <td>{{ Date::parse($task->due_date)->format('Y-m-d') }}</td>
                                            <td>
                                                @foreach($task->users() as $user)
                                                    <span class="badge badge-secondary">{{$user->name}}</span>
                                                @endforeach
                                            </td>
                                            <td>{{ $task->status }}</td>
                                            <td>{{ $task->priority }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if(!isset($preview))
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <script type="text/javascript" src="{{ asset('assets/js/html2pdf.bundle.min.js') }}"></script>

    <?php $url = route('task.report',[$currentWorkspace->slug]); ?>

    <script>

        'use strict';

        function closeScript() {

            setTimeout(function () {

                window.location.href = '{{ $url }}';

            }, 1000);

        }

        $(window).on('load', function () {

            var element = document.getElementById('boxes');

            var opt = {

                filename: '{{ $currentWorkspace->slug.'-task'.time() }}',

                image: {type: 'jpeg', quality: 1},

                html2canvas: {scale: 4, dpi: 72, letterRendering: true},

                jsPDF: {unit: 'in', format: 'A4'}

            };

            html2pdf().set(opt).from(element).save().then(closeScript);

        });

    </script>
@endif
</body>
</html>
