@extends('layouts.master')

@section('content')

{{ Form::model($post, [ 'method' => 'POST', 'route' => 'maps.store' ]) }}

{{ $errors->title }}
{{ Form::text('title') }}

{{ $errors->desc_md }}
{{ Form::textarea('desc_md', null, ['id' => 'desc_md_textarea']) }}
<div id="epiceditor"></div>

{{ Form::file('map_file'); }}

{{ Form::submit('Add Map') }}
    
{{ Form::close() }}

@stop