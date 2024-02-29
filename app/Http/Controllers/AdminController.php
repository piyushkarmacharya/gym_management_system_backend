<?php

namespace App\Http\Controllers;
use App\Models\Admin;
use Illuminate\Http\Request;

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
}
