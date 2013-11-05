@extends('layouts.master')

@section('content')

<div class="btn-group">
	<button type="button" class="active btn btn-default">All</button>
	<button type="button" class="btn btn-default">CP</button>
	<button type="button" class="btn btn-default">CTF</button>
	<button type="button" class="btn btn-default">PL</button>
	<button type="button" class="btn btn-default">KOTH</button>
</div>

{{ Form::text('search') }}

<p>&nbsp;</p>

<div class="maps-list">
	@foreach($maps as $map)
	<section class="map">
		<img class="img-thumbnail" src="/img/mapthumbs/gravel-pit-thumb.jpg">
		<div>
			<h3 class="map-name">[{{ strtoupper($map->mode) }}] {{ $map->name }} <small>v{{ $map->revision }} - {{ $map->developer }}</small></h3>
			<p class="expert">{{ strip_tags(preg_replace('/\s+?(\S+)?$/', '', substr($map->desc, 0, 121))); }}.. <a target="_blank" href="{{ $map->more_info_url }}">[Read More]</a></p>
			<p><a href="{{ $map->s3_path }}"><button type="button" class="btn btn-success btn-sm">
			  <span class="glyphicon glyphicon-download"></span> Download - {{ $map->filename }}</button></a></p>
		</div>
	</section>
	@endforeach
	{{ $maps->links() }}
</div>

@stop