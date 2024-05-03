<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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


        return response()->json(["login"=> $login, "token" => "abc"]);
        
        // return response()->json($req->all());
    }
}
