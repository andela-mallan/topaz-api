<?php

use Illuminate\Database\Seeder;

class topazDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          DB::table('topazDetails')->insert([
            'account_bank' => 'DFCU Bank',
            'account_name' => 'Lubega Denis Augustine & Naiga Vivianne Maria',
            'account_number' => '01441014662455',
            'account_sum' => 10000000
          ]);
    }
}
