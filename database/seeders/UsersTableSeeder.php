<?php

namespace Database\Seeders;

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
        //test user
        $user = new \App\Models\User;
        $user->firstName = "Max";
        $user->lastName = "Maier";
        $user->password = bcrypt('secret');
        $user->svnr = "12";
        $user->bdate = "02.02.2002";
        $user->email = 'test@gmail.com';
        $user->phone = "066410450345";
        $user->vaccinated = "0";
        $user->admin = "0";
        $user->termin = "0";
        $user->vaccination_id = 1;
        $user->save();
    }
}
