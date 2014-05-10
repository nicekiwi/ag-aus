@extends('layouts.admin')

@section('content')



<h1>Create Server Config</h1>

<p>Add a new line, then drag 'n Drop it where-ever you want.</p>

{{ Form::model($post, [ 'method' => 'POST', 'route' => 'admin.posts.store' ]) }}

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

<script type="text/javascript">
  var editor = new EpicEditor(opts).load();

  $("#event_maps").chosen();
</script>

@stop
