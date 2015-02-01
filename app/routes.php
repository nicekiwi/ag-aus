<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::post('queue/receive', function()
{
    return Queue::marshal();
});

Route::post('get-steam-server-status', 'HomeController@getServerStatus');

Route::get('tester', 'DonationController@checkDonatorExpiry');

Route::get('test', function()
{
	//$photo = new Photo;

	//return $photo->import_photos();

	//dd(User::find(1)->first()->created_at->diffForhumans());

//	 $server = new \SteamCondenser\Servers\SourceServer('203.33.121.205','27081');
//	 try {
//	   $server->rconAuth('');
//	   dd($server->rconExec('Users'));
//	 }
//	 catch(RCONNoAuthException $e) {
//	   trigger_error('Could not authenticate with the game server.',
//	     E_USER_ERROR);
//	 }

//	$server = new \SteamCondenser\Servers\SourceServer('192.168.0.114', 27016);
//	$server->initialize();
//	return $server->getPlayers();

	//return View::make('hello');

	// $server = new Server;
	//
	// dd($server);

	// $remotePath = 'service332/tf/cfg/server.cfg';
	// $contents = SSH::into('pantheon')->getString($remotePath);

	// echo '<pre>';
	// echo $contents;
	// echo '</pre>';

	//dd(Options::first());
	//
	//echo 
	//writeDonators();

});

Route::get('donators', function()
{
	// $gen = new Generator;

	// return $gen->donators();
	// 
	//checkDonatorExpiry();
	//return new \Carbon\Carbon('today');
	//
	//
	//$user = Steam::user(76561198006940234)->GetPlayerSummaries();

	//dd($user);
	// STEAM_0:1:6587177
	// 76561197973440083
	//$a = (string) (6587177 * 2) + 76561197960265728 + 1;

	//return App::make('MapController')->initiateRemoteAction('wacky_races_v2.bsp.bz2','bz2',1);

	//return substr('STEAM_0:1:6587177', -7);

	///dd($a);
	///
//	$data = Steam::user([76561197987217337,76561198073683885,76561197999078519])->GetPlayerSummaries();
//
//	dd($data);

});



//Route::get('server-info', function()
//{
//	$server = new Server;
//	return json_encode($server->getServerLocal());
//});
//
//Route::get('refresh-servers', function()
//{
//	$servers = new Servers;
//	return $servers->refreshServers();
//});

//Route::get('players', function()
//{
//	$servers = new Servers;
//	$players = $servers->getPlayers('203.33.121.205','27021');
//
//	//dd($players);
//
//	echo '<table>';
//	foreach($players as $player){
//	    echo '<tr><td>' . $player->getName() . '</td><td>' . $player->getSteamId() . '</td></tr>';
//	}
//	echo '</table>';
//
//	//var_dump($players);
//});

Route::get('news/{slug?}/{id?}', 'HomeController@getGroupNews');
Route::get('events/{slug}/{id}', 'HomeController@getGroupEvent');
Route::get('events', 'HomeController@getGroupEvents');
Route::get('get-steam-discussions', 'HomeController@getGroupDiscussions');




Route::get('bans', 'BansController@index_public');

Route::get('get-bans', 'BansController@pull_bans');

Route::get('check-steamid/{id}', 'PlayerController@getPlayerDataJson');

Route::get('group-members/{id?}', 'PlayerController@getGroupMembers');

Route::get('donate', 'DonationController@public_index');
Route::post('donate', 'DonationController@validate_donation');

Route::get('/', 'HomeController@index_public');


Route::get('maps/login', 'MapController@steamAuth');
Route::get('maps/logout', 'MapController@steamAuthLogout');

Route::post('maps/feedback', 'MapController@MapVote');

Route::get('maps', 'MapController@index_public');
//Route::get('maps/{slug}', 'MapController@show');






Route::get( 'login','UserController@login');
Route::post('login',                  		'UserController@do_login');
Route::get( 'login/forgot-password',        'UserController@forgot_password');
Route::post('login/forgot-password',        'UserController@do_forgot_password');
Route::get( 'logout',                 		'UserController@logout');

Route::get( 'login/reset-password/{token}', 'UserController@reset_password');
Route::post('login/reset-password',         'UserController@do_reset_password');
Route::get( 'login/confirm/{code}',         'UserController@confirm');


// ===============================================
// STEAM USER SECTION =================================
// ===============================================
Route::group(array('prefix' => 'steam-user', 'before' => 'steam-auth'), function()
{



});

// ===============================================
// ADMIN SECTION =================================
// ===============================================
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{
	// main page for the admin section (app/views/admin/dashboard.blade.php)
	Route::get('/', function()
	{
		return View::make('admin.index');
	});



	Route::get( 'user/create','UserController@create');

	Route::post('store-player', 'PlayerController@store');
	Route::post('maps/ajax-action', 'MapController@initiateRemoteActionAjax');
	Route::post('user','UserController@store');

	Route::resource('users', 'UserController');
	Route::resource('posts', 'PostController');
	Route::resource('maps', 'MapController');
	Route::resource('players', 'PlayerController');
	Route::resource('bans', 'BansController');
	Route::resource('options', 'OptionController');
	Route::resource('reports', 'ReportController');

});
