<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AttendanceQr;

class AttendanceQrController extends Controller
{
    public function read(){
        $data=AttendanceQr::first();
        return response()->json($data);
    }

    public function update(Request $req){
        $qr=AttendanceQr::where('id',1)->update(
            [
            'qrstr'=>$req->qrstr,
            ]
        );
    }
}
