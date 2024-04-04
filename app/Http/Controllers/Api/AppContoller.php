<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\App;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AppContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apps = App::all();
        return $this->successResponse($apps, 200);
        
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
     * @param  \App\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function show(App $app)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function edit(App $app)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, App $app)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\App  $app
     * @return \Illuminate\Http\Response
     */
    public function destroy(App $app)
    {
        //
    }
    
    /**
     * Get apps for manager
     */
    public function getAppsMgr($manager_id)
    {
        // $apps = App::get
    }

    public function getMembersApp($manager_id)
    {
        try {
        //     $apps = DB::select("SELECT 
        //     *,
        //     (SELECT 
        //       b.`name` 
        //     FROM
        //       ctiportal.`users` b 
        //     WHERE a.`employee_id` = b.`employee_id`) AS 'employee_name' 
        //   FROM
        //     ctiportal.`apps` a 
        //   WHERE a.`employee_id` IN (SELECT c.`employee_id` FROM ctiportal.`users` c WHERE c.`manager_id` = ".$manager_id.") 
        //   ORDER BY a.`time_entry`,
        //     a.`id` DESC ");

        $apps = DB::select("SELECT 
        *,
        (SELECT 
          b.`name` 
        FROM
          ctiportal.`users` b 
        WHERE a.`employee_id` = b.`employee_id`) AS 'employee_name' 
      FROM
        ctiportal.`apps` a 
      WHERE a.`employee_id` IN 
        (SELECT 
          c.`employee_id` 
        FROM
          ctiportal.`users` c 
        WHERE c.`manager_id` = ".$manager_id.") 
        
        AND a.`date_entry` BETWEEN NOW() - INTERVAL 30 DAY AND NOW()
      ORDER BY a.`time_entry`,
        a.`id` DESC ");

            $users = User::where('manager_id',$manager_id)->get();
            if(count($users)){
                // $users_id = [];
                // foreach ($users as $user) {
                    // array_push($users_id, $user->employee_id);
                // }
                // $apps  = App::whereIn('employee_id', $users_id)->orderByDesc('time_entry')->orderByDesc('id')->get();
                // $apps = DB::select("SELECT *,(SELECT b.`name` FROM ctiportal.`users` b WHERE a.`employee_id` = b.`employee_id`) AS 'employee_name' FROM ctiportal.`apps` a WHERE a.`employee_id` IN $users_id ORDER BY a.`time_entry`,a.`id` DESC");
                return response()->json([
                    'status' => true,
                    // 'name'            => $user['name'],
                    // 'email'           => $user['email'],
                    // 'user_id'         => $user['user_id'],
                    // 'employee_id'     => $user['employee_id'],
                    // 'manager_id'      => $user['manager_id'],
                    // 'department_id'   => $user['department_id'],
                    // 'department_name' => $user['department_name'],
                    // 'rank'            => $user['rank'],
                    'message' => 'Success response.',
                    'data'    => $apps
                  ], 200);
            } else {
                return $this->errorResponse(404, 'No team members found!');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse(500,$th->getMessage());
        }

        
    }
}
