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


	// Create new Quarter
	public function create_quarter()
	{
		// Get current year
		$year = date('Y');
		// Get timestamp of today
		$today = new \Carbon\Carbon('now');

		// Get dates for first quater
		$q1_start = new \Carbon\Carbon('first day of January');
		$q1_end = new \Carbon\Carbon('23:59:59 last day of March');

		// Get dates for second quater
		$q2_start = new \Carbon\Carbon('first day of April ');
		$q2_end = new \Carbon\Carbon('23:59:59 last day of June');

		// Get dates for third quater
		$q3_start = new \Carbon\Carbon('first day of July');
		$q3_end = new \Carbon\Carbon('23:59:59 last day of September');

		// Get dates for fourth quater
		$q4_start = new \Carbon\Carbon('first day of October');
		$q4_end = new \Carbon\Carbon('23:59:59 last day of December');

		// New Quarter Object
		$quarter = new DonationQuarter;

		// Calculate Goal amount from combination of server MOnthly costs times the Billing Cycle
		// ToDo: Billing cycle should be added to a Settings array somewhere.
		$quarter->goal_amount = Server::sum('monthlyCost') * 3;
		$quarter->year = $year;

		// Check which quater is current and apply the responding settings
		if($today->between($q1_start, $q1_end))//$today > $q1_start->toDateTimeString() && $today < $q1_end->toDateTimeString())
		{
			$quarter->title = '1st Quater ' . $quarter->year;
			$quarter->start_at = $q1_start;
			$quarter->end_at = $q1_end;
			$quarter->quarter = 1;
		}
		else if($today->between($q2_start, $q2_end))//$today > $q2_start->toDateTimeString() && $today < $q2_end->toDateTimeString())
		{
			$quarter->title = '2nd Quater ' . $quarter->year;
			$quarter->start_at = $q2_start;
			$quarter->end_at = $q2_end;
			$quarter->quarter = 2;
		}
		else if($today->between($q3_start, $q3_end))//$today > $q3_start->toDateTimeString() && $today < $q3_end->toDateTimeString())
		{
			$quarter->title = '3rd Quater ' . $quarter->year;
			$quarter->start_at = $q3_start;
			$quarter->end_at = $q3_end;
			$quarter->quarter = 3;
		}
		else if($today->between($q4_start, $q4_end))//$today > $q4_start->toDateTimeString() && $today < $q4_end->toDateTimeString())
		{
			$quarter->title = '4th Quater ' . $quarter->year;
			$quarter->start_at = $q4_start;
			$quarter->end_at = $q4_end;
			$quarter->quarter = 4;
		}

		// Save new quater
		$quarter->save();
	}

	// Update current Quarter
	public function update_quarter()
	{
		// Get timestamp of today
		$today = new \Carbon\Carbon('now');
		// Get latest quter Object
		$latest_quarter = DonationQuarter::orderBy('id','desc')->first();

		if(!$latest_quarter)
			return $this->create_quarter();

		$latest_quarter_ends = new \Carbon\Carbon($latest_quarter->end_at);

		// If today is later than the end date of the last quater
		// create a new quarter instance.
		if($today->gt($latest_quarter_ends))//$today->toDateTimeString() > $latest_quarter->ends_at)
		{
			return $this->create_quarter();
		}

		// Find current quarter Object instance
		$quarter = DonationQuarter::findOrFail($latest_quarter->id);

		// Add up all the donations placed in the time of the current quater
		$total_amount = Donation::whereBetween('created_at', [$quarter->start_at,$quarter->end_at])->sum('amount');

		// Caluclate percentage donations of total goal, only if donated
		// amount of greater than 0.
		if($total_amount > 0)
		{
			$percentage = round(($total_amount / $quarter->goal_amount) * 100);
			// Set total and percentages
			$quarter->total_amount = $total_amount;
			$quarter->goal_percentage = $percentage;

			//dd(number_format($percentage));
		}

		// Save changes to current quarter
		$quarter->save();
	}

	public function index()
	{
		// Get latest quter Object
		$quarter = DonationQuarter::orderBy('id','desc')->first();
		$donations = Donation::where('quarter_id',$quarter->id)->get();

		//dd($donations);

		// Return donate with quarter data
		return View::make('donate.index')->with([
			'donations' => $donations,
			'quarter' 	=> $quarter
		]);
	}

	public function public_index()
	{
		// Get latest quter Object
		$quarter = DonationQuarter::orderBy('id','desc')->first();
		$donations = Donation::where('quarter_id',$quarter->id)->get();

		//dd($donations);

		// Return donate with quarter data
		return View::make('donate.public')->with([
			'donations' => $donations,
			'quarter' 	=> $quarter
		]);
	}

	public function validate_donation()
	{
		$rules = array(
			//'steam_nickname'    => 'required',
			'email'      		=> 'required|email',
			'stripe_token'      => 'required',
			'stripe_data'      	=> 'required',
			'amount'      		=> 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) 
		{
			Session::flash('error_message', 'Required information missing, you have not been charged.');

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
					->with('error_message', $err['message']);
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

			if(Input::has('steam_id'))
				$donator->steam_id = $input['steam_id'];

			if(Input::has('steam_64id'))
				$donator->steam_64id = $input['steam_64id'];

			if(Input::has('steam_url'))
				$donator->steam_url = $input['steam_url'];

			if(Input::has('steam_nickname'))
				$donator->steam_nickname = $input['steam_nickname'];

			if(Input::has('steam_image'))
				$donator->steam_image = $input['steam_image'];

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
		$donation->amount = $input['amount'];

		// Get latest quter Object
		$quarter = DonationQuarter::orderBy('id','desc')->first();
		$donation->quarter_id = $quarter->id;

		$donation->save();

		$this->update_quarter();

		$message = 'Charge of $' . $input['amount'] . 'AUD to **** **** **** ' . $cc_info[1] . ', Exp ' . $cc_info[2] . '/' . $cc_info[3] . ' was successful, ';

		return View::make('donate.public')->with('success_message', $message);

		//return 'Charge of $' . $input['amount'] . 'AUD to **** **** **** ' . $cc_info[1] . ', Exp ' . $cc_info[2] . '/' . $cc_info[3] . ' was successful, ';
	}
}