<?php

class Donation extends Eloquent 
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */

	public function player()
    {
        return $this->belongsTo('Player');
    }

}