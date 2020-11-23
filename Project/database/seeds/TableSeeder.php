<?php

use Illuminate\Database\Seeder;

class TableSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
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
            'pwrd' => $this->str_random(20)
        ];

        DB::table('users')->insert($data);
    }

    function str_random($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function generateLast10() {
        $res = '';
        for ($i = 0; $i < 10; $i++) {
            $res .= rand(200, 600) . "&";
        }
        return $res;
    }
}
