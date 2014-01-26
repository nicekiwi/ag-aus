<?php

class DonationsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		foreach (range(10,20) as $index) {
			Donation::create([
				'donator_id' => $index,
				'message' => $faker->sentence($nbWords = 6),
				'currency' => 'AUD',
				'amount' => $index + 5,
			]);
		}
	}
}
