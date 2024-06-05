<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

function generateSecureRandomPassword($length = 12) {
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $digits = '0123456789';
    $special = '!@#$%^&*()-_=[]{}|;:,.<>?';

    // Ensure at least one character from each set
    $password = [
        $uppercase[random_int(0, strlen($uppercase) - 1)],
        $lowercase[random_int(0, strlen($lowercase) - 1)],
        $digits[random_int(0, strlen($digits) - 1)],
        $special[random_int(0, strlen($special) - 1)],
    ];

    // Fill the rest of the password length with random characters
    $allCharacters = $uppercase . $lowercase . $digits . $special;
    for ($i = 4; $i < $length; $i++) {
        $password[] = $allCharacters[random_int(0, strlen($allCharacters) - 1)];
    }

    // Shuffle the characters to ensure random distribution
    shuffle($password);

    // Convert the array to a string
    return implode('', $password);
}


class MemberController extends Controller
{
    public function create(Request $req){
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/',
            'dob' => 'nullable|date',
            'gender' => 'required',
            'email' => 'required|string|unique:member,email|regex:/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/',
            'contact_number' => 'required',
            'address' => 'required',
            'weight' => 'nullable',
            'height' => 'nullable',
            'photo' => 'required'
        ]);

        if ($validator->fails()) {
             return response()->json(['error'=>$validator->errors()],400);
        }

        $random_password=generateSecureRandomPassword(12);
       

        $mail = Mail::send('mail',['name'=>$req->name, 'email' => $req->email, 'password' => $random_password], function($message) use($req) {
            $message->to($req->email, $req->name)->subject
               ('Welcome to Club Desperado');
            $message->from(env('MAIL_FROM_ADDRESS'),'Club Desperado');
        });
        
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
            'password'=>$random_password,
        ]);

        return response()->json(['message'=>"Member created successfully",'password'=>$random_password],200);
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
        return response()->json(['message'=>"Successfully Deleted"],200);
    }

    public function update($mid,Request $req){
        $currentMember = Member::find($mid);
        $validator = Validator::make($req->all(), [
            'name' => 'required|string|regex:/^[a-zA-Z\s]+$/',
            'dob' => 'nullable|date',
            'gender' => 'required',
            'email' => "required|unique:member,email,{$mid},mid|regex:/^[\w\.-]+@[a-zA-Z\d\.-]+\.[a-zA-Z]{2,6}$/",
            'contact_number' => 'required',
            'address' => 'required',
            'weight' => 'nullable',
            'height' => 'nullable',
            'photo' => 'required'
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
            return response()->json(['message'=>'Password changed']);
            }
        }
        return response()->json(['message'=>'Failed to change password']);
    }
}
