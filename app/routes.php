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

View::composer('layouts.master', function($view)
{
	$servers = new Servers;
    $view->with('servers', $servers->getServers());
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

Route::get('/', function()
{
	
	return View::make('hello');
});

// Route::get('meow', function()
// {
	
// 	return View::make('meow')
//         ->with('posts', Post::all());
// });

Route::get('donate', function()
{
	return View::make('donate.form');
});

Route::post('donate', 'DonationController@charge_card');


Route::get('news', 'PostsController@index');
Route::resource('posts', 'PostsController');
Route::resource('maps', 'MapsController');