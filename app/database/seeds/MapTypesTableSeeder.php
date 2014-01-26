<?php

class MapTypesTableSeeder extends Seeder {

	public function run()
	{
		MapTypes::create(['type' => 'arena', 'name'=> 'Arena']);
		MapTypes::create(['type' => 'ctf', 'name'=> 'Capture the Flag']);
		MapTypes::create(['type' => 'cp', 'name'=> 'Control Point']);
		MapTypes::create(['type' => 'tfdb', 'name'=> 'Dodge Ball']);
		MapTypes::create(['type' => 'koth', 'name'=> 'King of the Hill']);
		MapTypes::create(['type' => 'mvm', 'name'=> 'Mann Vs Machine']);
		MapTypes::create(['type' => 'pl', 'name'=> 'Payload']);
		MapTypes::create(['type' => 'plr', 'name'=> 'Payload Race']);
		MapTypes::create(['type' => 'custom', 'name'=> 'Custom']);
	}
}
