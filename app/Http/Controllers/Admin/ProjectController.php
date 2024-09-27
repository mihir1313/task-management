<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->isMethod('post')) {

            return view('admin.projects.projects');
        }
        if ($request->ajax() && $request->isMethod('post')) {
            $data = Project::select('id', 'name', 'description')->get()->toArray();

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $action =  '<td style="display: inline-flex"><a class="btn btn-primary mx-2" data-id="' . $row['id'] . '" id="editProject">Edit</a>&nbsp; &nbsp;';
                    $action .=  '<a class="btn btn-danger" data-id="' . $row['id'] . '" id="removeProject">Delete</a>&nbsp; &nbsp;';
                    $action .= '<a class="btn btn-secondary" href="' . route('admin.tasks', ['id' => encrypt($row['id'])]) . '" id="taskProject">Task</a></td>';

                    return $action;
                })

                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function insert(Request $request)
    {
        $post = $request->all();

        $hid = $post['hid'];

        $response = array();
        $response['status'] = 0;
        $response['msg'] = 'Project Insertion failed!';

        $validation = Validator::make($request->all(), [
            'projectname'             => 'required',
            'description'             => 'required',
        ]);

        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }

        if (isset($hid) && $hid != '') {

            $updateProject = Project::where('id', $hid)->first();
            $updateProject->name =  isset($post['projectname']) ? $post['projectname'] : '';
            $updateProject->description =  isset($post['description']) ? $post['description'] : '';
            $updateProject->updated_at =  Carbon::now();
            $updateProject->save();
            if (isset($updateProject->id)) {
                $response['status'] = 1;
                $response['msg'] = 'Project Updated successfully.';
            }
        } else {
            $projectInsert =  new Project;
            $projectInsert->name =  isset($post['projectname']) ? $post['projectname'] : '';
            $projectInsert->description =  isset($post['description']) ? $post['description'] : '';
            $projectInsert->created_at =  Carbon::now();
            $projectInsert->save();
            if (isset($projectInsert->id)) {
                $response['status'] = 1;
                $response['msg'] = 'Project Inserted successfully.';
            }
        }

        echo json_encode($response);
        exit();
    }
    public function delete(Request $request)
    {
        $projectId = $request['id'];

        $project = Project::find($projectId);

        $response = array();
        $response['status'] = 0;
        $response['msg'] = "Something went wrong please try again.";

        if ($project) {
            $project->users()->detach();

            $project->tasks()->delete();

            $project->delete();


            $response['status'] = 1;
            $response['msg'] = "Project Deleted successfully.";
        }


        echo json_encode($response);
        exit();
    }
    public function edit(Request $request)
    {
        $edit_id = $request['id'];

        $response = array();
        $response['status'] = 0;
        $response['msg'] = "Something went wrong please try again.";

        $edit = array();

        if ($edit_id != "" && $edit_id != null) {

            $edit = Project::where('id', $edit_id)->first();

            if ($edit) {
                $response['status'] = 1;
                $response['msg'] = "Edit Successfully.";
                $response['data'] =  $edit;
            }
        }

        echo json_encode($response);
        exit();
    }
}
