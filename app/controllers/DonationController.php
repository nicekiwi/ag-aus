<?php

class DonationController extends BaseController
{
	protected $layout = 'layouts.master';

	function __construct() {

		// set quarter goal amount
		$this->options = Options::first();

		// Get timestamp of today
		$this->today = new \Carbon\Carbon('today');

		// Get current Quarter
		$this->quarter = DonationQuarter::where('quarter', $this->today->quarter)
					   					->where('year', $this->today->year)
					   					->first();

		// Create a new quarter if it does not exist
		if(!$this->quarter)
		{
			$this->quarter = $this->createQuarter();
		}
	}

	public function getDonationsJson() {
		return json_encode($this->quarter->donations);
	}

	public function getCurrentQuarterJson() {
		return json_encode($this->quarter->quarter);
	}

	public function index()
	{

		$quarters = DonationQuarter::orderBy('year','asc')
								   ->orderBy('quarter','asc')
								   ->get();

		$players = Player::whereNotNull('donation_expires')
						 ->orderBy('donation_expires','asc')
						 ->get();

		// Return donate with quarter data
		return View::make('donate.index', [
			'quarters' => $quarters,
			'players' => $players,
			'options' => $this->options,
			'bodyClass' => 'donations-page'
		]);
	}

	public function public_index()
	{
		// Return donate with quarter data
		$this->layout->bodyClass = 'donations-page';
		$this->layout->content = View::make('donate.public')->with([
			'quarter' => $this->quarter,
			'today' => $this->today,
			'options' => $this->options
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

	// notify the donor their payment was successful, and wait for a confirmation email
	public function notifyDonor($donation)
	{
		Mail::queue('emails.donations.nofity-donor', ['data' => $donation], function($message) use ($donation)
		{
			$message->to($donation->email)->subject('AG/DOP Donator Status Confirmed.');
		});
	}

	private function createQuarter()
	{
		$quarter = new DonationQuarter;
		$quarter->year = 	$this->today->year;
		$quarter->quarter = $this->today->quarter;
		$quarter->total = 0;
		$quarter->goal = 	$this->options->donation_quarter_goal;
		$quarter->save();

		return $quarter;
	}

	public function saveDonation()
	{
		$input = Input::all();
		

		// get or create donation_quarter record
		$quarter = $this->quarter;

		// Create new quarter if not found
		if(!$quarter->id) {
			$this->createQuarter();
		}

		// Save donation details to donnations table with player's ID.
		$donation = new Donation;
		$donation->email = 		$input['email'];
		$donation->amount = 	$input['amount'];
		$donation->currency = 	'AUD';

		$credit_card = explode(',', $input['stripe_data']);
		
		$donation->card_token = $input['stripe_token'];
		$donation->card_type = 	$credit_card[0];
		$donation->card_last4 = $credit_card[1];
		$donation->card_month = $credit_card[2];
		$donation->card_year = 	$credit_card[3];
		$donation->quarter_id = $quarter->id;


		if($input['steam_id'])
		{

			// Check if donation gets a perk
			if($donation->amount > $this->options->donation_monthly_cost) 
			{
				$months = round($donation->amount / $this->options->donation_monthly_cost);
				$expiry = $this->today->addDays(1)->addMonths($months);
			}
			else
			{
				$expiry = null;
			}

			$input['donation_expires'] = $expiry;

			//$donation->confirm_code = md5($donation->email . $expiry);

			// Use Validation to check if player has dontated before
			//$validator = Validator::make($input, ['steam_id' => 'required|unique:players']);
			$player = Player::where('steam_id', $input['steam_id'])->first();

			// If player already exists, get their ID
			if ( $player )
			{
				$donation->player_id = $player->id;
				$player->update($input['donation_expires']);
			}
			else
			{
				// Save new player to players table and get their ID
				$player = Player::create($input);

				// $player->steam_id = $input['steam_id'];

				// if(Input::has('steam_64id')){
				// 	$player->steam_64id = $input['steam_64id'];
				// }

				// if(Input::has('steam_url')){
				// 	$player->steam_url = $input['steam_url'];
				// }

				// if(Input::has('steam_nickname')){
				// 	$player->steam_nickname = $input['steam_nickname'];
				// }

				// if(Input::has('steam_image')){
				// 	$player->steam_image = $input['steam_image'];
				// }

				//$player->donation_expires = $expiry or null;
				//$player->save();
				//
				$donation->player_id = $player->id;
			}

			//$this->notifyAdmin($donation->player_id, $donation->amount, $donation->confirm_code);
			$this->notifyDonor($donation);

			Queue::push(function()
			{
				App::make('DonationController')->writeDonators();
			});

			// Mail::queue('emails.donations.notify-admin', null, function($message)
			// {
			// 	$message->to('nicekiwi@gmail.com')->subject('New Donation to AG/DOP');
			// });
		}

		// Save donation
		$donation->save();

		// update the quarter total and percentage
		$quarter->total = $this->quarter->total + $donation->amount;
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
		$donators = Player::where('donation_expires','>', $this->today->date)->get();

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
				$admins .= $n . '\"' . htmlspecialchars($donator->steam_nickname) . '\"' . $n;
				$admins .= '{' . $n;
				$admins .= $t . '// Expires ' . date('d/m/Y', $donator->donation_expires->date) . $n;
				$admins .= $t . '\"auth\"' . $t . $t . '\"steam\"' . $n;
				$admins .= $t . '\"identity\"' . $t . '\"' . $donator->steam_id . '\"' . $n;
				$admins .= $t . '\"group\"' . $t . $t . '\"Donator\"' . $n;
				$admins .= '}' . $n . $n;
			}

			// Write contents to Pantheon
			try
			{
				SSH::into('pantheon')->run(array(
					'echo "' . $admins . '" > ~/quelle/users/donators.txt',
					'~/quelle/scripts/generate-admins.sh',
				));
			}
			catch(ErrorException $e)
			{
				// Log a failed write
				Log::info('Writing Donators failed: ' . $e);
			}

			return;
		}
	}
}
