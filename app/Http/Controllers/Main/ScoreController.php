<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScoreRequest;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
    public function getScores(){
        $scores = Score::all();
        return response($scores, 200);
    }

    public function getScore($id){
        $user = Auth::user();
        $score = Score::where(["video_id" => $id, "user_id" => $user->id])->firstOrFail();
        return response($score, 200);
    }

    public function updateScore(ScoreRequest $request, $id): HttpResponse {
        $data = $request->validated();
        $user = Auth::user();


        $score = Score::where(["user_id" => $user->id, "video_id" => $id]);

        if ($score === null) {
            return response(
                "User with id {$user->id}, having video with id {$id} not found",
            //    Response::
            );
        }

        $updateScore = $score->update($data);
        if ($updateScore === false) {
            return response(
                "Couldn't update the user with id {$user->id}",
                
            );
        }

        return response($updateScore);
    }



    public function createScores(ScoreRequest $request){
        $data = $request->validated();

        $scoreData = [
            "user_id" => $data["user_id"],
            "video_id" => $data["video_id"],
            "score" => $data["score"],
            "active" => $data["active"]
        ];

        $score = Score::create($scoreData);

        return response([
            "msg" => "Uploaded successfully",
            "data" => $score
        ], 201);
    }
}
