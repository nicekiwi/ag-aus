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

	public function display_donation_widgit($view)
	{
		$total_amount = Donation::where('created_at', '>=', '2013-01-01')
						->sum('amount');

		$percentage = ($total_amount / 1000) * 100;
		
		if($percentage >= 75) $class = 'success';
		if($percentage <= 50) $class = 'warning';
		if($percentage <= 30) $class = 'danger';

		$data = new StdClass;
		$data->total_amount = $total_amount;
		$data->percentage = $percentage;
		$data->class = $class;

	    $view->with('data', $data);
	}

	public function display_donations()
	{
		$donations = Donation::with('donator')
						->where('created_at', '>=', '2013-01-01')
						->get();

		$total_amount = Donation::where('created_at', '>=', '2013-01-01')
						->sum('amount');

		$percentage = ($total_amount / 1000) * 100;
		
		if($percentage >= 75) $class = 'success';
		if($percentage <= 50) $class = 'warning';
		if($percentage <= 30) $class = 'danger';

		$data = new StdClass;
		$data->donations = $donations;
		$data->total_amount = $total_amount;
		$data->percentage = $percentage;
		$data->class = $class;

		return View::make('donate.donors')->with('data', $data);
	}

	public function validate_donation()
	{
		$rules = array(
			'steam_id'       	=> 'required',
			'email'      		=> 'required|email',
			'stripe_token'      => 'required',
			'stripe_data'      	=> 'required',
			'amount'      	=> 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) 
		{
			Session::flash('message', 'Required information missing, you have not been charged.');

			return Redirect::to('donate')
				->withErrors($validator)
				->withInput(Input::except('stripe_token'));
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
				'token' => Input::get('stripe_token'),
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

	public function notifyDonator()
	{

	}

	public function saveDonation()
	{
		$input = Input::all();
		$cc_info = explode(',', $input['stripe_data']);

		// Use Validation to check if donator has dontated before
		$validator = Validator::make($input, ['email' => 'required|email|unique:donators']);

		// If donator already exists, get their ID
		if ( $validator->fails() )
		{
			$id = Donator::where('email', $input['email'])->pluck('id');
		}
		else
		{
			// Save new donator to donators table and get their ID
			$donator = new Donator;
			$donator->steam_id = $input['steam_id'];
			if(Input::has('steam_image')) $donator->steam_image = $input['steam_image'];
			$donator->email = $input['email'];
			$donator->card_token = $input['stripe_token'];
			$donator->card_type = $cc_info[0];
			$donator->card_last4 = $cc_info[1];
			$donator->card_month = $cc_info[2];
			$donator->card_year = $cc_info[3];
			$donator->save();

			$id = $donator->id;
		}

		// Save donation details to donnations table with donator's ID.
		$donation = new Donation;
		$donation->donator_id = $id;
		$donation->anonymous = 0;
		$donation->amount = $input['amount'];
		$donation->save();

		return 'Charge of $'.$input['amount'].'AUD to **** **** **** '.$cc_info[1].', Exp '.$cc_info[2].'/'.$cc_info[3].' was successful, ';
	}
}