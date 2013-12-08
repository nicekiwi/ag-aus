<?php

class UsersTableSeeder extends Seeder {

	public function run()
	{
		Eloquent::unguard();

		User::create([
			'username' 	=> 'admin',
			'role'		=> 1,
			'email' 	=> 'admin@alternative-gaming.dev',
			'password' 	=> Hash::make('password')
		]);
	}
}
