<?php namespace Acme\Donations;

use Stripe;
use Stripe_Charge;
use Config;

Class StripeDonations implements DonationsInterface {

	public function __construct()
	{
		Stripe::setApiKey(Config::get('stripe.secret_key'));
	}

	public function charge(array $data)
	{
		try {
		  	return Stripe_Charge::create([
				'amount' => $data['amount'] * 100,
				'currency' => 'aud',
				'description' => $data['email'],
				'card' => $data['token']
			]);
		} 

		catch(Stripe_CardError $e) {
			//return Redirect::to('donate.form')->withInput();
			//Since it's a decline, Stripe_CardError will be caught
			$body = $e->getJsonBody();
			$err  = $body['error'];

			print('Status is:' . $e->getHttpStatus() . "\n");
			print('Type is:' . $err['type'] . "\n");
			print('Code is:' . $err['code'] . "\n");
			// param is '' in this case
			print('Param is:' . $err['param'] . "\n");
			print('Message is:' . $err['message'] . "\n");
		}

		catch (Stripe_InvalidRequestError $e) {
		  // Invalid parameters were supplied to Stripe's API
		}

		catch (Stripe_AuthenticationError $e) {
		  // Authentication with Stripe's API failed
		  // (maybe you changed API keys recently)
		} 

		catch (Stripe_ApiConnectionError $e) {
		  // Network communication with Stripe failed
		}

		catch (Stripe_Error $e) {
		  // Display a very generic error to the user, and maybe send
		  // yourself an email
		}

		catch (Exception $e) {
		  // Something else happened, completely unrelated to Stripe
		}

	}
}