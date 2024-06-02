<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
   
    // public function read($email,Request $req){
    //     $data=Admin::where("email",$email)->get();
    //     return response()->json($data);
    // }
  
    
    public function login(Request $req){
        $login = Auth::guard('admin')->attempt([
            'email' => $req->email,
            'password' => $req->password,
        ]);
        $id=0;
        $name="";
        if($login){
            $id=Admin::where('email',$req->email)->first()->id;
            $name=Admin::where('email',$req->email)->first()->name;
        }
        return response()->json(["login"=> $login,"id"=>$id,"name"=>$name]);
    }

    
    public function changePassword(Request $req){
        $user = Admin::where('id', $req->id)->first();
        if($user) {
            $email = $user->email;
            if(Auth::guard('admin')->attempt([
                'email' => $email,
                'password' => $req->oldPassword,
            ])) {
                Admin::where('id',$req->id)->update(
                    [
                        'password' => Hash::make($req->newPassword),
                    ]
                );
            return response()->json(['message'=>'Successfully changed password']);
            }else{
                return response()->json(['message'=>'Old password donot match']);
            }
        }
        
    }
}
