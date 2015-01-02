<?php

class DonationQuarter extends Eloquent {

	protected $table = 'donation_quarters';

	protected $fillable = [];

	public function donations()
    {
        return $this->HasMany('Donation', 'quarter_id');
    }
}