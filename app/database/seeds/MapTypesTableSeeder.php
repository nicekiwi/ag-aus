<?php

class MapTypesTableSeeder extends Seeder {

	public function run()
	{
		MapType::create(['type' => 'arena', 'name'=> 'Arena']);
		MapType::create(['type' => 'ctf', 'name'=> 'Capture the Flag']);
		MapType::create(['type' => 'cp', 'name'=> 'Control Point']);
		MapType::create(['type' => 'tfdb', 'name'=> 'Dodgebrightall']);
		MapType::create(['type' => 'koth', 'name'=> 'King of the Hill']);
		MapType::create(['type' => 'mvm', 'name'=> 'Mann Vs Machine']);
		MapType::create(['type' => 'pl', 'name'=> 'Payload']);
		MapType::create(['type' => 'plr', 'name'=> 'Payload Race']);
		MapType::create(['type' => 'sd', 'name'=> 'Special Delivery']);
		MapType::create(['type' => 'special', 'name'=> 'Special']);
		MapType::create(['type' => 'tc', 'name'=> 'Territorial Control']);
	}
}
