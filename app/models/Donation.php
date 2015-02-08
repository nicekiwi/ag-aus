<?php

class Donation extends Eloquent 
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

    protected $fillable = [];

	public function player()
    {
        return $this->belongsTo('Player');
    }

    public function quarter()
    {
        return $this->belongsTo('DonationQuarter');
    }



}