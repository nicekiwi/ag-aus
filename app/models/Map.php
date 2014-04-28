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


}
