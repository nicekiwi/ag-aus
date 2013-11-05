<?php namespace Acme\Donations;

interface DonationsInterface {
	public function charge(array $data);
}