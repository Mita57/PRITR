<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Text;
use function GuzzleHttp\Psr7\str;

class TextController extends Controller
{
    /**
     * Get a random text of certain length
     *
     *
     */
    public function index(Request $request)
    {
        $len = $request->input('len') == 'any' ? ['smol', 'med', 'long'] :
            [$request->input('len')];
        $topic = $request->input('topic');
        $lang = $request-> input('lang') == 'any' ? ['ru', 'en'] : [$request-> input('lang')];



        $topics = explode(',', $topic);

        foreach ($topics as $topic) {
            $topic = trim($topic);
        }


        if ($topic == 'any') {
            $text = Text::whereIn('length', $len)->whereIn('lang', $lang)->inRandomOrder()->first();
            if ($text) {
                return $text;
            } else {
                return response(['msg'=>'Nothing found'],404);
            }
        }

        $text = Text::whereIn('length', $len)->whereIn('lang', $lang)->whereIn('topic', $topics)
            ->inRandomOrder()->first();

        if ($text) {
            return $text;
        } else {
            return response(['msg'=>'Nothing found'],404);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    public function store(Request $request)
    {
        $newText = new Text();

        $length = '';

        if ($request->length <= 250) {
            $length = 'smol';
        }
        if ($request->length > 250) {
            $length = 'med';
        }
        if ($request->length > 400) {
            $length = 'big';
        }

        $newText->text = $request->text;
        $newText->length = $length;
        $newText->source = $request->source;
        $newText->topic = $request->topic;
        $newText->lang = $request->lang;
        $newText->save();

        return $newText;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     */
    public function show($id)
    {
        $existing_item = Text::find($id);

        if ($existing_item) {
            return $existing_item;
        } else {
            return response(['error-msg'=>'Object with this key does not exist'],404);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $existing_item = Text::find($id);

        if ($existing_item) {
            $existing_item->text = $request->text;
            $existing_item->length = $request->length;
            $existing_item->topic = $request->topic;
            $existing_item->source = $request->source;
            $existing_item->lang = $request->lang;
            $existing_item->save();
            return $existing_item;

        } else {
            return response(['error-msg'=>'Object with this key does not exist'],404);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existing_item = Text::find($id);

        if ($existing_item) {
            $existing_item->delete();
            return response(['msg'=>'Deleted successfully'],200);

        } else {
            return response(['error-msg'=>'Object with this key does not exist'],404);
        }
    }
}
