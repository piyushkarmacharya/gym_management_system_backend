<?php

namespace App\Http\Controllers;
use App\Models\Imagee;

use Illuminate\Http\Request;

class ImageeController extends Controller
{
    public function create(Request $req){
        $imagee=Imagee::create([
            'img'=>$req->img
        ]
        );
        return response()->json(['message'=>"Succeddfully inserted"],200);
    }
    public function read(){
        $imagee=Imagee::all();
        return response()->json($imagee);
    }
}
