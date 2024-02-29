<?php

namespace App\Http\Controllers;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function read($email,Request $req){
        $data=Staff::where("email",$email)->get();
        return response()->json($data);
    }
}
