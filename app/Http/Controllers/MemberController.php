<?php

namespace App\Http\Controllers;
use App\Models\Member;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function create(Request $req){
        $member=Member::create([
            'name'=>$req->name,
            'dob'=>$req->dob,
            'gender'=>$req->gender,
            'email'=>$req->email,
            'contact_number'=>$req->contact_number,
            'address'=>$req->address,
            'weight'=>$req->weight,
            'height'=>$req->height,
        ]);

        return response()->json(['message'=>"Succeddfully inserted"],200);
    }
    public function read(){
        $data=Member::all();
        return response()->json($data);
    }
    public function readSingle($email,Request $req){
        $data=Member::where('email',$email)->get();
        return response()->json($data);
    }
}
