@extends('layouts.admin')

@section('content')

<h1><i class="fa fa-pencil"></i> Edit Post</h1>

{{ Form::model($post, [ 'method' => 'PATCH', 'route' => ['admin.posts.update', $post->id]]) }}

{{ $errors->title }}
{{ Form::text('title') }}

{{ $errors->desc_md }}

{{ Form::textarea('desc_md', null, ['id' => 'desc_md_textarea']) }}
<div id="epiceditor"></div>

{{ Form::label('event', 'Event?')}}
{{ Form::checkbox('event') }}

{{ Form::label('event_maps', 'Event Map')}}
{{ Form::select('event_maps[]', $map_list, null, ['id' => 'event_maps', 'multiple']); }}


{{ Form::submit('Save') }}
    
{{ Form::close() }}

@stop

@section('footer')

<script type="text/javascript">
  var editor = new EpicEditor(opts).load();

  $("#event_maps").chosen();
</script>

@stop