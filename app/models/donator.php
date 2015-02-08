<?php
/**
 * Created by PhpStorm.
 * User: Ezra
 * Date: 7/02/15
 * Time: 2:37 AM
 */



class Donator extends Eloquent
{
    public function player()
    {
        return $this->belongsTo('Player');
    }
}