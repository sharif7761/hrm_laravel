<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\Project;
use App\Stage;
use App\Task;
use App\Timesheet;
use App\User;
use App\UserWorkspace;
use App\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ReportController extends Controller
{
    public function invoice($slug)
    {
        $currentWorkspace = Utility::getWorkspaceBySlug($slug);
        $objUser          = Auth::user();

        if($objUser->getGuard() == 'client')
        {
            $projects = Project::select('projects.*')->join('client_projects', 'projects.id', '=', 'client_projects.project_id')->where('client_projects.client_id', '=', $objUser->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
        }
        else
        {
            $projects = Project::select('projects.*')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->where('user_projects.user_id', '=', $objUser->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
        }
        // dd($projects);
        $invoices = $objUser->getInvoices($currentWorkspace->id);
        $project_name = '';
        $issue_date_from = '';
        $issue_date_to = '';

        return view('reports.invoice', compact('currentWorkspace', 'invoices', 'projects', 'project_name', 'issue_date_from', 'issue_date_to'));
//        return view('reports.invoice', compact('currentWorkspace', 'invoices', 'projects'));
//        if($currentWorkspace->creater->id == \Auth::user()->id || $objUser->getGuard() == 'client')
//        {
//            $objUser          = Auth::user();
//            $currentWorkspace = Utility::getWorkspaceBySlug($slug);
//            $invoices = $objUser->getInvoices($currentWorkspace->id);

//        }
//        else
//        {
//            return redirect()->route('home');
//        }
    }

    public function invoiceSearch(Request $request, $slug)
    {
        $currentWorkspace = Utility::getWorkspaceBySlug($slug);
        $objUser          = Auth::user();
        if($objUser->getGuard() == 'client')
        {
            $projects = Project::select('projects.*')->join('client_projects', 'projects.id', '=', 'client_projects.project_id')->where('client_projects.client_id', '=', $objUser->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
        }
        else
        {
            $projects = Project::select('projects.*')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->where('user_projects.user_id', '=', $objUser->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
        }
        if($currentWorkspace->creater->id == \Auth::user()->id || $objUser->getGuard() == 'client')
        {
//            $objUser          = Auth::user();
            $currentWorkspace = Utility::getWorkspaceBySlug($slug);

            $project_name = $request->project_name;
            $project_id = Project::select('id')->where('name', 'like', '%'.$project_name.'%')->first();

            $issue_date_from = '';
            $issue_date_to = '';
            $result = Invoice::query();
            if ($request->issue_from && $request->issue_to) {
                $issue_date_from = $request->issue_from;
                $issue_date_to = $request->issue_to;
                $result = $result->whereBetween('issue_date', [$request->issue_from, $request->issue_to]);
            }
            $project_name = null;
            if ($request->project_name) {
                $project_name = $request->project_name;
                $project_id = Project::select('id')->where('name', 'like', '%'.$project_name.'%')->first();
                $result = $result->where('project_id', '=', $project_id->id);
            }

            $invoices = $result->where('workspace_id','=',$currentWorkspace->id)->get();
            return view('reports.invoice', compact('currentWorkspace', 'invoices', 'project_name', 'issue_date_from', 'issue_date_to', 'projects'));
        }
        else
        {
            return redirect()->route('home');
        }
    }

    public function printInvoiceReport(Request $request, $slug)
    {
        $objUser          = Auth::user();
        $currentWorkspace = Utility::getWorkspaceBySlug($slug);

        $result = Invoice::query();
        if ($request->issue_from && $request->issue_to) {
            $result = $result->whereBetween('issue_date', [$request->issue_from, $request->issue_to]);
        }

        if ($request->project_name) {
            $project_name = $request->project_name;
            $project_id = Project::select('id')->where('name', 'like', '%'.$project_name.'%')->first();
            $result = $result->where('project_id', '=', $project_id->id);
        }

        $invoices = $result->where('workspace_id','=',$currentWorkspace->id)->get();

        $color    = '#ffffff';
        $template = 'invoice-template1';

        $font_color = Utility::getFontColor($color);

        return view('reports.' . $template, compact('currentWorkspace', 'invoices', 'color', 'font_color'));

    }

    public function timesheet($slug)
    {
        $project_id = '-1';

        $currentWorkspace = Utility::getWorkspaceBySlug($slug);
        $objUser          = Auth::user();
//        $users  =User::all();
        $users  = UserWorkspace::with('user')->where('workspace_id', '=', $currentWorkspace->id)->get();
        if($objUser->getGuard() == 'client')
        {
            $timesheets = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id')->join('tasks', 'tasks.id', '=', 'timesheets.task_id')->join('client_projects', 'projects.id', '=', 'client_projects.project_id')->where('client_projects.client_id', '=', $objUser->id)->where('projects.workspace', '=', $currentWorkspace->id)->where('client_projects.permission', 'LIKE', '%show timesheet%')->get();
        }
//        elseif($currentWorkspace->permission == 'Owner')
//        {
//            $projects = Project::select('projects.*')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->where('user_projects.user_id', '=', $objUser->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
//            $timesheets = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id')->join('tasks', 'tasks.id', '=', 'timesheets.task_id')->where('projects.workspace', '=', $currentWorkspace->id)->get();
//        }
        else
        {
            $projects = Project::select('projects.*')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->where('user_projects.user_id', '=', $objUser->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
            $timesheets = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id')->join('tasks', 'timesheets.task_id', '=', 'tasks.id')->where('projects.workspace', '=', $currentWorkspace->id)->whereRaw("find_in_set('" . $objUser->id . "',tasks.assign_to)")->get();
        }
//        {
//            $timesheets = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id')->join('tasks', 'timesheets.task_id', '=', 'tasks.id')->where('projects.workspace', '=', $currentWorkspace->id)->whereRaw("find_in_set('" . $objUser->id . "',tasks.assign_to)")->get();
//            $projects = Project::select('projects.*')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->where('user_projects.user_id', '=', $objUser->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
//        }

        return view('reports.timesheet', compact('currentWorkspace', 'timesheets', 'project_id','users','projects'));

    }

    public function printTimesheetReport(Request $request, $slug){

        $selected_dates_pdf = $request->selected_dates_pdf;
        $selected_week = $request->weeknumber_pdf;
        
        $project_search = null;
        if($request->timesheet_search) {
            $project_name = $request->timesheet_search;
            $project_search = Project::where('name', 'like', '%'.$project_name.'%')->first();
            $project_id = $project_search->id;
        } else {
            $project_id = '-1';
        }

        $project_user_name = $request->has('project_user_name') ? $request->project_user_name : null;
        $project_user_id = 0;
        if($project_user_name) {
            $project_user = User::where('name', 'like', '%'.$project_user_name.'%')->first();
            $project_user_id = $project_user->id;
        }

        $currentWorkspace = Utility::getWorkspaceBySlug($slug);
        $objUser          = Auth::user();
        if($objUser->getGuard() == 'client')
        {
            $timesheets = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id')->join('tasks', 'tasks.id', '=', 'timesheets.task_id')->join('client_projects', 'projects.id', '=', 'client_projects.project_id')->where('client_projects.client_id', '=', $objUser->id)->where('projects.workspace', '=', $currentWorkspace->id)->where('client_projects.permission', 'LIKE', '%show timesheet%')->get();
        }
        elseif($currentWorkspace->permission == 'Owner' && $project_user_id != 0)
        {
//            $timesheets = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id')->join('tasks', 'tasks.id', '=', 'timesheets.task_id')->where('projects.workspace', '=', $currentWorkspace->id)->get();
             $timesheets = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id')->join('tasks', 'tasks.id', '=', 'timesheets.task_id')->where('timesheets.created_by', $project_user_id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
        }
        elseif($currentWorkspace->permission == 'Owner' && $project_user_id == 0)
        {
            $timesheets = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id')->join('tasks', 'tasks.id', '=', 'timesheets.task_id')->where('projects.workspace', '=', $currentWorkspace->id)->get();
        }
        else
        {
            $timesheets = Timesheet::select('timesheets.*')->join('projects', 'projects.id', '=', 'timesheets.project_id')->join('tasks', 'timesheets.task_id', '=', 'tasks.id')->where('projects.workspace', '=', $currentWorkspace->id)->whereRaw("find_in_set('" . $objUser->id . "',tasks.assign_to)")->get();
        }

        return view('reports.timesheet-template', compact('currentWorkspace','timesheets', 'project_id', 'project_search', 'project_user_name', 'selected_dates_pdf', 'selected_week'));
    }


    public function task($slug)
    {
        $userObj          = Auth::user();
        $currentWorkspace = Utility::getWorkspaceBySlug($slug);

        if($userObj->getGuard() == 'client')
        {
            $projects = Project::select('projects.*')->join('client_projects', 'projects.id', '=', 'client_projects.project_id')->where('client_projects.client_id', '=', $userObj->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
        }
        else
        {
            $projects = Project::select('projects.*')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->where('user_projects.user_id', '=', $userObj->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
        }
        $stages = Stage::where('workspace_id', '=', $currentWorkspace->id)->orderBy('order')->get();
        $users  = User::select('users.*')->join('user_workspaces', 'user_workspaces.user_id', '=', 'users.id')->where('user_workspaces.workspace_id', '=', $currentWorkspace->id)->get();

        return view('reports.task', compact('currentWorkspace', 'projects', 'users', 'stages'));
    }

    public function printTaskReport(Request $request, $slug)
    {
        $userObj          = Auth::user();
        $currentWorkspace = Utility::getWorkspaceBySlug($slug);

        $project_name = $request->project_name;
        $start_date = $request->start_date.' '.'00:00:00';
        $end_date = $request->end_date.' '.'23:59:59';

        if (($request->start_date && $request->end_date) && $request->project_name) {
            $tasks = Task::whereBetween('due_date', [$start_date, $end_date])->select(['tasks.*','stages.name as status','stages.complete'])->join("stages", "stages.id", "=", "tasks.status")->join('projects', "projects.id", "=", "tasks.project_id")->where('projects.name', 'like', '%' . $project_name . '%')->get();
        } else if ($request->project_name) {
            $tasks = Task::select(['tasks.*','stages.name as status','stages.complete'])->join("stages", "stages.id", "=", "tasks.status")->join('projects', "projects.id", "=", "tasks.project_id")->where('projects.name', 'like', '%' . $project_name . '%')->get();
        } else if (($request->start_date && $request->end_date)) {
            $tasks = Task::whereBetween('due_date', [$start_date, $end_date])->select(['tasks.*','stages.name as status','stages.complete'])->join("stages", "stages.id", "=", "tasks.status")->join('projects', "projects.id", "=", "tasks.project_id")->get();
        }
        else {
            $tasks = Task::select(['tasks.*','stages.name as status','stages.complete'])->join("stages", "stages.id", "=", "tasks.status")->join('projects', "projects.id", "=", "tasks.project_id")->get();
        }

        if($userObj->getGuard() == 'client')
        {
            $projects = Project::select('projects.*')->join('client_projects', 'projects.id', '=', 'client_projects.project_id')->where('client_projects.client_id', '=', $userObj->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
        }
        else
        {
            $projects = Project::select('projects.*')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->where('user_projects.user_id', '=', $userObj->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
        }
        $stages = Stage::where('workspace_id', '=', $currentWorkspace->id)->orderBy('order')->get();
        $users  = User::select('users.*')->join('user_workspaces', 'user_workspaces.user_id', '=', 'users.id')->where('user_workspaces.workspace_id', '=', $currentWorkspace->id)->get();

        $color    = '#ffffff';
        $template = 'task-template';

        $font_color = Utility::getFontColor($color);

        return view('reports.' . $template, compact('currentWorkspace', 'tasks', 'color', 'font_color', 'projects', 'users', 'stages'));
    }

    public function taskSearch(Request $request, $slug) {
        $userObj          = Auth::user();
        $currentWorkspace = Utility::getWorkspaceBySlug($slug);
        $project_name = $request->project_name;

        if($project_name) {
            if($userObj->getGuard() == 'client')
            {
                $projects = Project::select('projects.*')->where('projects.name', 'like', '%' . $project_name . '%')->join('client_projects', 'projects.id', '=', 'client_projects.project_id')->where('client_projects.client_id', '=', $userObj->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
            }
            else
            {
                $projects = Project::select('projects.*')->where('projects.name', 'like', '%' . $project_name . '%')->join('user_projects', 'projects.id', '=', 'user_projects.project_id')->where('user_projects.user_id', '=', $userObj->id)->where('projects.workspace', '=', $currentWorkspace->id)->get();
            }

            $stages = Stage::where('workspace_id', '=', $currentWorkspace->id)->orderBy('order')->get();
            $users  = User::select('users.*')->join('user_workspaces', 'user_workspaces.user_id', '=', 'users.id')->where('user_workspaces.workspace_id', '=', $currentWorkspace->id)->get();

            return view('reports.task', compact('currentWorkspace', 'projects', 'users', 'stages'));
        }
    }
}
