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
            [
                'date' => '2020-02-17',
                'user_id' => 1,
                'work_time' => 7.5,
            ],
            [
                'date' => '2020-02-1',
                'user_id' => 1,
                'work_time' => 7.5,
            ],
            [
                'date' => '2020-02-3',
                'user_id' => 1,
                'work_time' => 7.5,
            ],
            [
                'date' => '2020-03-17',
                'user_id' => 1,
                'work_time' => 7.5,
            ],
            [
                'date' => '2020-03-18',
                'user_id' => 1,
                'work_time' => 7.5,
            ],
            [
                'date' => '2020-03-17',
                'user_id' => 2,
                'work_time' => 7.5,
            ],
            [
                'date' => '2020-03-18',
                'user_id' => 2,
                'work_time' => 7.5,
            ],
            [
                'date' => '2020-03-17',
                'user_id' => 3,
                'work_time' => 7.5,
            ],
            [
                'date' => '2020-03-18',
                'user_id' => 3,
                'work_time' => 7.5,
            ],
            [
                'date' => '2020-03-17',
                'user_id' => 4,
                'work_time' => 7.5,
            ],
            [
                'date' => '2020-03-18',
                'user_id' => 4,
                'work_time' => 7.5,
            ],
        ]);
    }
}
