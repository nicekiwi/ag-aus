@extends('layouts.master')

@section('content')

<h1>Edit Map: {{ $map->name }}</h1>

{{ Form::model($map, [ 'method' => 'PUT', 'route' => ['maps.update', $map->id]]) }}

{{ Form::label('type', 'Map Type')}}
{{ Form::select('type', $map_types); }}

{{ $errors->name }}
{{ Form::label('name', 'Map Name')}}
{{ Form::text('name') }}

{{ Form::label('revision', 'Map Revision')}}
{{ Form::text('revision') }}

{{ Form::label('more_info_url', 'More map info')}}
{{ Form::text('more_info_url') }}

{{ Form::label('s3_path', 'Path to Amazon S3 file')}}
{{ Form::text('s3_path', null, ['disabled' => true]) }}

{{ Form::label('image', 'Image of Map')}}
{{ Form::text('image') }}

{{ Form::label('developer', 'Map Developer')}}
{{ Form::text('developer') }}

{{ Form::label('developer_url', 'Map Developer URL')}}
{{ Form::text('developer_url') }}

{{ $errors->desc_md }}
{{ Form::label('desc_md', 'Map Notes')}}
{{ Form::textarea('desc_md', null, ['id' => 'desc_md_textarea']) }}
<div id="epiceditor"></div>

{{ Form::submit() }}
    
{{ Form::close() }}


<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/epiceditor/0.2.0/js/epiceditor.min.js"></script>
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