<?php

class MapFeedback extends Eloquent 
{
	protected $guarded = [];

	protected $table = 'map_feedback';


    public function map()
    {
    	return $this->belongsTo('Map');
    }


}
