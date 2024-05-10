<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attend(Request $req){
        $current_date = date("Y-m-d"); 
        $attendance=Attendance::where('mid',$req->mid)->orderBy('created_at', 'desc')->first();

        if($attendance){
            $last_attendance_date = substr($attendance->created_at, 0, 10);

            if($current_date == $last_attendance_date) {
                return response()->json(["message"=>"You have already checked in today"]);
            }

            else {
                $attend=Attendance::create(
                    [
                        'mid'=>$req->mid,
                    ]
        
                );

                if($attend){
                    return response()->json(["message"=>"Checked in successfully"]);
                }
            }
        }
       
        else {
            $attend=Attendance::create(
                [
                    'mid'=>$req->mid,
                ]
    
            );
        }
        
       
    }
}
