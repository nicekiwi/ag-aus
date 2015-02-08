<?php

class Player extends Eloquent
{
	protected $fillable = [];

	protected $dates = array('donation_expires');

	public function donations()
    {
        return $this->hasMany('Donation');
    }

    public function donator()
    {
        return $this->hasOne('Donator');
    }

    public function role()
    {
        return $this->hasOne('Role','id','role_id','player_role');
    }

    public function hasRole($role)
    {
        $ownRole = $this->role->name;

        if($ownRole == $role)
        {
            return true;
        }

        return false;
    }
}