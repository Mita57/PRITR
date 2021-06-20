<?php

namespace App\Http\Controllers;

use App\Game;
use App\Room;
use App\RoomMembers;
use App\Text;
use Illuminate\Http\Request;
use App\Http\Controllers\GameController;

class RoomController extends Controller {
    /**
     * Get a random text of certain length
     *
     *
     */
    public function index(Request $request) {
        $roomId = $request->input('room');



        $room = Room::where('id', '=', $roomId)->get()->last();

        if ($room) {
            return $this->join_room($request);
        } else {
            return response(['msg' => 'Nothing found'], 404);
        }
    }

    /**
     *
     *
     */
    public function store(Request $request) {
        $newRoom = new Room();

        $newRoom->save();


        return $newRoom;
    }

    public function next_game(Request $request) {
        $len = $request->len == 'any' ? ['smol', 'med', 'long'] :
            [$request->len];

        $topic = $request->topic;
        $lang = $request->lang == 'any' ? ['ru', 'en'] : [$request->lang];

        $room_id = $request->roomId;

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

        $gc = new GameController();
        $newGame = $gc->store($request, $texts, $room_id);

        $room = Room::find($room_id);

        $room->curr_game_id = $newGame->id;

        $room->save();

        return $newGame;

    }

    public function check_game(Request $request) {
        $client_game = $request->input('clientGame');
        $room_id = $request->input('roomId');

        file_put_contents('C:\Users\57thr\Documents\GitHub\PRITR\Project\app\Http\Controllers\log.txt', $room_id, FILE_APPEND);

        $curr_game = Room::find($room_id)->curr_game_id;

        if ($curr_game == $client_game) {
            return false;
        }

        return Game::find($curr_game);

    }

    public function check_game_members(Request $request) {
        $room = $request->input('roomId');


        return RoomMembers::with('User')->where('room_id', '=', $room)->get();
    }

    public function join_room(Request $request) {
        $user_id = auth()->user()->id;
        $room_id = $request->input('room');

        $check = RoomMembers::where(['user_id' => $user_id, 'room_id'=>$room_id])->get();

        if(sizeof($check)) {
            return $this->check_game_members($request);
        }



        $roomMeme = new RoomMembers();
        $roomMeme->user_id = $user_id;
        $roomMeme->room_id = $room_id;


        $roomMeme->save();

        return $this->check_game_members($request);

    }

}
