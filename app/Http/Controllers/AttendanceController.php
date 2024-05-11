<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;


class AttendanceController extends Controller
{
    public function attend(Request $req)
    {
        $current_date = date("Y-m-d");
        $attendance = Attendance::where('mid', $req->mid)->orderBy('created_at', 'desc')->first();

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
        }
    }

    public function getAttendanceInfo($date){
        $data=Attendance::where('date',$date)->get();
        return response()->json($data);
    }
}
