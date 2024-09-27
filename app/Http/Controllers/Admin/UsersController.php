<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CredentialMail;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->isMethod('post')) {
            return view('admin.users.users');
        }
        if ($request->ajax() && $request->isMethod('post')) {
            $data = User::select('id', 'name', 'email', 'role')->where('role', 'user')->get()->toArray();

            return Datatables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $action =  '<td style="display: inline-flex"><a class="btn btn-primary mx-2" data-id="' . $row['id'] . '" id="editUser">Edit</a>&nbsp; &nbsp;';
                    $action .=  '<a class="btn btn-danger" data-id="' . $row['id'] . '" id="removeUser">Delete</a></td>';
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
        $response['msg'] = 'Record Insertion failed!';

        $validation = Validator::make($request->all(), [
            'username'             => 'required',
            'email'             => 'required',
            'pass'             => 'required',
        ]);

        if ($validation->fails()) {
            $data['status'] = 0;
            $data['error'] = $validation->errors()->all();
            echo json_encode($data);
            exit();
        }

        if (isset($hid) && $hid != '') {

            $updateUser = User::where('id', $hid)->first();
            $updateUser->name =  isset($post['username']) ? $post['username'] : '';
            $updateUser->email =  isset($post['email']) ? $post['email'] : '';
            $updateUser->password =  isset($post['pass']) ? bcrypt($post['pass']) : '';
            $updateUser->role =  isset($post['role']) ? $post['role'] : '';
            $updateUser->updated_at =  Carbon::now();
            $updateUser->save();
            if (isset($updateUser->id)) {
                $response['status'] = 1;
                $response['msg'] = 'Record Updated successfully.';
                $details = [
                    'email' => $updateUser->email,
                    'password' => $post['pass'],
                ];
                Mail::to($updateUser->email)->send(new CredentialMail($details));
            }
        } else {
            $userInsert =  new User;
            $userInsert->name =  isset($post['username']) ? $post['username'] : '';
            $userInsert->email =  isset($post['email']) ? $post['email'] : '';
            $userInsert->password =  isset($post['pass']) ? bcrypt($post['pass'])  : '';
            $userInsert->role =  isset($post['role']) ? $post['role'] : '';
            $userInsert->created_at =  Carbon::now();
            $userInsert->save();
            if (isset($userInsert->id)) {
                $response['status'] = 1;
                $response['msg'] = 'User Inserted successfully.';
                $details = [
                    'email' => $userInsert->email,
                    'password' => $post['pass'],
                ];
           
                Mail::to($userInsert->email)->send(new CredentialMail($details));
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

            $edit = User::where('id', $edit_id)->first();

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
        $id = $request['id'];

        $response = array();
        $response['status'] = 0;
        $response['msg'] = "Something went wrong please try again.";

        $user = User::find($id);

        if (!$user) {
            $response['status'] = 0;
            $response['msg'] = "User not found.";
        }

        $user->tasks()->delete();

        $user->delete();


        $response['status'] = 1;
        $response['msg'] = "User Deleted successfully.";
        echo json_encode($response);
        exit();
    }
}
