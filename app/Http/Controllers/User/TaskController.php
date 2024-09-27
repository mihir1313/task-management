<?php

namespace App\Http\Controllers\User;

use DataTables;
use Carbon\Carbon;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\UserProject;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request, $id = null)
    {
      if (!$request->isMethod('post')) {
        
         $projectId = decrypt($id);
         $project = Project::select('name')->where('id',$projectId)->get()->toArray();
        
         $user = User::select('id', 'name')->where('role', 'user')->get()->toArray();

         return view('user.tasks.tasks')->with(compact('user','project'));
      }
       if ($request->ajax() && $request->isMethod('post')) {
 
          $currentURL = $_SERVER['HTTP_REFERER'];
          $urlId = basename($currentURL);
          $projectId = decrypt($urlId);
          
          $data = Task::where('project_id', $projectId)->get()->toArray();
 
          return Datatables::of($data)
             ->addIndexColumn()
 
             ->addColumn('action', function ($row) {
                $action =  '<td style="display: inline-flex"><a class="btn btn-primary mx-2" data-id="' . $row['id'] . '" id="editTask">Edit</a>&nbsp; &nbsp;';
                $action .=  '<a class="btn btn-danger" data-id="' . $row['id'] . '" id="removeTask">Delete</a></td>';
                return $action;
             })
 
             ->rawColumns(['action'])
             ->make(true);
       }
    }
    public function insert(Request $request)
   {
      $post = $request->all();
      $currentUserId = auth()->id();
     
      $currentURL = $_SERVER['HTTP_REFERER'];
      $urlId = basename($currentURL);
      $decryptedId = decrypt($urlId);

      $hid = $post['hid'];

      $response = array();
      $response['status'] = 0;
      $response['msg'] = 'Record Insertion failed!';

      $validation = Validator::make($request->all(), [
         'title'             => 'required',
         'description'             => 'required',
         // 'user'             => 'required',
         'status'             => 'required',
      ]);

      $data = array();
      if ($validation->fails()) {
         $data['status'] = 0;
         $data['error'] = $validation->errors()->all();
         echo json_encode($data);
         exit();
      }

      if (isset($hid) && $hid != '') {

         $updateTask = Task::where('id', $hid)->first();
         $updateTask->project_id =  isset($decryptedId) ? $decryptedId : '';
         $updateTask->user_id =  isset($currentUserId) ? $currentUserId : '';
         $updateTask->title =  isset($post['title']) ? $post['title'] : '';
         $updateTask->description =  isset($post['description']) ? $post['description'] : '';
         $updateTask->status =  isset($post['status']) ? $post['status'] : '';
         $updateTask->updated_at =  Carbon::now();
         $updateTask->save();

         if (isset($updateTask->id)) {
            $response['status'] = 1;
            $response['msg'] = 'Task Updated successfully.';
         }
      } else {
        
         $taskInsert =  new Task;
         $taskInsert->project_id =  isset($decryptedId) ? $decryptedId : '';
         $taskInsert->user_id =  isset($currentUserId) ? $currentUserId : '';
         $taskInsert->title =  isset($post['title']) ? $post['title'] : '';
         $taskInsert->description =  isset($post['description']) ? $post['description'] : '';
         $taskInsert->status = !empty($post['status']) ? $post['status'] : ''; 
         $taskInsert->created_at =  Carbon::now();
         $taskInsert->save();

         $userProject = new UserProject;
         $userProject->user_id = isset($currentUserId) ? $currentUserId : '';
         $userProject->project_id = isset($decryptedId) ? $decryptedId : '';
         $userProject->created_at = Carbon::now();
         $userProject->save();

         if (isset($taskInsert->id)) {
            $response['status'] = 1;
            $response['msg'] = 'Task Inserted successfully.';
         }
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

         $edit = Task::where('id', $edit_id)->first();

         if ($edit) {
            $response['status'] = 1;
            $response['msg'] = "Edit Successfully.";
            $response['data'] =  $edit;
         }
      }

      echo json_encode($response);
      exit();
   }
   public function delete(Request $request)
   {
      $delete_id = $request['id'];

      $response = array();
      $response['status'] = 0;
      $response['msg'] = "Something went wrong please try again.";

      if ($delete_id != "" && $delete_id != null) {

         $delete = Task::where('id', $delete_id)->delete();
         if ($delete) {
            $response['status'] = 1;
            $response['msg'] = "Task Deleted successfully.";
         }
      }
      echo json_encode($response);
      exit();
   }
}
