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

Route::get('test', function()
{
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
	echo '</table';

	//var_dump($players);
});

Route::get('get-bans', 'BanController@pull_bans');

Route::get('dothing', 'DonationController@create_quarter');

Route::get('check-steamid/{id}', 'ServerController@getID');

Route::get('group-members/{id?}', 'ServerController@getGroupMembers');

Route::get('donate', 'DonationController@public_index');
Route::post('donate', 'DonationController@validate_donation');

Route::get('donors', 'DonationController@display_donations');

Route::get('/', ['as' => 'home', function()
{
	return View::make('index');
}]);

//Route::get('admin', ['as' => 'admin', 'before' => 'auth', 'uses' => 'AdminController@index']);

//Route::get('login', 'SessionsController@create');
//Route::get('logout', 'SessionsController@destroy');
//Route::resource('sessions', 'SessionsController');

Route::get('news', 'PostController@index_public');
Route::get('news/{slug}', 'PostsController@show');

Route::get('maps', 'MapController@index_public');
Route::get('maps/{slug}', 'MapController@show');




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

	Route::get( 'user/create','UserController@create');
	Route::post('user','UserController@store');

	Route::get('maps/upload', 'MapController@upload');

	Route::resource('users', 'UserController');
	Route::resource('posts', 'PostController');
	Route::resource('maps', 'MapController');



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
