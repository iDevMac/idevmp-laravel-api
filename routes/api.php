<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Main\QppointController;
use App\Http\Controllers\Main\QuestionController;
use App\Http\Controllers\Main\ScoreController;
use App\Http\Controllers\Main\VideoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware("auth:sanctum")->group(function (){
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Videos Routes
    Route::prefix("/videos")->group(function (){
        Route::get("/", [VideoController::class, "getVideos"]);
        Route::get("/{id}", [VideoController::class, "getVideo"]);
        Route::post("/", [VideoController::class, "createVideos"]);
    });

    // Question Routes
    Route::prefix("/questions")->group(function () {
        Route::get("/", [QuestionController::class, "getQuestions"]);
        Route::get("/{id}", [QuestionController::class, "getQuestion"]);
        Route::post("/", [QuestionController::class, "createQuestions"]);    
    });

    // Qppoints Routes
    Route::prefix("/qppoints")->group(function (){
    Route::get("/", [QppointController::class, "getQppoints"]); 
    Route::get("/{id}", [QppointController::class, "getQppoints"]);
    Route::post("/", [QppointController::class, "createQppoints"]);
    });

    // Scores Routes
    Route::prefix("/scores")->group(function (){
    Route::get("/", [ScoreController::class, "getScores"]);
    Route::get("/{id}", [ScoreController::class, "getScore"]);
    Route::put("/{id}", [ScoreController::class, "updateScore"]);
    Route::post("/", [ScoreController::class, "createScores"]); 
    });

    Route::get("/signout", [AuthController::class, "signOut"]);
});


    Route::post("/signin", [AuthController::class, "signIn"]);
    Route::post("/signup", [AuthController::class, "signUp"]);
