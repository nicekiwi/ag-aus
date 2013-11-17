<?php

class Donation extends Eloquent 
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'donations';

	public function donator()
    {
        return $this->belongsTo('Donator');
    }

	public function getDonations()
	{
		return DB::table('donations')->get();
	}

	public function saveDonator()
	{

	}

}