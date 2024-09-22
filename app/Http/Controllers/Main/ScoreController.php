<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScoreRequest;
use App\Models\Score;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    public function getScores(){
        $scores = Score::all();
        return response($scores, 200);
    }

    public function getScore($id){
        $userId = Auth::user()->id;
        $score = Score::where(["video_id" => $id, "user_id" => $userId])->firstOrFail();
        return response($score, 200);
    }

    public function updateScore(Request $request, $id){
        $data = $request->validated();


        $user = $request->user();

        $score = Score::where(["user_id" => 1, "video_id" => $id])->firstOrFail();

        if ($score == null) {
            return response(
                "User with id {$user->id}, having video with id {$id} not found",
             404);
        }

            $score->score = $data["score"];
            $score->scored = $data["scored"];
            $score->percentage = $data["percentage"]; 

            $updateScore = $score->create();

        if ($updateScore === false) {
            return response(
                "Couldn't update the user with id {$user->id}",
                
            );
        }

        return response("Score Successfully Updated", 201);
    }



    public function createScores(Request $request){
        
        try {
            //code...
            // $data["user_id"] = Auth::user()->id;
            $data = $request->validate([
                "user_id" => "required|numeric",
                "video_id" => "required|numeric",
                "score" => "required|numeric",
                "scored" => "required",
                "percentage" => "required|numeric",
                "active" => "string"
            ]);

            $score = Score::firstOrNew([ "user_id" => $data["user_id"], "video_id" => $data["video_id"] ]);
                $score->user_id = $data["user_id"];
                $score->video_id = $data["video_id"];
                $score->score = $data["score"];
                $score->scored = $data["scored"];
                $score->percentage = $data["percentage"];
                $score->active = $data["active"];
            $score->save();

            return response($score, 201);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
