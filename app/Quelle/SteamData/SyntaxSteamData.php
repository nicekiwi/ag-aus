<?php namespace Quelle\SteamData;

use Steam;
use stdClass;

Class SyntaxSteamData implements SteamDataInterface 
{
	/**
	 * @param array $ids
	 * @return array
     */
	public function getPlayerData(array $ids)
	{
		// make sure all IDs are id64
		array_map(function($id)
		{
			return Steam::convertId($id,'id64');
		}, $ids);

		// Get Players details from Valve Web API
		$users = Steam::user($ids)->GetPlayerSummaries();

		// Setup the players object
		$players = [];

		if(count($users) == 0) return $players;

		foreach($users as $key => $user)
		{
			$player = new StdClass;

			$player->steam_id64 = 		$user->steamIds->id64;
			$player->steam_id32 = 		$user->steamIds->id32;
			$player->steam_id3 = 		$user->steamIds->id3;
			$player->steam_nickname = 	htmlspecialchars($user->personaName);
			$player->steam_url = 		$user->profileUrl;
			$player->steam_image = 		$user->avatarFullUrl;

			$players[] = $player;
		}

		return $players;
	}
}