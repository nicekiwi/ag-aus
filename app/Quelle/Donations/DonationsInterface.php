<?php namespace Quelle\Donations;

interface DonationsInterface {
	public function charge(array $data);
}