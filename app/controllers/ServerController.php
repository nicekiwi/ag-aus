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

	public function getID($id)
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

		return json_encode($data);
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
