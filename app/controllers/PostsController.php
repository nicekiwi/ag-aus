<?php

class PostsController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$posts = Post::orderBy('created_at','desc')->paginate(7);
        return View::make('posts.index')->with(compact('posts'));
	}

	public function display_event_widget($view)
	{
		$events = Post::all();
		//dd($events);
		$view->with('events', $events);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$map_list = Map::orderBy('name','asc')->lists('name','id');
        return View::make('posts.create')->with('map_list',$map_list);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// validate
		// read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'title'       => 'required',
			'desc_md'      => 'required'
		);

		//dd(Input::get('event_maps'));

		$validator = Validator::make(Input::all(), $rules);

		// process the login
		if ($validator->fails()) {
			Session::flash('message', 'post faikled post!');
			return Redirect::to('posts/create')
				->withErrors($validator)
				->withInput(Input::except('password'));
		}



		// store
		$html_desc = Markdown::string(Input::get('desc_md'));

		$post = new Post;
		$post->title = Input::get('title');
		$post->desc_md = Input::get('desc_md');
		$post->desc = $html_desc;
		$post->slug = Str::slug(Input::get('title'));

		$post->event = Input::get('event');
		//$post->event_maps = implode(',', Input::get('event_maps'));

		$dom = new domDocument;
		$dom->loadHTML($html_desc);
		$dom->preserveWhiteSpace = false;
		$xpath = new DOMXPath($dom);
			$src = $xpath->evaluate("string(//img/@src)");

		$post->featured_image = $src;

		//$post->author = Auth::User()->name;
		$post->save();

		// redirect
		Session::flash('message', 'Successfully created post!');
		return Redirect::to('news');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($slug)
	{
		$post = Post::where('slug',$slug)->first();

        return View::make('posts.show', compact('post'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$post = Post::findOrFail($id);
		$map_list = Map::orderBy('name','asc')->lists('name','id');

        return View::make('posts.edit')->with(['post'=>$post, 'map_list'=>$map_list]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        // validate
        // read more on validation at http://laravel.com/docs/validation
		$rules = array(
			'title'       => 'required',
			'desc_md'      => 'required'
		);

        $validator = Validator::make(Input::all(), $rules);

        // process the login
        if ($validator->fails()) {
            return Redirect::to('posts/' . $id . '/edit')
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
        } else {
            // store

            $html_desc = Markdown::string(Input::get('desc_md'));

            $post = Post::findOrFail($id);
			$post->title = Input::get('title');
			$post->desc_md = Input::get('desc_md');
			$post->desc = $html_desc;
			$post->slug = Str::slug(Input::get('title'));

			$post->event = Input::get('event');

			$dom = new domDocument;
			$dom->loadHTML($html_desc);
			$dom->preserveWhiteSpace = false;
			$xpath = new DOMXPath($dom);
   			$src = $xpath->evaluate("string(//img/@src)");

			$post->featured_image = $src;

            $post->save();

            // redirect
            Session::flash('message', 'Successfully updated post!');
            return Redirect::to('news/'.$post->slug);
        }
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
		$post = Post::findOrFail($id);
		$post->delete();

		// redirect
		Session::flash('message', 'Successfully deleted the post!');
		return Redirect::to('posts');
	}

}
