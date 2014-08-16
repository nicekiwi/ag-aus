<?php

class Player extends \Eloquent {
	protected $fillable = [];

	public function donations()
    {
        return $this->hasMany('Donation');
    }
}