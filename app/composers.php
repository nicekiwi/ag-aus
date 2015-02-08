<?php

View::composer('partials.donation-widget', function($view)
{
    $total_amount = Donation::where('created_at', '>=', '2013-01-01')
						->sum('amount');

	$percentage = ($total_amount / 85) * 100;

	if($percentage > 100) $percentage = 100;
	
	if($percentage >= 75) $class = 'success';
	if($percentage <= 50) $class = 'warning';
	if($percentage <= 30) $class = 'danger';

	$data = new StdClass;
	$data->total_amount = $total_amount;
	$data->percentage = $percentage;
	$data->class = $class;

    $view->with('data', $data);
});

//View::composer('maps.partials._upload-form', function($view)
//{
//	$postObject = new PostObject($this->s3, 'alternative-gaming', [
//		'acl' => 'public-read',
//	]);
//
//	$form = $postObject->prepareData()->getFormInputs();
//
//	$options = new stdClass;
//	$options->policy = $form['policy'];
//	$options->signature = $form['signature'];
//	$options->uid = uniqid();
//	$options->accessKey = $form['AWSAccessKeyId'];
//	$options->bucket = 'alternative-gaming';
//	$options->key = 'games/team-fortress-2/maps';//$form['key'];
//	$options->acl = $form['acl'];
//
//	$view->with(compact('options'));
//});

View::composer('maps.partials._upload-form', 'MapController@uploadFormComposer');
//View::composer('partials.event-widget', 'PostsController@display_events_widget');