<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function insert(Request $req){

    }
    public function read($email,Request $req){
        $data=Admin::where("email",$email)->get();
        return response()->json($data);
    }
    public function update($id,Request $req){
        
    }
    public function delete($id,Request $req){
        
    }
    public function login(Request $req){
        $login = Auth::guard('admin')->attempt([
            'email' => $req->email,
            'password' => $req->password,
        ]);
        $id=0;
        if($login){
            $id=Admin::where('email',$req->email)->first()->id;
        }
        return response()->json(["login"=> $login,"id"=>$id]);
        
        
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

            return response()->json(['message'=>'success']);

            }
        }

        return response()->json(['message'=>'failed']);

    }
}
