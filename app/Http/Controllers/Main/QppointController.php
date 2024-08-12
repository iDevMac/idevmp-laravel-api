<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\QppointRequest;
use App\Models\Qppoint;
use Illuminate\Http\Request;

class QppointController extends Controller
{
    public function getQppoits(){
        $qppoints = Qppoint::all();

        return response($qppoints, 200);
    }

    public function getQppoints($id){

        if ($id) {
            $qppoint = Qppoint::where("video_id", $id)->get()->toArray();
            return response($qppoint, 200);
        }

        return response([
            "msg" => "The question popup point(s) was not found"
        ], 404);

    }

    public function createQppoints(QppointRequest $request){
        $data = $request->validated();

        $qppointData = [
            "video_id" => $data["video_id"],
            "progress" => $data["progress"],
            "percentage" => $data["percentage"],
            "active" => $data["active"]
        ];

        $qppoint = Qppoint::create($qppointData);

        return response([
            "msg" => "Upload successful",
            "data" => $qppoint
        ], 201);
    }
}
