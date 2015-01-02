<?php

class MapController extends BaseController {

	protected $layout = 'layouts.master';
	protected $layoutAdmin = 'layouts.admin';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function upload()
	{
		$s3 = AWS::get('s3');

		$postObject = new \Aws\S3\Model\PostObject($s3, 'alternative-gaming', [
			'acl' => 'public-read',
		]);

		$form = $postObject->prepareData()->getFormInputs();

		$options = new stdClass;
		$options->policy = $form['policy'];
		$options->signature = $form['signature'];
		$options->uid = uniqid();
		$options->accessKey = $form['AWSAccessKeyId'];
		$options->bucket = 'alternative-gaming';
		$options->key = 'games/team-fortress-2/maps';//$form['key'];
		$options->acl = $form['acl'];

        return View::make('maps.upload')->with(compact('options'));
	}

	public function index()
	{
		$maps = $this->get_maps();
		$map_total = Map::count();
		$map_files = MapFile::where('map_id',null)->get();
		$map_types = MapType::orderBy('name','asc')->get();

		//dd($map_total);

        //$this->layoutAdmin->bodyClass = 'maps-page';
		return View::make('maps.index')->with([
        	'maps' => $maps,
        	'map_files' => $map_files,
        	'map_types' => $map_types,
        	'map_total' => $map_total
        ]);
	}

	public function index_public()
	{
		$maps = $this->get_maps();
		$map_total = Map::count();
		$map_types = MapType::orderBy('name','asc')->get();

        $this->layout->bodyClass = 'maps-page';
		$this->layout->content = View::make('maps.public')->with([
        	'maps'=>$maps,
        	'map_types'=>$map_types,
        	'map_total' => $map_total
        ]);
	}

	public function get_maps()
	{
		if(Input::has('type')) 
			//$maps = Map::orderBy('name','asc')->has('type',Input::get('type'))/*->where('type',Input::get('type'))->where('public',1)*/->get();
			$maps = Map::orderBy('name','asc')->whereHas('maptype', function($q)
			{
			    $q->where('type', Input::get('type'));

			})->get();
		else 
			$maps = Map::all();

		return $maps;
	}

	public function search($name)
	{
		$results = Map::where('name', 'LIKE', '%'.$name.'%')->orWhere('filename', 'LIKE', '%'.$name.'%')->pageinate(15);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        $s3 = AWS::get('s3');

		$response = $s3->listObjects([
			'Bucket' => 'alternative-gaming',
			'Prefix' => 'games/team-fortress-2/maps/'
		]);

	    $map_list = $response['Contents'];
        $map_types = MapType::orderBy('name','asc')->lists('name','type');
        $sync_count = 0;

        //dd($response['Contents']);

        foreach ($map_list as $map) 
        {
        	// Make sure Object is a valid file (Objects of size 0 are folders)
        	if($map['Size'] > 0)
        	{
        		// Get Filename
        		$rel_path = explode('/', $map['Key']);
        		$name = $rel_path[count($rel_path)-1];

        		// Get File Extenstion
        		$ext = explode('.', $name);
        		$ext = $ext[count($ext)-1];

        		// Get MapType from filename
        		$type = explode('_', $name);
        		$type = $type[0];

        		// Check if MapType exists in DB
        		$checkType = MapType::where('type', $type)->first();

        		// Get Special MapType ID
        		$special = MapType::where('type','special')->first();

        		// Check if filetype is TF2 Map or not
        		if($ext == 'bz2')
        		{
        			if(Map::where('filename',$name)->count() < 1)
		    		{
			        	$new_map = new Map;
						$new_map->filesize = $map['Size'];
						$new_map->filename = $name;
						$new_map->filetype = $ext;
						$new_map->s3_path = $map['Key'];

						// Pass MapType ID to Map Row
						if($checkType->id)
							$new_map->map_type_id = $checkType->id;
						else
							$new_map->map_type_id = $special->id;

						$new_map->created_by = Auth::user()->id;
						$new_map->updated_by = Auth::user()->id;
						$new_map->save();

						$sync_count++;
		    		}
        		}
        		else
        		{
        			if(MapFile::where('filename',$name)->count() < 1)
		    		{
			        	$new_file = new MapFile;
						$new_file->filesize = $map['Size'];
						$new_file->filename = $name;
						$new_file->filetype = $ext;
						$new_file->s3_path = $map['Key'];
						$new_file->save();

						$sync_count++;
		    		}
		    		// else
		    		// {
		    		// 	// If there is no map accociated with the file, add it.
		    		// 	if(MapFile::where('filename',$name)->pluck('map_id') == null)
		    		// 	{

		    		// 	}

		    		// 	$map = MapFile::where('filename',$name)->first();
		    		// 	$file = Map::where('id',$map->id);
		    		// }
        		}

        		$this->linkMapFiles();

        	}
    	}



    	Session::flash('success_message', $sync_count . ' new files were synced from Amazon S3.');
    	return Redirect::to('admin/maps');

    	//$map_list_updated = Map::where('filename',$map['Key'])->count() < 1

        //return View::make('maps.create')->with(['map_types' => $map_types, 'map_list' => $map_list]);
	}

