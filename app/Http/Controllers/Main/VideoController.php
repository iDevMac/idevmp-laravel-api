<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Score;
use App\Models\Video;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VideoController extends Controller
{
    public function getVideos(){
        $videos = Video::all();
        return response($videos, 200);
    }

    public function getVideo($id){
        $video = Video::where("id", $id)->firstOrFail();
        // return count($video);
        if (empty($video)) {
            return response([
                'msg' => `Video with id of {$id} was not found`,
            ], 404);
        }

        return response($video, 200);
    }

    public function createVideos(VideoRequest $request) {
        $data = $request->validated();

        $videoData = [
            "name" => $data["name"],
            "link" => $data["link"],
            "poster" => $data["poster"],
            "active" => $data["active"]
        ];

        $video = Video::create($videoData);

        // Get the last id inserted
        $lastInsertedId = DB::getPdo()->lastInsertId();



        // Create Score for each video uploaded 
        $scoreData = [
            "user_id" => Auth::user()->id,
            "video_id" => $lastInsertedId,
            "score" => "undefined",
            "active" => "Yes"
        ];

        $score = Score::create($scoreData);

        return response([
            "msg" => "Uploaded successfully",
            "data" => $video
        ], 201);
    }
}
