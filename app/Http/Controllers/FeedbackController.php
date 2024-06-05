<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function setFeedback(Request $req){
        $today=date("Y-m-d");
        $feed=Feedback::create([
            "mid"=>$req->mid,
            "feedback"=>$req->feedback,
            "date"=>$today
        ]);
        if($feed){
            return response()->json(['message'=>"Successfully added feedback"]);
        }
    }
    public function deleteFeedback($id){
        $feed=Feedback::where("id",$id)->delete();
        if($feed){
            return response()->json(['message'=>"Deleted Successfully"]);
        }
    }
}
