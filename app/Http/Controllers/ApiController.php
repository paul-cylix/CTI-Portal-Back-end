<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\App;
use App\Models\User;
use App\Models\Log as Apptwo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    protected function sync(Request $request){

        log::debug($request);

        DB::beginTransaction();
        try {
        
        $date_entry = date_create($request->date_entry);
        $time_entry = date_create($request->time_entry);

        // Apps Upload            
        $app = new App;
        $app->employee_id = $request->employee_id;
        $app->mode = $request->mode;
        $app->category_id = $request->category_id;
        $app->notes = $request->notes;
        $app->date_entry = $date_entry;
        $app->time_entry = $time_entry;
        $app->loc_address = $request->loc_address;
        $app->latitude = $request->latitude;
        $app->longitude = $request->longitude;
        $app->images = $request->images;
        $app->timestart = $request->timestart;
        $app->push_status = $request->push_status;
        $app->first_in = $request->first_in;
        $app->save();

        
        // use to update the app two
        $update_id = null;

        

        // Logs Upload
        if($request->app_two){

       

            // $date_log = date_create($request->date_log);
            // $clock_in = date_create($request->clock_in);
            // $clock_out = date_create($request->clock_out);

            $date_log = $request->date_log ? date_create($request->date_log) : NULL;
            $clock_in = $request->clock_in ? date_create($request->clock_in) : NULL;
            $clock_out = $request->clock_out ? date_create($request->clock_out) : NULL;


            // if there is upcoming update
            // di ko ma handle pag yung pinasa na params na id ay di nag eexist lagi niya return error 500 - paul 
            if($request->update_id){
                $log = Apptwo::find($request->update_id);
            } else {
                $log = new Apptwo;
            }

            $log->user_id    = $request->employee_id;
            $log->date_entry = $date_log;
            $log->clock_in   = $clock_in;
            $log->clock_out  = $clock_out;
            $log->save();
            $update_id = $log->id; // set update_id for possible update
        }
        
        // Image upload
        if ($request->hasFile('image')) {
            $completeFileName = $request->image->getClientOriginalName();
            $destinationPath  = "public/uploads/{$request->employee_id}/";  // For moving the file
            $request->image->storeAs($destinationPath, $completeFileName);
        }

        log::debug('Test Sync');

        // Save Overtime
        // if($request->overtime){
        //     $ot_date = date_create($request->ot_date);
        //     $ot_in = date_create($request->time_start);
        //     $ot_out = date_create($request->time_end);
    
    
        //     DB::table('humanresource.overtime_request')->insert([
        //         'reference' => '', // wala pa
        //         'request_date' => now(),
        //         'overtime_date' => date_format($ot_date, 'Y-m-d'),
        //         'ot_in' => date_format($ot_in, 'Y-m-d H:i:s'),
        //         'ot_out' => date_format($ot_out, 'Y-m-d H:i:s'),
        //         'ot_totalhrs' => $request->ot_hours,
        //         'employee_id' => $request->employee_id,
        //         'employee_name' => $request->emplyee_name,
        //         'purpose' => $request->purpose,
        //         'status' => 'In Progress',
        //         'UID' => $request->user_id,
        //         'fname' => '', // wala pa
        //         'lname' => '', // wala pa
        //         'department' => '', // wala pa
        //         'reporting_manager' => '', // wala pa
        //         'position' => '', // wala pa
        //         'ts' => now(),
        //         'GUID' => '', // wala pa
        //         // 'comments' => , 
        //         // 'ot_in_actual' => , 
        //         // 'ot_out_actual' => ,
        //         // 'ot_totalhrs_actual' => , 
        //         'main_id' => 0, // wala pa
        //         'remarks' => $request->purpose,
        //         'cust_id' => $request->project_id,
        //         'cust_name' => $request->project_name,
        //         'TITLEID' => $request->companyId,
        //         'PRJID' => '' // wala pa
        //     ]);
        // }

        if($request->emp_name){
            DB::table('operations.employee_scheduling')->insert([
            
                'employee_id' => $request->employee_id,
                'full_name' => $request->emp_name,
                'position' => $request->position_name,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'num_hrs' => $request->num_hrs,
                'site_id' => $request->site_id,
                'project_site' => $request->project_site,
                'costcenter_id' => $request->costcenter_id,
                'schedule_date' => $request->date_entry,
                'department' => $request->department
                 
            ]);
        }



        DB::commit();
        return response()->json([
            'status'    => true,
            'update_id' => $update_id,
            'message'   => 'Save Successfully.',
          ], 201);

        } catch (\Throwable $e) {
            DB::rollback();
            Log::debug($e);
            return $this->errorResponse(500, 'Internal Server Error!');
        }
    }

    protected function sync2(Request $request){

        log::debug($request);

        DB::beginTransaction();
        try {
        
        $date_entry = date_create($request->date_entry);
        $time_entry = date_create($request->time_entry);

        // Apps Upload            
        $app = new App;
        $app->employee_id = $request->employee_id;
        $app->mode = $request->mode;
        $app->category_id = $request->category_id;
        $app->notes = $request->notes;
        $app->date_entry = $date_entry;
        $app->time_entry = $time_entry;
        $app->loc_address = $request->loc_address;
        $app->latitude = $request->latitude;
        $app->longitude = $request->longitude;
        $app->images = $request->images;
        $app->timestart = $request->timestart;
        $app->push_status = $request->push_status;
        $app->first_in = $request->first_in;
        $app->save();

        
        // use to update the app two
        $update_id = null;

        // Logs Upload
        if($request->app_two){

       

            // $date_log = date_create($request->date_log);
            // $clock_in = date_create($request->clock_in);
            // $clock_out = date_create($request->clock_out);

            $date_log = $request->date_log ? date_create($request->date_log) : NULL;
            $clock_in = $request->clock_in ? date_create($request->clock_in) : NULL;
            $clock_out = $request->clock_out ? date_create($request->clock_out) : NULL;


            // if there is upcoming update
            // di ko ma handle pag yung pinasa na params na id ay di nag eexist lagi niya return error 500 - paul 
            if($request->update_id){
                $log = Apptwo::find($request->update_id);
            } else {
                $log = new Apptwo;
            }

            $log->user_id    = $request->employee_id;
            $log->date_entry = $date_log;
            $log->clock_in   = $clock_in;
            $log->clock_out  = $clock_out;
            $log->save();
            $update_id = $log->id; // set update_id for possible update
        }
        
        // Image upload
        if ($request->hasFile('image')) {
            $completeFileName = $request->image->getClientOriginalName();
            $destinationPath  = "public/uploads/{$request->employee_id}/";  // For moving the file
            $request->image->storeAs($destinationPath, $completeFileName);
        }

        // Save Overtime
        if(filter_var($request->overtime, FILTER_VALIDATE_BOOLEAN)){
            $ot_date = date_create($request->ot_date);
            $ot_in = date_create($request->time_start);
            $ot_out = date_create($request->time_end);
    
    
            DB::table('humanresource.overtime_request')->insert([
                'reference' => '', // wala pa
                'request_date' => now(),
                'overtime_date' => date_format($ot_date, 'Y-m-d'),
                'ot_in' => date_format($ot_in, 'Y-m-d H:i:s'),
                'ot_out' => date_format($ot_out, 'Y-m-d H:i:s'),
                'ot_totalhrs' => $request->ot_hours,
                'employee_id' => $request->employee_id,
                'employee_name' => $request->employee_name,
                'purpose' => $request->purpose,
                'status' => 'In Progress',
                'UID' => $request->user_id,
                'fname' => '', // wala pa
                'lname' => '', // wala pa
                'department' => '', // wala pa
                'reporting_manager' => '', // wala pa
                'position' => $request->position_name, 
                'ts' => now(),
                'GUID' => '', // wala pa
                // 'comments' => , 
                // 'ot_in_actual' => , 
                // 'ot_out_actual' => ,
                // 'ot_totalhrs_actual' => , 
                'main_id' => 0, // wala pa
                'remarks' => $request->purpose,
                'cust_id' => $request->project_id,
                'cust_name' => $request->project_name,
                'TITLEID' => $request->companyId,
                // 'PRJID' => '' // wala pa
            ]);
        }

        if($request->emp_name){
            DB::table('operations.employee_scheduling')->insert([
            
                'employee_id' => $request->employee_id,
                'full_name' => $request->emp_name,
                'position' => $request->position_name,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
                'num_hrs' => $request->num_hrs,
                'site_id' => $request->site_id,
                'project_site' => $request->project_site,
                'costcenter_id' => $request->costcenter_id,
                'schedule_date' => $request->date_entry,
                'department' => $request->department
                 
            ]);
        }



        DB::commit();
        return response()->json([
            'status'    => true,
            'update_id' => $update_id,
            'message'   => 'Save Successfully.',
          ], 201);

        } catch (\Throwable $e) {
            DB::rollback();
            Log::debug($e);
            return $this->errorResponse(500, 'Internal Server Error!');
        }
    }



    public function getFile($id,$image) {
        try {
            $file_location = 'storage/uploads/' .$id.'/'.$image;
            return response()->file(public_path(). '/' .$file_location);
        } catch (\Throwable $th) {
            return $this->errorResponse(500,$th->getMessage());
        }

    }

    public function filter(Request $request){
        // log::debug($request);
        $sql = "
        SELECT 
        a.id,
        b.`user_id_empl` AS 'id_no',
        b.`name`,
        DAYNAME (a.`date_entry`) AS 'week',
        a.`date_entry` AS 'date',
        TIME_FORMAT(a.`clock_in`, '%h:%i %p') AS 'time_in',
        TIME_FORMAT(a.`clock_out`, '%h:%i %p') AS 'time_out',
        a.`status`
        FROM
        ctiportal.`logs` a 
        INNER JOIN ctiportal.`users` b 
          ON b.`employee_id` = a.`user_id` 
        ";


        // Date range and Employee
        if ($request->dateRange && $request->employee) {
            $user_id = $request->employee['code'];
            
     
            $start = date("Y-m-d",strtotime($request->dateRange[0]));
            // date increased by 1day   
            $end = date("Y-m-d",strtotime($request->dateRange[1]. ' +1 day')); 
            $sql .= "WHERE a.`user_id` = '".$user_id."' AND a.`date_entry` BETWEEN '".$start."' AND '".$end."' AND a.`status` IN ('Active', 'For Approval') ORDER BY b.`name`, a.`date_entry`";
            $queryData = DB::select($sql);

        // Employee only
        } elseif($request->dateRange == false && $request->employee) {
            $user_id = $request->employee['code'];
            $sql .= "WHERE a.`user_id` = '".$user_id."' AND a.`status` IN ('Active', 'For Approval') ORDER BY b.`name`, a.`date_entry`";
            $queryData = DB::select($sql);

        // Date range only
        } elseif($request->dateRange && $request->employee == false) {
            $start = date("Y-m-d",strtotime($request->dateRange[0]));   
            $end = date("Y-m-d",strtotime($request->dateRange[1]. ' +1 day')); 
            $sql .= "WHERE a.`date_entry` BETWEEN '".$start."' AND '".$end."' AND a.`status` IN ('Active', 'For Approval') ORDER BY b.`name`, a.`date_entry`";
            $queryData = DB::select($sql);
        } else {
            $sql .= "WHERE a.`status` IN ('Active', 'For Approval') ORDER BY b.`name`, a.`date_entry`";
            $queryData = DB::select($sql);
        }

        return response()->json($queryData);
    }

    public function getLogs($id){
        $data = DB::select("
        SELECT 
        a.id,
        0 AS selected,
        a.user_id AS userid,
        a.date_entry AS dtr_date,
        DATE_FORMAT(a.clock_in, '%Y-%m-%d %h:%i %p') AS in_am,
        DATE_FORMAT(a.clock_out, '%Y-%m-%d %h:%i %p') AS out_pm,
        a.clock_in AS in_am1,
        a.clock_out AS out_pm1,
        a.status,
        b.name AS EmployeeName,
        b.department_name AS DepartmentName,
        b.position_name AS positionName,
        in_app.loc_address AS in_location,
        out_app.loc_address AS out_location
        FROM ctiportal.logs a 
        INNER JOIN ctiportal.users b ON a.user_id = b.employee_id
        LEFT JOIN ctiportal.apps in_app ON in_app.time_entry = a.clock_in AND in_app.employee_id = a.user_id
        LEFT JOIN ctiportal.apps out_app ON out_app.time_entry = a.clock_out AND out_app.employee_id = a.user_id
        WHERE b.manager_id = '".$id."' AND a.status = 'For Approval'
        ORDER BY EmployeeName, dtr_date;
        ");

        return response($data);
    }

    public function set(Request $request){
        Log::debug($request);
        $selectedData = $request->selectedData;
        $selectedData = json_decode($selectedData, true);

        
        for ($i = 0; $i < count($selectedData); $i++) {
            $dtr_date = date_create($selectedData[$i]['dtr_date']);

            $out_pm = null;
            $in_am = null;

            if ($selectedData[$i]['out_pm']) {
                $out_pm = date_create($selectedData[$i]['out_pm1']);
                $out_pm = date_format($out_pm, 'Y-m-d H:i:s');
            } 

            if ($selectedData[$i]['in_am']) {
                $in_am = date_create($selectedData[$i]['in_am1']);
                $in_am = date_format($in_am, 'Y-m-d H:i:s');
            }


            // DB::update("UPDATE ctiportal.`logs` a a SET a.`date_entry` = '".date_format($dtr_date, 'Y-m-d')."', a.`clock_in` =  '".$in_am."', a.`clock_out` = '".$out_pm."' ,a.`status` = '".$request->setStatus."' WHERE a.`id` = '".$selectedData[$i]['id']."' ");
            
            Apptwo::find($selectedData[$i]['id'])
                ->update(['date_entry' => date_format($dtr_date, 'Y-m-d'), 'clock_in' => $in_am, 'clock_out' => $out_pm, 'status' =>$request->setStatus]);
        }
        return response()->json(['message' => 'Attendance is now Active'], 200);
    }

    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required|email|unique:users,email',
            'fullname' => 'required',
            'employeeId' => 'required',
            'isManager' => 'required',
            'password' => 'required|confirmed|min:8|max:32',
            'rank' => 'required',
            'managerId' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['failed' => $validator->errors()]);
        }

        try {
            $user = new User();
            $user->name = $request->fullname;
            $user->email = $request->username;
            $user->password = bcrypt($request->password);
            $user->user_id = intval($request->userId);
            $user->employee_id = intval($request->employeeId);
            $user->manager_id = intval($request->managerId);
            $user->department_id = intval($request->departmentId);
            $user->department_name = $request->departmentName;
            $user->position_id = intval($request->positionId);
            $user->position_name = $request->positionName;
            $user->rank = $request->rank;        
            $user->save();
            return response()->json(['success' => 'Record registered Successfully!']);
        } catch (\Throwable $th) {
            log::debug($th);
            return response()->json($th, 500);
        }

    }

    public function getHrEmpShift($id){

        try {
            $schedule = DB::table("humanresource.hr_emp_shift")->where('SysPK_Empl',$id)->get();
            if(count($schedule)) {
                return $this->successResponse($schedule, 200);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => 'We couldn’t find schedule of the employee',
                    'data' => null,
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse(500,$th->getMessage());
        }

    }

    public function deleteInsertHrEMPShift(Request $request){
        DB::beginTransaction();
        try {

        // Delete all data in alibaba - hr_emp_shift table
        $deleted = DB::table('humanresource.hr_emp_shift')->delete();

        $records = $request["data"];
        // Insert each records to alibaba - hr_emp_shift table


        foreach ($records as $record) {
            DB::table('humanresource.hr_emp_shift')->insert([
                'id'           => $record["id"],
                'SysPK_Empl'   => $record["SysPK_Empl"],
                'timeIn'       => $record["timeIn"],
                'timeOut'      => $record["timeOut"],
                'amIN'         => $record["amIN"],
                'amOUT'        => $record["amOUT"],
                'pmIN'         => $record["pmIN"],
                'pmOUT'        => $record["pmOUT"],
                'shiftcode'    => $record["shiftcode"],
                'date_started' => $record["date_started"]
            ]);
        }

        DB::commit();
        return response()->json([
            'status'    => true,
            'message'   => 'Transfer Successfully.'
        ], 200);

        } catch (\Exception $e) {
            log::debug($e);
            DB::rollback();
            return response()->json([
                'status'    => false,
                'message'   => 'Transfer Failed.'
            ], 500);
        }
    }

    public function getEmployeeScheduling(){
        try {
            $records = DB::table("operations.employee_scheduling")->get();
            if(count($records)) {
                return $this->successResponse($records, 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'We couldn’t employee schedule',
                    'data' => null,
                ], 200);
            }
        } catch (\Throwable $th) {
            return $this->errorResponse(500,$th->getMessage());
        }
    }

    public function deleteEmployeeSchedule(Request $request) {
        
        DB::beginTransaction();
        try {
            
        foreach ($request->data as $id) {
            $deleted = DB::table("operations.employee_scheduling")->where('id', $id)->delete();
        }

        DB::commit();
        return response()->json([
            'status'    => true,
            'message'   => 'Transfer Successfully.'
        ], 200);

        } catch (\Exception $e) {
            log::debug($e);
            DB::rollback();
            return response()->json($e, 500);
        }
    }

    public function getEmpScheduleType($id) {
        $request = DB::table('humanresource.employees as a')->select('a.schedule_type')->where('a.SysPK_Empl', $id)->get();

        if (count($request)) {
            return response()->json([
                'status'    => true,
                'message'   => 'Get Successfully.',
                'schedule_type' => $request[0]->schedule_type
            ], 200);
        } else {
            return response()->json([
                'status'    => true,
                'message'   => 'Not found.',
                'schedule_type' => null
            ], 404);
        }
        
    }

    public function getprojects($companyId) {
        try {
            $request = DB::table('general.setup_project')
            ->select('project_id','project_name','SOID')
            ->where('project_type','!=','MAIN OFFICE')
            ->where('status','=','Active')
            ->where('title_id','=',$companyId)
            ->where('Main_office_id', $companyId)
            ->orderBy('project_name')
            ->get();
    
            if (count($request)) {
                return response()->json([
                    'status'    => true,
                    'message'   => 'Get Successfully.',
                    'data' => $request
                ], 200);
            } else {
                return response()->json([
                    'status'    => true,
                    'message'   => 'Not found.',
                    'schedule_type' => null
                ], 404);
            }
        } catch (\Throwable $th) {
            throw $th;
            log::debug($th);
            return response()->json([
                'status'    => true,
                'message'   => $th,
                'data' => null
            ], 500);
        }
    }

    public function saveOT($request) {

        if($request->overtime){
        $ot_date = date_create($request->ot_date);
        $ot_in = date_create($request->time_start);
        $ot_out = date_create($request->time_end);


        DB::table('humanresource.overtime_request')->insert([
            'reference' => '',
            'request_date' => now(),
            'overtime_date' => date_format($ot_date, 'Y-m-d'), // meron
            'ot_in' => date_format($ot_in, 'Y-m-d H:i:s'), // meron
            'ot_out' => date_format($ot_out, 'Y-m-d H:i:s'), // meron
            'ot_totalhrs' => $request->ot_hours, // meron
            'employee_id' => $request->employee_id, // meron
            'employee_name' => $request->emplyee_name, // meron
            'purpose' => $request->purpose, // meron
            'status' => 'In Progress', // static
            'UID' => $request->user_id, // meron
            'fname' => '', // wala pa
            'lname' => '', // wala pa
            'department' => '', // wala pa
            'reporting_manager' => '', // wala pa
            'position' => '', // wala pa
            'ts' => now(),
            'GUID' => '', // wala pa
            // 'comments' => , 
            // 'ot_in_actual' => , 
            // 'ot_out_actual' => ,
            // 'ot_totalhrs_actual' => , 
            'main_id' => 0, // wala pa
            'remarks' => $request->purpose, // meron
            'cust_id' => $request->project_id, // meron
            'cust_name' => $request->project_name, // meron
            'TITLEID' => $request->companyId, // meron
            'PRJID' => $request->project_id // meron
        ]);
    }

    }

    public function getHROT() {
        $result = DB::table("humanresource.a_overtime_request")->where('transferred', 0)->get();
        if (count($result)) {
            return response()->json([
                'status'    => true,
                'message'   => 'Get Successfully.',
                'overtime_request' => $result
            ], 200);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Not found.',
                'schedule_type' => null
            ], 404);
        }
    }

    public function transferredHROT(){
        DB::beginTransaction();
        try {

        $affected = DB::table('humanresource.a_overtime_request')
        ->where('transferred', 0)
        ->update(['transferred' => 1]);

        DB::commit();
        return response()->json([
            'status'    => true,
            'message'   => 'Transfer Successfully.'
        ], 200);

        } catch (\Exception $e) {
            log::debug($e);
            DB::rollback();
            return response()->json([
                'status'    => false,
                'message'   => 'Transfer Failed.'
            ], 500);
        }
    }

    public function getReportingManager($id){
        $result = DB::select("SELECT RMID, RMName FROM general.`systemreportingmanager` WHERE UID = $id ORDER BY RMName");
        if (count($result)) {
            return response()->json([
                'status'    => true,
                'message'   => 'Get Successfully.',
                'reporting_manager' => $result
            ], 200);
        } else {
            return response()->json([
                'status'    => false,
                'message'   => 'Not found.',
                'schedule_type' => null
            ], 404);
        }
    }

    public function getLeaveBalance($id){
        $result = DB::select("call humanresource.Display_LeaveCredits_Per_Employee($id)");
        return response()->json(['data'=>$result],200);
    }

    public function saveLAF(Request $request){


        log::debug($request);
        

        if($request[0]['row_count']){
            $count = intval($request[0]['row_count']);
            
        
            for ($i = 1; $i <= $count; $i++) {
                if($request[$i]['leave_type'] === 'VL') {
                    $leave_type = 'Vacation Leave';
                }

                if($request[$i]['leave_type'] === 'SL') {
                    $leave_type = 'Sick Leave';
                }

                if($request[$i]['leave_paytype'] === 'With Pay') {
                    $leave_paytype = 'wp';
                }

                if($request[$i]['leave_paytype'] === 'Without Pay') {
                    $leave_paytype = 'wop';
                }

                if($request[$i]['leave_halfday'] === 'Wholeday') {
                    $num_days = 1;
                } else {
                    $num_days = 0.5;
                }

                



                $leaveArray[] = [
                    // 'main_id'           => $mainID,
                    // 'reference'         => $reqRef,
                    'request_date'      => date_create($request[$i]['request_date']),
                    'date_needed'       => date_create($request[$i]['request_date']),
                    'employee_id'       => $request[$i]['employee_id'],
                    'employee_name'     => $request[$i]['employee_name'],
                    'medium_of_report'  => $request[$i]['medium_of_report'],
                    // 'report_time'       => date_create($request->reportDateTime),
                    'leave_type'        => $leave_type,
                    'leave_date'        => $request[$i]['leave_date'],
                    'leave_paytype'     => $leave_paytype,
                    'leave_halfday'     => $request[$i]['leave_halfday'],
                    'num_days'          => $num_days,
                    'reason'            => $request[$i]['reason'],
                    'status'            => 'In Progress',
                    'UID'               => $request[$i]['UID'],
                    // 'fname'             => $request[$i]['loggedUserFirstName'],
                    // 'lname'             => $request[$i]['loggedUserLastName'],
                    'position'          => $request[$i]['position'],
                    'reporting_manager' => $request[$i]['reporting_manager'],
                    'department'        => $request[$i]['department'],
                    'ts'                => now(),
                    // 'GUID'              => $guid,
                    // 'TITLEID'           => $request->companyId,
                    // 'webapp'            => 1
                  ];
            }

            DB::table('humanresource.leave_request')->insert($leaveArray);
        }
    
        // Post String JSON
        // log::debug(($request[0]['request_date']));
        // log::debug(gettype($request[0]['request_date']));

        // log::debug(gettype($request)); // object
        
        // $total = count($request); // 2
        
        // [0]['']
        // $request->count
        
        
        // log::debug($request->count);
        // log::debug($total);

        // $total = count((array)$obj);






    }
}
