<?php

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function players()
    {
        return $this->belongsToMany('Player','id','player_id','player_role');
    }
}