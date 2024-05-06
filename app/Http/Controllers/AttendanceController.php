<?php

namespace App\Http\Controllers;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function attend(Request $req){
        $attend=Attendance::create(
            [
                'mid'=>$req->mid,
            ]

        );
    }
}
