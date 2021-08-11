@extends('layouts.admin')

@section('page-title') {{__('Tasks')}} @endsection

@push('css-page')
    <style>
        .page-content .select2-container {
            z-index: 0 !important;
        }
    </style>
@endpush
@section('content')
    @auth('web')
        @if($currentWorkspace->creater->id == Auth::user()->id)
            <section class="row my-5">
                <div class="col-12">
                    <div class="">
                        <div class="col-md-4 float-left">
                            <select class="select2 " size="sm" name="project_name" id="custom_search">
                                <option value="">{{__('All Projects')}}</option>
                                @foreach($projects as $project)
                                    <option value="{{$project->name}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-8 float-right">
                            <label for="issue_from">From</label>
                            <input type="date" name="issue_from" id="start_date1" class="custom-input">
                            <label for="issue_to">To</label>
                            <input type="date" name="issue_to" id="end_date1" class="custom-input">
{{--                            <input type="text" name="project_name" id="custom_search" placeholder="Enter Project Name" class="custom-input">--}}
                            <button type="submit" class="btn btn-xs btn-info"
                                    formaction="{{ route('task.report', $currentWorkspace->slug) }}" id="custom_search_btn">
                                Search
                            </button>
                        </div>
                        <form method="post" class="float-right">
                            @csrf
                            <div class="col-md-12">
                                <div class=" mb-3">
                                    <input type="text" name="project_name" id="project_name_hidden" class="d-none">
                                    <input type="date" name="start_date" id="start_date1_hidden" class="d-none">
                                    <input type="date" name="end_date" id="end_date1_hidden" class="d-none">
                                    <button type="submit" class="btn btn-xs btn-success pdf-download-btn float-right"
                                            formaction="{{ route('task.report.print', $currentWorkspace->slug) }}"><i class="fa fa-file"></i> {{ __('Download PDF') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
        @endif
    @endauth
    <section class="section">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-centered table-hover mb-0 animated"
                                   id="tasks-selection-datatable">
                                <thead>
                                <th>{{__('Task')}}</th>
                                <th>{{__('Project')}}</th>
                                <th>{{__('Milestone')}}</th>
                                <th>{{__('Due Date')}}</th>
                                @if($currentWorkspace->permission == 'Owner' || Auth::user()->getGuard() == 'client')
                                    <th>{{__('Assigned to')}}</th>
                                @endif
                                <th>{{__('Status')}}</th>
                                <th>{{__('Priority')}}</th>
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
@endsection

@push('css-page')
@endpush

@push('scripts')
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
                $("#tasks-selection-datatable tbody tr").html('<td colspan="11" class="text-center"> {{ __("Loading ...") }}</td>');

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
                    url: '{{route('tasks.ajax',[$currentWorkspace->slug])}}',
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
@endpush
