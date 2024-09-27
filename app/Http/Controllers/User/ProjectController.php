<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    
    public function index(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view('user.projects.projects');
        }
        
        if ($request->ajax() && $request->isMethod('post')) {

            $data = auth()->user()->projects()
                ->select('projects.id as project_id', 'projects.name', 'projects.description')
                ->get()
                ->toArray();
    
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $action = '<td style="display: inline-flex"><a class="btn btn-secondary" href="' . route('user.tasks', ['id' => encrypt($row['project_id'])]) . '" id="taskProject">Task</a></td>';
                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    


}

