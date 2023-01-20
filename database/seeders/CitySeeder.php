<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::unprepared('SET GLOBAL max_allowed_packet = 268435456;');
        $path = database_path('sql/cities.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
