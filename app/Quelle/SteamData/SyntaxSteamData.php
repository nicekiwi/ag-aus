<?php namespace Quelle\SteamData;

use Steam;
use stdClass;

Class SyntaxSteamData implements SteamDataInterface 
{
	public function checkIds($id)
	{
		// Check if the ID is a community ID
		if(strpos($id, 'STEAM') !== false)
		{
			return $this->convertSteamIdToCommunityId($id);
		}
		else
		{
			return $id;
		}
	}

	public function getPlayerData(array $ids) 
	{
		// Check all ids to make sure they're communityID
		// and convert them if they are not
		if (is_array($ids))
		{
			$ids = array_map ( [$this, 'checkIds'], $ids );
		}
		else
		{
			$ids = $this->checkIds($ids);
		}
		

		// Get Players details from Valve Web API
		$users = Steam::user($ids)->GetPlayerSummaries();

		// Setup the players object
		$players = new StdClass;

		foreach($users as $key => $user)
		{
			$player = new StdClass;

			$player->steam_url = 		$user->profileUrl;
			$player->steam_64id = 		$user->steamId;
			$player->steam_nickname = 	strip_tags($user->personaName);
			$player->steam_image = 		$user->avatarFullUrl;
			$player->steam_id = 		$this->convertCommunityIdToSteamId($user->steamId);

			$players->players[] = $player;
		}

		return $players;

	}

	public function convertCommunityIdToSteamId(int $id)
	{
		$x = ($id - 76561197960265728) / 2;
		return 'STEAM_0:' . is_float($x) . ':' . (int)$x; 
	}

	public function convertSteamIdToCommunityId(string $id)
	{
		$x = explode(':', $id);
		return (string) ($x[2] * 2) + 76561197960265728 + $x[1];
	}

}