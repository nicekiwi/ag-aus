<?php

class MapTypes extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

    public function maps()
    {
        return $this->hasMany('Map');
    }
}
