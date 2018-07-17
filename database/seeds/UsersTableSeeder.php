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
        DB::table('users')->truncate();
        DB::table('users')->insert([
            [
              'nama' =>'admin',
              'username' => 'admin',
              'email'   => 'cybersamarinda@gmail.com',
              'password' => bcrypt('samarinda'),
            ],
            [
              'nama' =>'ketua',
              'username' => 'ketua',
              'email' => 'ketua@email.com',
              'password' => bcrypt('samarinda'),
            ]
        ]);
    }
}
