<?php

class MapFile extends Eloquent
{
    public function map()
    {
        return $this->hasOne('Map');
    }
}