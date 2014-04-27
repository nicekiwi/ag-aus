<?php

class MapType extends Eloquent
{
	public function maps()
    {
        return $this->hasMany('Map');
    }
}
