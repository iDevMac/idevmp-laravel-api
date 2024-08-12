<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function getQuestions() {
        $questions = Question::all();
        return response(compact('questions'), 200);
    }

    public function getQuestion($id){

        if ($id) {
            # code...
            $questions = Question::where("video_id", $id)->get()->toArray();
            return response($questions, 200);   
        }

        return response([
            "msg" => "No questions found for this video"
        ], 404);
    }


    public function createQuestions(QuestionRequest $request) {
        try {
            //code...
            $data = $request->validated();
            $questionData = [
                'video_id' => $data['video_id'],
                'question' => $data['question'],
                'options' => $data['options'],
                'answer' => $data['answer'],
                'active' => $data['active']
            ];
    
            $question = Question::create($questionData);

        } catch (\Throwable $th) {
            throw $th;
        }

        return response([
            'msg' => 'Upload Successful',
            'question' => $question
        ], 201);
    }
}
