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

Route::get('tester', 'DonationController@checkDonatorExpiry');

// Route::get('test', function()
// {
	//$photo = new Photo;

	//return $photo->import_photos();

	//dd(User::find(1)->first()->created_at->diffForhumans());

	// $server = new SourceServer('203.33.121.205','27081');
	// try {
	//   $server->rconAuth('');
	//   dd($server->rconExec('Users'));
	// }
	// catch(RCONNoAuthException $e) {
	//   trigger_error('Could not authenticate with the game server.',
	//     E_USER_ERROR);
	// }

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

// });

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
	$data = Steam::user([76561197987217337,76561198073683885,76561197999078519])->GetPlayerSummaries();

	dd($data);

});



Route::get('server-info', function()
{
	$server = new Server;
	return json_encode($server->getServerLocal());
});

Route::get('refresh-servers', function()
{
	$servers = new Servers;
	return $servers->refreshServers();
});

Route::get('players', function()
{
	$servers = new Servers;
	$players = $servers->getPlayers('203.33.121.205','27021');

	//dd($players);

	echo '<table>';
	foreach($players as $player){
	    echo '<tr><td>' . $player->getName() . '</td><td>' . $player->getSteamId() . '</td></tr>';
	}
	echo '</table>';

	//var_dump($players);
});

Route::get('bans', 'BansController@index_public');

Route::get('get-bans', 'BansController@pull_bans');

//Route::get('update-quarter', 'DonationController@update_quarter');

Route::get('check-steamid/{id}', 'PlayerController@getPlayerDataJson');

Route::get('group-members/{id?}', 'PlayerController@getGroupMembers');

Route::get('donate', 'DonationController@public_index');
Route::post('donate', 'DonationController@validate_donation');

Route::get('/', 'HomeController@index_public');

//Route::get('admin', ['as' => 'admin', 'before' => 'auth', 'uses' => 'AdminController@index']);

//Route::get('login', 'SessionsController@create');
//Route::get('logout', 'SessionsController@destroy');
//Route::resource('sessions', 'SessionsController');

Route::get('news', 'PostController@index_public');
Route::get('news/json/{id}', 'PostController@comments_plugin');
Route::get('news/{slug}', 'PostController@show');

Route::get('maps/login', 'MapController@steamAuth');
Route::get('maps/logout', 'MapController@steamAuthLogout');

Route::post('maps/feedback', 'MapController@MapVote');

Route::post('maps/verify-remote-removal', 'MapController@verifyRemoteRemoval');
Route::post('maps/verify-remote-download', 'MapController@verifyRemoteDownload');

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
// ADMIN SECTION =================================
// ===============================================
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{
	// main page for the admin section (app/views/admin/dashboard.blade.php)
	Route::get('/', function()
	{
		return View::make('admin.index');
	});

	Route::post('store-player', 'PlayerController@store');

	Route::get('donations/{year?}/{quarter?}','DonationController@index');
	//Route::get('donations/players','DonationController@expiry');
	//Route::get('donations/confirm/{code}','DonationController@confirmDonation');

	Route::get( 'user/create','UserController@create');
	Route::post('user','UserController@store');

	//Route::get('maps/upload', 'MapController@upload');
	//
	//
	Route::post('maps/remote-action-ajax', 'MapController@initiateRemoteActionAjax');

	Route::resource('users', 'UserController');
	Route::resource('posts', 'PostController');
	//Route::resource('maps/configs', 'MapConfigController');
	Route::resource('maps', 'MapController');
	//Route::resource('map-files', 'MapFileController');
	Route::resource('players', 'PlayerController');
	Route::resource('bans', 'BansController');
	Route::resource('options', 'OptionController');





	// // subpage for the posts found at /admin/posts (app/views/admin/posts.blade.php)
	// Route::get('posts', function()
	// {
	// 	return View::make('posts.show');
	// });

	// // subpage to create a post found at /admin/posts/create (app/views/admin/posts-create.blade.php)
	// Route::get('posts/create', function()
	// {
	// 	return View::make('posts.create');
	// });
	// Confide routes

});
