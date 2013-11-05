<?php

class Action extends Eloquent 
{

	public function getInfo()
	{
		//$steamer = new SteamCondenser/SourceServer('192.168.0.114', 27015);
		//$server = new SourceServer('203.33.121.205', 27021);
		//$server = new SteamCondenser/SourceServer('192.168.0.114', 27016);
		//$server->initialize();

		//return $server->getRules();

		$server = new SourceServer('203.33.121.205', 27021);
		$server->initialize();

		// Steam Communtiy ID of Robin Walker.
		//$steamCommunityId = "76561197960435530";
		// Create SteamId Object
		//$steamIdObject = new SteamId( "$steamCommunityId" );
		 
		//$steam_avatar = $steamIdObject->getIconAvatarUrl();
		//$steam_name = $steamIdObject->getNickname();

		$meow = new StdClass;
		$meow = $server->getPlayers();

		return $server;



				//$id = SteamId::create('nicekiwi9');
				//$stats = $id->getGameStats('tf2');
				//$achievements = $stats->getAchievements();

				//echo '<pre>';
				//dd($achievements);
				//echo '</pre>';
			//$master = new MasterServer(MasterServer::GOLDSRC_MASTER_SERVER);
			//$servers = $master->getServers();
			//$randomServer = $servers[array_rand($servers)];

			//$server = new GoldSrcServer($randomServer[0], $randomServer[1]);



		//$id = SteamId::create('nicekiwi9');
		//$stats = $id->getGameStats('tf2');
		//return $stats->getAchievements();
	}

	public function getServers()
	{
		return DB::table('servers')->get();
	}
}