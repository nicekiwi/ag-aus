<?php

class MapController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		// $s3 = AWS::get('s3');

		// $postObject = new \Aws\S3\Model\PostObject($s3, 'alternative-gaming', [
		// 	'acl' => 'public-read',
		// 	//'key' => 'games/team-fortress-2/maps'
		// ]);

		// // $postObject = $s3->postObject('alternative-gaming', [
		// // 	'acl' => 'public-read',
		// // 	'key' => 'games/team-fortress-2/maps'
		// // ]);

		// $form = $postObject->prepareData()->getFormInputs();

		// $options = new stdClass;
		// $options->policy = $form['policy'];
		// $options->signature = $form['signature'];
		// $options->uid = uniqid();
		// $options->accessKey = $form['AWSAccessKeyId'];
		// $options->bucket = 'alternative-gaming';
		// $options->key = 'games/team-fortress-2/maps';//$form['key'];
		// $options->acl = $form['acl'];

		//dd($form);

		$maps = $this->get_maps();
		$map_files = MapFile::all();
		$map_types = MapType::orderBy('name','asc')->get();

        return View::make('maps.index')->with([
        	'maps' => $maps,
        	'map_files' => $map_files,
        	'map_types' => $map_types,
        	'options' => $options
        ]);
	}

	public function index_public()
	{
		$maps = $this->get_maps();
		$map_types = MapType::orderBy('name','asc')->get();

        return View::make('maps.public')->with(['maps'=>$maps,'map_types'=>$map_types]);
	}

	// public function upload()
	// {
		

	// 	return View::make('maps.upload')->with(compact('options'));
	// }

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

        foreach ($response['Contents'] as $map) 
        {
        	// Make sure Object is a valid file (Objects of size 0 are folders)
        	if($map['Size'] > 0)
        	{
        		$rel_path = explode('/', $map['Key']);
        		$name = $rel_path[count($rel_path)-1];

        		$ext = explode('.', $name);
        		$ext = $ext[count($ext)-1];

        		if($ext == 'bz2')
        		{
        			if(Map::where('filename',$name)->count() < 1)
		    		{
			        	$new_map = new Map;
						$new_map->filesize = $map['Size'];
						$new_map->filename = $name;
						$new_map->filetype = $ext;
						$new_map->s3_path = $map['Key'];
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
        		}

        	}
    	}

    	Session::flash('success_message', $sync_count . ' new files were synced from Amazon S3.');
    	return Redirect::to('admin/maps');

    	//$map_list_updated = Map::where('filename',$map['Key'])->count() < 1

        //return View::make('maps.create')->with(['map_types' => $map_types, 'map_list' => $map_list]);
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
			$map->type = Input::get('type');
			$map->name = Input::get('name');
			$map->revision = Input::get('revision');
			$map->more_info_url = Input::get('more_info_url');
			$map->image = Input::get('image');
			$map->desc_md = Input::get('desc_md');
			$map->desc = $html_desc;
			$map->slug = Str::slug(Input::get('name'));
			$map->developer = Input::get('developer');
			$map->developer_url = Input::get('developer_url');
			$map->save();

			Session::flash('message', 'Successfully created map!');
			return Redirect::to('maps');
		}

		Session::flash('message', 'Error');
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
		$map->type = Input::get('type');
		$map->name = Input::get('name');
		$map->revision = Input::get('revision');
		$map->more_info_url = Input::get('more_info_url');
		$map->images = Input::get('images');
		$map->video = Input::get('video');
		$map->notes = Input::get('notes');
		$map->slug = Str::slug(Input::get('name').' '.Input::get('revision'));
		$map->developer = Input::get('developer');
		$map->developer_url = Input::get('developer_url');
		$map->save();

		Session::flash('success_message', $map->name . ' ' . $map->revision . ' updated successfully.');
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
		//
	}

}
