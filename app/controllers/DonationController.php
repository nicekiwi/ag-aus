<?php

class DonationController extends BaseController 
{


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
		$donations = App::make('Quelle\Donations\DonationsInterface');
	
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
		$credit_card = explode(',', $input['stripe_data']);

		// Save donation details to donnations table with player's ID.
		$donation = new Donation;
		$donation->amount = $input['amount'];
		$donation->currency = 'AUD';

		$donation->email = $input['email'];
		$donation->card_token = $input['stripe_token'];
		$donation->card_type = $credit_card[0];
		$donation->card_last4 = $credit_card[1];
		$donation->card_month = $credit_card[2];
		$donation->card_year = $credit_card[3];

		// Get latest quter Object
		$quarter = DonationQuarter::orderBy('id','desc')->first();
		$donation->quarter_id = $quarter->id;

		if(Input::has('steam_id'))
		{
			// Use Validation to check if player has dontated before
			$validator = Validator::make($input, ['steam_id' => 'required|unique:players']);

			// If player already exists, get their ID
			if ( $validator->fails() )
			{
				$existing_player = Player::where('steam_id', $input['steam_id'])->first();
				$donation->player_id = $existing_player->id;

				// Update the nickname if different from previously saved one.
				if(Input::has('steam_nickname') && $input['steam_nickname'] !== $existing_player->steam_nickname)
				{
					$existing_player->steam_nickname = $input['steam_nickname'];
					$existing_player->save();
				}
			}
			else
			{
				// Save new player to players table and get their ID
				$player = new Player;

				$player->steam_id = $input['steam_id'];

				if(Input::has('steam_64id'))
					$player->steam_64id = $input['steam_64id'];

				if(Input::has('steam_url'))
					$player->steam_url = $input['steam_url'];

				if(Input::has('steam_nickname'))
					$player->steam_nickname = $input['steam_nickname'];

				if(Input::has('steam_image'))
					$player->steam_image = $input['steam_image'];

				$player->save();
				$donation->player_id = $player->id;
			}
		}

		// Save donation
		$donation->save();

		// Update quarter
		$this->update_quarter();

		// Write Donations to the server.
		$this->writeDonators();

		//$message = 'Charge of $' . $donation->amount . 'AUD to **** **** **** ' . $donation->card_last4 . ', Exp ' . $donation->card_month . '/' . $donation->card_year . ' was successful, ';

		$message = '<b>Donation Successful</b>, thanks for the support! You have been emailed a confirmation and if you donated more than $12 your ingame perks will take effect next time the map chnages on the server.';

		return Redirect::to('/donate')->with('success_message', $message);
	}

	private function writeDonators()
	{
		$donators = Player::where('donation_expires','>', strtotime('today'))->get();

		if($donators->count() > 0)
		{
			// New Line Break
			$n 	= "\n";
			// New Tab space
			$t 	= "\t";

			// Start content as empty
			$sprite = '';
			$admins = '';
			
			foreach ($donators as $donator)
			{
				$admins .= '{' . $n;
				$admins .= $t . '// ' . $donator->steam_nickname . $n;
				$admins .= $t . '// Expires ' . date('d/m/Y', strtotime($donator->donation_expires)) . $n;
				$admins .= $t . $donator->steam_id . $n;
				$admins .= '}' . $n . $n;

				$sprite .= '//' . $donator->steam_nickname . $n;
				$sprite .= '// Expires ' . date('d/m/Y', strtotime($donator->donation_expires)) . $n;
				$sprite .= $donator->steam_id . $n;
			}

			// Setup file paths
			$filePath = 'quelle/remote-configs/donators/';
			$spritePath = 'donators.txt';
			$adminsPath = 'admins.txt';

			// Write contents
			$contents = SSH::into('pantheon')->getString($remotePath);

			return;
		}
	}
}