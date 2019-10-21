<?php

use Illuminate\Database\Seeder;
use \App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*@var $user User */
       $user = User::create([
           'login' => 'admin',
           'password' => bcrypt('bbM!4)hjU;7SA75'),
           'api_token' => \Illuminate\Support\Str::random(60),
           'firstname' => 'Вадим',
           'lastname' => 'Гавриляк',
           'patronymic' => 'Юрьевич',
           'status' => 1,
           'remember_token' => Str::random(10),
       ]);

       $user->assignRole(\App\Constants\User\Role::ADMIN);
    }


}
