<?php

namespace Database\Seeders;

use DateTime;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LocationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $location = new \App\Models\Location;
        $location->plz = "7675";
        $location->place = "Winterfell";
        $location->street = "Kings Road";
        $location->streetnumber = "22";
        $location->info = "Straße nach Winterfell";
        $location->save();

        $vaccination1 = new \App\Models\Vaccination;
        $vaccination1->date = "18.05.2021";
        $vaccination1->start = "10:00";
        $vaccination1->end = "11:00";
        $vaccination1->amount = "11";
        //$vaccination1->location_id = 2;

        //get the first user
        /*$user = \App\Models\User::all()->first();
        $location->user()->associate($user);*/

        $location->vaccinations()->saveMany([$vaccination1]);
        $location->save();

    }
}
