<?php

class Donations extends Eloquent 
{

	public function getDonations()
	{
		return DB::table('donations')->get();
	}

	public function saveDonator()
	{

	}

}