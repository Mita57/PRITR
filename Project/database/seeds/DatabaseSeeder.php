<?php

use Illuminate\Database\Seeder;

class atabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $length = rand(0, 2);
        $length_str = '';
        $lang = rand(0, 1) === 0 ? 'en' : 'ru';
        $text = '';
        switch ($length) {
            case 0:
            {
                $this->str_random(150, $lang);
                $length_str = 'short';
            }
            case 1:
            {
                $this->str_random(300, $lang);
                $length_str = 'med';
            }
            case 2:
            {
                $this->str_random(500, $lang);
                $length_str = 'long';
            }
        }

        $data = [
            'text' => $text,
            'legth' => $length_str,
            'topic' => 'gachimuchi',
            'lang' => $lang
        ];

        DB::table('users')->insert($data);

        $data = [
            'email' => $this->str_random(10) . "@" . $this->str_random(5) . "@" . $this->str_random(3),
            'nick' => $this->str_random(15),
            'mmr' => rand(200, 10000),
            'last_10' => $this->generateLast10(),
            'max_ever' => rand(200, 1000),
            'cpm_sum' => rand(0, 3000000),
            'finished_games_overall' => rand(0, 5000),
            'battle_royale_finished' => rand(0, 1000),
            'battle_royale_won' => rand(0, 100),
            'classic_finished' => rand(0, 1000),
            'classic_won' => rand (0, 200),
            'arena_got_to_room1' => rand(0, 100),
            'arena_played' => rand(0, 1000),
        ];

        DB::table('users')->insert($data);
    }

    function generateLast10() {
        $res = '';
        for ($i = 0; $i < 10; $i++) {
            $res .= rand(200, 600) . "&";
        }
        return $res;
    }


    function str_random($length = 10, $lang) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ';
        $charactersrus = '0123456789абвгдеёжзийклмнопрстуфхчшщэюяАБВГДЕЁЙЖЗИЙКЛМНОПРСТУФХЦЧШЩЭЮЯ ';
        if ($lang == 'en') {
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;

        } else {
            $charactersLength = strlen($charactersrus);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $charactersrus[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }

    }
}
