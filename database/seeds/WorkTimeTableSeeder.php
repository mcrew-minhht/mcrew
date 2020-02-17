<?php

use Illuminate\Database\Seeder;

class WorkTimeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('work_time')->insert([
            'date' => '2020-02-17',
            'user_id' => 1,
            'work_time' => 7.5,
        ]);
    }
}
