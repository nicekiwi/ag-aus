<?php

View::composer('partials.server-list', function($view)
{
	$servers = new Servers;
    $view->with('servers', $servers->getServers());
});

View::composer('partials.event-list', function($view)
{
	$view->with('events', Post::where('event',1)->take(3)->get());
});

View::composer('partials.donation-widget', function($view)
{
    $total_amount = Donation::where('created_at', '>=', '2013-01-01')
						->sum('amount');

	$percentage = ($total_amount / 85) * 100;
	
	if($percentage >= 75) $class = 'success';
	if($percentage <= 50) $class = 'warning';
	if($percentage <= 30) $class = 'danger';

	$data = new StdClass;
	$data->total_amount = $total_amount;
	$data->percentage = $percentage;
	$data->class = $class;

    $view->with('data', $data);
});

//View::composer('partials.donation-widget', 'DonationController@display_donation_widget');
//View::composer('partials.event-widget', 'PostsController@display_events_widget');