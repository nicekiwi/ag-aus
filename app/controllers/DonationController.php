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

	public function charge_card()
	{
		$donations = App::make('Acme\Donations\DonationsInterface');
	
		try {
			  	$donations->charge([
				'email' => Input::get('email'),
				'token' => Input::get('stripe-token'),
				'amount' => Input::get('amount')
			]);

			return 'Charge was successful';
		} 

		catch(Stripe_CardError $e) {

			//Since it's a decline, Stripe_CardError will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];

			// print('Status is:' . $e->getHttpStatus() . "\n");
			// print('Type is:' . $err['type'] . "\n");
			// print('Code is:' . $err['code'] . "\n");
			// // param is '' in this case
			// print('Param is:' . $err['param'] . "\n");
			// print('Message is:' . $err['message'] . "\n");
			return Redirect::to('donate')->withInput(Input::all())->with('flash_message', $err['message']);
			
		}
	}
}