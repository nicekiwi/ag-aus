<?php

class DonatorsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		foreach (range(10,20) as $index) {
			Donator::create([
				'id'		=> $index,
				'steam_id' 	=> $faker->userName,
				'email'		=> $faker->safeEmail,
				'donation_expires' => '2014-05-12 18:48:04',
				'card_token' => 'card_' . md5($index),
				'card_last4' => $faker->year,
				'card_type' => 'visa',
				'card_month' => $faker->month,
				'card_year' => $faker->year,
				
			]);
		}
	}
}
