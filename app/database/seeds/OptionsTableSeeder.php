<?php

class OptionsTableSeeder extends Seeder {

	public function run()
	{

			Options::create([
				'donation_quarter_goal' => 220,
				'donation_monthly_cost' => 7.00,
				'donation_admin_email1' => 'nicekiwi@gmail.com'//,
				//'donation_admin_email2' => ''
			]);

	}
}
