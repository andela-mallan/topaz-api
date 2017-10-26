<?php

use Illuminate\Database\Seeder;

class ContributionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $limit = 13;

        for ($i=0; $i<$limit; $i++) {
            DB::table('contributions')->insert([
              'member_id' => $faker->numberBetween($min = 1, $max = 13),
              'month_contribution' => $faker->numberBetween($min = 50000, $max = 70000),
              'month_fine' => $faker->randomElement($array = array(0, 5000)),
              'time_paid' => $faker->date($format = 'Y-m-d', $max = 'now')
            ]);
        }
    }
}
