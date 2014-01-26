@extends('layouts.admin')

@section('content')

<h1>Add a new Map</h1>

@foreach($map_list as $map)

{{ $map['Key'] }} - {{ round(($map['Size']/1048576), 2) . "Mb"; }}

@endforeach

{{ Form::model($post, [ 'method' => 'POST', 'route' => 'maps.store', 'files' => true, 'id' => 'upload_form' ]) }}

{{ Form::label('type', 'Map Type')}}
{{ Form::select('type', $map_types); }}

{{ $errors->name }}
{{ Form::label('name', 'Map Name')}}
{{ Form::text('name') }}

{{ Form::label('revision', 'Map Revision')}}
{{ Form::text('revision') }}

{{ Form::label('more_info_url', 'More map info')}}
{{ Form::text('more_info_url') }}

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

{{ Form::submit('Submit', ['id' => 'upload']) }}

{{ Form::close() }}

@stop

@section('footer')

<style type="text/css">
	

</style>
<script type="text/javascript" src="/js/uploadbar.js"></script>
<script type="text/javascript" src="/js/vendor/epiceditor.min.js"></script>
<script type="text/javascript">
	var opts = {
	  container: 'epiceditor',
	  textarea: 'desc_md_textarea',
	  clientSideStorage: false,
	  theme: {
	    base: 'http://{{ $_SERVER["HTTP_HOST"] }}/themes/base/epiceditor.css',
	    //preview: 'http://{{ $_SERVER["HTTP_HOST"] }}/themes/preview/preview-dark.css',
	    editor: 'http://{{ $_SERVER["HTTP_HOST"] }}/themes/editor/epic-dark.css'
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