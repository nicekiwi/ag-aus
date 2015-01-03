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
    public function filesizeHuman()
    {
        

        $filesize = $this->filesize;

        //dd($filesize);

        if ($filesize >= 1048576) {

            return number_format($filesize / 1048576, 2) . ' MB';
        }
        else if ($filesize >= 1024) {

            return number_format($filesize / 1024, 2) . ' KB';
        }

    }

    public function mapThumbnail()
    {
        $url = $this->images;

        if($url) {
            return $url;
        } 
        else {
            return urlencode(url('/img/no-thumb.png'));
        }
    }
    

    // public function getMaps()
    // {
    //     if(Input::has('type')) {

    //         $maps = $this::orderBy('name','asc')->whereHas('maptype', function($q)
    //         {
    //             $q->where('type', Input::get('type'));

    //         })->get();
    //     } 
    //     else {
    //         $maps = $this::all();
    //     }

    //     return $maps;
    // }

    public function search($name)
    {
        return Map::Where('filename', 'LIKE', '%' . $name . '%')->pageinate(15);
    } 

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
