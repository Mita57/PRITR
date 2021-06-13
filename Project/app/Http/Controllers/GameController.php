<?php

namespace App\Http\Controllers;

use App\GameResult;
use App\User;
use Illuminate\Http\Request;
use App\Text;

use App\Game;
use Illuminate\Support\Facades\DB;

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


        $newGame->started = false;

        $newGame->game_time = time();


        $newGame->save();

        return $newGame::with('text')->get()->first();

    }


    public function startGame(Request $request) {
        $id = $request->id;


        $game = Game::where('id', '=', $id)->where('started', '=', false)->first();


        if (!$game) {
            return 0;
        }

        $game->started = true;

        $game->save();

        return $game;
    }

    public function join_game(Request $request) {

        $game_id = $request->gameId;


        if (sizeof(GameResult::where(['game_id' => $game_id, 'user_id' => auth()->user()->id])->get()) != 0) {
            return $this->get_game_members($request);
        }


        $game_res = new GameResult();


        $game_res->user_id = auth()->user()->id;

        $game_res->game_id = $game_id;

        $game_res->cpm = 0;

        $game_res->place = 0;


        $game_res->save();


        return $this->get_game_members($request);
    }

    /**
     * Gets the members of the race as well as the results
     *
     * @param int $id
     */
    public function get_game_members(Request $request) {

        $members = GameResult::where('game_id', $request->gameId)->with('user')->get();

        //        if (sizeof($members) >=2) {
        //            $this->startGame($request);
        //        }


        return $members;

    }

    public function post_text_data(Request $request) {
        $game_id = round($request->gameId);

        $user_id = round(auth()->user()->id);

        $cpm = round($request->cpm);

        $completion = round($request->completion);


        file_put_contents('C:\Users\57thr\Documents\GitHub\PRITR\Project\app\Http\Controllers\log.txt',
            sprintf('UPDATE classic_results SET cpm = %d , completion = %s WHERE game_id = %f AND user_id = %g',
                $cpm, $completion, $game_id, $user_id), FILE_APPEND);

        DB::update(sprintf('UPDATE classic_results SET cpm = %d , completion = %s WHERE game_id = %f AND user_id = %g',
            $cpm, $completion, $game_id, $user_id));

    }


    public function game_final(Request $request) {
        $user_id = auth()->user()->id;

        $game_id = $request->gameId;

        $cpm = round($request->cpm);

        $race_time = round($request->raceTime);

        $place = round(GameResult::where('game_id', '=', $game_id)->max('place') + 1);

        if ($place == 1) {
            $user->classic_won = round($user->classic_won + 1);
        }

        $user = User::find($user_id);

        $user->cpm_sum = round($user->cpm + $cpm);

        $user->classic_finished = round($user->classic_finished++);

        $user->last_10 = $this->get_last_10($user->last_10, $cpm);

        $user->cpm_last_10 = round($this->get_cpm_last_10($user->last_10));

        $user->save();

        DB::update(sprintf('UPDATE classic_results SET race_time = %s, place = %k WHERE game_id = %f AND user_id = %g',
            $race_time, $place, $game_id, $user_id));

        return $user;
    }

    private function get_last_10($last_10, $cpm) {

        $res_string = $last_10;

        $results = explode(',', $last_10);

        if (sizeof($results) == 10) {
            $res_string = substr($res_string, strlen($res_string[0] + 1));
            $res_string .= $cpm . ',';
            return $res_string;
        }

        $res_string .= $cpm . ',';
        return $res_string;
    }

    private function get_cpm_last_10($last_10) {
        $results = explode(',', $last_10);

        $sum = 0;

        foreach ($results as $res) {
            $sum += (int)$res;
        }

        return $sum / sizeof($results);
    }

}
