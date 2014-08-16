<?php namespace Quelle\Providers;

use Illuminate\Support\ServiceProvider;

Class DonationsServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('Quelle\Donations\DonationsInterface', 'Quelle\Donations\StripeDonations');
	}
}