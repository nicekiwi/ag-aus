<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		//$this->call('UsersTableSeeder');
		$this->call('PostsTableSeeder');
		$this->call('ServersTableSeeder');
		$this->call('MapTypesTableSeeder');

		$this->call('DonatorsTableSeeder');
		$this->call('DonationsTableSeeder');
	}

}