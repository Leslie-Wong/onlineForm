<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class SeedLanguage extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lang = DB::table('languages')->where("code", "=", "en")->first();
        if (!$lang) {
            $userId = DB::table('languages')->insertGetId([
                "code" => "en",
                "name" => "English",
                "flag" => "us",
            ]);
        } else {
            abort(500, "English is already exist!");
        }
    }
}
