<?php

class DonationController extends BaseController
{
	protected $layout = 'layouts.master';
	protected $layoutAdmin = 'layouts.admin';

	function __construct() {

		// set quarter goal amount
		$this->quarterGoal = Options::pluck('donation_quarter_goal');

		// Get current year
		$this->thisYear = date('Y');

		// Get timestamp of today
		$this->today = new \Carbon\Carbon('today');

		// Get quater dates
		$this->firstQuarter = [
			new \Carbon\Carbon('first day of January'),
			new \Carbon\Carbon('23:59:59 last day of March')
		];

		$this->secondQuarter = [
			new \Carbon\Carbon('first day of April'),
			new \Carbon\Carbon('23:59:59 last day of June')
		];

		$this->thirdQuarter = [
			new \Carbon\Carbon('first day of July'),
			new \Carbon\Carbon('23:59:59 last day of September')
		];

		$this->fourthQuarter = [
			new \Carbon\Carbon('first day of October'),
			new \Carbon\Carbon('23:59:59 last day of December')
		];

		$this->currentQuarter = new StdClass;

		// check for and get current quarter donations
		if ($this->today->between($this->firstQuarter[0],$this->firstQuarter[1])) {
			$this->currentQuarter->dates = $this->firstQuarter;
		}
		if ($this->today->between($this->secondQuarter[0],$this->secondQuarter[1]))  {
			$this->currentQuarter->dates = $this->secondQuarter;
		}
		if ($this->today->between($this->thirdQuarter[0],$this->thirdQuarter[1])) {
			$this->currentQuarter->dates = $this->thirdQuarter;
		}
		if ($this->today->between($this->fourthQuarter[0],$this->fourthQuarter[1]))  {
			$this->currentQuarter->dates = $this->fourthQuarter;
		}

		$this->currentQuarter->donations = Donation::whereBetween('created_at', $this->currentQuarter->dates)->get();
		$this->currentQuarter->totalDonations = $this->currentQuarter->donations->sum('amount');
		$this->currentQuarter->percentage = round(($this->currentQuarter->totalDonations / $this->quarterGoal) * 100);
		$this->currentQuarter->number = $this->today->quarter;

		// get donations for current quater

	}

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
	// public function create_quarter()
	// {
	// 	// Get current year
	// 	$year = date('Y');
	// 	// Get timestamp of today
	// 	$today = new \Carbon\Carbon('now');
	//
	// 	// Get dates for first quater
	// 	$q1_start = new \Carbon\Carbon('first day of January');
	// 	$q1_end = new \Carbon\Carbon('23:59:59 last day of March');
	//
	// 	// Get dates for second quater
	// 	$q2_start = new \Carbon\Carbon('first day of April ');
	// 	$q2_end = new \Carbon\Carbon('23:59:59 last day of June');
	//
	// 	// Get dates for third quater
	// 	$q3_start = new \Carbon\Carbon('first day of July');
	// 	$q3_end = new \Carbon\Carbon('23:59:59 last day of September');
	//
	// 	// Get dates for fourth quater
	// 	$q4_start = new \Carbon\Carbon('first day of October');
	// 	$q4_end = new \Carbon\Carbon('23:59:59 last day of December');
	//
	// 	// New Quarter Object
	// 	$quarter = new DonationQuarter;
	//
	// 	// Calculate Goal amount from combination of server MOnthly costs times the Billing Cycle
	// 	// ToDo: Billing cycle should be added to a Settings array somewhere.
	// 	$quarter->goal_amount = Server::sum('monthlyCost') * 3;
	// 	$quarter->year = $year;
	//
	// 	// Check which quater is current and apply the responding settings
	// 	if($today->between($q1_start, $q1_end))//$today > $q1_start->toDateTimeString() && $today < $q1_end->toDateTimeString())
	// 	{
	// 		$quarter->title = '1st Quater ' . $quarter->year;
	// 		$quarter->start_at = $q1_start;
	// 		$quarter->end_at = $q1_end;
	// 		$quarter->quarter = 1;
	// 	}
	// 	else if($today->between($q2_start, $q2_end))//$today > $q2_start->toDateTimeString() && $today < $q2_end->toDateTimeString())
	// 	{
	// 		$quarter->title = '2nd Quater ' . $quarter->year;
	// 		$quarter->start_at = $q2_start;
	// 		$quarter->end_at = $q2_end;
	// 		$quarter->quarter = 2;
	// 	}
	// 	else if($today->between($q3_start, $q3_end))//$today > $q3_start->toDateTimeString() && $today < $q3_end->toDateTimeString())
	// 	{
	// 		$quarter->title = '3rd Quater ' . $quarter->year;
	// 		$quarter->start_at = $q3_start;
	// 		$quarter->end_at = $q3_end;
	// 		$quarter->quarter = 3;
	// 	}
	// 	else if($today->between($q4_start, $q4_end))//$today > $q4_start->toDateTimeString() && $today < $q4_end->toDateTimeString())
	// 	{
	// 		$quarter->title = '4th Quater ' . $quarter->year;
	// 		$quarter->start_at = $q4_start;
	// 		$quarter->end_at = $q4_end;
	// 		$quarter->quarter = 4;
	// 	}
	//
	// 	// Save new quater
	// 	$quarter->save();
	// }

