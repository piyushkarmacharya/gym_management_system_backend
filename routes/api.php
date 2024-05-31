<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\MemberController;

use App\Http\Controllers\ImageeController;
use App\Http\Controllers\AttendanceQrController;
use App\Http\Controllers\AttendanceController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('admin/login',[AdminController::class,'login']);
Route::post('admin/change-password',[AdminController::class,'changePassword']);
Route::post('Member/login',[MemberController::class,'login']);


Route::post('Member/register',[MemberController::class,'create']);
Route::get('Member/details',[MemberController::class,'read']);
Route::get('Member/delete/{mid}',[MemberController::class,'delete']);
Route::post('Member/update/{mid}',[MemberController::class,'update']);             
Route::post('member/change-password',[MemberController::class,'changePassword']);

Route::get('Member/details/{name}',[MemberController::class,'readSingle']);


Route::get('AttendanceQr',[AttendanceQrController::class,'read']);
Route::post('AttendanceQr/update',[AttendanceQrController::class,'update']);             
Route::post('attendance',[AttendanceController::class,'attend']);             
Route::get('attendance/info/{date}',[AttendanceController::class,'getAttendanceInfo']);          
Route::get('attendance/member-total-present/{mid}',[AttendanceController::class,'getMemberTotalPresent']);          
Route::get('memberattendance/info/{mid}',[AttendanceController::class,'getMemberAttendanceInfo']);          


