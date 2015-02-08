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

//	$role = Role::find(1);
//	$role->users;
//
//
//
//	$permission = Permission::find(4);
//
//	//dd($permission);
//
//	dd($permission->roles);

	$player = App::make('PlayerController')->getPlayerData(['STEAM_0:0:23337253']);

	dd($player);

});

Route::get('get-steam-news', 'HomeController@getGroupNews');
Route::get('get-steam-events', 'HomeController@getGroupEvents');
Route::get('get-steam-discussions', 'HomeController@getGroupDiscussions');


Route::get('/', 'HomeController@index_public');

//Route::get('bans', 'BansController@index_public');

//Route::get('get-bans', 'BansController@pull_bans');

//Route::get('check-steamid/{id}', 'PlayerController@getPlayerDataJson');

//Route::get('group-members/{id?}', 'PlayerController@getGroupMembers');

Route::get('donate', 'DonationController@public_index');
Route::post('donate', 'DonationController@validate_donation');




Route::get('maps/login', 'MapController@steamAuth');
Route::get('maps/logout', 'MapController@steamAuthLogout');

Route::post('maps/feedback', 'MapController@MapVote');

Route::get('maps', 'MapController@index_public');



Route::get( 'login',						'UserController@login');
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
Route::group(array('prefix' => 'players', 'before' => 'steam-auth'), function()
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

	Route::get( 'user/create',		'UserController@create');

	Route::post('store-player', 	'PlayerController@store');
	Route::post('maps/ajax-action', 'MapController@ajaxAction');
	Route::post('user',				'UserController@store');

	Route::resource('users', 		'UserController');
	Route::resource('posts', 		'PostController');
	Route::resource('maps','MapController');
	Route::resource('players', 		'PlayerController');
	Route::resource('bans', 		'BansController');
	Route::resource('options', 		'OptionController');
	Route::resource('donations', 	'DonationController');
	Route::resource('reports', 		'ReportController');

});
