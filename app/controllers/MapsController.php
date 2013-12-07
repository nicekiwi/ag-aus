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
		if(Input::has('type')) $maps = Map::orderBy('name','asc')->where('type',Input::get('type'))->get();
		else $maps = Map::all();

		$map_modes = MapModes::orderBy('name','asc')->get();

        return View::make('maps.index')->with(['maps'=>$maps,'map_modes'=>$map_modes]);
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
        $map_modes = MapModes::orderBy('name','asc')->lists('name','mode');

        return View::make('maps.create')->with('map_modes',$map_modes);
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
	public function show($id)
	{
        return View::make('maps.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('maps.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
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
