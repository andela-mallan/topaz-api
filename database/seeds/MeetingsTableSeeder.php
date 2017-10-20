<?php

use Illuminate\Database\Seeder;

class MeetingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $limit = 5;

        for ($i=0; $i<$limit; $i++) {
            DB::table('meetings')->insert([
              'meeting_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
              'attendants' => json_encode($faker->randomElements($array = array(
                $faker->name, $faker->name, $faker->name, $faker->name), $count = 2)),
              'minutes' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
              'operation_costs' => json_encode(array($faker->catchPhrase => 15000)),
              'location' => $faker->word,
              'months_objectives' => json_encode(array($faker->catchPhrase => $faker->boolean))
            ]);
        }
    }
}
