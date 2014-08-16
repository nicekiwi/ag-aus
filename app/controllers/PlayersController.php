<?php

class PlayersController extends \BaseController {

	private $steam = "\SteamCondenser\Community\SteamId";

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
	 * Store a newly created resource in storage.
	 * POST /players
	 *
	 * @return Response
	 */
	public function store()
	{
		$steam = $this->steam;

		if(Input::has('id'))
			$id = Input::get('id');
		else
			return;

		if(Player::where('steam_id', $id)->get()->count() < 1)
		{
			$data = $this->getPlayerInfo($id);

			if($data->message) 
			{
				return;
			}
			else
			{
				$player = new Player;
				$player->steam_url = $data->steam_url;
				$player->steam_64id = $data->steam_64id;
				$player->steam_nickname = $data->steam_nickname;
				$player->steam_image = $data->steam_image;
				$player->steam_id = $data->steam_id;

				$player->save();
			}
		}
	}

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

	public function validateIdAjax($id)
	{
		return json_encode($this->getPlayerInfo($id));
	}

	public function getPlayerInfo($id)
	{
		$steam = $this->steam;

		if(strpos($id, 'STEAM') !== false)
			$id = $steam::convertSteamIdToCommunityId($id);

		$data = new StdClass;

		try
		{
			$steamID = $steam::create($id);

			$data->steam_url = $steamID->getCustomUrl();
			$data->steam_64id = $steamID->getSteamId64();
			$data->steam_nickname = $steamID->getNickname();
			$data->steam_image = $steamID->getFullAvatarUrl();
			$data->steam_id = $steamID->convertCommunityIdToSteamId($id);
		}
		catch (Exception $e)
		{
			$data->message = $e->getMessage(); //'Profile does not exist or it set to Private.';
		}

		return $data;
	}

}