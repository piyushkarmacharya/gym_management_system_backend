<?php

namespace App\Http\Controllers;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function read($email,Request $req){
        $data=Staff::where("email",$email)->get();
        return response()->json($data);
    }

    public function login(Request $req){
        $login = Auth::guard('staff')->attempt([
            'email' => $req->email,
            'password' => $req->password,
        ]);


        return response()->json(["login"=> $login]);
        
        // return response()->json($req->all());
    }
    public function create(Request $req){
        
        $Staff=Staff::create([
            'first name'=>$req->name,
            'last name'=>"default for now",
            'gender'=>$req->gender,
            'email'=>$req->email,
            'phone number'=>$req->contact_number,
            'address'=>$req->address,
            'password'=>$req->password,
        ]);

        return response()->json(['message'=>"Successfully inserted"],200);
    
    
    }
}
