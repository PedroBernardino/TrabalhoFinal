<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Pedro Henrique',
            'username' => 'pedrinhozika',
            'email' => 'pedro@gmail.com',
            'password' => bcrypt('pedro123'),
            'isBlogger' => 0
        ]);
        App\User::create([
            'name'=> 'Lucas Tanaka',
            'username' => 'Tanakinha',
            'email' => 'lucas@gmail.com',
            'password' => bcrypt('lucas123'),
            'isBlogger' => 1
        ]);
    }
}
