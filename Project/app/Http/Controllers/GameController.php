<?php

namespace App\Http\Controllers;

use App\GameResult;
use Illuminate\Http\Request;
use App\Text;

use App\Game;

class GameController extends Controller {

    /**
     * Get a race with certain settings, if there are no races, create one and return it
     *
     */
    public function index(Request $request) {
        $len = $request->input('len') == 'any' ? ['smol', 'med', 'long'] :
            [$request->input('len')];

        $topic = $request->input('topic');
        $lang = $request->input('lang') == 'any' ? ['ru', 'en'] : [$request->input('lang')];

        $topics = explode(',', $topic);

        foreach ($topics as $topic) {
            $topic = trim($topic);
        }


        $texts = null;

        if ($topic == 'any') {
            $texts = Text::whereIn('length', $len)->whereIn('lang', $lang)->pluck('id')->toArray();
        } else {
            $texts = Text::whereIn('length', $len)->whereIn('lang', $lang)->whereIn('topic', $topics)
                ->pluck('id')->toArray();
        }


        $game = Game::with('text')->whereIn('text_id', $texts)->where('started', '=', false)->first();


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


        $newGame->text_id = $texts[array_rand($texts)];

        file_put_contents('C:\Users\57thr\Documents\GitHub\PRITR\Project\app\Http\Controllers\log.txt', sizeof($texts));

        $newGame->started = false;

        $newGame->game_time = time();


        $newGame->save();

        return $newGame::with('text')->get();

    }


    public function startGame(Request $request){
        $id = $request->id;

        $game = Game::where('id', '=', $id)->where('started', '=', false)->started = true;
        if(!$game) {
            return 0;
        }
        $game->save();

        return $game;
    }

    public function join_game(Request $request) {
        $game_id = $request->gameId;

        $game_res = new GameResult();

        $game_res->user = auth()->user()->id;

        $game_res->game_id = $game_id;

        $game_res->save();

        return $this->get_game_members($game_id);
    }

    /**
     * Gets the members of the race as well as the results
     *
     * @param int $id
     */
    public function get_game_members(Request $request){
        $members = GameResult::with('user')::where('game_id', $request->input('gameId'))->get();


        return $members;

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