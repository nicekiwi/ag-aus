<?php

class BansController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /bans
	 *
	 * @return Response
	 */
	public function index()
	{
		$bans = Ban::all();
		return View::make('bans.index')->with('bans', $bans);
	}

	public function index_public()
	{
		$bans = Ban::all();
		return View::make('bans.public')->with('bans', $bans);
	}

	public function pull_bans()
	{
		$steamClass = "\SteamCondenser\Community\SteamId";

		$remotePath = 'service311/tf/cfg/banned_user.cfg';
		//$remotePath = 'remote-configs/banned_user.cfg';
		$contents = SSH::into('pantheon')->getString($remotePath);
		$contents = preg_split("/((\r?\n)|(\r\n?))/", $contents);

		return View::make('bans.test')->with('bans', $contents);

		//$count = 0;

		// foreach($contents as $line)
		// {
		// 	if($count >= 10) break;

		// 	$line = explode(' ', $line);

		// 	$steam64ID = $line[2];
		// 	$steamID = $steamClass::convertSteamIdToCommunityId($steam64ID);
		// 	$steamID = $steamClass::create($steamID);

		// 	echo $steamID->getNickname() . '<br>';

		// 	$count++;
		// }
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /bans/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /bans
	 *
	 * @return Response
	 */
	public function store()
	{
		$r = new jyc\rcon\Rcon('localhost', 25574, 'password');
	}

	/**
	 * Display the specified resource.
	 * GET /bans/{id}
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
	 * GET /bans/{id}/edit
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
	 * PUT /bans/{id}
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
	 * DELETE /bans/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}