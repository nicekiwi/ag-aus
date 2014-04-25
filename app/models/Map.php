<?php

class Map extends Eloquent {
	protected $guarded = array();

	public static $rules = array();

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


	public function maptype()
    {
        return $this->belongsTo('MapTypes','type');
    }


}
