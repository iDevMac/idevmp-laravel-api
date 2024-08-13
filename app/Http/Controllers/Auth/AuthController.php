<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signIn(SignInRequest $request) {
        $data = $request->validated();
        $credentials = ['email'=>$data['email'], 'password'=>$data['password']];

            if (!Auth::guard('web')->attempt($credentials)) {
                return response([
                    'msg' => 'Provided credentials are invalid',
                ], 422);
            }

            /** @var User $user */
            $user = Auth::user();
            $token = $user->createToken('plain')->plainTextToken;
            $status = $user->admin;

          return response(compact('user', 'token', 'status'));
    }

    public function signUp(SignUpRequest $request){
        $data = $request->validated();

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ];

        $user = User::create($userData);

        $token = $user->createToken('plain')->plainTextToken;

        $status = $user->admin;

        return response(compact('user', 'token', 'status'), 201);
    }

    public function signOut(Request $request){
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete;

        return response('', 204);
    }
}
