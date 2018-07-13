<?php

use Illuminate\Database\Seeder;
use App\Room;
use Faker\Factory as Faker;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i=0; $i<20; $i++){
            Room::create([
                'kost_id'       => rand(1, 5),
                'name'          => $faker->word,
                'description'   => $faker->paragraph,
            ]);
        }
    }
}
