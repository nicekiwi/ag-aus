<?php namespace Quelle\SteamData;

interface SteamDataInterface
{

	public function getPlayerData(array $ids);

	public function convertCommunityIdToSteamId(int $id);

	public function convertSteamIdToCommunityId(string $id);

}