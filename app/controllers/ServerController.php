<?php

//use SteamCondenser\Community;

class ServerController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	public function getGroupMembers($groupID = '2835397')
	{
		$groupClass = "\SteamCondenser\Community\SteamGroup";
		$steamClass = "\SteamCondenser\Community\SteamId";

		$data = new StdClass;

		try 
		{
			$group = $groupClass::create($groupID);
			$members = $group->getMembers();

			foreach ($members as $i) {
				$data->member[] = $i->getSteamId64();
			}
		} 
		catch (Exception $e) 
		{
			$data->message = $e->getMessage(); //'Profile does not exist or it set to Private.';
		}

		return View::make('members.public')->with('members',$data);
	}

	public function getID($id, $public = true)
	{
		$steam = "\SteamCondenser\Community\SteamId";

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
			$data->steam_id = $steamID->convertCommunityIdToSteamId($data->steamId64);
		} 
		catch (Exception $e)
		{
			$data->message = $e->getMessage(); //'Profile does not exist or it set to Private.';
		}

		if($public)
			return json_encode($data);
		else
			return $data;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
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
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
