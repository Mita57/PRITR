<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $http = new \GuzzleHttp\Client([    'base_uri' => 'http://localhost:8001',
            'defaults' => [
                'exceptions' => false
            ]]);

        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->email,
                    'password' => $request->password,
                    'scope'=>''
                ]
            ]);

            $nick = User::where('email', '=', $request->email)->get()[0]->username;

            $resp = json_decode($response->getBody()->getContents(), true);

            $resp['nick'] = $nick;


            return json_encode($resp);

        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }

            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);



        return User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mmr'=>0,
            'last_10'=>'',
            'max_ever'=>0,
            'finished_games_overall'=>0,
            'battle_royale_finished'=>0,
            'battle_royale_won'=>0,
            'classic_finished'=>0,
            'classic_won'=>0,
            'arena_got_to_room1'=>0,
            'arena_played'=>0
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Logged out successfully', 200);
    }
}
