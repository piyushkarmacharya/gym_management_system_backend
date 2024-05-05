<?php

namespace App\Http\Controllers;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

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
            'photo'=>$req->photo,
            'password'=>$req->password,
        ]);

        return response()->json(['message'=>"Succeddfully inserted"],200);
    }

    public function login(Request $req){
        $login = Auth::guard('member')->attempt([
            'email' => $req->email,
            'password' => $req->password,
        ]);
        return response()->json(["login"=> $login]);
    }

    public function read(){
        $data=Member::all();
        return response()->json($data);
    }

    public function readByEmail($email,Request $req){
        $data=Member::where("email",$email)->get();
        return response()->json($data);
    }

    public function readSingle($name,Request $req){
        $data=Member::where('name',$name)->get();
        return response()->json($data);
    }
    public function delete($mid,Request $req){
        $mem=Member::where('mid',$mid)->delete();
    }

    public function update($mid,Request $req){
        $memb=Member::where('mid',$mid)->update(
            [
            'name'=>$req->name,
            'dob'=>$req->dob,
            'gender'=>$req->gender,
            'email'=>$req->email,
            'contact_number'=>$req->contact_number,
            'address'=>$req->address,
            'weight'=>$req->weight,
            'height'=>$req->height,
            'photo'=>$req->photo,
            'password'=>$req->password,
            ]
        );
    }
}
