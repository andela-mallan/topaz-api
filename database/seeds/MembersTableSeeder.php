<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
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
            DB::table('members')->insert([
              'name' => $faker->name,
              'role' => $faker->jobTitle,
              'role_description' => $faker->text($maxNbChars = 200),
              'email' => $faker->email,
              'phone' => $faker->phoneNumber
            ]);
        }
    }
}
