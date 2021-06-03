<?php

use Illuminate\Database\Seeder;

class TextSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
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
