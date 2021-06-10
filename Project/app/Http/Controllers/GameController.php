<?php

namespace App\Http\Controllers;

use App\GameResult;
use Illuminate\Http\Request;

use App\Game;

class GameController extends Controller {
    public function index(Request $request) {
        $len = $request->input('len') == 'any' ? ['smol', 'med', 'long'] :
            [$request->input('len')];

        $topic = $request->input('topic');
        $lang = $request->input('lang') == 'any' ? ['ru', 'en'] : [$request->input('lang')];

        $topics = explode(',', $topic);

        foreach ($topics as $topic) {
            $topic = trim($topic);
        }

        $texts = Text::whereIn('length', $len)->whereIn('lang', $lang)->whereIn('topic', $topics)
            ->lists('id')->toArray();

        $game = Game::whereIn('game_id', $texts)->where('started', '=', false);

        if (!$game) {
            return $this->store($request, $texts);
        }

        return $game;

    }


    /**
     * Store a newly created resource in storage.
     *
     */
    public function store(Request $request, $texts) {
        $newGame = new Game();

        $newGame->text = array_rand($texts);

        $newGame->started = time();

        $newGame->save();

        return $newGame;

    }


    public function startGame($id) {
        $game = Game::where('id', '=', $id)->started = true;
        $game->save();

        return $game;
    }

    public function join_game($game_id, $user) {
        $game_res = new GameResult();

        $game_res->user = $user;

        $game_res->save();

        return $this->get_game_members($game_id);
    }

    public function get_game_members($game_id) {

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id) {

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

    }
}
