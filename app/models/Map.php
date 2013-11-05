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
}
