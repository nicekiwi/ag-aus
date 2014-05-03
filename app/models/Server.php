<?php

class Server extends Eloquent 
{
	// protected $table = 'servers';

	public function initServer($ip,$port)
	{
		$server = new SourceServer($ip, $port);
		$server->initialize();
		return $server;
	}

	public function getServerInfo($ip,$port)
	{
		$server = $this->initServer($ip,$port);
		$info = $server->getServerInfo();
		return $info;
	}

	public function getPlayers($ip,$port,$rcon_passwd=null)
	{
		$server = $this->initServer($ip,$port);
		$players = $server->getPlayers($rcon_passwd);
		return $players;
	}

	public function getServers()
	{
		return DB::table('servers')->orderBy('order','asc')->get();
	}

	public function updateServer($id,$players,$offline)
	{
		return DB::table('servers')
            ->where('id', $id)
            ->update(array('players' => $players, 'offline' => $offline));
	}

	public function refreshServers()
	{
		$servers = $this->getServers();

		foreach ($servers as $server) {
			if($server->type === 'source')
			{
				try
				{
					$info = $this->getServerInfo($server->ipaddress,$server->port);
					$this->updateServer($server->id,$info['numberOfPlayers'],0);
				}
				catch (TimeoutException $e)
				{
					$this->updateServer($server->id,0,1);
				}
			}
			
			if($server->game === 'minecraft')
			{
				try
				{
					$mc = new Minecraft;
					$info = $mc->getStatus($server->ipaddress,$server->port);
					$this->updateServer($server->id,$info['numberOfPlayers'],0);
				}
				catch (TimeoutException $e)
				{
					$this->updateServer($server->id,0,1);
				}
			}
		}
	}

	public function getServerLocal()
	{
		return DB::table('servers')->select('id','players','offline')->get();
	}

}