<?php

class DonationController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function validate_donation()
	{
		$rules = array(
			'steam_id'       	=> 'required',
			'email'      		=> 'required',
			'stripe-token'      => 'required',
			'stripe-data'      	=> 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) 
		{
			Session::flash('message', 'post faikled post!');

			return Redirect::to('donate')
				->withErrors($validator);
				->withInput(Input::except('stripe-token'));
		}
		else 
		{
			return $this->charge_card();
		}
	}

	public function charge_card()
	{
		$donations = App::make('Acme\Donations\DonationsInterface');
	
		try 
		{
		  	$donations->charge([
				'email' => Input::get('email'),
				'token' => Input::get('stripe-token'),
				'amount' => Input::get('amount')
			]);

			return $this->saveDonation();
		} 

		catch(Stripe_CardError $e) 
		{
			//Since it's a decline, Stripe_CardError will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];

			// print('Status is:' . $e->getHttpStatus() . "\n");
			// print('Type is:' . $err['type'] . "\n");
			// print('Code is:' . $err['code'] . "\n");
			// // param is '' in this case
			// print('Param is:' . $err['param'] . "\n");
			// print('Message is:' . $err['message'] . "\n");
			return Redirect::to('donate')
					->withInput(Input::all())
					->with('flash_message', $err['message']);
		}
	}

	public function notify_user()
	{

	}

	public function saveDonation()
	{
		$id = DB::table('donators')->insertGetId(
		    array('email' => 'john@example.com', 'votes' => 0)
		);

		DB::table('donations')->insert(
		    array('email' => 'john@example.com', 'votes' => 0)
		);


	}
}