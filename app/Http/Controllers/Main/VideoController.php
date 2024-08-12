<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Video;

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
            "link" => $data["link"],
            "name" => $data["name"],
            "poster" => $data["poster"],
            "active" => $data["active"]
        ];

        $video = Video::create($videoData);

        return response([
            "msg" => "Uploaded successfully",
            "data" => $video
        ], 201);
    }
}
