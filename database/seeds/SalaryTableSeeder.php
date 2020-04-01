<?php

use Illuminate\Database\Seeder;

class SalaryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('salary')->insert([
            ['user_id' => 1,'base_salary' => 1000000,'salary' => 1000000,'number_of_dependents' => 1,],
            ['user_id' => 2,'base_salary' => 1000000,'salary' => 1000000,'number_of_dependents' => 1,],
            ['user_id' => 3,'base_salary' => 1000000,'salary' => 1000000,'number_of_dependents' => 1,],
            ['user_id' => 4,'base_salary' => 1000000,'salary' => 1000000,'number_of_dependents' => 1,],
        ]);
    }
}
