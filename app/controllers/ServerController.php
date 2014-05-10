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
		$data->members = array();

		try 
		{
			$group = $groupClass::create($groupID);

			$member = $group->getMembers();

			$userID = $steamClass::create($member[3]->getSteamId64());

			dd($userID->getNickname());

			$d = 0;

			foreach ($group->getMembers() as $member) 
			{
				
				if($d > 1) break;

				$userID = $steamClass::create($member->getSteamId64());

				$user = new StdClass;
				$user->nickname = $userID->getNickname();

				$data->members[] = $user;

				$d++;
			}
		} 
		catch (Exception $e) 
		{
			$data->message = $e->getMessage(); //'Profile does not exist or it set to Private.';
		}

		dd($data);
	}

	public function getID($id, $public = true)
	{
		$steam = "\SteamCondenser\Community\SteamId";

		$data = new StdClass;

		try 
		{
			$steamID = $steam::create($id);

			$data->steamId = $steamID->getCustomUrl();
			$data->steamId64 = $steamID->getSteamId64();
			$data->nickname = $steamID->getNickname();
			$data->profileImage = $steamID->imageUrl;
			$data->id2 = $steamID->convertCommunityIdToSteamId($data->steamId64);
			//$data->
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
