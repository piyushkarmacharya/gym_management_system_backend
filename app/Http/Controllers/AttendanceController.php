<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class AttendanceController extends Controller
{
    public function getTotalPresent($date,Request $req){
        $totalPresent=Attendance::where('date',$date)->count();
        return response()->json(["totalPresent" => $totalPresent]);

    }
    public function getMemberTotalPresent($mid,Request $req){
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $totalPresent = Attendance::where('mid', $mid)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->count();

        return response()->json(["totalPresent" => $totalPresent]);

       

    }

    public function attend(Request $req)
    {
        $current_date = date("Y-m-d");
        $attendance = Attendance::where('mid', $req->mid)->orderBy('date', 'desc')->first();

        if ($attendance) {
            $last_attendance_date = $attendance->date;

            if ($current_date == $last_attendance_date) {
                return response()->json(["message" => "You have already checked in today"]);
            } else {
                $attend = Attendance::create(
                    [
                        'mid' => $req->mid,
                        'date' => date("Y-m-d"),
                    ]

                );
                if ($attend) {
                    return response()->json(["message" => "Checked in successfully"]);
                }
            }
        } else {
            $attend = Attendance::create(
                [
                    'mid' => $req->mid,
                    'date' => date("Y-m-d"),
                ]

            );
            return response()->json(["message" => "Checked in successfully"]);
        }
    }

    public function getAttendanceInfo($date)
    {
        $info = DB::table('member')
            ->join('attendance', 'member.mid', '=', 'attendance.mid')
            ->select('attendance.date','member.name','member.mid','member.contact_number','attendance.created_at')
            ->where('attendance.date','=',$date)
            ->get();
        
        return response()->json($info);
    }
    
    public function getMemberAttendanceInfo($mid)
    {
        $info = DB::table('member')
            ->join('attendance', 'member.mid', '=', 'attendance.mid')
            ->select('attendance.date','member.name','member.mid','member.contact_number','attendance.created_at')
            ->where('attendance.mid','=',$mid)
            ->orderBy('date', 'desc')
            ->get();
        
        return response()->json($info);
    }
}
