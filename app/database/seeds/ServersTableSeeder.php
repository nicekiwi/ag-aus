<?php

class ServersTableSeeder extends Seeder {

	public function run()
	{
		Servers::create([
			'order' 			=> 1,
			'name'				=> '#1 Chill Out Server',
			'vanilla_name' 		=> 'TF2 Server #1',
			'ip' 				=> '203.33.121.205',
			'port'			 	=> '27021',
			'type'				=> 'source',
			'game'			 	=> 'tf2',
			'offline'			=> '0',
			'maxPlayers'		=> '24',
			'players'			=> '0'
		]);

		Servers::create([
			'order' 			=> 2,
			'name'				=> '#2 Straight Up Server',
			'vanilla_name' 		=> 'TF2 Server #2',
			'ip' 				=> '203.33.121.205',
			'port'			 	=> '27058',
			'type'				=> 'source',
			'game'			 	=> 'tf2',
			'offline'			=> '0',
			'maxPlayers'		=> '18',
			'players'			=> '0'
		]);

		Servers::create([
			'order' 			=> 3,
			'name'				=> '#3 Apeture Test Server',
			'vanilla_name' 		=> 'TF2 Server #3',
			'ip' 				=> '203.33.121.205',
			'port'			 	=> '27082',
			'type'				=> 'source',
			'game'			 	=> 'tf2',
			'offline'			=> '0',
			'maxPlayers'		=> '18',
			'players'			=> '0'
		]);

		Servers::create([
			'order' 			=> 4,
			'name'				=> '#4 Rage AGainst the Machines',
			'vanilla_name' 		=> 'TF2 Server #4',
			'ip' 				=> '203.33.121.205',
			'port'			 	=> '27081',
			'type'				=> 'source',
			'game'			 	=> 'tf2',
			'offline'			=> '0',
			'maxPlayers'		=> '9',
			'players'			=> '0'
		]);

		Servers::create([
			'order' 			=> 5,
			'name'				=> 'Devil\'s Playground',
			'vanilla_name' 		=> 'Garry\'s Mod',
			'ip' 				=> '103.23.148.228',
			'port'			 	=> '27075',
			'type'				=> 'source',
			'game'			 	=> 'gm',
			'offline'			=> '0',
			'maxPlayers'		=> '10',
			'players'			=> '0'
		]);

		Servers::create([
			'order' 			=> 6,
			'name'				=> 'Minecraft Server',
			'vanilla_name' 		=> 'Minecraft',
			'ip' 				=> '203.33.121.209',
			'port'			 	=> '25567',
			'type'				=> 'source',
			'game'			 	=> 'gm',
			'offline'			=> '0',
			'maxPlayers'		=> '20',
			'players'			=> '0'
		]);
	}
}
