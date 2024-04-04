<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Log as Apptwo;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::all();
        // return $this->successResponse($users, 200);

        $users = User::orderBy('name')->get();
        return $this->successResponse($users, 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Login Mod
     */
    public function register(Request $request)
    {
        try 
        {
            // Validation
            $validateUser = validator::make($request->all(),
            [
                'email'    => 'required|email|unique:users,email',
                'password' => 'required'
            ]);
    
            if($validateUser->fails()){
                return response()->json([
                    'status'  => false,
                    'message' => 'validation error',
                    'errors'  => $validateUser->errors()
                ], 401);
            }

            // $user = User

        } catch (\Throwable $th) {
            //throw $th;
            return $this->errorResponse(500,$th->getMessage());
        }

    }

    public function login(Request $request)
    {
        try {

            $login = $request->validate([
                'email'    => 'required',
                'password' => 'required',
            ]);

            if (!Auth::attempt($login)){
                return $this->errorResponse(401, 'Incorrect email or password!');
            }
            
            //Authenticated User
            $user = Auth::user();
            // $apps = App::where('employee_id', $user['employee_id'])->orderBy('time_entry', 'ASC')->get();
            $apps = App::where('employee_id', $user['employee_id'])->where('date_entry', '>', now()->subDays(30)->endOfDay())->orderBy('time_entry', 'ASC')->get();

            $logs = Apptwo::where('user_id', $user['employee_id'])->orderBy('id', 'ASC')->get();
            // $business_list = DB::table('general.business_list')->get();
            $setup_projects = DB::table('general.setup_project')->select('project_id as site_id','project_name as project_site')->get();

        
            return response()->json([
                'status'          => true,
                'name'            => $user['name'],
                'email'           => $user['email'],
                'user_id'         => $user['user_id'],
                'employee_id'     => $user['employee_id'],
                'manager_id'      => $user['manager_id'],
                'department_id'   => $user['department_id'],
                'department_name' => $user['department_name'],
                'rank'            => $user['rank'],
                'position_id'     => $user['position_id'],
                'position_name'   => $user['position_name'],
                'message'         => 'Login Successfully.',
                'data'            => $apps,
                'logs'            => $logs,
                // 'business_list'   => $business_list,
                'setup_projects'  => $setup_projects
                ], 200);

        } catch (\Throwable $th) {
            return $this->errorResponse(500,$th->getMessage());
        }
    }

    public function kiosk_login(Request $request)
    {
        try {

            $login = $request->validate([
                'name'    => 'required'
            ]);

            //Authenticated User
            
            $user = User::where('name',$request->name)->get();
            
            // $apps = App::where('employee_id', $user[0]->employee_id)->orderBy('time_entry','ASC')->get();
            $apps = App::where('employee_id', $user[0]->employee_id)->where('date_entry', '>', now()->subDays(32)->endOfDay())->orderBy('time_entry','ASC')->get();

            $logs = Apptwo::where('user_id', $user[0]->employee_id)->orderBy('id', 'ASC')->get();
            $setup_projects = DB::table('general.setup_project')->select('project_id as site_id','project_name as project_site')->get();
        

            return response()->json([
                'status'          => true,
                'name'            => $user[0]->name,
                'email'           => $user[0]->email,
                'user_id'         => $user[0]->user_id,
                'employee_id'     => $user[0]->employee_id,
                'manager_id'      => $user[0]->manager_id,
                'department_id'   => $user[0]->department_id,
                'department_name' => $user[0]->department_name,
                'rank'            => $user[0]->rank,
                'position_id'     => $user[0]->position_id,
                'position_name'   => $user[0]->position_name,
                'message'         => 'Login Successfully.',
                'data'            => $apps,
                'logs'            => $logs,
                // 'business_list'   => $business_list,
                'setup_projects'  => $setup_projects
                ], 200);

        } catch (\Throwable $th) {
            return $this->errorResponse(500,$th->getMessage());
        }
    }

    public function get_members($manager_id) {
        $members = User::select('name','employee_id')->where('manager_id', $manager_id)->orderBy('name', 'asc')->get();
        return response()->json([
            'status'  => true,
            'message' => 'Get request success!',
            'data'  => $members
        ], 200);
    }

    public function check($id){
        try {
            // $user = User::where('status', 'Active')->findOrFail($id);
            $user = User::where('status', 'Active')->where('employee_id', $id)->firstOrFail();
            return $this->successResponse($user,200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse(404, 'No active user found');
        }
    }

}
