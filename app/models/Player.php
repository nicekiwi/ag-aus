<?php

class Player extends \Eloquent {
	protected $fillable = [];

	protected $dates = array('donation_expires');

	public function donations()
    {
        return $this->hasMany('Donation');
    }
}