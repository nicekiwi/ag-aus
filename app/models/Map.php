<?php

use LaravelBook\Ardent\Ardent;

class Map extends Ardent 
{
	protected $guarded = [];

	// public static $rules = [
	// 	'name' => 'required|between:4,16',
	// 	'email' => 'required|email',
	// 	'password' => 'required|alpha_num|between:4,8|confirmed',
	// 	'password_confirmation' => 'required|alpha_num|between:4,8'
	// ];

	function getMapList()
	{
		$s3 = AWS::get('s3');

		$response = $s3->listObjects([
			'Bucket' => 'ag-maps'
		]);

		return $response;
	}

	public function parseYouTubeUrl($url)
	{
	     $pattern = '#^(?:https?://)?(?:www\.)?(?:m\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
	     preg_match($pattern, $url, $matches);
	     return (isset($matches[1])) ? $matches[1] : false;
	}


	public function mapType()
    {
        return $this->belongsTo('MapType','map_type_id');
    }

    public function mapFiles()
    {
        return $this->hasMany('MapFile','map_id');
    }

    public function mapTags()
    {
    	return $this->hasMany('MapTag','map_tag_id');
    }

    public function mapConfig()

    {
    	return $this->belongsToMany('MapConfig','map_map_config','map_config_id','map_id');
    }

    public function user()
    {
        return $this->belongsTo('User', 'created_by');
    }

    public function feedback()
    {
    	return $this->hasMany('MapFeedback');
    }

    // public function voteUp()
    // {
    // 	$this->where()
    // }

    // public function voteDown()
    // {
    	
    // }

    // public function voteBroken()
    // {
    	
    // }


}
