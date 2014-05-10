<?php

class DonationsTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker\Factory::create();

		DonationQuarter::create([
			'id' => 1,
			'title' => '2nd Quater Goal',
			'goal_amount' => 239.55,
			'start_at' => '2014-04-01 00:00:00',
			'end_at' => '2014-08-30 23:59:59',
		]);

		foreach (range(10,20) as $index)
		{
			Donation::create([
				'donator_id' => $index,
				'quarter_id' => 1,
				'message' => $faker->sentence($nbWords = 6),
				'currency' => 'AUD',
				'amount' => $index + 5,
			]);
		}
	}
}
