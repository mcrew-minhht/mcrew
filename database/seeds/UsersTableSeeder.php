<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'name' => 'admin',
            'role' => 1,
            'member_type' => 1,
            ],
            [
            'email' => 'user1@gmail.com',
            'password' => Hash::make('user1'),
            'name' => 'Nguyen Van Nhan',
            'role' => 2,
            'member_type' => 1,
            ],
            [
            'email' => 'user2@gmail.com',
            'password' => Hash::make('user2'),
            'name' => 'Nhan Nguyen Van',
            'role' => 2,
            'member_type' => 2,
            ],
            [
            'email' => 'user3@gmail.com',
            'password' => Hash::make('user3'),
            'name' => 'Van Nguyen Nhan',
            'role' => 2,
            'member_type' => 3,
            ],
        ]);
    }
}
