@extends('layouts.master')

@section('content')



<h1>Create new Post</h1>

{{ Form::model($post, [ 'method' => 'POST', 'route' => 'posts.store' ]) }}

{{ $errors->title }}
{{ Form::text('title') }}

{{ $errors->desc_md }}

{{ Form::textarea('desc_md', null, ['id' => 'desc_md_textarea']) }}
<div id="epiceditor"></div>

{{ Form::label('event', 'Event?')}}
{{ Form::checkbox('event') }}

{{ Form::label('event_maps', 'Event Map')}}
{{ Form::select('event_maps[]', $map_list, null, ['id' => 'event_maps', 'multiple']); }}


{{ Form::submit('Add Post') }}
    
{{ Form::close() }}

@stop

@section('footer')

<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/chosen/1.0/chosen.min.css">
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/chosen/1.0/chosen.jquery.min.js"></script>
<script type="text/javascript" src="/js/vendor/epiceditor.min.js"></script>
<script type="text/javascript">
	var opts = {
	  container: 'epiceditor',
	  textarea: 'desc_md_textarea',
	  clientSideStorage: false,
	  theme: {
	    base: 'http://ag-aus.dev/themes/base/epiceditor.css',
	    //preview: 'http://ag-aus.dev/themes/preview/preview-dark.css',
	    editor: 'http://ag-aus.dev/themes/editor/epic-dark.css'
	  },
	  button: {
	    preview: true,
	    fullscreen: false,
	    bar: "auto"
	  },
	  focusOnLoad: false,
	  autogrow: true
	};

	var editor = new EpicEditor(opts).load();

	$("#event_maps").chosen();
</script>

@stop