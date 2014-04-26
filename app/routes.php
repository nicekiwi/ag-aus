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

	return View::make('hello');

});

Route::get('server-info', function()
{
	$server = new Servers;
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

Route::get('check-steamid/{id}', function($id)
{
	$data = new StdClass;

	try 
	{
		$steamID = SteamId::create($id);
		$data->steamid = $steamID->getCustomUrl();
		$data->nickname = $steamID->getNickname();
		$data->profileImage = $steamID->imageUrl;
	} 
	catch (SteamCondenserException $e) 
	{
		$data->message = $e->getMessage(); //'Profile does not exist or it set to Private.';
	}

	return json_encode($data);
});

Route::get('bio', function()
{
	return View::make('bio');
});

Route::get('donations', function()
{
	return View::make('donate.form');
});

Route::get('donors', 'DonationController@display_donations');
Route::post('donate', 'DonationController@validate_donation');

Route::get('/', ['as' => 'home', function()
{
	return View::make('index');
}]);

//Route::get('admin', ['as' => 'admin', 'before' => 'auth', 'uses' => 'AdminController@index']);

Route::get('login', 'SessionsController@create');
Route::get('logout', 'SessionsController@destroy');
Route::resource('sessions', 'SessionsController');

Route::get('news', 'PostController@index_public');
Route::get('news/{slug}', 'PostsController@show');

Route::get('maps', 'MapController@index_public');
Route::get('maps/{slug}', 'MapsController@show');






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
});