<?php

class Donator extends Eloquent 
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'donators';

	public function donations()
    {
        return $this->hasMany('Donation');
    }

}