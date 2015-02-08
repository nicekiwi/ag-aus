<?php

class Post extends Eloquent
{
	protected $guarded = array();

	public static $rules = array();

	public function user()
    {
        return $this->belongsTo('User', 'created_by');
    }
}
