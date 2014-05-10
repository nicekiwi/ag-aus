<?php

return array(

	/*
	|--------------------------------------------------------------------------
	| Default Remote Connection Name
	|--------------------------------------------------------------------------
	|
	| Here you may specify the default connection that will be used for SSH
	| operations. This name should correspond to a connection name below
	| in the server list. Each connection will be manually accessible.
	|
	*/

	'default' => 'production',

	/*
	|--------------------------------------------------------------------------
	| Remote Server Connections
	|--------------------------------------------------------------------------
	|
	| These are the servers that will be accessible via the SSH task runner
	| facilities of Laravel. This feature radically simplifies executing
	| tasks on your servers, such as deploying out these applications.
	|
	*/

	'connections' => Config::get('keys.laravel.remote-connections'),//array(
//
		// 'production' => array(
		// 	'host'      => Config::get('keys.stripe.live_secret_key'),
		// 	'username'  => Config::get('keys.stripe.live_secret_key'),
		// 	'password'  => Config::get('keys.stripe.live_secret_key'),
		// 	'key'       => Config::get('keys.stripe.live_secret_key'),
		// 	'keyphrase' => Config::get('keys.stripe.live_secret_key'),
		// 	'root'      => Config::get('keys.stripe.live_secret_key'),
		// ),
//
		//'production' => Config::get('keys.remote.production'),
//
	//),

	/*
	|--------------------------------------------------------------------------
	| Remote Server Groups
	|--------------------------------------------------------------------------
	|
	| Here you may list connections under a single group name, which allows
	| you to easily access all of the servers at once using a short name
	| that is extremely easy to remember, such as "web" or "database".
	|
	*/

	'groups' => array(

		'web' => array('production')

	),

);
