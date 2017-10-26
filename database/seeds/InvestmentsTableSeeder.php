<?php

use Illuminate\Database\Seeder;

class InvestmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $limit = 3;

        for ($i=0; $i<$limit; $i++) {
            DB::table('investments')->insert([
              'project_name' => $faker->company,
              'description' => $faker->text($maxNbChars = 200),
              'location' => $faker->word,
              'start_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
              'in_progress' => $faker->boolean,
              'expected_investment_value' => json_encode(array(
                $faker->word => $faker->numberBetween($min = 1000, $max = 9000))),
              'total_investment_value' => json_encode(array(
                $faker->word => $faker->numberBetween($min = 1000, $max = 9000))),
              'revenue' => json_encode(array(
                $faker->monthName => $faker->numberBetween($min = 1000, $max = 9000))),
              'profits' => json_encode(array(
                $faker->monthName => $faker->numberBetween($min = 1000, $max = 9000)))
            ]);
        }
    }
}
