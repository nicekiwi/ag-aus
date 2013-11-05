<?php
// Keys for all AG Stuff.
return array (

	// Laravel Specific
	'laravel' => [
			// Database
		'database' = [
			// Live Mysql Creds
			'db_name' = '',
			'username' => '',
			'password' => ''
		],
	],

	// Stripe Keys
	'stripe' => [
		// Live
		'live_secret_key' => '',
		'live_publishable_key' => '',
		// Testing
		'test_secret_key' => '',
		'test_publishable_key' => ''
	],

	// Amazon Keys
	'amazon' => [
		'aws_key'    => '',
    	'aws_secret' => '',
    	'region'	 => 'ap-southeast-2'
	],

	// Mandrill SMTP
	'mandrill' => [
		'username' => '',
		'password' => ''
	],

);