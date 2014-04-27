<?php

class GamesTableSeeder extends Seeder {

	public function run()
	{
		Game::create([
			'id' 			=> 1,
			'name'			=> 'Team Fortress 2',
			'engine' 		=> 'source',
		]);

		Game::create([
			'id' 			=> 2,
			'name'			=> 'Garry\'s Mod',
			'engine' 		=> 'source',
		]);

		Game::create([
			'id' 			=> 3,
			'name'			=> 'CounterStrike: GO',
			'engine' 		=> 'source',
		]);

		Game::create([
			'id' 			=> 4,
			'name'			=> 'Minecraft',
			'engine' 		=> 'minecraft',
		]);
	}
}
