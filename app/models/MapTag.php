<?php

class MapTag extends Eloquent
{
	public function maps()
    {
        return $this->hasMany('Map');
    }
}