	// Link MapFiles with Maps with the same filename.
	public function linkMapFiles()
	{
		// Get all files without maps assigned to them
		$files = MapFile::where('map_id', null)->get();

		// Go through each file 
		foreach ($files as $file) 
		{
			// Get file name
			$name = explode('.', $file->filename);
        	$name = $name[0];

        	// Check if a map with the same name exists
        	$map = Map::where('filename',$name.'.bsp.bz2')->first();

        	// If the map exists
        	if($map->id != null)
        	{
        		// Save the Map ID to the file
        		$file->map_id = $map->id;
        		$file->save();
        	}
		}
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if(Input::hasFile('map_file')) 
		{
			$file = Input::file('map_file');

			$file_name = $file->getClientOriginalName();
			$file_ext = $file->getClientOriginalExtension();

			$s3 = App::make('aws')->get('s3');
			$s3->putObject(array(
			  'Bucket' 		=> 'ag-maps',
			  'Key'        	=> $file_name,
			  'SourceFile' 	=> $file->getRealPath(),
			  'ACL'			=> 'public-read',
			  'ContentType'	=> 'application/x-bzip2',
			));

			$html_desc = Markdown::string(Input::get('desc_md'));

			$map = new Map;
			$map->filesize = $file->getSize();
			$map->filename = $file_name;
			$map->s3_path = 'https://s3-ap-southeast-2.amazonaws.com/ag-maps/' . $file_name;
			$map->map_type_id = Input::get('type');
			$map->name = Input::get('name');
			//$map->revision = Input::get('revision');
			//$map->more_info_url = Input::get('more_info_url');
			$map->images = Input::get('images');
			//$map->desc_md = Input::get('desc_md');
			//$map->desc = $html_desc;
			//$map->slug = Str::slug(Input::get('name'));
			//$map->developer = Input::get('developer');
			//$map->developer_url = Input::get('developer_url');
			$map->save();

			Session::flash('success_message', 'Successfully created map!');
			return Redirect::to('maps');
		}

		Session::flash('error_message', 'Error');
        return Redirect::to('admin/maps');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$map = Map::where('slug',$slug)->with('maptype')->first();

        return View::make('maps.show')->with('map',$map);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $map = Map::findOrFail($id);
        $map_types = MapType::orderBy('name','asc')->lists('name','id');

        return View::make('maps.edit')->with([ 'map' => $map, 'map_types' => $map_types ]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$map = Map::findOrFail($id);
		$map->map_type_id = Input::get('map_type_id');
		//$map->name = Input::get('name');
		//$map->revision = Input::get('revision');
		//$map->more_info_url = Input::get('more_info_url');
		$map->images = Input::get('images');
		//$map->video = Input::get('video');
		//$map->notes = Input::get('notes');
		//$map->slug = Str::slug(Input::get('name').' '.Input::get('revision'));
		//$map->developer = Input::get('developer');
		//$map->developer_url1 = Input::get('developer_url');
		$map->save();

		Session::flash('success_message', $map->filename . ' updated successfully.');
		return Redirect::to('admin/maps');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		// delete
		$map = Map::findOrFail($id);
		$map->delete();

		// redirect
		Session::flash('success_message', $map->filename . ' deleted.');
		return Redirect::to('admin/posts');
	}


	// pull the player into the database
	public function steamAuth()
	{
		$steam_64id = SteamLogin::validate();

		if($steam_64id) {

			$player = Player::where('steam_64id',$steam_64id)->first();

			// If player already exists, get their ID
			if ( !$player )
			{
				// Get player data from Steam
				$data = App::make('PlayersController')->getPlayerInfo($steam_64id);

				// Save new player to players table and get their ID
				$player = new Player;

				$player->steam_id = $data->steam_id;
				$player->steam_64id = $steam_64id;
				$player->steam_url = $data->steam_url;
				$player->steam_nickname = $data->steam_nickname;
				$player->steam_image = $data->steam_image;

				$player->save();
			}

			// save player data to session
			Session::put('public-auth-true', 1);
			Session::put('player', $player);

			return Redirect::to('/maps')->with('success_message', 'You have been authenticated, vote away.');

		}
		else {
			return Redirect::to('/maps')->with('error_message', 'Could not authenticate you with Steam.');
		}
	}

	// pull the player into the database
	public function steamAuthLogout()
	{
		Session::forget('public-auth-true');
		Session::forget('player');

		return Redirect::to('/maps')->with('success_message', 'I saw nothing! NOOOTHING!');
	}
}