	// Update current Quarter
	// public function update_quarter()
	// {
	// 	// Get timestamp of today
	// 	$today = new \Carbon\Carbon('now');
	// 	// Get latest quter Object
	// 	$latest_quarter = DonationQuarter::orderBy('id','desc')->first();
	//
	// 	if(!$latest_quarter)
	// 		return $this->create_quarter();
	//
	// 	$latest_quarter_ends = new \Carbon\Carbon($latest_quarter->end_at);
	//
	// 	// If today is later than the end date of the last quater
	// 	// create a new quarter instance.
	// 	if($today->gt($latest_quarter_ends))//$today->toDateTimeString() > $latest_quarter->ends_at)
	// 	{
	// 		return $this->create_quarter();
	// 	}
	//
	// 	// Find current quarter Object instance
	// 	$quarter = DonationQuarter::findOrFail($latest_quarter->id);
	//
	// 	// Add up all the donations placed in the time of the current quater
	// 	$total_amount = Donation::whereBetween('created_at', [$quarter->start_at,$quarter->end_at])->sum('amount');
	//
	// 	// Caluclate percentage donations of total goal, only if donated
	// 	// amount of greater than 0.
	// 	if($total_amount > 0)
	// 	{
	// 		$percentage = round(($total_amount / $quarter->goal_amount) * 100);
	// 		// Set total and percentages
	// 		$quarter->total_amount = $total_amount;
	// 		$quarter->goal_percentage = $percentage;
	//
	// 		//dd(number_format($percentage));
	// 	}
	//
	// 	// Save changes to current quarter
	// 	$quarter->save();
	// }
	//
	//
	//
	//

	public function getDonations() {
		return json_encode($this->currentQuarter->donations);
	}

	public function getCurrentQuarter() {
		return json_encode($this->currentQuarter->dates);
	}

	public function index()
	{
		// Get donations from current quater
		//$donations = Donation::where('quarter_id',$quarter->id)->get();

		//dd($donations);
		//
		$quarters = DonationQuarter::take(4)->get();

		// Return donate with quarter data
		return View::make('donate.index')->with([
			'quarters' => $quarters
		]);
	}

	public function expiry()
	{
		// Get donations from current quater
		//$donations = Donation::where('quarter_id',$quarter->id)->get();

		//dd($donations);
		//
		$players = Player::whereNotNull('donation_expires')->orderBy('donation_expires','asc')->get();
		$today = $this->today;

		// Return donate with quarter data
		return View::make('donate.expiry')->with([
			'players' => $players,
			'today'	=> $today
		]);
	}

