<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\ScoreRequest;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function getScores(){
        $scores = Score::all();
        return response($scores, 200);
    }

    public function getScore($id){
        $score = Score::where("video_id", $id)->firstOrFail();
        return response($score, 200);
    }

    public function createScores(ScoreRequest $request){
        $data = $request->validated();

        $scoreData = [
            "link" => $data["link"],
            "name" => $data["name"],
            "poster" => $data["poster"],
            "active" => $data["active"]
        ];

        $score = Score::create($scoreData);

        return response([
            "msg" => "Uploaded successfully",
            "data" => $score
        ], 201);
    }
}
