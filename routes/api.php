<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AppContoller;
use App\Http\Controllers\Api\CategoryContoller;
use App\Http\Controllers\Api\LogContoller;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::resource('apps', AppContoller::class)->only([
//     'index'
// ]);

// Route::resource('logs', LogContoller::class)->only([
//     'index'
// ]);

// Route::resource('categories', CategoryContoller::class)->only([
//     'index'
// ]);


Route::apiResources([
    'apps' => AppContoller::class,
    'logs' => LogContoller::class,
    'categories' => CategoryContoller::class,
    'users' => UserController::class,
]);

Route::post('auth/register', [UserController::class, 'register']);
Route::post('auth/login', [UserController::class, 'login']);
Route::post('auth/kiosk-login', [UserController::class, 'kiosk_login']);
Route::get('auth/check/{id}', [UserController::class, 'check']);
Route::get('app/members/{manager_id}', [AppContoller::class, 'getMembersApp']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/sync', [ApiController::class, 'sync']);
Route::post('auth/sync2', [ApiController::class, 'sync2']);
Route::get('getFile/{id}/{image}', [ApiController::class, 'getFile']);
Route::get('check-connection', function () {return true;});


Route::post('post-aex-filter', [ApiController::class, 'filter']); // filter logs
Route::get('get-dtr-logs/{id}', [ApiController::class, 'getLogs']); // get dtr of all users under this manager
Route::post('post-dtr-logs-approve', [ApiController::class, 'set']); // approve multiple row

Route::post('register', [ApiController::class, 'register']); // user register
Route::get('get-hr-shift/{id}', [ApiController::class, 'getHrEmpShift']); // get hr_emp_shift by id

Route::get('get-getEmployeeScheduling', [ApiController::class, 'getEmployeeScheduling']); // get employee scheduling
Route::post('post-deleteEmployeeSchedule', [ApiController::class, 'deleteEmployeeSchedule']); // delete employee scheduling transactions

Route::post('post-deleteInsertHrEMPShift', [ApiController::class, 'deleteInsertHrEMPShift']); // delete and insert hr emp shift
Route::get('user/get_members/{manager_id}', [UserController::class, 'get_members']); // get name and employee id of manager

Route::get('get-getEmpScheduleType/{id}', [ApiController::class, 'getEmpScheduleType']); // get employee schedule type

Route::get('get-getprojects/{id}', [ApiController::class, 'getprojects']); // get projects in general.setup_projects for OT

Route::get('get-getHROT', [ApiController::class, 'getHROT']); // get human resource overtime request data.
Route::get('get-transferredHROT', [ApiController::class, 'transferredHROT']); // Update transfer to true.

Route::get('get-reportingManager/{id}', [ApiController::class, 'getReportingManager']); // Update transfer to true.

Route::get('/get-getLeaveBalance/{id}', [ApiController::class, 'getLeaveBalance']); // get request for purchase request

Route::post('post-saveLAF', [ApiController::class, 'saveLAF']); // delete and insert hr emp shift

