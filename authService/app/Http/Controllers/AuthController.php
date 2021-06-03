<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public $loginAfterSignUp = true;

    public function login(Request $request) {
        $creds = $request->only("email", "password");
        $token = JWTAuth::attempt($creds);

        if(!$token)
        {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        setcookie("auth_token", $token);

        return response()->json([
            "meme"=> $this->loginAfterSignUp,
            "status" => true,
            "token" => $token
        ]);
    }

    public function register(Request $request) {
        $this->validate($request, [
            "username" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|string|min:6|max:32"
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        if($this->loginAfterSignUp) {
            return $this->login($request);
        }

        return response()->json([
            "meme"=> $this->loginAfterSignUp,
            "status" => true,
            "user" => $user
        ]);
    }

    public function checkToken(Request $request)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            return response()->json(['type'=>'Success', 'message'=>'token is valid'],200);
        }
        catch (JWTException $e) {
            return response()->json(['type'=>'Error', 'message'=>'token expired or user unauthorized'],401);
        }

    }

    public function logout(Request $request)
    {
        $this->validate($request, [
            "token" => "required"
        ]);

        try {
            JWTAuth::invalidate($request->token);
            return response()->json([
                "status" => true,
                "message" => "User logged out successfully"
            ]);
        }
        catch (JWTException $exception) {
            return response()->json([
                "status" => false,
                "message" => "Ops, the user can not be logged out"
            ]);
        }
    }
}
