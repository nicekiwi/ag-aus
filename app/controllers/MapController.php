<?php

use Aws\Common\Exception;
use Aws\S3\Model\PostObject;

class MapController extends BaseController
{

    protected $layout = 'layouts.master';
    protected $layoutAdmin = 'layouts.admin';

    function __construct()
    {
        $this->s3 = AWS::get('s3');
    }

    public function uploadFormComposer($view)
    {
        $postObject = new PostObject($this->s3, 'alternative-gaming', [
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

        $view->with(compact('options'));
    }

    public function index()
    {
        $maps = Map::where('map_type_id', '>', 0)->get();
        $map_total = $maps->count();
        $map_files = Map::where('map_type_id', 0)->get();
        $maps_broken = MapFeedback::where('vote_broken', 1)->orderBy('vote_broken_status','asc')->get();

        return View::make('maps.index')->with([
            'maps' => $maps,
            'map_files' => $map_files,
            'map_total' => $map_total,
            'maps_broken' => $maps_broken
        ]);
    }

    public function index_public()
    {
        $maps = Map::where('map_type_id', '>', 0)->where('remote', 1)->where('website', 1)->get();
        $map_total = $maps->count();
        $map_types = MapType::orderBy('name', 'asc')->get();

        $this->layout->bodyClass = 'maps-page';
        $this->layout->content = View::make('maps.public')->with([
            'maps' => $maps,
            'map_types' => $map_types,
            'map_total' => $map_total
        ]);
    }


    /**
     * pull all maps from amazon and import them
     *
     * @return Response
     */
    public function create()
    {
        $response = $this->s3->listObjects([
            'Bucket' => 'alternative-gaming',
            'Prefix' => 'games/team-fortress-2/maps/'
        ]);

        $map_list = $response['Contents'];
        $map_types = MapType::orderBy('name', 'asc')->lists('name', 'type');
        $sync_count = 0;

        //dd($response['Contents']);

        foreach ($map_list as $map) {
            // Make sure Object is a valid file (Objects of size 0 are folders)
            if ($map['Size'] > 0) {
                // Get Filename
                $rel_path = explode('/', $map['Key']);
                $name = $rel_path[count($rel_path) - 1];

                // Get File Extenstion
                $ext = explode('.', $name);
                $ext = $ext[count($ext) - 1];

                // Get MapType from filename
                $type = explode('_', $name);
                $type = $type[0];

                // Check if MapType exists in DB
                $checkType = MapType::where('type', $type)->first();

                // Get Special MapType ID
                $special = MapType::where('type', 'special')->first();

                // Get old record and update if found
                $new_map = Map::where('filename', $name)->first();

                // if existing record is not found, make new one
                if (!$new_map) {
                    $new_map = new Map;
                }

                $new_map->filesize = $map['Size'];
                $new_map->filename = $name;
                $new_map->filetype = $ext;
                $new_map->s3_path = $map['Key'];

                // Check if filetype is TF2 Map or not
                if ($ext == 'bz2') {
                    // Pass MapType ID to Map Row
                    if ($checkType->id) {
                        $new_map->map_type_id = $checkType->id;
                    } else {
                        $new_map->map_type_id = $special->id;
                    }
                } else {
                    $new_map->map_type_id = 0;
                }

                $new_map->created_by = Auth::user()->id;
                $new_map->updated_by = Auth::user()->id;
                $new_map->save();

                $sync_count++;


                //   		else
                //   		{
                //   			if(MapFile::where('filename',$name)->count() < 1)
                // 		{
                //      	$new_file = new MapFile;
                // $new_file->filesize = $map['Size'];
                // $new_file->filename = $name;
                // $new_file->filetype = $ext;
                // $new_file->s3_path = $map['Key'];
                // $new_file->save();

                // $sync_count++;
                // 		}
                // else
                // {
                // 	// If there is no map accociated with the file, add it.
                // 	if(MapFile::where('filename',$name)->pluck('map_id') == null)
                // 	{

                // 	}

                // 	$map = MapFile::where('filename',$name)->first();
                // 	$file = Map::where('id',$map->id);
                // }
                //}

                //$this->linkMapFiles();

            }
        }


        Session::flash('success_message', $sync_count . ' new files were synced from Amazon S3.');
        return Redirect::to('admin/maps');

        //$map_list_updated = Map::where('filename',$map['Key'])->count() < 1

        //return View::make('maps.create')->with(['map_types' => $map_types, 'map_list' => $map_list]);
    }

    // Link MapFiles with Maps with the same filename.
    // public function linkMapFiles()
    // {
    // 	// Get all files without maps assigned to them
    // 	$files = MapFile::where('map_id', null)->get();

    // 	// Go through each file
    // 	foreach ($files as $file)
    // 	{
    // 		// Get file name
    // 		$name = explode('.', $file->filename);
    //        	$name = $name[0];

    //        	// Check if a map with the same name exists
    //        	$map = Map::where('filename',$name.'.bsp.bz2')->first();

    //        	// If the map exists
    //        	if($map->id != null)
    //        	{
    //        		// Save the Map ID to the file
    //        		$file->map_id = $map->id;
    //        		$file->save();
    //        	}
    // 	}
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    // public function store()
    // {
    // 	if(Input::hasFile('map_file'))
    // 	{
    // 		$file = Input::file('map_file');

    // 		$file_name = $file->getClientOriginalName();
    // 		$file_ext = $file->getClientOriginalExtension();

    // 		$s3 = App::make('aws')->get('s3');
    // 		$s3->putObject(array(
    // 		  'Bucket' 		=> 'ag-maps',
    // 		  'Key'        	=> $file_name,
    // 		  'SourceFile' 	=> $file->getRealPath(),
    // 		  'ACL'			=> 'public-read',
    // 		  'ContentType'	=> 'application/x-bzip2',
    // 		));

    // 		$html_desc = Markdown::string(Input::get('desc_md'));

    // 		$map = new Map;
    // 		$map->filesize = $file->getSize();
    // 		$map->filename = $file_name;
    // 		$map->s3_path = 'https://s3-ap-southeast-2.amazonaws.com/ag-maps/' . $file_name;
    // 		$map->map_type_id = Input::get('type');
    // 		$map->name = Input::get('name');
    // 		//$map->revision = Input::get('revision');
    // 		//$map->more_info_url = Input::get('more_info_url');
    // 		$map->images = Input::get('images');
    // 		//$map->desc_md = Input::get('desc_md');
    // 		//$map->desc = $html_desc;
    // 		//$map->slug = Str::slug(Input::get('name'));
    // 		//$map->developer = Input::get('developer');
    // 		//$map->developer_url = Input::get('developer_url');
    // 		$map->save();

    // 		Session::flash('success_message', 'Successfully created map!');
    // 		return Redirect::to('maps');
    // 	}

    // 	Session::flash('error_message', 'Error');
    //        return Redirect::to('admin/maps');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    // public function show($slug)
    // {
    // 	$map = Map::where('slug',$slug)->with('maptype')->first();

    //        return View::make('maps.show')->with('map',$map);
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $map = Map::findOrFail($id);

        if ($map->map_type_id === 0) {
            Session::flash('error_message', $map->filename . ' is not a map, it can not be edited.');
            return Redirect::to('admin/maps');
        }

        $map_types = MapType::orderBy('name', 'asc')->lists('name', 'id');

        return View::make('maps.edit')->with(['map' => $map, 'map_types' => $map_types]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
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
        //return Redirect::to('admin/maps');
        return 'Update successful';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        // delete
        $map = Map::findOrFail($id);
        $filename = $map->filename;

        Queue::push(function () use ($filename) {
            App::make('MapController')->deleteMapFromAmazon($filename);
        });

        $map->delete();

        if (!Request::ajax()) {
            // redirect
            Session::flash('success_message', $filename . ' deleted.');
            return Redirect::to('admin/maps');
        }
    }

    public function deleteMapFromAmazon($filename)
    {
        $response = $this->s3->deleteObject([
            'Bucket' => 'alternative-gaming',
            'Key' => 'games/team-fortress-2/maps/' . $filename
        ]);
    }


    // pull the player into the database
    public function steamAuth()
    {
        $steam_64id = SteamLogin::validate();

        if ($steam_64id) {

            // Get player data from Steam, or make new player and return it
            $player = App::make('PlayerController')->getPlayerData($steam_64id);

            // If player is empty
            if (count($player) == 0)
            {
                return Redirect::to('/')->with('error_message', 'Invalid Steam Session, Could not authenticate you with Steam.');
            }

            // save player data to session
            Session::put('public-auth-true', 1);
            Session::put('player', $player);

            return Redirect::to('/')->with('success_message', 'You have been authenticated, vote away.');

        }
        else
        {
            return Redirect::to('/')->with('error_message', 'Could not authenticate you with Steam.');
        }
    }

    // pull the player into the database
    public function steamAuthLogout()
    {
        Session::forget('public-auth-true');
        Session::forget('player');

        return Redirect::to('/maps')->with('success_message', 'I saw nothing! NOOOTHING!');
    }

    public function mapVote()
    {
        if (!Session::has('public-auth-true')) {
            return false;
        }

        $input = Input::all();
        $player = Session::get('player');

        $feedback = MapFeedback::where('map_id', $input['map_id'])
            ->where('player_id', $player->id)
            ->first();

        if (!$feedback) {
            $feedback = new MapFeedback;
            $feedback->map_id = $input['map_id'];
            $feedback->player_id = $player->id;
        }

        $feedback->vote_up = ($input['action'] === 'up' ? 1 : 0);
        $feedback->vote_down = ($input['action'] === 'down' ? 1 : 0);
        $feedback->vote_broken = ($input['action'] === 'broken' ? 1 : 0);
        $feedback->save();

        return '1';

    }



    public function ajaxAction()
    {
        return $this->remoteAction(Input::get('id'), Input::get('action'));
    }

    public function remoteAction($id, $action)
    {
        $map = Map::findOrFail($id);

        if(!$map) return 0;

        $filename = $map->filename;
        $filetype = $map->filetype;
        $response = null;

        if($action == 'add-remote')
        {
            $response = $this->remoteRequest('~/quelle/scripts/download-map.sh ' . $filename . ' ' . $filetype);

            if($response == 1)
            {
                $map->remote = 1;
            }
        }
        else if($action == 'remove-remote')
        {
            $response = $this->remoteRequest('~/quelle/scripts/remove-map.sh ' . $filename . ' ' . $filetype);

            if($response == 1)
            {
                $map->remote = 0;
            }
        }
        else if($action == 'add-website')
        {
            $response = 1;
            $map->website = 1;
        }
        else if($action == 'remove-website')
        {
            $response = 1;
            $map->website = 0;
        }

        $map->save();

        return $response;
    }

    private $ssh_response;

    /**
     * @param $command
     * @return null
     */
    private function remoteRequest($command)
    {
        $this->ssh_response = null;

        try
        {
            SSH::into('pantheon')->run($command, function ($line)
            {
                $this->ssh_response = (int)$line;
            });
        }
        catch(ErrorException $e)
        {
            $this->ssh_response = 500;
        }


        return $this->ssh_response;
    }
}
