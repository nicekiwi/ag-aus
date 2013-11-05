@extends('layouts.master')

@section('content')





{{ Form::model($post, [ 'method' => 'POST', 'route' => 'posts.store' ]) }}

{{ $errors->title }}
{{ Form::text('title') }}

{{ $errors->desc_md }}

{{ Form::textarea('desc_md', null, ['id' => 'desc_md_textarea']) }}
<div id="epiceditor"></div>

{{ Form::submit('Add Post') }}
    
{{ Form::close() }}

@stop

@section('footer')

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
</script>

@stop