	public function public_index()
	{
		// Get latest quter Object
		//$quarter = DonationQuarter::orderBy('id','desc')->first();
		//$donations = Donation::where('quarter_id',$quarter->id)->get();

		//dd($this->currentQuarter);

		// Return donate with quarter data
		$this->layout->bodyClass = 'donations-page';
		$this->layout->content = View::make('donate.public')->with([
			'donations' => 	$this->currentQuarter->donations,
			'percentage' => $this->currentQuarter->percentage,
			'total' => 			$this->currentQuarter->totalDonations,
			'goal' 	=> 			$this->quarterGoal,
			'number'	=> 	$this->currentQuarter->number
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

	// let the donator know their donor status has been applied to the game servers
	// public function confirmDonation($code) {
	// 	$donation = Donation::where('confirm_code', $code)->where('confirmed',0)->first();

	// 	if($donation) {

	// 		Mail::queue('emails.donations.confirm-donor', ['data' => $donation], function($message) use ($donation)
	// 		{
	// 			$message->to($donation->email)->subject('AG/DOP Donator Status Confirmed.');
	// 		});

	// 		$donation->confirmed = 1;
	// 		$donation->confirmed_by = Auth::user()->id;
	// 		$donation->save();

	// 		return Redirect::to('/admin/donations')
	// 				->with('success_message', 'Donation confirmed, a confirmation email has been sent to the donor.');

	// 	}
	// 	else {

	// 		return Redirect::to('/admin/donations')
	// 				->with('error_message', 'Donation is already confirmed or the code is invalid.');
	// 	}
	// }

	// notify the donor their payment was successful, and wait for a confirmation email
	public function notifyDonor($donation)
	{
		Mail::queue('emails.donations.nofity-donor', ['data' => $donation], function($message) use ($donation)
		{
			$message->to($donation->email)->subject('AG/DOP Donator Status Confirmed.');
		});
	}

	// public function notifyAdmin($playerID, $donationAmount, $confirmCode)
	// {
	// 	$options = Options::first();
	// 	$player = Player::find($playerID);
	// 	$snippets = $this->getConfigSnippet($playerID);

	// 	//dd($options);

	// 	$data = new StdClass;
	// 	$data->admin = $snippets[0];
	// 	$data->sprite = $snippets[1];
	// 	$data->amount = $donationAmount;
	// 	$data->nickname = $player->steam_nickname;
	// 	$data->expiry = $player->donation_expiry;
	// 	$data->code = $confirmCode;

	// 	Mail::queue('emails.donations.notify-admin', ['data' => $data], function($message) use ($options)
	// 	{
	// 		$message->to($options->donation_admin_email1)->subject('New Donation to AG/DOP');
	// 	});
	// }

	public function saveDonation()
	{
		$input = Input::all();
		$credit_card = explode(',', $input['stripe_data']);

		// get or create donation_quarter record
		$quarter = DonationQuarter::where('quarter', $this->today->quarter)->first();

		if(!$quarter->id) {

			$quarter = new DonationQuarter;
			$quarter->year = $this->today->year;
			$quarter->quarter = $this->today->quarter;
			$quarter->goal = $this->quarterGoal;
			$quarter->save();

		}

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
		$donation->quarter_id = $quarter->id;


		if($input['steam_id'])
		{
			// Check if donation gets a perk
			if($donation->amount > 7) {
				$expiry = new \Carbon\Carbon('tomorrow');
				$expiry = $expiry->addMonths(round($donation->amount / 7));
			}

			//$donation->confirm_code = md5($donation->email . $expiry);

			// Use Validation to check if player has dontated before
			$validator = Validator::make($input, ['steam_id' => 'required|unique:players']);

			// If player already exists, get their ID
			if ( $validator->fails() )
			{
				$existing_player = Player::where('steam_id', $input['steam_id'])->first();
				$donation->player_id = $existing_player->id;
				$existing_player->donation_expires = $expiry or null;

				// Update the nickname if different from previously saved one.
				if(Input::has('steam_nickname') && $input['steam_nickname'] !== $existing_player->steam_nickname)
				{
					$existing_player->steam_nickname = $input['steam_nickname'];
				}

				$existing_player->save();
			}
			else
			{
				// Save new player to players table and get their ID
				$player = new Player;

				$player->steam_id = $input['steam_id'];

				if(Input::has('steam_64id')){
					$player->steam_64id = $input['steam_64id'];
				}

				if(Input::has('steam_url')){
					$player->steam_url = $input['steam_url'];
				}

				if(Input::has('steam_nickname')){
					$player->steam_nickname = $input['steam_nickname'];
				}

				if(Input::has('steam_image')){
					$player->steam_image = $input['steam_image'];
				}

				$player->donation_expires = $expiry or null;
				$player->save();
				$donation->player_id = $player->id;
			}

			//$this->notifyAdmin($donation->player_id, $donation->amount, $donation->confirm_code);
			$this->notifyDonor($donation);

			Queue::push(function()
			{
				$this->writeDonators();
			});

			// Mail::queue('emails.donations.notify-admin', null, function($message)
			// {
			// 	$message->to('nicekiwi@gmail.com')->subject('New Donation to AG/DOP');
			// });
		}

		// Save donation
		$donation->save();

		// update the quarter total and percentage
		$quarter->total = Donation::where('quarter_id', $quarter->id)->sum('amount');
		$quarter->percentage = round(($quarter->total / $quarter->goal) * 100);
		$quarter->save();

		// Write Donations to the server.
		//$this->writeDonators();

		$message = '<b>Donation Successful</b>, w00t! Our friendly Admins have been notified and will apply your donator status very soon, you should get an  email when this has been done. If this dosen\'t happen within a day give us a yell on steam or TeamSpeak.';

		return Redirect::to('/donate')->with('success_message', $message);
	}

	private function getConfigSnippet($playerID)
	{
		$player = Player::find($playerID);

		if($player)
		{
			// New Line Break
			$n 	= "\n";
			// New Tab space
			$t 	= "\t";

			$admin = '{' . $n;
			$admin .= $t . '// ' . $player->steam_nickname . $n;
			$admin .= $t . '// Expires ' . date('d/m/Y', strtotime($player->donation_expires)) . $n;
			$admin .= $t . $player->steam_id . $n;
			$admin .= '}';

			$sprite = '// ' . $player->steam_nickname . $n;
			$sprite .= '// Expires ' . date('d/m/Y', strtotime($player->donation_expires)) . $n;
			$sprite .= $player->steam_id;

			return [$admin,$sprite];
		}
	}

	public function notifyDonorExpires($donation)
	{
		Mail::queue('emails.donations.notify-donor-expires', ['data' => $donation], function($message) use ($donation)
		{
			$message->to($donation->email)->subject('Your AG/DOP Donator Status expires soon.');
		});
	}

	public function checkDonatorExpiry()
	{
		$donators = Player::where('donation_expires', $this->today->addDays(5))->get();

		if($donators) 
		{
			foreach ($donators as $donator) 
			{
				$this->notifyDonorExpires($donator->donations->first());
			}
		}

		$this->writeDonators();
	}

	public function writeDonators()
	{
		$donators = Player::where('donation_expires','>', strtotime('today'))->get();

		if($donators->count() > 0)
		{
			// New Line Break
			$n 	= "\n";
			// New Tab space
			$t 	= "\t";

			// Start content with new lines
			$admins = $n . $n;
			
			foreach ($donators as $donator)
			{
				$admins .= $n . '\"' . $donator->steam_nickname . '\"' . $n;
				$admins .= '{' . $n;
				$admins .= $t . '// Expires ' . date('d/m/Y', strtotime($donator->donation_expires)) . $n;
				$admins .= $t . '\"auth\"' . $t . $t . '\"steam\"' . $n;
				$admins .= $t . '\"identity\"' . $t . '\"' . $donator->steam_id . '\"' . $n;
				$admins .= $t . '\"group\"' . $t . $t . '\"Donator\"' . $n;
				$admins .= '}' . $n . $n;
			}

			// Write contents to Pantheon
		    SSH::into('pantheon')->run(array(
				'echo "' . $admins . '" > ~/quelle/users/donators.txt',
			    '~/quelle/scripts/generate-admins.sh',
			));

			return;
		}
	}
}
