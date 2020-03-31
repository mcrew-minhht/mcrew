<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert([
            ['name' => 'Theatre', 'customer_id' => '1'],
            ['name' => "Vinh's API", 'customer_id' => '2'],
        ]);
    }
}
