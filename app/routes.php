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



Route::get('create-user' , function()
{
	/*User::create(array(
        'email' => 'nicekiwi@email.com',
        'password' => Hash::make('password')
    ));*/

	return Hash::make('password');
});

Route::get('amazon', function()
{
	$s3 = AWS::get('s3');

	$response = $s3->listObjects([
		'Bucket' => 'ag-maps'
	]);

	// $objects = $s3->getIterator('ListObjects', array(
 //        'Bucket' => 'ag-maps'
 //    ));

	foreach ($response['Contents'] as $object) {
        echo $object['Key'] . "\n";
    }

	//return json_encode($objects);

	// foreach ($response->body->Contents as $item){
	//     print_r($item->Key."");
	// }

	// var_dump($response->isOK());
	// var_dump(count($response->body->Contents))

	// $url = $s3->getObjectUrl([
	// 	'Bucket' => 'ag-maps',
	// 	'' => ''
	// 	'my-bucket', 'video/sample_public.mp4'
	// ]);

	//echo $url;

	echo "<pre>";
	//dd($mowl);
	echo "</pre>";
	// Success?
	//var_dump($response->isOK());
	//var_dump(count($response->body->Contents));
});

//Route::post('make-donation', 'DonationController@charge_card');

Route::get('server-info', function()
{
	$server = new Servers;
	return json_encode($server->getServerLocal());
});

Route::get('ow', function()
{
	$s3 = AWS::get('s3');
	$objectHeaders = $s3->getObjectHeaders(array(
	    'Bucket' => 'ag-maps',
	    'Key'    => 'ctf/ctf_turbine_pro_rc2.bsp.bz2',
	));
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

// Route::get('upload', function()
// {
// 	$s3 = AWS::get('s3');
 
// 	// Create Object is pretty self explanatory:
// 	// Arg 1: The bucket where your file will be created.
// 	// Arg 2: The name of your file.
// 	// Arg 3: An array of Options.
// 	//        In this case we're specifying the &quot;fileUpload&quot; option (a file on your server)
// 	//        and the ACL setting to allow this file to be read by anyone.
// 	$response = $s3->createObject('ag-maps', 'in_the_cloud.jpg'/*, array(
// 		'fileUpload'=>__DIR__.'/file.jpg'*///,
// 		//'acl'=>AmazonS3::ACL_PUBLIC,
// 	/*)*/);
	 
// 	// Check if everything is okay.
// 	if ((int) $response->isOK()) echo 'I Uploaded a File from My Server!';
// });

// Route::get('meow', function()
// {
	
// 	return View::make('meow')
//         ->with('posts', Post::all());
// });

Route::get('donations', function()
{
	return View::make('donate.form');
});

Route::get('donors', 'DonationController@display_donations');

Route::post('donate', 'DonationController@validate_donation');


Route::get('/', ['as' => 'home', function()
{
	return View::make('index');
	//dd(Donation::find(8)->donator);
}]);

/*Route::get('admin' ['as' => 'admin', function()
{
	return "Meow, woof hai" . Auth::user()->email;
}])->before('auth');*/

Route::get('admin', ['as' => 'admin', 'before' => 'auth', 'uses' => 'AdminController@index']);

Route::get('login', 'SessionsController@create');
Route::get('logout', 'SessionsController@destroy');
Route::resource('sessions', 'SessionsController');

Route::get('news', 'PostsController@index');
Route::get('news/{slug}', 'PostsController@show');



Route::resource('posts', 'PostsController');
Route::resource('maps', 'MapsController');