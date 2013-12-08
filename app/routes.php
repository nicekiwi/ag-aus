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

	foreach($players as $key => $value){
	    echo $value->getName() . 'has a score of' . $value->getScore() . '<br>';
	}
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

Route::get('games', function()
{
	return View::make('games');
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

Route::get('admin', ['as' => 'admin', 'before' => 'auth', 'uses' => 'AdminController@index']);

Route::get('login', 'SessionsController@create');
Route::get('logout', 'SessionsController@destroy');
Route::resource('sessions', 'SessionsController');

Route::get('news', 'PostsController@index');
Route::get('news/{slug}', 'PostsController@show');

Route::resource('posts', 'PostsController');
Route::resource('maps', 'MapsController');