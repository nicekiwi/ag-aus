<?php namespace Quelle\Providers;

use Illuminate\Support\ServiceProvider;

Class SteamDataServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('Quelle\SteamData\SteamDataInterface', 'Quelle\SteamData\SyntaxSteamData');
	}
}