<?php

use Illuminate\Database\Seeder;
use App\Posko;

use Faker\Factory as Faker;
use Faker\Provider;

class PoskoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      $faker = Faker::create();
    	foreach (range(1,10) as $index) {
	        Posko::create([
            'title' => $faker->text($maxNbChars = 200),
            'address' => 'Tes',
            'village_id' => 3205280,
            'leader' => $faker->name,
            'phone' => $faker->phoneNumber,
            'area_id' => 1
	        ]);
        }
    }
}
