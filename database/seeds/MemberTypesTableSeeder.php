<?php

use Illuminate\Database\Seeder;

class MemberTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('member_types')->insert([
            [
            'name' => 'mcrew',
            ],
            [
            'name' => 'part_time',
            ],
            [
            'name' => 'other_company',
            ],
        ]);
    }
}
