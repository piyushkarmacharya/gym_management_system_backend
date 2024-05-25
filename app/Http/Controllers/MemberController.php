<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function create(Request $req){
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|alpha:ascii',
            'dob' => 'nullable|date',
            'gender' => 'required',
            'email' => 'required|string|unique:member,email|regex:/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/',
            'contact_number' => 'required',
            'address' => 'required',
            'weight' => 'nullable',
            'height' => 'nullable',
            'password' => 'required',
            'photo' => 'nullable'
        ]);

        if ($validator->fails()) {
             return response()->json(['error'=>$validator->errors()],400);
        }

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

        return response()->json(['message'=>"Member created successfully"],200);
    }

    public function login(Request $req){
        $login = Auth::guard('member')->attempt([
            'email' => $req->email,
            'password' => $req->password,
        ]);
        $mid=0;
        $name="";
        $photo="";
        if($login){
            $mid=Member::where('email',$req->email)->first()->mid;
            $name=Member::where('email',$req->email)->first()->name;
            $photo=Member::where('email',$req->email)->first()->photo;
        }
        return response()->json(["login"=> $login,"mid"=>$mid,"name"=>$name,"photo"=>$photo]);
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
        $currentMember = Member::find($mid);
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|alpha:ascii',
            'dob' => 'nullable|date',
            'gender' => 'required',
            'email' => "required|unique:member,email,{$mid},mid|regex:/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/",
            'contact_number' => 'required',
            'address' => 'required',
            'weight' => 'nullable',
            'height' => 'nullable',
            'photo' => 'nullable'
        ]);

        if ($validator->fails()) {
             return response()->json(['error'=>$validator->errors()],400);
        }
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
            
            ]
        );
        return response()->json(['message'=>"Update Successful"]);

    }
    
    public function changePassword(Request $req){
        $user = Member::where('mid', $req->mid)->first();
        if($user) {
            $email = $user->email;
            if(Auth::guard('member')->attempt([
                'email' => $email,
                'password' => $req->oldPassword,
            ])) {
                Member::where('mid',$req->mid)->update(
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
