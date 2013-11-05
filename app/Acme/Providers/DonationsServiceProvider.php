<?php namespace Acme\Providers;

use Illuminate\Support\ServiceProvider;

Class DonationsServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('Acme\Donations\DonationsInterface', 'Acme\Donations\StripeDonations');
	}
}