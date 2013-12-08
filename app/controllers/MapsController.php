<?php

class MapsController extends BaseController {

	protected $table = 'maps';

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Input::has('type')) $maps = Map::orderBy('name','asc')->where('type',Input::get('type'))->where('public',1)->get();
		else $maps = Map::where('public',1)->get();

		$map_types = MapTypes::orderBy('name','asc')->get();

        return View::make('maps.index')->with(['maps'=>$maps,'map_types'=>$map_types]);
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
        $map_types = MapTypes::orderBy('name','asc')->lists('name','type');
        $sync_count = 0;

        foreach ($response['Contents'] as $map) 
        {
        	// Make sure Object is a valid file (Objects of size 0 are folders)
        	if($map['Size'] > 0)
        	{
        		$rel_path = explode('/', $map['Key']);
        		$name = $rel_path[count($rel_path)-1];

	        	if(Map::where('filename',$name)->count() < 1)
	    		{
		        	$new_map = new Map;
					$new_map->filesize = $map['Size'];
					$new_map->filename = $name;
					$new_map->s3_path = $map['Key'];
					$new_map->save();

					$sync_count++;
	    		}
        	}
    	}

    	Session::flash('success_message', $sync_count . ' were maps synced from Amazon.');
    	return Redirect::to('/maps');

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
        return Redirect::to('maps');
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
        $map_types = MapTypes::orderBy('name','asc')->lists('name','id');

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
		$html_desc = Markdown::string(Input::get('desc_md'));

		$map = Map::findOrFail($id);
		$map->type = Input::get('type');
		$map->name = Input::get('name');
		$map->revision = Input::get('revision');
		$map->more_info_url = Input::get('more_info_url');
		$map->image = Input::get('image');
		$map->desc_md = Input::get('desc_md');
		$map->desc = $html_desc;
		$map->slug = Str::slug(Input::get('name').' '.Input::get('revision'));
		$map->developer = Input::get('developer');
		$map->developer_url = Input::get('developer_url');
		$map->save();

		Session::flash('success_message', $map->name . ' ' . $map->revision . ' updated successfully.');
		return Redirect::to('maps');
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
