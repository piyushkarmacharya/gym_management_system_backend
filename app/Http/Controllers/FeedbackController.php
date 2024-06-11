<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
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
    public function getFeedback(){
        $info = DB::table('feedback')
        ->join('member', 'feedback.mid', '=', 'member.mid')
        ->select('feedback.date','feedback.id','member.mid','member.name','feedback.feedback')
        ->orderBy('feedback.date','desc')
        ->get();
    
    return response()->json($info);
            
    }
    public function deleteFeedback($id){
        $feed=Feedback::where("id",$id)->delete();
        if($feed){
            return response()->json(['message'=>"Deleted Successfully"]);
        }else{
            return response()->json(['message'=>"Feedback not found"]);
        }
    }
}
