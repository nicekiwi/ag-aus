<?php

class Ban extends \Eloquent {
	protected $fillable = [];

	public function player()
	{
		return $this->belongsTo('Player');
	}

	public function bannedBy()
	{
		return $this->belongsTo('Player','banned_by');
	}
}