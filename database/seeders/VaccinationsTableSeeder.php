<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VaccinationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*//test vaccination
        $vaccination = new \App\Models\Vaccination;
        $vaccination->date = "12.05.2021";
        $vaccination->start = "0";
        $vaccination->end = "0";
        $vaccination->amount = "12";
        $vaccination->location_id = 1;
        $vaccination->save();*/

        $vaccination = \App\Models\Vaccination::all()->first();
        $vaccination->save();

        $user = new \App\Models\User;
        $user->firstName = "Hubert";
        $user->lastName = "Nuss";
        $user->password = bcrypt('secret');
        $user->svnr = "11";
        $user->bdate = "02.02.2001";
        $user->email = 'test2@gmail.com';
        $user->phone = "0664130450345";
        $user->vaccinated = "0";
        $user->admin = "0";
        $user->termin = "0";
        //$user->vaccination_id = 1;

        $vaccination->users()->saveMany([$user]);
    }
}
