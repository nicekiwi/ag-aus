<?php

class PlayerController extends BaseController {


	/**
	 * Display a listing of the resource.
	 * GET /players
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * @param $steam_id
	 * @return bool|\Illuminate\Database\Eloquent\Model|null|Player|static
     */
	public function store(array $ids)
	{
		$players = $this->getPlayerData($ids);
		$newPlayers = [];

		array_walk($players, function($player)
		{
			$newPlayers[] = Player::firstOrCreate($player);
		});

		return $newPlayers;
	}
	// public function store()
	// {
	// 	$steam = $this->steam;

	// 	if(Input::has('id'))
	// 		$id = Input::get('id');
	// 	else
	// 		return;

	// 	if(Player::where('steam_id', $id)->get()->count() < 1)
	// 	{
	// 		$data = $this->getPlayerInfo($id);

	// 		if($data->message) 
	// 		{
	// 			return;
	// 		}
	// 		else
	// 		{
	// 			$player = new Player;
	// 			$player->steam_url = $data->steam_url;
	// 			$player->steam_64id = $data->steam_64id;
	// 			$player->steam_nickname = $data->steam_nickname;
	// 			$player->steam_image = $data->steam_image;
	// 			$player->steam_id = $data->steam_id;

	// 			$player->save();
	// 		}
	// 	}
	// }

	/**
	 * Display the specified resource.
	 * GET /players/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /players/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /players/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /players/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	/**
	 * @return bool
     */
	public function validatePlayer()
	{
		if(!Input::has('id32')) return false;

		$players =  $this->getPlayerData([Input::get('id32')]);

		if(count($players) > 0)
		{
			return true;
		}

		return false;
	}

	public function getPlayerData($ids)
	{
		return App::make('Quelle\SteamData\SteamDataInterface')->getPlayerData($ids);
	}

	public function getGroupMembers()
	{
		$members = Steam::group()->GetGroupSummary('2835397');

		$members = $members->members;

		//$members = array_chunk($members, 100);

		dd($members);

		// $data = [];

		// foreach($members->members->id64 as $member)
		// {
		// 	$data[] = $member->id64;
		// }

		// $players = Steam::user($data)->GetPlayerSummaries();

		// dd($players);
	}

}